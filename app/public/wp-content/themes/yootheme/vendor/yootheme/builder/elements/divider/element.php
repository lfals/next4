<?php

namespace YOOtheme;

return [

    'updates' => [

        '1.20.0-beta.4' => function ($node) {

            if (isset($node->props['maxwidth_align'])) {
                $node->props['block_align'] = $node->props['maxwidth_align'];
                unset($node->props['maxwidth_align']);
            }

        },

    ],

];
