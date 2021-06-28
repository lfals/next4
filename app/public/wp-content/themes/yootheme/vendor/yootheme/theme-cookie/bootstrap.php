<?php

namespace YOOtheme;

use YOOtheme\Theme\CookieListener;

return [

    'theme' => function (Config $config) {
        return $config->loadFile(Path::get('./config/theme.json'));
    },

    'events' => [

        'theme.head' => [
            CookieListener::class => 'initHead',
        ],

    ],

];
