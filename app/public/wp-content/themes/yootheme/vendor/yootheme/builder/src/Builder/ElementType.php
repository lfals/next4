<?php

namespace YOOtheme\Builder;

use YOOtheme\Arr;

/**
 * @property bool $container
 * @property bool $element
 */
class ElementType implements \JsonSerializable
{
    /**
     * @var array
     */
    public $data;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Gets a data value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Checks if a data value exists.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Handles method calls.
     *
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($name, array $args)
    {
        $method = $this->$name;

        if (!is_callable($method)) {
            trigger_error(sprintf('Call to undefined method %s::%s()', __CLASS__, $name), E_USER_ERROR);
        }

        if ($method instanceof \Closure) {
            $method = $method->bindTo($this);
        }

        return call_user_func_array($method, $args);
    }

    /**
     * Returns data for JSON serialize.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return Arr::omit($this->data, ['templates', 'transforms', 'updates', 'path']);
    }
}
