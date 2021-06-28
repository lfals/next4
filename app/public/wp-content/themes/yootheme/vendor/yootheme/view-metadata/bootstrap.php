<?php

namespace YOOtheme;

use YOOtheme\View\MetadataManager;

return [

    'extend' => [

        View::class => function (View $view, $app) {
            $view->addFunction('metadata', $app->wrap(Metadata::class . '@set'));
        },

    ],

    'aliases' => [
        Metadata::class => 'metadata',
    ],

    'services' => [
        Metadata::class => MetadataManager::class,
    ],

];
