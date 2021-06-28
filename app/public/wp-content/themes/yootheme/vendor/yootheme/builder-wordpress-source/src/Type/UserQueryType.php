<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class UserQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'authorArchive' => [

                    'type' => 'User',

                    'metadata' => [
                        'group' => 'Page',
                        'label' => 'Author',
                        'view' => ['author-archive'],
                    ],

                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],

                ],

            ],

        ];
    }

    public static function resolve($root)
    {
        global $post;
        return get_userdata($post->post_author) ?: null;
    }
}
