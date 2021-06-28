<?php

namespace YOOtheme\Builder\Wordpress\Acf;

use YOOtheme\Arr;
use YOOtheme\Str;

class SourceListener
{
    public static function initSource($source)
    {
        // is acf installed?
        if (!is_callable('acf_get_fields')) {
            return;
        }

        $ignore = [
            'tab',
            'clone',
            'message',
            'accordion',
            'flexible_content',
        ];

        $arguments = [
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
        ];

        $source->objectType('LinkField', Type\LinkFieldType::config());
        $source->objectType('ValueField', Type\ValueFieldType::config());
        $source->objectType('ChoiceField', Type\ChoiceFieldType::config());
        $source->objectType('ChoiceFieldString', Type\ChoiceFieldStringType::config());
        $source->objectType('GoogleMapsField', Type\GoogleMapsFieldType::config());

        if ($fields = AcfHelper::fields('user', '', $ignore)) {
            static::configFields($source, 'User', $fields);
        }

        foreach (get_post_types($arguments, 'objects') as $name => $type) {

            if (!$type->rest_base || $name === $type->rest_base) {
                continue;
            }

            if ($fields = AcfHelper::fields('post', $name, $ignore)) {
                static::configFields($source, $name, $fields);
                static::configOrder($source, $type->name, $type);
                static::configOrder($source, $type->rest_base, $type);

            }
        }

        foreach (get_taxonomies($arguments, 'objects') as $name => $taxonomy) {

            if (!$taxonomy->rest_base) {
                continue;
            }

            if ($fields = AcfHelper::fields('term', $name, $ignore)) {
                static::configFields($source, $name, $fields);
            }
        }
    }

    protected static function configFields($source, $name, array $fields)
    {
        $type = Str::camelCase([$name, 'Fields'], true);

        // add field on type
        $source->objectType(Str::camelCase($name, true), [

            'fields' => [

                'field' => [
                    'type' => $type,
                    'metadata' => [
                        'label' => 'Fields',
                    ],
                    'extensions' => [
                        'call' => Type\FieldsType::class . '::field',
                    ],
                ],

            ],

        ]);

        // configure field type
        $source->objectType($type, Type\FieldsType::config($source, $fields));
    }

    protected static function configOrder($source, $query, \WP_Post_Type $type)
    {
        $name = Str::camelCase([$type->rest_base, 'Query'], true);
        $field = Str::camelCase(['custom', $query]);

        $key = "fields.{$field}.metadata.fields._order.fields.order.options";

        $source->objectType($name, function ($typeDef) use ($key, $type) {

            Arr::update($typeDef->config, $key, function ($options) use ($type) {

                $orderOptions = [];

                foreach (AcfHelper::groups('post', $type->name) as $group) {
                    $orderOptions[$group['title']] = array_map(function ($name) {
                        return "field:{$name}";
                    }, array_column(acf_get_fields($group), 'name', 'label'));
                }

                return array_replace_recursive($options, $orderOptions);
            });
        });
    }
}
