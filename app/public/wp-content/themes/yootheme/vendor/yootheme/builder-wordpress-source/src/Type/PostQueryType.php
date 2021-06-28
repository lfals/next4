<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Builder\Source;
use YOOtheme\Str;

class PostQueryType
{
    /**
     * @param Source        $source
     * @param \WP_Post_Type $type
     *
     * @return array
     */
    public static function config(Source $source, \WP_Post_Type $type)
    {
        $name = Str::camelCase([$type->rest_base, 'Query'], true);
        $field = Str::camelCase($type->rest_base);

        $source->objectType($name, SinglePostQueryType::config($type));
        $source->objectType($name, CustomPostQueryType::config($type));

        if ($type->has_archive || $type->name === 'post') {
            $source->objectType($name, PostArchiveQueryType::config($type));
        }

        return [

            'fields' => [

                $field => [

                    'type' => $name,

                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root)
    {
        return $root;
    }
}
