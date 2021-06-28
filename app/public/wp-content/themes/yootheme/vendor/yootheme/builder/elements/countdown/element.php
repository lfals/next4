<?php

namespace YOOtheme;

return [

    'placeholder' => [

        'props' => [
            'date' => date('Y-m-d', strtotime('+1 week')),
        ],

    ],

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return (bool) $node->props['date'];

        },

    ],

    'updates' => [

        '1.22.0-beta.0.1' => function ($node) {

            if (isset($node->props['gutter'])) {
                $node->props['grid_column_gap'] = $node->props['gutter'];
                $node->props['grid_row_gap'] = $node->props['gutter'];
                unset($node->props['gutter']);
            }

        },

    ],

];
