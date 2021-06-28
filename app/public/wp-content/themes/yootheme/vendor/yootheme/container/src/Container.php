<?php

namespace YOOtheme;

use Psr\Container\ContainerInterface;
use YOOtheme\Container\BadFunctionCallException;
use YOOtheme\Container\InvalidArgumentException;
use YOOtheme\Container\LogicException;
use YOOtheme\Container\RuntimeException;
use YOOtheme\Container\Service;
use YOOtheme\Container\ServiceNotFoundException;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @var array
     */
    protected $services = [];

    /**
     * @var array
     */
    protected $extenders = [];

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @var array
     */
    protected $resolving = [];

    /**
     * Gets a service.
     *
     * @param string $id
     * @param string ...$ids
     *
     * @return mixed
     */
    public function __invoke($id, ...$ids)
    {
        return $ids ? array_map([$this, 'get'], array_merge([$id], $ids)) : $this->get($id);
    }

    /**
     * Gets a service.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->get($id);
    }

    /**
     * Checks if service exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function __isset($id)
    {
        return $this->has($id);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return isset($this->services[$id]) || isset($this->instances[$id]) || $this->isAlias($id);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        try {

            return $this->resolve($id);

        } catch (\Exception $e) {

            if ($this->has($id)) {
                throw $e;
            }

            throw new ServiceNotFoundException("Service '{$id}' is not defined");
        }
    }

    /**
     * Sets a service instance.
     *
     * @param string $id
     * @param mixed  $instance
     *
     * @return mixed
     */
    public function set($id, $instance)
    {
        unset($this->aliases[$id]);

        return $this->instances[$id] = $instance;
    }

    /**
     * Adds a service definition.
     *
     * @param string                  $id
     * @param string|callable|Service $service
     * @param bool                    $shared
     *
     * @return Service
     */
    public function add($id, $service = null, $shared = true)
    {
        if (is_string($service) || is_null($service)) {
            $service = new Service($service ?: $id, $shared);
        } elseif ($service instanceof \Closure) {
            $service = (new Service($id, $shared))->setFactory($service);
        } elseif (!$service instanceof Service) {
            throw new InvalidArgumentException('Service definition must be string or Closure');
        }

        unset($this->instances[$id], $this->aliases[$id]);

        return $this->services[$id] = $service;
    }

    /**
     * Adds a callback to extend a service.
     *
     * @param string   $id
     * @param callable $callback
     */
    public function extend($id, callable $callback)
    {
        $id = $this->getAlias($id);

        if (isset($this->instances[$id])) {

            $extended = $callback($this->instances[$id], $this);

            if (isset($extended) && $extended !== $this->instances[$id]) {
                throw new LogicException("Extending a resolved service {$id} must return the same instance");
            }

        } else {
            $this->extenders[$id][] = $callback;
        }
    }

    /**
     * Checks if a service is shared.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isShared($id)
    {
        return !empty($this->services[$id]->shared) || isset($this->instances[$id]);
    }

    /**
     * Checks if an alias exists.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isAlias($id)
    {
        return isset($this->aliases[$id]);
    }

    /**
     * Gets an alias.
     *
     * @param string $alias
     *
     * @throws LogicException
     *
     * @return string
     */
    public function getAlias($alias)
    {
        if (!isset($this->aliases[$alias])) {
            return $alias;
        }

        if ($this->aliases[$alias] === $alias) {
            throw new LogicException("[{$alias}] is aliased to itself");
        }

        return $this->getAlias($this->aliases[$alias]);
    }

    /**
     * Sets an alias.
     *
     * @param string $alias
     * @param string $id
     */
    public function setAlias($alias, $id)
    {
        $this->aliases[$alias] = $id;
    }

    /**
     * Gets a callback from service@method or service::method syntax.
     *
     * @param callable|string $callback
     *
     * @return callable|null
     */
    public function callback($callback)
    {
        if (is_string($callback)) {

            if (strpos($callback, '::')) {

                list($service, $method) = explode('::', $callback, 2);

                $callback = [$this->getAlias($service), $method];

            } elseif (strpos($callback, '@')) {

                list($service, $method) = explode('@', $callback, 2);

                $callback = [$this->get($service), $method];

            } elseif ($this->has($callback) || class_exists($callback)) {

                $callback = $this->get($callback);
            }
        }

        return is_callable($callback) ? $callback : null;
    }

    /**
     * Calls the callback with given parameters.
     *
     * @param callable|string $callback
     * @param array           $parameters
     * @param bool            $resolve
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function call($callback, array $parameters = [], $resolve = true)
    {
        if (!$callable = $this->callback($callback)) {
            throw BadFunctionCallException::create($callback);
        }

        if ($resolve) {
            $function = Reflection::getFunction($callable);
            $parameters = $this->resolveArguments($function, $parameters);
        }

        return $callable(...$parameters);
    }

    /**
     * Wraps the callback with optional parameter resolving.
     *
     * @param callable|string $callback
     * @param array           $parameters
     * @param bool            $resolve
     *
     * @return callable
     */
    public function wrap($callback, array $parameters = [], $resolve = true)
    {
        return function (...$params) use ($callback, $parameters, $resolve) {
            return $this->call($callback, array_replace($parameters, $params), $resolve);
        };
    }

    /**
     * Resolves a service from the container.
     *
     * @param string $id
     *
     * @throws \Exception
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public function resolve($id)
    {
        $id = $this->getAlias($id);

        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (isset($this->resolving[$id])) {

            if ($this->resolving[$id] === true) {
                throw new RuntimeException(sprintf('Circular reference detected %s => %s', join(' => ', array_keys($this->resolving)), $id));
            }

            return $this->instances[$id] = $this->resolving[$id];
        }

        $this->resolving[$id] = true;

        $service = isset($this->services[$id]) ? $this->services[$id] : new Service($id);
        $extenders = isset($this->extenders[$id]) ? $this->extenders[$id] : [];
        $instance = $service->resolveInstance($this);

        $this->resolving[$id] = $this->isShared($id) ? $instance : null;

        foreach ($extenders as $extender) {
            $instance = $extender($instance, $this) ?: $instance;
        }

        if (isset($this->instances[$id]) && $this->instances[$id] !== $instance) {
            throw new LogicException("Extending a resolved service {$id} must return the same instance");
        }

        if ($this->isShared($id)) {
            $this->instances[$id] = $instance;
        }

        unset($this->resolving[$id]);

        return $instance;
    }

    /**
     * Resolves arguments for given function.
     *
     * @param \ReflectionFunctionAbstract $function
     * @param array                       $parameters
     *
     * @return array
     */
    public function resolveArguments(\ReflectionFunctionAbstract $function, array $parameters = [])
    {
        if ($dependencies = $this->resolveDependencies($function, $parameters)) {
            $parameters = array_merge($dependencies, $parameters);
        }

        if ($function->getNumberOfRequiredParameters() > $count = count($parameters)) {

            $parameter = $function->getParameters()[$count];
            $declaring = $parameter->getDeclaringFunction();

            throw new RuntimeException("Can't resolve {$parameter} for " . Reflection::toString($declaring));
        }

        return $parameters;
    }

    /**
     * Resolves dependencies for given function.
     *
     * @param \ReflectionFunctionAbstract $function
     * @param array                       $parameters
     *
     * @return array
     */
    public function resolveDependencies(\ReflectionFunctionAbstract $function, array &$parameters = [])
    {
        $dependencies = [];

        foreach ($function->getParameters() as $parameter) {

            if (array_key_exists($name = "\${$parameter->name}", $parameters)) {

                if ($parameters[$name] instanceof \Closure) {
                    $dependencies[] = $parameters[$name]();
                } else {
                    $dependencies[] = $parameters[$name];
                }

                unset($parameters[$name]);

            } elseif (preg_match('/<\w+?>\s([\\\\\w]+)/', $parameter, $matches) && array_key_exists($matches[1], $parameters)) {

                if (is_string($parameters[$matches[1]])) {
                    $dependencies[] = $this->get($parameters[$matches[1]]);
                } else {
                    $dependencies[] = $parameters[$matches[1]];
                }

                unset($parameters[$matches[1]]);

            } elseif ($matches && ($this->has($matches[1]) || class_exists($matches[1]))) {
                $dependencies[] = $this->get($matches[1]);
            } else {
                break;
            }
        }

        return $dependencies;
    }
}
