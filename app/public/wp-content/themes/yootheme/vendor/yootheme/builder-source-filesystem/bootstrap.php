<?php

namespace YOOtheme\Builder\Source\Filesystem;

use YOOtheme\Config;

return [

    'events' => [

        'source.init' => [
            SourceListener::class => ['initSource', -5], // -5 to show the 'External' Group after the 'Custom' Group
        ],

    ],

    'services' => [

        FileHelper::class => function (Config $config) {
            return new FileHelper($config('app.uploadDir'));
        },

    ],

];
