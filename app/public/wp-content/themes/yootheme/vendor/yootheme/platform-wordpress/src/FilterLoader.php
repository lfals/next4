<?php

namespace YOOtheme\Wordpress;

use YOOtheme\Application\EventLoader;
use YOOtheme\Container;

class FilterLoader extends EventLoader
{
    /**
     * Adds a listener.
     *
     * @param Container $container
     * @param string    $event
     * @param string    $class
     * @param string    $method
     * @param array     $params
     */
    public function addListener(Container $container, $event, $class, $method, ...$params)
    {
        add_filter($event, function (...$arguments) use ($container, $class, $method) {

            $callback = [$class, $method];

            if ($method[0] === '@') {
                $callback = join($callback);
            }

            return $container->call($callback, $arguments);

        }, ...$params);
    }
}
