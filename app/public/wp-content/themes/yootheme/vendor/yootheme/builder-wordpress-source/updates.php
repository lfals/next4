<?php

namespace YOOtheme;

return [

    '2.4.0-beta.5' => function ($node, array $params) {

        if (isset($node->source->query->arguments->order) && $node->source->query->arguments->order === 'none') {
            $node->source->query->arguments->order = 'date';
        }

    },

];
