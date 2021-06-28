<?php

namespace YOOtheme;

return [

    'updates' => [

        '2.4.0-beta.0.2' => function ($node) {

            if (isset($node->props['image_visibility'])) {
                $node->props['media_visibility'] = $node->props['image_visibility'];
                unset($node->props['image_visibility']);
            }

        },

        '2.1.0-beta.2.1' => function ($node) {

            if (in_array(Arr::get($node->props, 'style'), ['primary', 'secondary'])) {
                $node->props['text_color'] = '';
            }

        },

        '1.22.0-beta.0.1' => function ($node) {
            unset($node->props['widths']);
        },

        '1.18.0' => function ($node, array $params) {

            /**
             * @var $parent
             */
            extract($params);

            if (!isset($node->props['vertical_align']) && Arr::get($node->props, 'vertical_align') === true) {
                $node->props['vertical_align'] = 'middle';
            }

        },

    ],

];
