<?php

namespace YOOtheme;

class Middleware
{
    /**
     * @var array
     */
    public $stack;

    /**
     * Constructor.
     *
     * @param callable   $kernel
     * @param callable[] $stack
     */
    public function __construct(callable $kernel, array $stack = [])
    {
        $this->stack = $stack;
        $this->stack[] = $kernel;
    }

    /**
     * Invokes the next middleware callback.
     *
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        $callback = array_shift($this->stack);

        // add next() as last argument
        if ($this->stack) {
            $arguments[] = $this;
        }

        return $callback(...$arguments);
    }
}
