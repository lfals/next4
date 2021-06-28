<?php

namespace YOOtheme;

return [

    'aliases' => [
        Encrypter::class => 'encrypter',
    ],

    'services' => [

        Encrypter::class => function (Config $config) {
            return new Encryption\Encrypter($config('session.token'), $config('app.secret'));
        },

    ],

];
