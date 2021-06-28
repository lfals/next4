<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return (bool) $node->props['video'];

        },

    ],

    'updates' => [

        '1.20.0-beta.1.1' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

        '1.18.0' => function ($node) {

            if (!isset($node->props['video_box_decoration']) && Arr::get($node->props, 'video_box_shadow_bottom') === true) {
                $node->props['video_box_decoration'] = 'shadow';
            }

        },

    ],

];
