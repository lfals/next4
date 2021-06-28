<?php

namespace YOOtheme\Builder\Wordpress\Toolset\Type;

use YOOtheme\Builder\Wordpress\Toolset\Helper;
use YOOtheme\Str;

class RelationshipType
{
    public static function config($name, $relationship)
    {
        $intermediary = isset($relationship['roles']['intermediary']) ?
            Helper::fieldsGroups('post', $relationship['roles']['intermediary']['types']) : [];

        return [

            'fields' => array_merge([

                'post' => [

                    'type' => Str::camelCase($name, true),
                    'metadata' => [
                        'label' => 'Post',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::resolvePost',
                    ],

                ],

            ], array_filter(array_reduce($intermediary, function ($fields, $field) {

                return $fields + Helper::loadFields($field, [
                    'type' => 'String',
                    'name' => strtr($field['slug'], '-', '_'),
                    'metadata' => [
                        'label' => $field['name'],
                        'group' => $field['group'],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolveIntermediaryField',
                            'args' => ['slug' => $field['slug']],
                        ],
                    ],
                ]);
            }, []))),

        ];
    }

    public static function resolvePost($item)
    {
        return get_post($item['post']);
    }

    public static function resolveIntermediaryField($item, $args)
    {
        if (!isset($item['intermediary'])) {
            return;
        }

        $post = get_post($item['intermediary']);
        $fieldService = new \Types_Field_Service(false);
        $fieldInstance = $fieldService->get_field(new \Types_Field_Gateway_Wordpress_Post(), $args['slug'], $post->ID);

        if ($fieldInstance) {
            return Helper::getFieldValue($fieldInstance);
        }
    }
}
