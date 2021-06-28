<?php

namespace YOOtheme;

class Routes implements \IteratorAggregate
{
    /**
     * @var Route[]
     */
    protected $index = [];

    /**
     * @var Route[]
     */
    protected $routes = [];

    /**
     * Adds a route.
     *
     * @param string|string[] $method
     * @param string          $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function map($method, $path, $handler, array $attributes = [])
    {
        $route = new Route($path, $handler, $method);
        $route->setAttributes($attributes);

        if ($this->index) {
            $this->index = [];
        }

        return $this->routes[] = $route;
    }

    /**
     * Adds a GET route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function get($path, $handler, array $attributes = [])
    {
        return $this->map('GET', $path, $handler, $attributes);
    }

    /**
     * Adds a POST route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function post($path, $handler, array $attributes = [])
    {
        return $this->map('POST', $path, $handler, $attributes);
    }

    /**
     * Adds a PUT route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function put($path, $handler, array $attributes = [])
    {
        return $this->map('PUT', $path, $handler, $attributes);
    }

    /**
     * Adds a PATCH route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function patch($path, $handler, array $attributes = [])
    {
        return $this->map('PATCH', $path, $handler, $attributes);
    }

    /**
     * Adds a DELETE route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function delete($path, $handler, array $attributes = [])
    {
        return $this->map('DELETE', $path, $handler, $attributes);
    }

    /**
     * Adds a HEAD route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function head($path, $handler, array $attributes = [])
    {
        return $this->map('HEAD', $path, $handler, $attributes);
    }

    /**
     * Adds a OPTIONS route.
     *
     * @param string|string[] $path
     * @param string|callable $handler
     * @param array           $attributes
     *
     * @return Route
     */
    public function options($path, $handler, array $attributes = [])
    {
        return $this->map('OPTIONS', $path, $handler, $attributes);
    }

    /**
     * Adds a group of routes.
     *
     * @param string   $prefix
     * @param callable $group
     *
     * @return Routes
     */
    public function group($prefix, callable $group)
    {
        $routes = new static();

        $group($routes);

        return $this->mount($prefix, $routes);
    }

    /**
     * Mounts a route collection.
     *
     * @param string $prefix
     * @param Routes $routes
     *
     * @return $this
     */
    public function mount($prefix, Routes $routes)
    {
        $prefix = trim($prefix, '/');

        foreach ($routes as $route) {
            $this->routes[] = $route->setPath($prefix . $route->getPath());
        }

        return $this;
    }

    /**
     * Gets a route by name.
     *
     * @param string $name
     *
     * @return Route|null
     */
    public function getRoute($name)
    {
        $index = $this->getIndex();

        return isset($index[$name]) ? $index[$name] : null;
    }

    /**
     * Gets an index of routes.
     *
     * @return Route[]
     */
    public function getIndex()
    {
        if (!$this->index) {
            foreach ($this->routes as $index => $route) {
                $this->index[$route->getAttribute('name', "route_{$index}")] = $route;
            }
        }

        return $this->index;
    }

    /**
     * Implements the IteratorAggregate.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }
}
