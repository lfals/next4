<?php

namespace YOOtheme\Builder;

use GraphQL\Executor\ExecutionResult;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Utils\AST;
use YOOtheme\GraphQL\SchemaBuilder;
use YOOtheme\GraphQL\Type\Introspection;

class Source extends SchemaBuilder
{
    /**
     * @var Schema
     */
    protected $schema;

    /**
     * Gets the schema.
     *
     * @return Schema
     */
    public function getSchema()
    {
        return $this->schema ?: ($this->schema = $this->buildSchema());
    }

    /**
     * Sets the schema.
     *
     * @param Schema $schema
     *
     * @return Schema
     */
    public function setSchema(Schema $schema)
    {
        return $this->schema = $schema;
    }

    /**
     * Executes a query on schema.
     *
     * @param mixed       $source
     * @param mixed       $value
     * @param mixed       $context
     * @param array|null  $variables
     * @param string|null $operation
     * @param callable    $fieldResolver
     * @param array       $validationRules
     *
     * @return ExecutionResult
     */
    public function query($source, $value = null, $context = null, $variables = null, $operation = null, $fieldResolver = null, $validationRules = null)
    {
        if (is_array($source)) {
            $source = AST::fromArray($source);
        }

        return GraphQL::executeQuery($this->getSchema(), $source, $value, $context, $variables, $operation, $fieldResolver, $validationRules);
    }

    /**
     * Executes an introspection on schema.
     *
     * @param array $options
     *
     * @return ExecutionResult
     */
    public function queryIntrospection(array $options = [])
    {
        $metadata = [
            'type' => $this->getType('Object'),
            'resolve' => function ($type, ...$args) {
                return isset($type->config['metadata']) ? $type->config['metadata'] : null;
            },
        ];

        $options += [
            '__Type' => compact('metadata'),
            '__Field' => compact('metadata'),
            '__InputValue' => compact('metadata'),
        ];

        return GraphQL::executeQuery($this->getSchema(), Introspection::getIntrospectionQuery($options));
    }
}
