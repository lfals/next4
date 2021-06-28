<?php

namespace YOOtheme\Builder\Wordpress\Toolset\Type;

use YOOtheme\Builder\Wordpress\Toolset\Helper;
use YOOtheme\Str;

class RelationshipFieldsType
{
    public static function config($source, $name, $relationships)
    {
        return [

            'fields' => array_filter(array_map(function ($relationship) use ($source, $name) {

                // determine role in relationship
                $isParent = $relationship['roles']['parent']['types'][0] === $name;

                $config = [
                    'name' => strtr($relationship['slug'], '-', '_'),
                    'metadata' => [
                        'label' => $relationship['labels']['singular'],
                        'group' => 'Relationships',
                    ],
                    'extensions' => [
                        'call' => [
                            'args' => [
                                'slug' => $relationship['slug'],
                                'isParent' => $isParent,
                            ],
                        ],
                    ],
                ];

                // find type of related items
                $type = $relationship['roles'][$isParent ? 'child' : 'parent']['types'][0];
                $post = Helper::getPostType($type);
                if (!$post) {
                    return false;
                }

                if ($relationship['cardinality']['type'] === 'one-to-one' || ($relationship['cardinality']['type'] === 'one-to-many' && !$isParent)) {

                    $config['type'] = $type = Str::camelCase($post->name, true);
                    $config['extensions']['call']['func'] = __CLASS__ . '::resolve';
                } else {

                    $relationshipName = Str::camelCase(['toolset', $post->name, $relationship['slug']], true);

                    $source->objectType($relationshipName, RelationshipType::config($post->name, $relationship));

                    $config['type'] = ['listOf' => $relationshipName];
                    $config['extensions']['call']['func'] = __CLASS__ . '::resolveManyToMany';
                }

                return $config;

            }, $relationships)),

        ];
    }

    public static function resolve($post, $args, $context, $info)
    {
        $related = toolset_get_related_post($post, $args['slug'], $args['isParent'] ? 'child' : 'parent');

        if ($related !== 0) {
            return get_post($related);
        }
    }

    public static function resolveManyToMany($post, $args, $context, $info)
    {
        $isParent = $args['isParent'];

        $roles = toolset_get_related_posts($post, $args['slug'], [
            'query_by_role' => $isParent ? 'parent' : 'child',
            'role_to_return' => [$isParent ? 'child' : 'parent', 'intermediary'],
        ]);

        return array_map(function ($role) use ($isParent) {

            return [
                'post' => $role[$isParent ? 'child' : 'parent'],
                'intermediary' => $role['intermediary'],
            ];
        }, $roles);
    }
}
