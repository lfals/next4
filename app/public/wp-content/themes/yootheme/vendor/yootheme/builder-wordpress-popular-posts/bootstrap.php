<?php

namespace YOOtheme\Builder\Wordpress\PopularPosts;

return [

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSource', -10],
        ],

    ],

];
