<?php

namespace YOOtheme;

use YOOtheme\Image\ExifLoader;

return [

    'routes' => [
        ['get', '/image', ImageController::class . '@get', ['allowed' => true, 'save' => true]],
    ],

    'aliases' => [
        ImageProvider::class => 'image',
    ],

    'services' => [

        ImageProvider::class => function (Config $config) {

            $provider = new ImageProvider($config('image.cacheDir'), [
                'route' => 'image',
                'secret' => $config('app.secret'),
            ]);

            return $provider->addLoader(new ExifLoader());
        },

    ],

];
