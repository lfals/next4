<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Str;

class SinglePostQueryType
{
    /**
     * @param \WP_Post_Type $type
     *
     * @return array
     */
    public static function config(\WP_Post_Type $type)
    {
        $name = Str::camelCase($type->name, true);
        $field = Str::camelCase(['single', $type->name]);

        return [

            'fields' => [

                $field => [
                    'type' => $name,
                    'metadata' => [
                        'label' => $type->labels->singular_name,
                        'view' => ["single-{$type->name}"],
                        'group' => 'Page',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],

            ],

        ];
    }

    public static function resolve()
    {
        global $post, $wp_query;

        $wp_query->setup_postdata($post);

        return $post;
    }
}
