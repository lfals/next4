<?php

namespace YOOtheme\Container;

use YOOtheme\Container;

class Service
{
    /**
     * @var string
     */
    public $class;

    /**
     * @var bool
     */
    public $shared;

    /**
     * @var callable
     */
    protected $factory;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * Constructor.
     *
     * @param string $class
     * @param bool   $shared
     */
    public function __construct($class, $shared = false)
    {
        $this->class = $class;
        $this->shared = $shared;
    }

    /**
     * Sets service class.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Checks if service is shared.
     *
     * @return bool
     */
    public function isShared()
    {
        return $this->shared;
    }

    /**
     * Sets service as shared.
     *
     * @param bool $shared
     *
     * @return $this
     */
    public function setShared($shared = true)
    {
        $this->shared = (bool) $shared;

        return $this;
    }

    /**
     * Gets a service factory.
     *
     * @return callable
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Sets a service factory.
     *
     * @param callable|string $factory
     *
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * Sets an argument value.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setArgument($name, $value)
    {
        $this->arguments[$name] = $value;

        return $this;
    }

    /**
     * Gets arguments for given function.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Sets an array of arguments.
     *
     * @param array $arguments
     *
     * @return $this
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Resolves a new instance.
     *
     * @param Container $container
     *
     * @throws LogicException
     * @throws \ReflectionException
     *
     * @return object
     */
    public function resolveInstance(Container $container)
    {
        return $this->factory ? $container->call($this->factory, $this->arguments) : $this->resolveClass($container);
    }

    /**
     * Resolves an instance from class.
     *
     * @param Container $container
     *
     * @throws LogicException
     * @throws \ReflectionException
     *
     * @return object
     */
    protected function resolveClass(Container $container)
    {
        $class = new \ReflectionClass($this->class);

        if (!$class->isInstantiable()) {
            throw new LogicException("Can't instantiate {$this->class}");
        }

        if (!$constructor = $class->getConstructor()) {
            return $class->newInstance();
        }

        $arguments = $container->resolveArguments($constructor, $this->arguments);

        return $class->newInstanceArgs($arguments);
    }
}
