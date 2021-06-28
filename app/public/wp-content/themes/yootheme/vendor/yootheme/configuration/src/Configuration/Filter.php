<?php

namespace YOOtheme\Configuration;

class Filter
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        foreach ($filters as $name => $filter) {
            $this->add($name, $filter);
        }
    }

    /**
     * Adds a filter function.
     *
     * @param string   $name
     * @param callable $filter
     *
     * @return $this
     */
    public function add($name, callable $filter)
    {
        $this->filters[$name] = $filter;

        return $this;
    }

    /**
     * Applies filters to a value.
     *
     * @param mixed $value
     * @param mixed $filters
     * @param array $arguments
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public function apply($filters, $value, ...$arguments)
    {
        if (is_string($filters)) {
            $filters = explode('|', $filters);
        }

        foreach ($filters as $name) {

            if (!isset($this->filters[$name])) {
                throw new \RuntimeException("Undefined filter '{$name}'");
            }

            $value = $this->filters[$name]($value, ...$arguments);
        }

        return $value;
    }
}
