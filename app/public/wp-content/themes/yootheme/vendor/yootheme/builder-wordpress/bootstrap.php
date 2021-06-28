<?php

namespace YOOtheme;

use YOOtheme\Builder\Wordpress\BuilderController;
use YOOtheme\Builder\Wordpress\ContentListener;

return [

    'routes' => [
        ['post', '/page', [ContentListener::class, 'savePage']],
        ['post', '/builder/image', [BuilderController::class, 'loadImage']],
    ],

    'filters' => [

        'pre_post_content' => [
            ContentListener::class => 'onPrePostContent',
        ],

        'builder_content' => [
            ContentListener::class => ['onBuilderContent', 10, 2],
        ],

        'template_include' => [
            ContentListener::class => [['onTemplateInclude'], ['onLateTemplateInclude', 50]],
        ],

    ],

    'extend' => [

        View::class => function (View $view) {

            $loader = function ($name, $parameters, callable $next) {

                $content = $next($name, $parameters);

                return empty($parameters['context']) || $parameters['context'] !== 'content'
                    ? apply_filters('builder_content', $content, $parameters)
                    : $content;
            };

            $view->addLoader($loader, '*/builder/elements/layout/templates/template.php');
        },

        Builder::class => function (Builder $builder, $app) {

            $builder->addTypePath(Path::get('./elements/*/element.json'));

            if ($childDir = $app->config->get('theme.childDir')) {
                $builder->addTypePath("{$childDir}/builder/*/element.json");
            }

        },

    ],

];
