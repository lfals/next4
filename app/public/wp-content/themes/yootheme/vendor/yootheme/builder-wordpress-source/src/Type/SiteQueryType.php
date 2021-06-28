<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class SiteQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'site' => [
                    'type' => 'Site',
                    'metadata' => [
                        'label' => 'Site',
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
        $user = wp_get_current_user();
        return [
            'title' => get_bloginfo('name', 'display'),
            'page_title' => wp_title('&raquo;', false),
            'user' => $user->ID !== 0 ? $user : null,
            'is_guest' => (int) $user->ID === 0,
        ];
    }
}
