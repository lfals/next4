<?php

namespace YOOtheme;

return [

    'updates' => [

        '2.1.0-beta.0.1' => function ($node) {

            if (Arr::get($node->props, 'image_grid_width') === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

        },

        '1.22.0-beta.0.1' => function ($node) {

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

        '1.18.10.1' => function ($node) {

            if (isset($node->props['image_inline_svg'])) {
                $node->props['image_svg_inline'] = $node->props['image_inline_svg'];
                unset($node->props['image_inline_svg']);
            }

        },

    ],

];
