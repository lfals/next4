<?php

namespace YOOtheme\Application;

use YOOtheme\Container;

class AliasLoader
{
    /**
     * Load service aliases.
     *
     * @param Container $container
     * @param array     $configs
     */
    public function __invoke(Container $container, array $configs)
    {
        $config = array_merge_recursive(...$configs);

        foreach ($config as $id => $aliases) {
            foreach ((array) $aliases as $alias) {
                $container->setAlias($alias, $id);
            }
        }
    }
}
