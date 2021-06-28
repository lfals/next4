<?php

namespace YOOtheme;

use YOOtheme\Theme\StyleFontLoader;
use YOOtheme\Theme\StylerController;
use YOOtheme\Theme\StylerListener;

return [

    'theme' => function (Config $config) {

        $config->add('styler', ['ignore_less' => []]);

        return $config->loadFile(Path::get('./config/theme.json'));
    },

    'routes' => [
        ['get', '/theme/styles', [StylerController::class, 'loadStyle']],
        ['post', '/theme/styles', [StylerController::class, 'saveStyle']],
        ['get', '/styler/library', [StylerController::class, 'index']],
        ['post', '/styler/library', [StylerController::class, 'addStyle']],
        ['delete', '/styler/library', [StylerController::class, 'removeStyle']],
    ],

    'events' => [

        'customizer.init' => [
            StylerListener::class => 'initCustomizer',
        ],

    ],

    'services' => [

        StyleFontLoader::class => [
            'arguments' => ['$cache' => function () {
                return Path::get('~theme/fonts');
            }],
        ],

    ],

];
