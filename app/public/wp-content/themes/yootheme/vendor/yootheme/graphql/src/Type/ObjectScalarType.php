<?php

namespace YOOtheme\GraphQL\Type;

use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;

class ObjectScalarType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'Object';

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function parseValue($value)
    {
        return is_array($value) ? $value : null;
    }

    /**
     * @param  $valueNode
     * @param null|array $variables
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        throw new Error("Query error: Can't parse Object literal");
    }
}
