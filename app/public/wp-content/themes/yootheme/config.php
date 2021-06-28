<?php

namespace YOOtheme;

return [

    'theme' => function () {

        return [

            'name' => 'YOOtheme',

            'version' => '2.4.17',

            'url' => Url::to(__DIR__),

            'rootDir' => __DIR__,

            'menus' => [
                'navbar' => 'Navbar',
                'mobile' => 'Mobile'
            ],

            'positions' => [
                'toolbar-left' => 'Toolbar Left',
                'toolbar-right' => 'Toolbar Right',
                'logo' => 'Logo',
                'logo-mobile' => 'Logo Mobile',
                'navbar' => 'Navbar',
                'header' => 'Header',
                'top' => 'Top',
                'sidebar' => 'Sidebar',
                'bottom' => 'Bottom',
                'mobile' => 'Mobile',
                'builder-1' => 'Builder 1',
                'builder-2' => 'Builder 2',
                'builder-3' => 'Builder 3',
                'builder-4' => 'Builder 4',
                'builder-5' => 'Builder 5',
                'builder-6' => 'Builder 6'
            ],

            'styles' => [

                'imports' => [
                    Path::get('./vendor/assets/uikit/src/images/backgrounds/*.svg'),
                    Path::get('./vendor/assets/uikit-themes/*/images/*.svg'),
                ]

            ],

            'defaults' => [

                'menu' => [
                    'positions' => [
                        'navbar' => '',
                        'mobile' => '',
                    ]
                ]

            ]

        ];

    },

    'config' => function () {

        return [

            'image' => [
                'cacheDir' => Path::get('./cache')
            ]

        ];

    },

];
