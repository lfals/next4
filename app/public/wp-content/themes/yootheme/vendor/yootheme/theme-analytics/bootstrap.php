<?php

namespace YOOtheme;

use YOOtheme\Theme\AnalyticsListener;

return [

    'events' => [

        'theme.head' => [
            AnalyticsListener::class => 'initHead',
        ],

    ],

];
