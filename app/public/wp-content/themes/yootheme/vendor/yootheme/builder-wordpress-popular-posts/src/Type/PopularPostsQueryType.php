<?php

namespace YOOtheme\Builder\Wordpress\PopularPosts\Type;

use WordPressPopularPosts\Helper;
use YOOtheme\Str;

class PopularPostsQueryType
{
    /**
     * @param \WP_Post_Type $type
     *
     * @return array
     */
    public static function config(\WP_Post_Type $type)
    {
        $name = Str::camelCase($type->name, true);
        $field = Str::camelCase(['popular', $type->rest_base]);

        $plural = Str::lower($type->label);
        $singular = Str::lower($type->labels->singular_name);

        $terms = ($taxonomies = get_object_taxonomies($type->name)) ? [

            'terms' => [
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
            ],

        ] : [];

        return [

            'fields' => [

                $field => [

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
                    ],

                    'metadata' => [
                        'label' => "Popular {$type->label}",
                        'group' => 'Custom',
                        'fields' => $terms + [
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
                                        'default' => 'views',
                                        'options' => [
                                            'Comments' => 'comments',
                                            'Total Views' => 'views',
                                            'Average Daily Views' => 'avg',
                                        ],
                                    ],
                                    'order_direction' => [
                                        'label' => 'Time Range',
                                        'type' => 'select',
                                        'default' => 'monthly',
                                        'options' => [
                                            'Last 24 hours' => 'daily',
                                            'Last 7 days' => 'weekly',
                                            'Last 30 days' => 'monthly',
                                            'All-time' => 'all',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],

                    'extensions' => [

                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => ['post_type' => $type->name],
                        ],

                    ],

                ],

            ],

        ];
    }

    public static function resolve($root, array $args)
    {
        $query = [
            'post_status' => 'publish',
            'post_type' => $args['post_type'],
            'offset' => $args['offset'],
            'numberposts' => $args['limit'],
            'tax_query' => [],
            'suppress_filters' => false,
        ];

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

        $now = new \DateTime(Helper::now(), new \DateTimeZone(Helper::get_timezone()));
        $range = $args['order_direction'];
        $order = $args['order'];

        static::addFilterOnce('posts_where', function ($where) use ($range, $order, $now) {
            if ($range === 'all' && $order === 'comments') {
                return $where . 'AND comment_count > 0';
            }

            return $where;
        });

        static::addFilterOnce('posts_fields', function ($fields) use ($range, $order, $now) {
            if ($range === 'all') {
                if ($order === 'avg') {
                    return "{$fields}, (v.pageviews/(IF (DATEDIFF('{$now->format('Y-m-d')}', MIN(v.day)) > 0, DATEDIFF('{$now->format('Y-m-d')}', MIN(v.day)), 1))) AS avg_views";
                }

                return $fields;
            }

            if ($order === 'views') {
                return "{$fields}, pageviews";
            }
            if ($order === 'avg') {
                return "{$fields}, avg_views";
            }
                return "{$fields}, c.comment_count";

        });

        static::addFilterOnce('posts_orderby', function ($orderby) use ($range, $order) {

            if ($order === 'views') {
                return 'pageviews DESC';
            }
            if ($order === 'avg') {
                return 'avg_views DESC';
            }

            return ($range === 'all' ? '' : 'c.') . 'comment_count DESC';
        });

        static::addFilterOnce('posts_groupby', function ($groupby) use ($range, $order) {
            if ($range === 'all' && $order === 'avg') {
                return 'v.postid';
            }

            return $groupby;
        });

        static::addFilterOnce('posts_join', function ($join) use ($range, $order, $now) {

            /**
             * @var wpdb $wpdb
             */
            global $wpdb;

            if ($range === 'all') {
                if ($order !== 'comments') {
                    return "{$join} INNER JOIN `{$wpdb->prefix}popularpostsdata` v ON {$wpdb->posts}.ID = v.postid";
                }

                return $join;
            }

            $startDate = clone $now;

            switch($range) {
                case 'daily':
                    $startDate = $startDate->sub(new \DateInterval('P1D'));
                    $startDatetime = $startDate->format('Y-m-d H:i:s');
                    $views_time_range = "view_datetime >= '{$startDatetime}'";
                    break;
                case 'weekly':
                    $startDate = $startDate->sub(new \DateInterval('P6D'));
                    $startDatetime = $startDate->format('Y-m-d');
                    $views_time_range = "view_date >= '{$startDatetime}'";
                    break;
                case 'monthly':
                    $startDate = $startDate->sub(new \DateInterval('P29D'));
                    $startDatetime = $startDate->format('Y-m-d');
                    $views_time_range = "view_date >= '{$startDatetime}'";
                    break;
            }

            if ($order === 'views') {
                return "{$join} INNER JOIN (SELECT SUM(pageviews) AS pageviews, postid FROM `{$wpdb->prefix}popularpostssummary` WHERE {$views_time_range} GROUP BY postid) v ON {$wpdb->posts}.ID = v.postid";
            }

            if ($order === 'avg') {
                return "{$join} INNER JOIN (SELECT SUM(pageviews)/(IF (DATEDIFF('{$now->format('Y-m-d H:i:s')}', '{$startDatetime}') > 0, DATEDIFF('{$now->format('Y-m-d H:i:s')}', '{$startDatetime}'), 1)) AS avg_views, postid FROM `{$wpdb->prefix}popularpostssummary` WHERE {$views_time_range} GROUP BY postid) v ON {$wpdb->posts}.ID = v.postid";
            }

            if ($order === 'comments' && $range !== 'all') {
                return "{$join} INNER JOIN (SELECT COUNT(comment_post_ID) AS comment_count, comment_post_ID FROM `{$wpdb->comments}` WHERE comment_date_gmt >= '{$startDatetime}' AND comment_approved = '1' GROUP BY comment_post_ID) c ON {$wpdb->posts}.ID = c.comment_post_ID";
            }

        });

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
