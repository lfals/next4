<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Str;

class CustomPostQueryType
{
    /**
     * @param \WP_Post_Type $type
     *
     * @return array
     */
    public static function config(\WP_Post_Type $type)
    {
        $name = Str::camelCase($type->name, true);
        $base = Str::camelCase($type->rest_base, true);

        $plural = Str::lower($type->label);
        $singular = Str::lower($type->labels->singular_name);

        $terms = ($taxonomies = get_object_taxonomies($type->name)) ? [

            'label' => 'Limit by Terms',
            'description' => "The {$singular} is only loaded from the selected terms. {$type->label} from child terms are not included. Use the <kbd>shift</kbd> or <kbd>ctrl/cmd</kbd> key to select multiple terms.",
            'type' => 'select',
            'default' => [],
            'options' => array_map(function ($taxonomy) {
                return ['evaluate' => "config.taxonomies.{$taxonomy}"];
            }, $taxonomies),
            'attrs' => [
                'multiple' => true,
                'class' => 'uk-height-medium uk-resize-vertical',
            ],

        ] : [];

        return [

            'fields' => [

                "custom{$name}" => [

                    'type' => $name,

                    'args' => [
                        'id' => [
                            'type' => 'Int',
                        ],
                        'terms' => [
                            'type' => [
                                'listOf' => 'Int',
                            ],
                        ],
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'order' => [
                            'type' => 'String',
                        ],
                        'order_direction' => [
                            'type' => 'String',
                        ],
                        'order_alphanum' => [
                            'type' => 'Boolean',
                        ],
                    ],

                    'metadata' => [
                        'label' => "Custom {$type->labels->singular_name}",
                        'group' => 'Custom',
                        'fields' => array_merge([
                            'id' => [
                                'label' => 'Select Manually',
                                'description' => "Pick a {$singular} manually or use filter options to specify which {$singular} should be loaded dynamically.",
                                'type' => 'select-item',
                                'post_type' => $type->name,
                                'labels' => [
                                    'type' => $type->labels->singular_name,
                                ],
                            ],
                        ], $terms ? [
                            'terms' => $terms + [
                                'enable' => '!id',
                            ],
                        ] : [], [
                            'offset' => [
                                'label' => 'Offset',
                                'description' => "Set the offset to specify which {$singular} is loaded.",
                                'type' => 'number',
                                'default' => 0,
                                'modifier' => 1,
                                'attrs' => [
                                    'min' => 1,
                                    'required' => true,
                                ],
                                'enable' => '!id',
                            ],
                            '_order' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'order' => [
                                        'label' => 'Order',
                                        'type' => 'select',
                                        'default' => 'date',
                                        'options' => [
                                            'Date' => 'date',
                                            'Modified' => 'modified',
                                            'Alphabetical' => 'title',
                                            'Author' => 'author',
                                            'Post Order' => 'menu_order',
                                            'Comment Count' => 'comment_count',
                                            'Random' => 'rand',
                                        ],
                                        'enable' => '!id',
                                    ],
                                    'order_direction' => [
                                        'label' => 'Direction',
                                        'type' => 'select',
                                        'default' => 'DESC',
                                        'options' => [
                                            'Ascending' => 'ASC',
                                            'Descending' => 'DESC',
                                        ],
                                        'enable' => '!id',
                                    ],
                                ],
                            ],
                            'order_alphanum' => [
                                'text' => 'Alphanumeric Ordering',
                                'type' => 'checkbox',
                                'enable' => '!id',
                            ],
                        ]),
                    ],

                    'extensions' => [

                        'call' => [
                            'func' => __CLASS__ . '::resolvePost',
                            'args' => ['post_type' => $type->name],
                        ],

                    ],

                ],

                "custom{$base}" => [

                    'type' => [
                        'listOf' => $name,
                    ],

                    'args' => [
                        'terms' => [
                            'type' => [
                                'listOf' => 'Int',
                            ],
                        ],
                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ],
                        'order' => [
                            'type' => 'String',
                        ],
                        'order_direction' => [
                            'type' => 'String',
                        ],
                        'order_alphanum' => [
                            'type' => 'Boolean',
                        ],
                    ],

                    'metadata' => [
                        'label' => "Custom {$type->label}",
                        'group' => 'Custom',
                        'fields' => array_merge($terms ? compact('terms') : [], [
                            '_offset' => [
                                'description' => "Set the starting point and limit the number of {$plural}.",
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
                                        'default' => 10,
                                        'attrs' => [
                                            'min' => 1,
                                        ],
                                    ],
                                ],
                            ],
                            '_order' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'order' => [
                                        'label' => 'Order',
                                        'type' => 'select',
                                        'default' => 'date',
                                        'options' => [
                                            'Date' => 'date',
                                            'Modified' => 'modified',
                                            'Alphabetical' => 'title',
                                            'Author' => 'author',
                                            'Post Order' => 'menu_order',
                                            'Comment Count' => 'comment_count',
                                            'Random' => 'rand',
                                        ],
                                    ],
                                    'order_direction' => [
                                        'label' => 'Direction',
                                        'type' => 'select',
                                        'default' => 'DESC',
                                        'options' => [
                                            'Ascending' => 'ASC',
                                            'Descending' => 'DESC',
                                        ],
                                    ],
                                ],
                            ],
                            'order_alphanum' => [
                                'text' => 'Alphanumeric Ordering',
                                'type' => 'checkbox',
                            ],
                        ]),
                    ],

                    'extensions' => [

                        'call' => [
                            'func' => __CLASS__ . '::resolvePosts',
                            'args' => ['post_type' => $type->name],
                        ],

                    ],

                ],

            ],

        ];

    }

    public static function resolvePost($root, array $args)
    {
        if (!empty($args['id'])) {
            return get_post($args['id']);
        }

        if ($posts = static::resolvePosts($root, ['limit' => 1] + $args)) {
            return array_shift($posts);
        }
    }

    public static function resolvePosts($root, array $args)
    {
        $query = [
            'post_status' => 'publish',
            'post_type' => $args['post_type'],
            'orderby' => $args['order'],
            'order' => $args['order_direction'],
            'offset' => $args['offset'],
            'numberposts' => $args['limit'],
            'tax_query' => [],
            'suppress_filters' => false,
        ];

        if (Str::startsWith($query['orderby'], 'field:')) {
            $query['meta_key'] = substr($query['orderby'], 6);
            $query['orderby'] = 'meta_value';
        }

        if (!empty($args['terms'])) {

            $taxonomies = [];

            foreach ($args['terms'] as $id) {
                if ($term = get_term($id) and $term instanceof \WP_Term) {
                    $taxonomies[$term->taxonomy][] = $id;
                }
            }

            foreach ($taxonomies as $taxonomy => $terms) {
                $query['tax_query'][] = [
                    'taxonomy' => $taxonomy,
                    'terms' => $terms,
                    'include_children' => false,
                    'field' => 'term_id',
                ];
            }
        }

        if (!empty($args['order_alphanum']) && $args['order'] !== 'rand') {
            static::addFilterOnce('posts_orderby', function ($orderby) use ($query) {

                if ($orderby && !Str::contains($orderby, ',')) {
                    $orderby = preg_replace('/([^\s]+).*/', "(substr($1, 1, 1) > '9') {$query['order']}, $1+0 {$query['order']}, $1 {$query['order']}", $orderby, 1);
                }

                return $orderby;
            });
        }

        return get_posts($query);
    }

    protected static function addFilterOnce($tag, $fn)
    {
        add_filter($tag, $removeFn = function ($arg) use ($tag, $fn, &$removeFn) {
            remove_filter($tag, $removeFn);
            return $fn($arg);
        });
    }
}
