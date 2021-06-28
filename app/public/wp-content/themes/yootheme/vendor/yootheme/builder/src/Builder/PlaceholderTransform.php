<?php

namespace YOOtheme\Builder;

use YOOtheme\Arr;

class PlaceholderTransform
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

        // Placeholder props
        if (isset($type->placeholder['props'])) {

            $callback = function ($value, $key) use ($node) {
                return isset($node->props[$key]);
            };

            if (!Arr::some($type->placeholder['props'], $callback)) {
                $node->props = array_merge($node->props, $type->placeholder['props']);
            }
        }

        // Placeholder children
        if (isset($type->placeholder['children']) and empty($node->children)) {

            $callback = function ($value) {
                return (object) $value;
            };

            $node->children = array_map($callback, $type->placeholder['children']);
        }
    }
}
