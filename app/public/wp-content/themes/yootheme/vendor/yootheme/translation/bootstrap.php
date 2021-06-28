<?php

namespace YOOtheme;

require __DIR__ . '/functions.php';

return [

    'services' => [

        Translator::class => function (Config $config) {

            $translator = new Translation\Translator();
            $translator->setLocale($config('locale.code'));

            return $translator;
        },

    ],

];
