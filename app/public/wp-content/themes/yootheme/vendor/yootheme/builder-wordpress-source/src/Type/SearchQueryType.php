<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class SearchQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'search' => [
                    'type' => 'Search',
                    'metadata' => [
                        'label' => 'Search',
                        'view' => ['search'],
                        'group' => 'Page',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        return $root;
    }
}
