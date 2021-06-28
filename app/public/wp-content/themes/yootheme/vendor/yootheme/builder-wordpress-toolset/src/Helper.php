<?php

namespace YOOtheme\Builder\Wordpress\Toolset;

use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\Url;

class Helper
{
    /**
     * @param string $type
     * @param string $name
     *
     * @return array
     */
    public static function groups($type, $name)
    {
        if (!class_exists('\Toolset_Field_Group_Post_Factory')) {
            return [];
        }

        if ($type === 'post') {
            $fieldGroups = \Toolset_Field_Group_Post_Factory::get_instance()
                ->get_groups_by_post_type($name);

            $factory = \Toolset_Field_Group_Post_Factory::get_instance();
        } elseif ($type === 'term') {
            $fieldGroups = \Toolset_Field_Group_Term_Factory::get_instance()
                ->get_groups_by_taxonomy($name);

            $factory = \Toolset_Field_Group_Term_Factory::get_instance();
        } elseif ($type === 'user') {
            $fieldGroups = \Toolset_Field_Group_User_Factory::get_instance()
                ->get_groups_by_roles();
            $fieldGroups = array_merge(...array_values($fieldGroups));

            $factory = \Toolset_Field_Group_User_Factory::get_instance();
        }

        return array_map(function ($fieldGroup) use ($factory) {
            return $factory->load_field_group($fieldGroup->get_slug());
        }, $fieldGroups);
    }

    public static function fields($type, $fieldSlugs, $loadRFG = true)
    {
        if ($type === 'post') {
            $factory = \Toolset_Field_Definition_Factory_Post::get_instance();
        } elseif ($type === 'term') {
            $factory = \Toolset_Field_Definition_Factory_Term::get_instance();
        } elseif ($type === 'user') {
            $factory = \Toolset_Field_Definition_Factory_User::get_instance();
        } else {
            return [];
        }

        $rfg_service = new \Types_Field_Group_Repeatable_Service();

        $fields = [];
        foreach ($fieldSlugs as $slug) {
            $field = $factory->load_field_definition($slug);

            if ($field && $field->is_managed_by_types()) {
                $fields[$slug] = $field->get_definition_array();
            } elseif ($loadRFG) {
                $repeatableGroup = $rfg_service->get_object_from_prefixed_string($slug);
                $groupFieldSlugs = $repeatableGroup->get_field_slugs();

                if ($groupFieldSlugs) {
                    $fields[$slug] = [
                        'name' => $repeatableGroup->get_name(),
                        'slug' => $slug,
                        'type' => 'rfg',
                        'fieldSlugs' => $groupFieldSlugs,
                    ];
                }
            }
        }

        return $fields;
    }

    public static function fieldsGroups($type, $name = null)
    {
        $fields = [];
        foreach (static::groups($type, $name) as $group) {
            foreach (static::fields($type, $group->get_field_slugs()) as $field) {
                $field['group'] = $group->get_display_name();
                $fields[$field['slug']] = $field;
            }
        }

        return $fields;
    }

    public static function getRelationships($name)
    {
        return toolset_get_relationships([
            'type_constraints' => [
                'any' => [
                    'type' => $name,
                ],
                'parent' => [
                    'domain' => 'posts',
                ],
                'child' => [
                    'domain' => 'posts',
                ],
            ],
            'origin' => 'any',
        ]);
    }

    public static function loadFields($field, array $config)
    {
        $fields = [];

        if ($field['type'] === 'post') {
            $post = self::getPostType($field['data']['post_reference_type']);

            if (!$post) {
                return [];
            }

            $type = Str::camelCase($post->name, true);

            $fields[] = [
                'type' => self::isMultiple($field) ? ['listOf' => $type] : $type,
            ] + $config;

        } elseif ($field['type'] === 'date') {

            if (self::isMultiple($field)) {
                $fields[] = [
                    'type' => [
                        'listOf' => 'ToolsetDateField',
                    ],
                ];
            } else {
                $fields[] = array_merge_recursive(
                    $config,
                    ['metadata' => ['filters' => ['date']]]
                );
            }

        } else {

            if (self::isMultiple($field)) {
                $fields[] = [
                    'type' => [
                        'listOf' => 'ToolsetValueField',
                    ],
                ] + $config;

                // add concat field
                if ($field['type'] === 'checkboxes') {
                    $fields[] = [
                        'name' => $config['name'] . 'String',
                        'type' => 'ToolsetValueStringField',
                    ] + $config;
                }
            } else {
                $fields[] = $config;
            }
        }

        return array_combine(array_column($fields, 'name'), $fields);
    }

    public static function getFieldValue($fieldInstance)
    {
        $field = $fieldInstance->to_array();

        // support for legacy types
        if (!$field && method_exists($fieldInstance, 'get_data_raw')) {
            $field = $fieldInstance->get_data_raw();
        }

        $fieldType = $fieldInstance->get_type();

        if (in_array($fieldType, ['checkboxes', 'radio', 'select'])) {

            $options = $fieldInstance->get_options();
            $value = array_map(function ($option) {
                return $option->get_value();
            }, $options);

            // filter unchecked radio, select options
            $value = array_values(array_filter($value));
        } elseif (in_array($fieldType, ['checkbox'])) {

            $option = $fieldInstance->get_option();
            $value = [
                $option->get_value(),
            ];
        } elseif (in_array($fieldType, ['post'])) {
            return $fieldInstance->get_post();
        } else {
            $value = $fieldInstance->get_value();
        }

        // format latitude and longitude for maps element
        if (in_array($fieldType, ['google_address'])) {
            $value = array_map(function ($value) {
                return preg_replace('/^{(.+)}$/', '$1', $value);
            }, $value);
        }

        // make absolute image paths relative
        if ($fieldType === 'image' && is_array($value)) {
            $value = array_map(function ($src) {

                $base = Url::base();
                $url = set_url_scheme($src, 'relative');

                return Str::startsWith($url, $base)
                    ? Path::relative($base, $url)
                    : $url;

            }, $value);
        }

        if ($value && self::isMultiple($field)) {
            return array_map(function ($value) {
                return compact('value');
            }, $value);
        }

        return isset($value[0]) ? $value[0] : null;
    }

    public static function getPostType($post_type)
    {
        global $wp_post_types;

        if (empty($wp_post_types[$post_type]->rest_base) || $wp_post_types[$post_type]->name === $wp_post_types[$post_type]->rest_base) {
            return;
        }

        return $wp_post_types[$post_type];
    }

    public static function isMultiple($field)
    {
        if (in_array($field['type'], ['checkboxes', 'relationship'])) {
            return isset($field['data']['options']) && count($field['data']['options']) > 1;
        }

        return isset($field['data']['repetitive']) && $field['data']['repetitive'] === '1';
    }
}
