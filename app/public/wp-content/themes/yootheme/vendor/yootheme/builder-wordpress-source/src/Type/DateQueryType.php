<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class DateQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'date' => [
                    'type' => 'Date',
                    'metadata' => [
                        'label' => 'Date',
                        'view' => ['date-archive'],
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
