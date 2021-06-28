<?php

namespace YOOtheme;

return [

    '2.2.0-beta.0.1' => function ($node, array $params) {

        $isToolset = isset($node->source->query->field->name) && in_array('toolset', $field = explode('.', $node->source->query->field->name));

        if ($isToolset) {
            $node->source->query->field->name = strtr($node->source->query->field->name, '-', '_');
        }

        if (isset($node->source->props)) {

            // snake case custom field names
            foreach ((array) $node->source->props as $prop) {
                if (isset($prop->name) && ($isToolset || in_array('toolset', explode('.', $prop->name)))) {
                    $prop->name = strtr($prop->name, '-', '_');
                }
            }
        }
    },

];
