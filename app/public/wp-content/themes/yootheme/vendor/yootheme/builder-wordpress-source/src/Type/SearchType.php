<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class SearchType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'searchword' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Search Word',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::searchQuery',
                    ],
                ],

                'total' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Item Count',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::foundPosts',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'Search',
            ],

        ];
    }

    public static function searchQuery()
    {
        return get_search_query();
    }

    public static function foundPosts()
    {
        global $wp_query;
        return $wp_query->found_posts;
    }
}
