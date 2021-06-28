<?php

namespace YOOtheme;

use YOOtheme\Theme\Wordpress\Breadcrumbs;

return [

    'transforms' => [

        'render' => function ($node) {
            $node->props['items'] = Breadcrumbs::getItems($node->props);
        },

    ],

];
