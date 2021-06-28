<?php

namespace YOOtheme\Configuration;

abstract class Node
{
    /**
     * Resolves node to their values.
     *
     * @param array $params
     *
     * @return mixed
     */
    abstract public function resolve(array $params);

    /**
     * Compiles node as parsable string.
     *
     * @param array $params
     *
     * @return string
     */
    abstract public function compile(array $params);

    /**
     * Resolves arguments to their values.
     *
     * @param array $arguments
     * @param array $params
     *
     * @return array
     */
    public function resolveArgs(array $arguments, array $params = [])
    {
        $args = [];

        foreach ($arguments as $argument) {
            $args[] = $argument instanceof Node ? $argument->resolve($params) : $argument;
        }

        return $args;
    }

    /**
     * Compiles arguments as parsable string.
     *
     * @param array $arguments
     * @param array $params
     *
     * @return string
     */
    public function compileArgs(array $arguments, array $params = [])
    {
        $args = [];

        foreach ($arguments as $argument) {
            $args[] = $argument instanceof Node ? $argument->compile($params) : var_export($argument, true);
        }

        return join(', ', $args);
    }
}
