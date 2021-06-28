<?php

namespace YOOtheme\GraphQL\Utils;

use GraphQL\Type\Definition\FieldDefinition;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils\AST as ASTUtils;

class AST extends ASTUtils
{
    public static function objectType(ObjectType $type)
    {
        $node = [
            'kind' => 'ObjectTypeDefinition',
            'name' => [
                'kind' => 'Name',
                'value' => $type->name,
            ],
            'fields' => [],
            'interfaces' => [],
            'directives' => [],
        ];

        if (isset($type->config['directives'])) {
            foreach ($type->config['directives'] as $config) {
                $node['directives'][] = static::directive($config);
            }
        }

        return static::fromArray($node);
    }

    public static function field(FieldDefinition $field)
    {
        $node = [
            'kind' => 'FieldDefinition',
            'name' => [
                'kind' => 'Name',
                'value' => $field->name,
            ],
            'arguments' => [],
            'directives' => [],
        ];

        if (isset($field->config['directives'])) {
            foreach ($field->config['directives'] as $config) {
                $node['directives'][] = static::directive($config);
            }
        }

        return static::fromArray($node);
    }

    public static function directive(array $config)
    {
        $directive = [
            'kind' => 'Directive',
            'name' => [
                'kind' => 'Name',
                'value' => $config['name'],
            ],
        ];

        if (isset($config['args'])) {
            foreach ($config['args'] as $name => $value) {
                $directive['arguments'][] = static::argument($name, $value);
            }
        }

        return static::fromArray($directive);
    }

    public static function argument($name, $value)
    {
        $argument = [
            'kind' => 'Argument',
            'name' => [
                'kind' => 'Name',
                'value' => $name,
            ],
            'value' => [
                'kind' => 'StringValue',
                'value' => $value,
            ],
        ];

        return static::fromArray($argument);
    }
}
