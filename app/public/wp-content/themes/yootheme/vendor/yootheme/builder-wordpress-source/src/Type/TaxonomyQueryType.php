<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use YOOtheme\Builder\Source;
use YOOtheme\Str;

class TaxonomyQueryType
{
    /**
     * @param Source       $source
     * @param \WP_Taxonomy $taxonomy
     *
     * @return array
     */
    public static function config(Source $source, \WP_Taxonomy $taxonomy)
    {
        $name = Str::camelCase([$taxonomy->rest_base, 'Query'], true);
        $field = Str::camelCase($taxonomy->rest_base);

        $source->objectType($name, TaxonomyArchiveQueryType::config($taxonomy));
        $source->objectType($name, CustomTaxonomyQueryType::config($taxonomy));

        return [

            'fields' => [

                $field => [
                    'type' => $name,
                    'extensions' => [
                        'call' => __CLASS__ . '::resolve',
                    ],
                ],

            ],

        ];
    }

    public static function resolve($root)
    {
        return $root;
    }
}
