<?php

namespace YOOtheme\Theme\Wordpress;

return [

    'events' => [

        'customizer.init' => [
            EditorListener::class => 'enqueueEditor',
        ],

    ],

];
