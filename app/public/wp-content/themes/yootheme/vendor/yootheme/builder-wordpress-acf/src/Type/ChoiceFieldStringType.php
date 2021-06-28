<?php

namespace YOOtheme\Builder\Wordpress\Acf\Type;

class ChoiceFieldStringType
{
    /**
     * @return array
     */
    public static function config()
    {
        $field = [
            'type' => 'String',
            'args' => [
                'separator' => [
                    'type' => 'String',
                ],
            ],
            'metadata' => [
                'arguments' => [
                    'separator' => [
                        'label' => 'Separator',
                        'description' => 'Set the separator between fields.',
                        'default' => ', ',
                    ],
                ],
            ],
            'extensions' => [
                'call' => __CLASS__ . '::resolve',
            ],
        ];

        return [

            'fields' => [

                'label' => array_merge_recursive($field, [
                    'metadata' => [
                        'label' => 'Labels',
                    ],
                ]),

                'value' => array_merge_recursive($field, [
                    'metadata' => [
                        'label' => 'Values',
                    ],
                ]),

            ],

        ];
    }

    public static function resolve($item, $args, $context, $info)
    {
        $args += ['separator' => ', '];

        return join($args['separator'], array_column($item, $info->fieldName));
    }
}
