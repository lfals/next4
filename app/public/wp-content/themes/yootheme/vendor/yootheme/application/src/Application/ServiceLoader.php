<?php

namespace YOOtheme\Application;

use YOOtheme\Container;

class ServiceLoader
{
    /**
     * Load services configuration.
     *
     * @param Container $container
     * @param array     $configs
     */
    public function __invoke(Container $container, array $configs)
    {
        $config = array_merge(...$configs);

        foreach ($config as $id => $service) {

            if (is_array($service)) {

                $definition = $container->add($id);

                if (isset($service['class'])) {
                    $definition->setClass($service['class']);
                }

                if (isset($service['factory'])) {
                    $definition->setFactory($service['factory']);
                }

                if (isset($service['arguments'])) {
                    $definition->setArguments($service['arguments']);
                }

                if (isset($service['shared'])) {
                    $definition->setShared($service['shared']);
                }

            } else {
                $container->add($id, $service);
            }

        }
    }
}
