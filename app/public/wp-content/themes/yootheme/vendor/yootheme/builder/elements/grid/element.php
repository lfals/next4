<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            $node->tags = [];

            // Filter tags
            if (!empty($node->props['filter'])) {

                foreach ($node->children as $child) {

                    $child->tags = [];

                    foreach (explode(',', $child->props['tags']) as $tag) {

                        // Strip tags as precaution if tags are mapped dynamically
                        $tag = strip_tags($tag);

                        if ($key = str_replace(' ', '-', trim($tag))) {
                            $child->tags[$key] = trim($tag);
                        }
                    }

                    $node->tags += $child->tags;
                }

                natsort($node->tags);

                if ($node->props['filter_reverse']) {
                    $node->tags = array_reverse($node->tags, true);
                }
            }

        },

    ],

    'updates' => [

        '2.4.14.2' => function ($node) {

            $node->props['animation'] = $node->props['item_animation'];
            $node->props['item_animation'] = true;

        },

        '2.1.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'item_maxwidth') === 'xxlarge') {
                $node->props['item_maxwidth'] = '2xlarge';
            }

            if (Arr::get($node->props, 'title_grid_width') === 'xxlarge') {
                $node->props['title_grid_width'] = '2xlarge';
            }

            if (Arr::get($node->props, 'image_grid_width') === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

        },

        '2.0.0-beta.8.1' => function ($node) {

            if (isset($node->props['grid_align'])) {
                $node->props['grid_column_align'] = $node->props['grid_align'];
                unset($node->props['grid_align']);
            }

        },

        '2.0.0-beta.5.1' => function ($node) {

            if (Arr::get($node->props, 'link_type') === 'content') {
                $node->props['title_link'] = true;
                $node->props['image_link'] = true;
                $node->props['link_text'] = '';
            } elseif (Arr::get($node->props, 'link_type') === 'element') {
                $node->props['panel_link'] = true;
                $node->props['link_text'] = '';
            }
            unset($node->props['link_type']);

        },

        '1.22.0-beta.0.1' => function ($node) {

            if (isset($node->props['gutter'])) {
                $node->props['grid_column_gap'] = $node->props['gutter'];
                $node->props['grid_row_gap'] = $node->props['gutter'];
                unset($node->props['gutter']);
            }

            if (isset($node->props['divider'])) {
                $node->props['grid_divider'] = $node->props['divider'];
                unset($node->props['divider']);
            }

            if (isset($node->props['filter_gutter'])) {
                $node->props['filter_grid_column_gap'] = $node->props['filter_gutter'];
                $node->props['filter_grid_row_gap'] = $node->props['filter_gutter'];
                unset($node->props['filter_gutter']);
            }

            if (isset($node->props['filter_breakpoint'])) {
                $node->props['filter_grid_breakpoint'] = $node->props['filter_breakpoint'];
                unset($node->props['filter_breakpoint']);
            }

            if (isset($node->props['title_gutter'])) {
                $node->props['title_grid_column_gap'] = $node->props['title_gutter'];
                $node->props['title_grid_row_gap'] = $node->props['title_gutter'];
                unset($node->props['title_gutter']);
            }

            if (isset($node->props['title_breakpoint'])) {
                $node->props['title_grid_breakpoint'] = $node->props['title_breakpoint'];
                unset($node->props['title_breakpoint']);
            }

            if (isset($node->props['image_gutter'])) {
                $node->props['image_grid_column_gap'] = $node->props['image_gutter'];
                $node->props['image_grid_row_gap'] = $node->props['image_gutter'];
                unset($node->props['image_gutter']);
            }

            if (isset($node->props['image_breakpoint'])) {
                $node->props['image_grid_breakpoint'] = $node->props['image_breakpoint'];
                unset($node->props['image_breakpoint']);
            }

        },

        '1.20.0-beta.1.1' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

        '1.20.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'title_style') === 'heading-hero') {
                $node->props['title_style'] = 'heading-xlarge';
            }

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

            if (in_array($style, ['juno', 'vibe', 'yard'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-medium';
                }

            }

            if (in_array($style, ['district', 'florence', 'flow', 'nioh-studio', 'summit', 'vision'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-large';
                }

            }

            if (in_array($style, ['lilian'])) {

                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-2xlarge';
                }

            }

        },

        '1.19.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'meta_align') === 'top') {
                $node->props['meta_align'] = 'above-title';
            }

            if (Arr::get($node->props, 'meta_align') === 'bottom') {
                $node->props['meta_align'] = 'below-title';
            }

            if (Arr::get($node->props, 'link_style') === 'panel') {
                if (Arr::get($node->props, 'panel_style')) {
                    $node->props['link_type'] = 'element';
                } else {
                    $node->props['link_type'] = 'content';
                }
                $node->props['link_style'] = 'default';
            }

            if (isset($node->props['image_card'])) {
                $node->props['panel_card_image'] = $node->props['image_card'];
                unset($node->props['image_card']);
            }

        },

        '1.18.10.3' => function ($node) {

            if (Arr::get($node->props, 'meta_align') === 'top') {
                if (!empty($node->props['meta_margin'])) {
                    $node->props['title_margin'] = $node->props['meta_margin'];
                }
                $node->props['meta_margin'] = '';
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

            if (!isset($node->props['grid_parallax']) && Arr::get($node->props, 'grid_mode') === 'parallax') {
                $node->props['grid_parallax'] = Arr::get($node->props, 'grid_parallax_y');
            }

            if (!isset($node->props['image_box_decoration']) && Arr::get($node->props, 'image_box_shadow_bottom') === true) {
                $node->props['image_box_decoration'] = 'shadow';
            }

            if (!isset($node->props['meta_color']) && Arr::get($node->props, 'meta_style') === 'muted') {
                $node->props['meta_color'] = 'muted';
                $node->props['meta_style'] = '';
            }

        },

    ],

];
