<?php

namespace YOOtheme\Builder;

class NormalizeTransform
{
    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        /**
         * @var $type
         */
        extract($params);

        $node->id = isset($node->id) ? $node->id : null;
        $node->attrs = isset($node->attrs) ? $node->attrs : [];
        $node->children = isset($node->children) ? $node->children : [];

        // Default to "null", if field not exists
        $fields = $type->fields ?: [];

        foreach ($type->panels ?: [] as $panel) {
            if (isset($panel['fields'])) {
                $fields += $panel['fields'];
            }
        }

        foreach (array_diff_key($fields, $node->props) as $name => $value) {
            $node->props[$name] = null;
        }
    }
}
