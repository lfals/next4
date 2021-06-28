<?php

namespace YOOtheme\Theme\Wordpress;

return [

    'events' => [

        'theme.init' => [
            WooCommerceListener::class => 'initTheme',
        ],

        'customizer.init' => [
            WooCommerceListener::class => 'initCustomizer',
        ],

        'builder.template' => [
            WooCommerceListener::class => ['matchTemplate', 10],
        ],

    ],

    'filters' => [

        'woocommerce_enqueue_styles' => [
            WooCommerceListener::class => 'removeStyle',
        ],

    ],

];
