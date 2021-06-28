<?php

namespace YOOtheme\Application;

use YOOtheme\Config;
use YOOtheme\Database;
use YOOtheme\Path;
use YOOtheme\Url;
use YOOtheme\View;

return [

    'config' => function (Config $config) {

        $config->addFilter('url', function ($value, $file) {
            return Url::to(Path::resolve(dirname($file), $value));
        });

    },

    'extend' => [

        View::class => function (View $view, $app) {
            $view->addGlobal('app', $app);
            $view->addGlobal('config', $app(Config::class));
        },

    ],

    'aliases' => [

        View::class => 'view',
        Database::class => 'db',

    ],

    'loaders' => [

        'services' => new ServiceLoader(),
        'aliases' => new AliasLoader(),
        'extend' => new ExtendLoader(),
        'events' => new EventLoader(),
        'routes' => new RouteLoader(),
        'config' => new ConfigLoader(),

    ],

];
