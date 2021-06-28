<?php

namespace YOOtheme\Application;

use YOOtheme\Config;
use YOOtheme\Container;

class ConfigLoader
{
    /**
     * Load configuration.
     *
     * @param Container $container
     * @param array     $configs
     */
    public function __invoke(Container $container, array $configs)
    {
        $container->extend(Config::class, static function (Config $configuration) use ($container, $configs) {

            foreach ($configs as $config) {

                if ($config instanceof \Closure) {
                    $config = $config($configuration, $container);
                }

                $configuration->add('', (array) $config);
            }

        });
    }
}
