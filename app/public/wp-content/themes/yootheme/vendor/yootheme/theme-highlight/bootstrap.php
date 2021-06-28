<?php

namespace YOOtheme;

use YOOtheme\Theme\HighlightListener;

return [

    'actions' => [

        'onBeforeRender' => [
            HighlightListener::class => 'beforeRender',
        ],

    ],

    'filters' => [

        'builder_content' => [
            HighlightListener::class => 'checkContent',
        ],

    ],

];
