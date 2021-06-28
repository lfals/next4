<?php

namespace YOOtheme;

/**
 * @var Config $config
 */
$config = app(Config::class);

return [

    '2.4.0-beta.0.3' => function ($node) {

        $rename = [
            'slider' => 'overlay-slider',
            'slider_item' => 'overlay-slider_item',
            'map_marker' => 'map_item',
        ];

        if (!empty($node->type) && $node->type === 'layout') {
            $apply = function ($node) use (&$apply, $rename) {

                if (isset($node->type) && !empty($rename[$node->type])) {
                    $node->type = $rename[$node->type];
                }

                if (!empty($node->children)) {
                    array_map($apply, $node->children);
                }

            };
            $apply($node);
        }

    },

    '2.3.0-beta.0.1' => function ($node) {

        $rename = [
            'joomla_module' => 'module',
            'wordpress_widget' => 'module',
            'joomla_position' => 'module_position',
            'wordpress_area' => 'module_position',
        ];

        if (!empty($node->type) && $node->type === 'layout') {
            $apply = function ($node) use (&$apply, $rename) {

                if (isset($node->type) && !empty($rename[$node->type])) {
                    $node->type = $rename[$node->type];
                }

                if (!empty($node->children)) {
                    array_map($apply, $node->children);
                }

            };
            $apply($node);
        }

    },

    '2.1.1.1' => function ($node, array $params) use ($config) {

        list($style) = explode(':', $config('~theme.style'));

        if (in_array($style, ['horizon'])) {

            if ((Arr::get($node->props, 'title_style') === 'h6' || (Arr::get($node->props, 'title_element') === 'h6' && empty(Arr::get($node->props, 'title_style')))) && empty(Arr::get($node->props, 'title_color'))) {
                $node->props['title_color'] = 'primary';
            }

        }

        if (in_array($style, ['fjord'])) {

            if ((Arr::get($node->props, 'title_style') === 'h4' || (Arr::get($node->props, 'title_element') === 'h4' && empty(Arr::get($node->props, 'title_style')))) && empty(Arr::get($node->props, 'title_color'))) {
                $node->props['title_color'] = 'primary';
            }

        }

    },

    '2.1.0-beta.0.1' => function ($node, array $params) {

        /**
         * @var $type
         */
        extract($params);

        if (Arr::get($node->props, 'maxwidth') === 'xxlarge') {
            $node->props['maxwidth'] = '2xlarge';
        }

        // move declaration of uk-hidden class to visibility settings
        if ($type->element && empty($node->props['visibility']) && !empty($node->props['class'])) {
            $node->props['class'] = trim(preg_replace_callback('/(^|\s+)uk-hidden@(s|m|l|xl)/', function ($match) use ($node) {
                $node->props['visibility'] = 'hidden-' . $match[2];
                return '';
            }, $node->props['class']));
        }

    },

    '1.22.0-beta.0.1' => function ($node) {

        if (isset($node->type) && in_array($node->type, ['joomla_position', 'wordpress_area']) && isset($node->props['grid_gutter'])) {
            $node->props['column_gap'] = $node->props['grid_gutter'];
            $node->props['row_gap'] = $node->props['grid_gutter'];
            unset($node->props['grid_gutter']);
        }

        if (isset($node->type) && in_array($node->type, ['joomla_position', 'wordpress_area']) && isset($node->props['grid_divider'])) {
            $node->props['divider'] = $node->props['grid_divider'];
            unset($node->props['grid_divider']);
        }

    },

    '1.20.0-beta.1.1' => function ($node) {

        if (isset($node->type) && in_array($node->type, ['joomla_position', 'wordpress_area', 'joomla_module', 'wordpress_widget']) && isset($node->props['maxwidth_align'])) {
            $node->props['block_align'] = $node->props['maxwidth_align'];
            unset($node->props['maxwidth_align']);
        }

    },

    '1.20.0-beta.0.1' => function ($node) {

        if (isset($node->type) && in_array($node->type, ['joomla_module', 'wordpress_widget'])) {

            if (Arr::get($node->props, 'title_style') === 'heading-primary') {
                $node->props['title_style'] = 'heading-medium';
            }

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (in_array($style, ['craft', 'district', 'jack-backer', 'tomsen-brody', 'vision', 'florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (Arr::get($node->props, 'title_style') === 'h1' || (empty($node->props['title_style']) && Arr::get($node->props, 'title_element') === 'h1')) {
                    $node->props['title_style'] = 'heading-small';
                }
            }

            if (in_array($style, ['florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {

                if (Arr::get($node->props, 'title_style') === 'h2') {
                    $node->props['title_style'] = Arr::get($node->props, 'title_element') === 'h1' ? '' : 'h1';
                } elseif (empty($node->props['title_style']) && Arr::get($node->props, 'title_element') === 'h2') {
                    $node->props['title_style'] = 'h1';
                }
            }

            if (in_array($style, ['fuse', 'horizon', 'joline', 'juno', 'lilian', 'vibe', 'yard'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] = 'heading-small';
                }
            }

            if (in_array($style, ['copper-hill'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] = Arr::get($node->props, 'title_element') === 'h1' ? '' : 'h1';
                } elseif (Arr::get($node->props, 'title_style') === 'h1') {
                    $node->props['title_style'] = Arr::get($node->props, 'title_element') === 'h2' ? '' : 'h2';
                } elseif (empty($node->props['title_style']) && Arr::get($node->props, 'title_element') === 'h1') {
                    $node->props['title_style'] = 'h2';
                }
            }

            if (in_array($style, ['trek', 'fjord'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] = 'heading-large';
                }
            }
        }

    },

];
