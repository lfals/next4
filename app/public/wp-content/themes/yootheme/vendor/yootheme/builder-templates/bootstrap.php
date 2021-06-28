<?php

namespace YOOtheme;

use YOOtheme\Builder\Templates\TemplateController;
use YOOtheme\Builder\Templates\TemplateHelper;
use YOOtheme\Builder\Templates\TemplateListener;

return [

    'routes' => [

        ['post', '/builder/template', [TemplateController::class, 'saveTemplate']],
        ['delete', '/builder/template', [TemplateController::class, 'deleteTemplate']],
        ['post', '/builder/template/reorder', [TemplateController::class, 'reorderTemplates']],

    ],

    'events' => [

        'builder.data' => [
            TemplateListener::class => 'loadTemplates',
        ],

        'customizer.init' => [
            TemplateListener::class => ['initCustomizer', -20],
        ],

    ],

    'services' => [

        TemplateHelper::class => '',

    ],

];
