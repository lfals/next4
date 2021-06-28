<?php

namespace YOOtheme\Container;

use Psr\Container\ContainerExceptionInterface;

class BadFunctionCallException extends \BadFunctionCallException implements ContainerExceptionInterface
{
    /**
     * Creates an exception from given callback.
     *
     * @param string|callable $callback
     * @param mixed           $code
     * @param null|mixed      $previous
     *
     * @return static
     */
    public static function create($callback, $code = 0, $previous = null)
    {
        $function = $callback;

        if (is_object($callback)) {

            $function = get_class($callback);

        } elseif (is_array($callback)) {

            list($class, $method) = $callback;

            if (is_string($class)) {
                $function = "{$class}::{$method}";
            } else {
                $function = get_class($class) . "@{$method}";
            }
        }

        return new static("Function {$function} is not a callable", $code, $previous);
    }
}
