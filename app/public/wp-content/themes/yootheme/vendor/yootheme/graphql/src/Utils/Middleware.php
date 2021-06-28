<?php

namespace YOOtheme\GraphQL\Utils;

class Middleware
{
    /**
     * @var callable
     */
    protected $handler;

    /**
     * @var array
     */
    protected $stack = [];

    /**
     * Constructor.
     *
     * @param callable $handler
     */
    public function __construct(callable $handler = null)
    {
        $this->handler = $handler;
    }

    /**
     * Invokes the next middleware handler.
     *
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        if ($this->stack) {
            $arguments[] = $this;
        }

        $handler = array_shift($this->stack) ?: $this->handler;

        return $handler(...$arguments);
    }

    /**
     * Returns true if handler exists.
     */
    public function hasHandler()
    {
        return isset($this->handler);
    }

    /**
     * Sets the middleware handler.
     *
     * @param callable $handler
     */
    public function setHandler(callable $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Unshift a middleware to the bottom of the stack.
     *
     * @param callable $middleware
     */
    public function unshift(callable $middleware)
    {
        array_unshift($this->stack, $middleware);
    }

    /**
     * Push a middleware to the top of the stack.
     *
     * @param callable $middleware
     */
    public function push(callable $middleware)
    {
        array_push($this->stack, $middleware);
    }
}
