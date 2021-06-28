<?php

namespace YOOtheme\Builder;

class DisabledTransform
{
    /**
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array $params)
    {
        return !isset($node->props['status']) || $node->props['status'] !== 'disabled';
    }
}
