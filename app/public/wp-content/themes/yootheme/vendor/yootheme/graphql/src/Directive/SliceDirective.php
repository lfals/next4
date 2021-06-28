<?php

namespace YOOtheme\GraphQL\Directive;

use GraphQL\Type\Definition\Directive;
use GraphQL\Type\Definition\FieldArgument;
use GraphQL\Type\Definition\Type;

class SliceDirective extends Directive
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => 'slice',
            'args' => [
                new FieldArgument([
                    'name' => 'offset',
                    'type' => Type::int(),
                ]),
                new FieldArgument([
                    'name' => 'limit',
                    'type' => Type::int(),
                ]),
            ],
            'locations' => [
                'FIELD',
                'FRAGMENT_SPREAD',
                'INLINE_FRAGMENT',
            ],
        ]);
    }

    /**
     * Directive callback.
     *
     * @param array $params
     *
     * @return \Closure
     */
    public function __invoke(array $params)
    {
        return function ($root, $args, $context, $info, callable $next) use ($params) {

            extract($params + ['offset' => 0, 'limit' => null]);

            $value = $next($root, $args, $context, $info);

            // TODO 2.4 no need to check for $offset && $limit ?
            if (is_array($value) && ($offset || $limit)) {
                return array_slice($value, (int) $offset, (int) $limit ?: null);
            }

            return $value;
        };
    }
}
