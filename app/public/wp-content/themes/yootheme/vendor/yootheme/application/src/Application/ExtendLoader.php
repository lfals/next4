<?php

namespace YOOtheme\Application;

use YOOtheme\Container;

class ExtendLoader
{
    /**
     * Load service extenders.
     *
     * @param Container $container
     * @param array     $configs
     */
    public function __invoke(Container $container, array $configs)
    {
        foreach ($configs as $config) {
            foreach ($config as $id => $callback) {
                $container->extend($id, $callback);
            }
        }
    }
}
