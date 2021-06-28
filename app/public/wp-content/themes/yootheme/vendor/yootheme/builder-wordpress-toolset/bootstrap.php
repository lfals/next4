<?php

namespace YOOtheme\Builder\Wordpress\Toolset;

use YOOtheme\Builder\UpdateTransform;

return [

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSource', -10],
        ],

    ],

    'extend' => [

        UpdateTransform::class => function (UpdateTransform $update) {
            $update->addGlobals(require __DIR__ . '/updates.php');
        },

    ],

];
