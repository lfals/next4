<?php

namespace YOOtheme\Builder\Wordpress\Toolset\Type;

use YOOtheme\Builder\Wordpress\Toolset\Helper;

class GroupType
{
    public static function config($fieldGroup)
    {
        return [

            'fields' => array_filter(array_reduce(Helper::fields('post', $fieldGroup['fieldSlugs'], true), function ($fields, $field) use ($fieldGroup) {

                return $fields + Helper::loadFields($field, [
                    'type' => 'String',
                    'name' => strtr($field['slug'], '-', '_'),
                    'metadata' => [
                        'label' => $field['name'],
                        'group' => $fieldGroup['name'],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => ['slug' => $field['slug']],
                        ],
                    ],
                ]);

            }, [])),

        ];

    }

    public static function resolve($item, $args, $context, $info)
    {
        foreach ($item->get_fields() as $fieldInstance) {
            if ($fieldInstance->get_slug() === $args['slug']) {
                return Helper::getFieldValue($fieldInstance);
            }
        }
    }
}
