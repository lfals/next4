<?php

namespace YOOtheme\Application;

use YOOtheme\Container;

class RouteLoader
{
    /**
     * Load routes.
     *
     * @param Container $container
     * @param array     $configs
     */
    public function __invoke(Container $container, array $configs)
    {
        $container->extend('routes', static function ($routes) use ($configs) {

            foreach (array_merge(...$configs) as $route) {
                $routes->map(...$route);
            }

        });
    }
}
