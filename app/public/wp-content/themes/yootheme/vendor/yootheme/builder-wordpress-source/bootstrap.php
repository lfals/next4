<?php

namespace YOOtheme\Builder\Wordpress\Source;

use YOOtheme\Builder;
use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Builder\UpdateTransform;
use YOOtheme\Path;

return [

    'config' => [

        'source' => [
            'id' => get_current_blog_id(),
        ],

    ],

    'routes' => [
        ['get', '/wordpress/posts', [SourceController::class, 'posts']],
    ],

    'events' => [

        'source.init' => [
            SourceListener::class => 'initSource',
        ],

        'customizer.init' => [
            SourceListener::class => ['initCustomizer', 10],
        ],

        'builder.template' => [
            TemplateListener::class => 'matchTemplate',
        ],

    ],

    'filters' => [

        'template_include' => [
            TemplateListener::class => ['includeTemplate', 20],
        ],

        'wp_link_query_args' => [
            SourceListener::class => 'addPostTypeFilter',
        ],

    ],

    'extend' => [

        Builder::class => function (Builder $builder) {
            $builder->addTypePath(Path::get('./elements/*/element.json'));
        },

        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        },

        SourceTransform::class => function (SourceTransform $transform) {

            $transform->addFilter('date', function ($value, $format) {

                if (!$value) {
                    return $value;
                }

                if (is_string($value) && !is_numeric($value)) {
                    $value = strtotime($value);
                }

                return date_i18n($format ?: get_option('date_format', 'd/m/Y'), intval($value) ?: time());
            });

        },

    ],

];
