<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use WP_User;

class UserType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'name' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Name',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::name',
                    ],
                ],

                'nicename' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Nicename',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::nicename',
                    ],
                ],

                'nickname' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Nickname',
                        'filters' => ['limit'],
                    ],
                ],

                'firstName' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'First name',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::firstName',
                    ],
                ],

                'lastName' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Last name',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::lastName',
                    ],
                ],

                'description' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Description',
                        'filters' => ['limit'],
                    ],
                ],

                'email' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Email',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::email',
                    ],
                ],

                'registered' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Registered',
                        'filters' => ['date'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::registered',
                    ],
                ],

                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Website Url',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::url',
                    ],
                ],

                'link' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Link',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::link',
                    ],
                ],

                'avatar' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Avatar',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::avatar',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'User',
            ],

        ];
    }

    public static function name(WP_User $user)
    {
        return $user->display_name;
    }

    public static function nicename(WP_User $user)
    {
        return $user->user_nicename;
    }

    public static function firstName(WP_User $user)
    {
        return $user->first_name;
    }

    public static function lastName(WP_User $user)
    {
        return $user->last_name;
    }

    public static function email(WP_User $user)
    {
        return $user->user_email;
    }

    public static function registered(WP_User $user)
    {
        return $user->user_registered;
    }

    public static function url(WP_User $user)
    {
        return $user->user_url;
    }

    public static function link(WP_User $user)
    {
        return get_author_posts_url($user->ID);
    }

    public static function avatar(WP_User $user)
    {
        return get_avatar_url($user->ID);
    }
}
