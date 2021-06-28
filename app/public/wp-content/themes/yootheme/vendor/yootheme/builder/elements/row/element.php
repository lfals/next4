<?php

namespace YOOtheme;

return [

    'updates' => [

        '2.3.0-beta.1.1' => function ($node) {

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (in_array($style, ['fjord'])) {
                if (Arr::get($node->props, 'width') === 'default') {
                    $node->props['width'] = 'large';
                }
            }

        },

        '2.1.0-beta.1.1' => function ($node) {

            if (!empty($node->props['layout']) && $node->props['layout'] === '1-1') {
                unset($node->props['layout']);
            }

        },

        '2.1.0-beta.0.1' => function ($node) {

            if (empty($node->props['layout'])) {
                $node->props['layout'] = '1-1';
            }

            switch ($node->props['layout']) {
                case ',':
                    $node->props['layout'] = '1-2,1-2';
                    break;
                case ',,':
                    $node->props['layout'] = '1-3,1-3,1-3';
                    break;
                case 'fixed,':
                    $node->props['layout'] = 'large,expand';
                    break;
                case ',fixed':
                    $node->props['layout'] = 'expand,large';
                    break;
                case ',fixed,':
                    $node->props['layout'] = 'expand,large,expand';
                    break;
                case 'fixed,,fixed':
                    $node->props['layout'] = 'large,expand,large';
                    break;
            }

            if (empty($node->props['breakpoint'])) {
                $node->props['breakpoint'] = 'm';
            }

            $breakpoint = $node->props['breakpoint'];
            $breakpoints = array_slice(['xlarge', 'large', 'medium', 'small', 'default'], array_search($breakpoint, ['xl', 'l', 'm', 's', '']));

            if (!empty($node->props['layout'])) {

                $layouts = explode('|', $node->props['layout']);

                while (count($layouts) + 1 > count($breakpoints) && isset($layouts[count($layouts) - 1])) {
                    unset($layouts[count($layouts) - 1]);
                }

                foreach ($layouts as $widths) {

                    $breakpoint = array_shift($breakpoints);
                    $prop = "width_{$breakpoint}";

                    foreach (explode(',', $widths) as $index => $width) {

                        if (!isset($node->children[$index]->props)) {
                            continue;
                        }

                        if (empty($node->props['fixed_width'])) {
                            $node->props['fixed_width'] = 'large';
                        }
                        if ($node->props['fixed_width'] === 'xxlarge') {
                            $node->props['fixed_width'] = '2xlarge';
                        }

                        if (is_array($node->children[$index]->props)) {
                            $node->children[$index]->props = (object) $node->children[$index]->props;
                        }

                        $node->children[$index]->props->$prop = $width === 'large' ? $node->props['fixed_width'] : $width;
                    }
                }
            }

            $count = count($node->children);
            if (!empty($node->props['order_last']) && $count > 1) {

                if (is_array($node->children[$index]->props)) {
                    $node->children[$index]->props = (object) $node->children[$index]->props;
                }

                $node->children[$count - 1]->props->order_first = $node->props['breakpoint'] ?: 'xs';
            }

            unset($node->props['breakpoint'], $node->props['fixed_width'], $node->props['order_last']);

        },

        '2.0.0-beta.5.1' => function ($node) {

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (!in_array($style, ['jack-baker', 'morgan-consulting', 'vibe'])) {
                if (Arr::get($node->props, 'width') === 'large') {
                    $node->props['width'] = 'xlarge';
                }
            }

            if (in_array($style, ['craft', 'district', 'florence', 'makai', 'matthew-taylor', 'pinewood-lake', 'summit', 'tomsen-brody', 'trek', 'vision', 'yard'])) {
                if (Arr::get($node->props, 'width') === 'default') {
                    $node->props['width'] = 'large';
                }
            }

        },

        '1.22.0-beta.0.1' => function ($node) {

            if (isset($node->props['gutter'])) {
                $node->props['column_gap'] = $node->props['gutter'];
                $node->props['row_gap'] = $node->props['gutter'];
                unset($node->props['gutter']);
            }

            if (empty($node->props['layout'])) {
                return;
            }

            switch ($node->props['layout']) {
                case '2-3,':
                    $node->props['layout'] = '2-3,1-3';
                    break;
                case ',2-3':
                    $node->props['layout'] = '1-3,2-3';
                    break;
                case '3-4,':
                    $node->props['layout'] = '3-4,1-4';
                    break;
                case ',3-4':
                    $node->props['layout'] = '1-4,3-4';
                    break;
                case '1-2,,|1-1,1-2,1-2':
                    $node->props['layout'] = '1-2,1-4,1-4|1-1,1-2,1-2';
                    break;
                case ',,1-2|1-2,1-2,1-1':
                    $node->props['layout'] = '1-4,1-4,1-2|1-2,1-2,1-1';
                    break;
                case ',1-2,':
                case ',1-2,|1-2,1-1,1-2':
                    $node->props['layout'] = '1-4,1-2,1-4';
                    break;
                case ',,,|1-2,1-2,1-2,1-2':
                    $node->props['layout'] = '1-4,1-4,1-4,1-4|1-2,1-2,1-2,1-2';
                    break;
            }

        },

    ],

];
