<?php

namespace YOOtheme\Configuration;

class FilterNode extends Node
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $filters;

    /**
     * Constructor.
     *
     * @param mixed  $value
     * @param string $filter
     * @param mixed  $filters
     */
    public function __construct($value, $filters)
    {
        $this->value = $value;
        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $params)
    {
        $arguments = $this->resolveArgs([$this->filters, $this->value, $params['file']], $params);

        return $params['filter']->apply(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(array $params)
    {
        $arguments = $this->compileArgs([$this->filters, $this->value], $params);

        return "\$filter->apply({$arguments}, \$file)";
    }
}
