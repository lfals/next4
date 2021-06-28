<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Str;

class TaxonomyArchiveQueryType
{
    /**
     * @param \WP_Taxonomy $taxonomy
     *
     * @return array
     */
    public static function config(\WP_Taxonomy $taxonomy)
    {
        $name = Str::camelCase($taxonomy->name, true);
        $field = Str::camelCase(['taxonomy', $taxonomy->name]);

        $metadata = [
            'group' => 'Page',
            'view' => ["taxonomy-{$taxonomy->name}"],
        ];

        $fields = [

            $field => [
                'type' => $name,
                'metadata' => $metadata + [
                    'label' => $taxonomy->labels->singular_name,
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::resolve',
                ],
            ],

        ];

        foreach ($taxonomy->object_type as $name) {

            $type = get_post_type_object($name);

            if (!$type->public || !$type->show_ui || !$type->show_in_nav_menus) {
                continue;
            }

            if (!$type->rest_base || $name === $type->rest_base) {
                continue;
            }

            $field = Str::camelCase([$taxonomy->name, $name]);

            $fields[$field] = [

                'type' => [
                    'listOf' => Str::camelCase($name, true),
                ],

                'args' => [
                    'offset' => [
                        'type' => 'Int',
                    ],
                    'limit' => [
                        'type' => 'Int',
                    ],
                ],

                'metadata' => $metadata + [
                    'label' => $type->label,
                    'fields' => [
                        '_offset' => [
                            'description' => "Set the starting point and limit the number of {$type->label}.",
                            'type' => 'grid',
                            'width' => '1-2',
                            'fields' => [
                                'offset' => [
                                    'label' => 'Start',
                                    'type' => 'number',
                                    'default' => 0,
                                    'modifier' => 1,
                                    'attrs' => [
                                        'min' => 1,
                                        'required' => true,
                                    ],
                                ],
                                'limit' => [
                                    'label' => 'Quantity',
                                    'type' => 'limit',
                                    'attrs' => [
                                        'placeholder' => 'No limit',
                                        'min' => 0,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],

                'extensions' => [
                    'call' => __CLASS__ . '::resolvePosts',
                ],

            ];
        }

        return compact('fields');
    }

    public static function resolve()
    {
        return get_queried_object();
    }

    public static function resolvePosts($root, array $args)
    {
        global $wp_query;

        $args += [
            'offset' => 0,
            'limit' => null,
        ];

        if ($args['offset'] || $args['limit']) {
            return array_slice($wp_query->posts, (int) $args['offset'], (int) $args['limit'] ?: null);
        }

        return $wp_query->posts;
    }
}
