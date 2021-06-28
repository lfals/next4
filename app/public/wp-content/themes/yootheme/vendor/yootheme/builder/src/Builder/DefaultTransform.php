<?php

namespace YOOtheme\Builder;

class DefaultTransform
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

        // Defaults
        if ($type->defaults) {
            $node->props += $type->defaults;
        }
    }
}
