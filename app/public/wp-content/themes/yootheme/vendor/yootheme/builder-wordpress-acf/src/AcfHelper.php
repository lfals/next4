<?php

namespace YOOtheme\Builder\Wordpress\Acf;

class AcfHelper
{
    /**
     * @param string $type
     * @param string $name
     * @param array  $ignore
     *
     * @return array
     */
    public static function fields($type, $name = '', array $ignore = [])
    {
        $fields = [];

        foreach (static::groups($type, $name) as $group) {
            foreach (acf_get_fields($group) as $field) {
                if (!in_array($field['type'], $ignore)) {
                    $fields[$field['name']] = $field + compact('group');
                }
            }
        }

        return $fields;
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return array
     */
    public static function groups($type, $name)
    {
        $groups = [];

        foreach (acf_get_field_groups() as $group) {
            if (self::matchGroup($group, $type, $name)) {
                $groups[] = $group;
            }
        }

        return $groups;
    }

    protected static function matchGroup($group, $type, $name)
    {
        foreach ($group['location'] as $rules) {
            foreach ($rules ?: [] as $rule) {

                /**
                 * @var $param
                 * @var $operator
                 * @var $value
                 */
                extract($rule);

                if ($type === 'post' && $param === 'post_type' && acf_match_location_rule($rule, ['post_type' => $name], $group)
                    || $type === 'term' && $param === 'taxonomy' && acf_match_location_rule($rule, ['taxonomy' => $name], $group)
                    || $type === 'user' && $operator === '==' && $value === 'all' && in_array($param, ['user_role', 'user_form'])
                ) {
                    return true;
                }
            }
        }
    }
}
