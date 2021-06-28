<?php

namespace YOOtheme\Builder\Wordpress\Acf;

return [

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSource', -10],
        ],

    ],

];
