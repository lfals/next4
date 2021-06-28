<?php

namespace YOOtheme\Builder\Source\Type;

class SiteType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Site Title',
                        'filters' => ['limit'],
                    ],
                ],

                'page_title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Page Title',
                        'filters' => ['limit'],
                    ],
                ],

                'user' => [
                    'type' => 'User',
                    'metadata' => [
                        'label' => 'Current User',
                    ],
                ],

                'is_guest' => [
                    'type' => 'Int',
                    'metadata' => [
                        'label' => 'Guest User',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'Site',
            ],

        ];
    }
}
