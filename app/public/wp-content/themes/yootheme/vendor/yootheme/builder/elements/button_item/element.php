<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return $node->props['link']
                && (
                    Str::length($node->props['content'])
                    || $node->props['icon']
                );
        },

    ],

    'updates' => [

        '1.18.0' => function ($node) {

            if (Arr::get($node->props, 'link_target') === true) {
                $node->props['link_target'] = 'blank';
            }

            if (Arr::get($node->props, 'button_style') === 'muted') {
                $node->props['button_style'] = 'link-muted';
            }

        },

    ],

];
