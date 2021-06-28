<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Builder\Source;
use YOOtheme\Str;

class TaxonomyType
{
    /**
     * @param Source       $source
     * @param \WP_Taxonomy $taxonomy
     *
     * @return array
     */
    public static function config(Source $source, \WP_Taxonomy $taxonomy)
    {
        $name = Str::camelCase($taxonomy->name, true);

        foreach ($taxonomy->object_type as $typeName) {
            $type = get_post_type_object($typeName);

            if (!$type->public || !$type->show_ui || !$type->show_in_nav_menus) {
                continue;
            }

            if (!$type->rest_base || $typeName === $type->rest_base) {
                continue;
            }

            $source->objectType(Str::camelCase($typeName, true), static::configType($taxonomy));
        }

        return [

            'fields' => [

                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Name',
                        'filters' => ['limit'],
                    ],
                ],

                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],

                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolveLink',
                    ],
                ],

                'count' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Item Count',
                    ],
                ],

            ] + ($taxonomy->hierarchical ? [

                'parent' => [
                    'type' => $name,
                    'metadata' => [
                        'label' => "Parent {$taxonomy->labels->singular_name}",
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveParent',
                            'args' => ['taxonomy' => $taxonomy->name],
                        ],
                    ],
                ],

                'children' => [
                    'type' => [
                        'listOf' => $name,
                    ],
                    'args' => [
                        'order' => [
                            'type' => 'String',
                        ],
                        'order_direction' => [
                            'type' => 'String',
                        ],
                    ],
                    'metadata' => [
                        'label' => "Child {$taxonomy->labels->name}",
                        'fields' => [
                            '_order' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'fields' => [
                                    'order' => [
                                        'label' => 'Order',
                                        'type' => 'select',
                                        'default' => 'term_order',
                                        'options' => [
                                            'Term Order' => 'term_order',
                                            'Alphabetical' => 'name',
                                        ],
                                    ],
                                    'order_direction' => [
                                        'label' => 'Direction',
                                        'type' => 'select',
                                        'default' => 'ASC',
                                        'options' => [
                                            'Ascending' => 'ASC',
                                            'Descending' => 'DESC',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveChildren',
                            'args' => ['taxonomy' => $taxonomy->name],
                        ],
                    ],
                ],

            ] : []),

            'metadata' => [
                'type' => true,
                'label' => $taxonomy->labels->singular_name,
            ],

        ];
    }

    /**
     * @param \WP_Taxonomy $taxonomy
     *
     * @return array
     */
    public static function configType(\WP_Taxonomy $taxonomy)
    {
        $name = Str::camelCase($taxonomy->name, true);

        return [

            'fields' => [

                $taxonomy->rest_base => [

                    'type' => [
                        'listOf' => $name,
                    ],

                    'metadata' => [
                        'label' => $taxonomy->label,
                    ],

                    'extensions' => [

                        'call' => [
                            'func' => __CLASS__ . '::resolveTerms',
                            'args' => ['taxonomy' => $taxonomy->name],
                        ],

                    ],

                ],

                "{$taxonomy->name}String" => [

                    'type' => 'String',

                    'args' => [
                        'separator' => [
                            'type' => 'String',
                        ],
                        'show_link' => [
                            'type' => 'Boolean',
                        ],
                        'link_style' => [
                            'type' => 'String',
                        ],
                    ],

                    'metadata' => [
                        'label' => $taxonomy->label,
                        'arguments' => [
                            'separator' => [
                                'label' => 'Separator',
                                'description' => 'Set the separator between terms.',
                                'default' => ', ',
                            ],
                            'show_link' => [
                                'label' => 'Link',
                                'type' => 'checkbox',
                                'default' => true,
                                'text' => 'Show link',
                            ],
                            'link_style' => [
                                'label' => 'Link Style',
                                'description' => 'Set the link style.',
                                'type' => 'select',
                                'default' => '',
                                'options' => [
                                    'Default' => '',
                                    'Muted' => 'link-muted',
                                    'Text' => 'link-text',
                                    'Heading' => 'link-heading',
                                    'Reset' => 'link-reset',
                                ],
                                'enable' => 'arguments.show_link',
                            ],
                        ],
                    ],

                    'extensions' => [

                        'call' => [
                            'func' => __CLASS__ . '::resolveTermString',
                            'args' => ['taxonomy' => $taxonomy->name],
                        ],

                    ],

                ],

            ],

        ];
    }

    public static function resolveLink(\WP_Term $term)
    {
        return get_term_link($term);
    }

    public static function resolveParent(\WP_Term $term, array $args)
    {
        return $term->parent ? get_term($term->parent) : new \WP_Term((object) (['id' => 0, 'name' => 'ROOT'] + $args));
    }

    public static function resolveChildren(\WP_Term $term, array $args)
    {
        $args += [
            'order' => 'term_order',
            'order_direction' => 'ASC',
        ];

        $query = [
            'taxonomy' => $args['taxonomy'],
            'orderby' => $args['order'],
            'order' => $args['order_direction'],
            'parent' => $term->term_id,
        ];

        return get_terms($query);
    }

    public static function resolveTerms($post, array $args)
    {
        return wp_get_post_terms($post->ID, $args['taxonomy']);
    }

    public static function resolveTermString($post, array $args)
    {
        $args += ['separator' => ', ', 'show_link' => true, 'link_style' => ''];
        $before = $args['link_style'] ? "<span class=\"uk-{$args['link_style']}\">" : '';
        $after = $args['link_style'] ? '</span>' : '';

        if ($args['show_link']) {
            return get_the_term_list($post->ID, $args['taxonomy'], $before, $args['separator'], $after) ?: null;
        }

        $terms = get_the_terms($post->ID, $args['taxonomy']);

        return $terms ? implode($args['separator'], array_map(function ($term) { return $term->name; }, $terms)) : null;
    }
}
