<?php

namespace YOOtheme\Builder;

use YOOtheme\Builder;
use YOOtheme\Config;
use YOOtheme\Path;
use YOOtheme\View;

return [

    'routes' => [

        ['post', '/builder/encode', BuilderController::class . '@encodeLayout'],
        ['get', '/builder/library', BuilderController::class . '@index'],
        ['post', '/builder/library', BuilderController::class . '@addElement'],
        ['delete', '/builder/library', BuilderController::class . '@removeElement'],

    ],

    'events' => [

        'customizer.init' => [
            BuilderListener::class => ['initCustomizer', -10],
        ],

    ],

    'extend' => [

        View::class => function (View $view, $app) {

            $builder = function ($node, $params = []) use ($app) {

                // support old builder arguments
                if (!is_string($node)) {
                    $node = json_encode($node);
                }

                if (is_string($params)) {
                    $params = ['prefix' => $params];
                }

                return $app(Builder::class)->render($node, $params);
            };

            $view->addFunction('builder', $builder);
        },

    ],

    'services' => [

        Builder::class => function (Config $config, View $view, UpdateTransform $update, ElementTransform $element) {

            $config->addFile('builder', Path::get('./config/builder.json'));
            $config->addFilter('builder', function ($value) use ($config) { // map builder: to builder.
                return $config->get("builder.{$value}");
            });

            $builder = new Builder([$config, 'loadFile'], [$view, 'render']);
            $builder->addTransform('preload', $update);
            $builder->addTransform('preload', new DefaultTransform());
            $builder->addTransform('presave', new OptimizeTransform());
            $builder->addTransform('precontent', new NormalizeTransform());
            $builder->addTransform('prerender', new NormalizeTransform());
            $builder->addTransform('prerender', function ($node, $params) use ($config) {

                /**
                 * @var $index
                 * @var $type
                 * @var $prefix
                 * @var $parent
                 */
                extract($params);

                if ($type->container) {
                    $node->parent = !empty($node->children);
                }

                if ($parent && !empty($prefix) && ($type->element || $type->container)) {

                    $node->id = empty($parent->id) ? "{$prefix}#{$index}" : "{$parent->id}-{$index}";

                    if ($config('app.isCustomizer') && $type->element) {
                        $node->attrs['data-id'] = $node->id;
                    }
                }
            });

            if (!$config('app.isCustomizer')) {
                $builder->addTransform('precontent', new DisabledTransform());
                $builder->addTransform('prerender', new DisabledTransform());
            }

            $builder->addTransform('prerender', new PlaceholderTransform());
            $builder->addTransform('render', $element);
            $builder->addTransform('render', function ($node) {
                return !(empty($node->children) && !empty($node->parent));
            });

            $builder->addTypePath(Path::get('./elements/*/element.json'));

            return $builder;
        },

        UpdateTransform::class => function (Config $config) {

            $update = new UpdateTransform($config('theme.version'));
            $update->addGlobals(require __DIR__ . '/updates.php');

            return $update;
        },

    ],

];
