<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return (bool) Str::length($node->props['content']);

        },

    ],

];
