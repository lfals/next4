<?php

namespace YOOtheme\Builder\Wordpress\Toolset;

use YOOtheme\Arr;
use YOOtheme\Builder\Wordpress\Toolset\Type\ValueType;
use YOOtheme\Str;

class SourceListener
{
    public static function initSource($source)
    {
        // is toolset installed?
        if (!in_array('types/wpcf.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            return;
        }

        $arguments = [
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
        ];

        $source->objectType('ToolsetValueField', ValueType::config());

        $source->objectType('ToolsetValueStringField', ValueType::configString());

        $source->objectType('ToolsetDateField', ValueType::configDate());

        // add user fields
        if ($fields = Helper::fieldsGroups('user')) {
            static::configFields($source, 'User', $fields);
        }

        // add post fields
        foreach (get_post_types($arguments, 'objects') as $name => $type) {

            if (!$type->rest_base || $name === $type->rest_base) {
                continue;
            }

            if ($fields = Helper::fieldsGroups('post', $name)) {
                static::configFields($source, $name, $fields);
                static::configOrder($source, $type->name, $type);
                static::configOrder($source, $type->rest_base, $type);
            }

            if ($relationships = Helper::getRelationships($name)) {
                static::configRelationshipFields($source, $name, $relationships);
            }
        }

        // add taxonomy fields
        foreach (get_taxonomies($arguments, 'objects') as $name => $taxonomy) {

            if (!$taxonomy->rest_base) {
                continue;
            }

            if ($fields = Helper::fieldsGroups('term', $name)) {
                static::configFields($source, $name, $fields);
            }
        }
    }

    public static function configFields($source, $name, array $fields)
    {
        $type = Str::camelCase([$name, 'Toolset'], true);

        // add field on type
        $source->objectType(Str::camelCase($name, true), [

            'fields' => [

                'toolset' => [
                    'type' => $type,
                    'metadata' => [
                        'label' => 'Fields',
                    ],
                    'extensions' => [
                        'call' => Type\FieldsType::class . '::toolset',
                    ],
                ],

            ],

        ]);

        $source->objectType($type, Type\FieldsType::config($source, $fields));
    }

    public static function configOrder($source, $query, \WP_Post_Type $type)
    {
        $name = Str::camelCase([$type->rest_base, 'Query'], true);
        $field = Str::camelCase(['custom', $query]);

        $key = "fields.{$field}.metadata.fields._order.fields.order.options";

        $source->objectType($name, function ($typeDef) use ($key, $type) {

            Arr::update($typeDef->config, $key, function ($options) use ($type) {

                $orderOptions = [];

                foreach (Helper::groups('post', $type->name) as $group) {

                    $toolsetFields = Helper::fields('post', $group->get_field_slugs(), false);

                    $orderOptions[$group->get_display_name()] = array_map(function ($name) {
                        return "field:wpcf-{$name}";
                    }, array_column($toolsetFields, 'slug', 'name'));
                }

                return array_replace_recursive($options, $orderOptions);
            });
        });
    }

    public static function configRelationshipFields($source, $name, array $relationships)
    {
        $type = Str::camelCase([$name, 'Toolset'], true);

        // add field on type
        $source->objectType(Str::camelCase($name, true), [

            'fields' => [

                'toolset' => [
                    'type' => $type,
                    'metadata' => [
                        'label' => 'Fields',
                    ],
                    'extensions' => [
                        'call' => Type\FieldsType::class . '::toolset',
                    ],
                ],

            ],

        ]);

        $source->objectType($type, Type\RelationshipFieldsType::config($source, $name, $relationships));
    }
}
