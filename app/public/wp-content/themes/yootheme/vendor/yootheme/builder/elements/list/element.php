<?php

namespace YOOtheme;

return [

    'updates' => [

        '2.1.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'list_style') === 'bullet') {
                $node->props['list_marker'] = 'bullet';
                $node->props['list_style'] = '';
            }

            if (Arr::get($node->props, 'list_size') === true) {
                $node->props['list_size'] = 'large';
            } else {
                $node->props['list_size'] = '';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

        },

        '1.20.0-beta.1.1' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

        '1.20.0-beta.0.1' => function ($node) {

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (in_array($style, ['craft', 'district', 'jack-backer', 'tomsen-brody', 'vision', 'florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (Arr::get($node->props, 'content_style') === 'h1') {
                    $node->props['content_style'] = 'heading-small';
                }

            }

            if (in_array($style, ['florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (Arr::get($node->props, 'content_style') === 'h2') {
                    $node->props['content_style'] = 'h1';
                }

            }

            if (in_array($style, ['copper-hill'])) {

                if (Arr::get($node->props, 'content_style') === 'h1') {
                    $node->props['content_style'] = 'h2';
                }

            }

        },

        '1.18.10.1' => function ($node) {

            if (isset($node->props['image_inline_svg'])) {
                $node->props['image_svg_inline'] = $node->props['image_inline_svg'];
                unset($node->props['image_inline_svg']);
            }

            if (isset($node->props['image_animate_svg'])) {
                $node->props['image_svg_animate'] = $node->props['image_animate_svg'];
                unset($node->props['image_animate_svg']);
            }

        },

        '1.18.0' => function ($node) {

            if (!isset($node->props['content_style'])) {
                $node->props['content_style'] = Arr::get($node->props, 'text_style');
            }

        },

    ],

];
