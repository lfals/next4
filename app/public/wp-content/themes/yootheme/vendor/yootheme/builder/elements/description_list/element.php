<?php

namespace YOOtheme;

return [

    'updates' => [

        '2.2.0-beta.2.1' => function ($node) {

            if (Arr::get($node->props, 'title_style') === 'strong') {
                $node->props['title_style'] = 'text-bold';
            }

            if (in_array(Arr::get($node->props, 'title_style'), ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])) {
                $node->props['title_element'] = 'h3';
            }

        },

        '2.1.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'list_size') === true) {
                $node->props['list_size'] = 'large';
            } else {
                $node->props['list_size'] = '';
            }

        },

        '1.22.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'layout') === 'grid-2-m' && Arr::get($node->props, 'width') === 'expand' && isset($node->props['leader'])) {
                $node->props['gutter'] = 'small';
            }

            if (isset($node->props['gutter'])) {
                $node->props['title_grid_column_gap'] = $node->props['gutter'];
                $node->props['title_grid_row_gap'] = $node->props['gutter'];
                unset($node->props['gutter']);
            }

            if (isset($node->props['breakpoint'])) {
                $node->props['title_grid_breakpoint'] = $node->props['breakpoint'];
                unset($node->props['breakpoint']);
            }

            if (isset($node->props['width'])) {
                $node->props['title_grid_width'] = $node->props['width'];
                unset($node->props['width']);
            }

            if (isset($node->props['leader'])) {
                $node->props['title_leader'] = $node->props['leader'];
                unset($node->props['leader']);
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

                if (Arr::get($node->props, 'title_style') === 'h1') {
                    $node->props['title_style'] = 'heading-small';
                }

            }

            if (in_array($style, ['florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (Arr::get($node->props, 'title_style') === 'h2') {
                    $node->props['title_style'] = 'h1';
                }

            }

            if (in_array($style, ['copper-hill'])) {

                if (Arr::get($node->props, 'title_style') === 'h1') {
                    $node->props['title_style'] = 'h2';
                }

            }

        },

        '1.19.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'meta_align') === 'top-title') {
                $node->props['meta_align'] = 'above-title';
            }

            if (Arr::get($node->props, 'meta_align') === 'bottom-title') {
                $node->props['meta_align'] = 'below-title';
            }

            if (Arr::get($node->props, 'meta_align') === 'top-content') {
                $node->props['meta_align'] = 'above-content';
            }

            if (Arr::get($node->props, 'meta_align') === 'bottom-content') {
                $node->props['meta_align'] = 'below-content';
            }

        },

        '1.18.0' => function ($node) {

            if (Arr::get($node->props, 'title_style') === 'muted') {
                $node->props['title_style'] = '';
                $node->props['title_color'] = 'muted';
            }

            if (!isset($node->props['meta_color']) && in_array(Arr::get($node->props, 'meta_style'), ['muted', 'primary'], true)) {
                $node->props['meta_color'] = $node->props['meta_style'];
                $node->props['meta_style'] = '';
            }

            switch (Arr::get($node->props, 'layout')) {
                case '':
                    $node->props['width'] = 'auto';
                    $node->props['layout'] = 'grid-2';
                    break;
                case 'width-small':
                    $node->props['width'] = 'small';
                    $node->props['layout'] = 'grid-2';
                    break;
                case 'width-medium':
                    $node->props['width'] = 'medium';
                    $node->props['layout'] = 'grid-2';
                    break;
                case 'space-between':
                    $node->props['width'] = 'expand';
                    $node->props['layout'] = 'grid-2';
                    break;
            }

        },

    ],

];
