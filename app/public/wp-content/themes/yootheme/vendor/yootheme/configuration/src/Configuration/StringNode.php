<?php

namespace YOOtheme\Configuration;

class StringNode extends Node
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * Constructor.
     *
     * @param string $format
     * @param array  $arguments
     */
    public function __construct($format, array $arguments = [])
    {
        $this->format = $format;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $params)
    {
        $arguments = array_merge([$this->format], $this->arguments);
        $arguments = $this->resolveArgs($arguments, $params);

        return sprintf(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(array $params)
    {
        $arguments = array_merge([$this->format], $this->arguments);
        $arguments = $this->compileArgs($arguments, $params);

        return "sprintf({$arguments})";
    }
}
