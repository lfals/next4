<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class CustomUsersQueryType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'customUsers' => [

                    'type' => [
                        'listOf' => 'User',
                    ],

                    'args' => [
                        'roles' => [
                            'type' => [
                                'listOf' => 'String',
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
                        'label' => 'Custom Users',
                        'group' => 'Custom',
                        'fields' => [
                            'roles' => [
                                'label' => 'Roles',
                                'description' => 'Users are only loaded from the selected roless.',
                                'type' => 'select',
                                'attrs' => [
                                    'multiple' => true,
                                ],
                                'options' => [
                                    ['evaluate' => 'config.roles'],
                                ],
                            ],
                            '_offset' => [
                                'description' => 'Set the starting point and limit the number of users.',
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
                                        'default' => 'display_name',
                                        'options' => [
                                            'Alphabetical' => 'display_name',
                                            'Register date' => 'user_registered',
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
                        'call' => __CLASS__ . '::resolve',
                    ],

                ],

            ],

        ];

    }

    public static function resolve($root, array $args)
    {
        $query = [
            'orderby' => $args['order'],
            'order' => $args['order_direction'],
            'offset' => $args['offset'],
            'number' => $args['limit'],
        ];

        if (!empty($args['roles'])) {
            $query['role__in'] = $args['roles'];
        }

        return get_users($query);
    }
}
