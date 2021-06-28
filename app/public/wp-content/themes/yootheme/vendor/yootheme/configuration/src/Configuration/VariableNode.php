<?php

namespace YOOtheme\Configuration;

class VariableNode extends Node
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $params)
    {
        $arguments = $this->resolveArgs([$this->name], $params);

        return $params['config']->get(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(array $params)
    {
        $arguments = $this->compileArgs([$this->name], $params);

        return "\$config->get({$arguments})";
    }
}
