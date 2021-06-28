<?php

namespace YOOtheme;

use YOOtheme\Theme\CustomizerListener;
use YOOtheme\Theme\ImageLoader;
use YOOtheme\Theme\ThemeListener;
use YOOtheme\Theme\Updater;
use YOOtheme\Theme\ViewHelper;

return [

    'theme' => function (Config $config) {
        return $config->loadFile(Path::get('./config/theme.json'));
    },

    'events' => [

        'theme.head' => [
            ThemeListener::class => ['initHead', -10],
        ],

        'metadata.load' => [
            ThemeListener::class => ['loadMetadata', -10],
        ],

        'customizer.init' => [
            CustomizerListener::class => [['initCustomizer', 0], ['lateInitCustomizer', -20]],
        ],

        'app.request' => [
            CustomizerListener::class => 'handleRequest',
        ],

    ],

    'extend' => [

        View::class => function (View $view, $app) {
            $app(ViewHelper::class)->register($view);
        },

        ImageProvider::class => function (ImageProvider $image, $app) {
            $image->addLoader($app(ImageLoader::class));
        },

    ],

    'services' => [

        Updater::class => function (Config $config) {

            $updater = new Updater($config('theme.version'));
            $updater->add(Path::get('./updates.php'));

            return $updater;
        },

    ],

];
