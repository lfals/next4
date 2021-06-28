<?php

namespace YOOtheme\GraphQL\Directive;

use GraphQL\Type\Definition\Directive;
use GraphQL\Type\Definition\FieldArgument;
use GraphQL\Type\Definition\Type;
use YOOtheme\Container;
use YOOtheme\GraphQL\Utils\Middleware;

class CallDirective extends Directive
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'call',
            'args' => [
                new FieldArgument([
                    'name' => 'func',
                    'type' => Type::string(),
                ]),
                new FieldArgument([
                    'name' => 'args',
                    'type' => Type::string(),
                ]),
            ],
            'locations' => [
                'ENUM_VALUE',
                'FIELD_DEFINITION',
            ],
        ]);

        $this->container = $container;
    }

    /**
     * Resolve value from function callback.
     *
     * @param array      $params
     * @param Middleware $resolver
     *
     * @return \Closure
     */
    public function __invoke(array $params, Middleware $resolver)
    {
        // override default resolver
        $resolver->setHandler($this->container->callback($params['func']));

        // merge additional arguments
        if (isset($params['args']) && is_array($arguments = json_decode($params['args'], true))) {
            return function ($value, $args, $context, $info, $next) use ($arguments) {
                return $next($value, $args + $arguments, $context, $info);
            };
        }
    }
}
