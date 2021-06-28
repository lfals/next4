<?php

namespace YOOtheme\Builder;

use YOOtheme\Application;
use YOOtheme\Builder;
use YOOtheme\Builder\Source\SourceListener;
use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Event;
use YOOtheme\GraphQL\Directive\SliceDirective;
use YOOtheme\GraphQL\Plugin\ContainerPlugin;
use YOOtheme\GraphQL\Type\ObjectScalarType;

return [

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSource', 50],
        ],

        'source.error' => [
            SourceListener::class => 'errorSource',
        ],

        'customizer.init' => [
            SourceListener::class => 'initCustomizer',
        ],

    ],

    'extend' => [

        // Before Placeholder Transform, after Normalize and Id Transform
        Builder::class => function (Builder $builder, $app) {
            $builder->addTransform('prerender', $app(SourceTransform::class), 2);
        },

    ],

    'services' => [

        Source::class => function (SliceDirective $slice, ObjectScalarType $objectType) {

            $source = new Source([new ContainerPlugin(Application::getInstance())]);
            $source->setType($objectType);
            $source->setDirective($slice);

            Event::emit('source.init', $source);

            return $source;
        },

    ],

];
