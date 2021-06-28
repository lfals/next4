<?php

namespace YOOtheme\Configuration;

use YOOtheme\Arr;

class Repository
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * Gets a value (shortcut).
     *
     * @param string $index
     * @param mixed  $default
     *
     * @return mixed
     */
    public function __invoke($index, $default = null)
    {
        return $this->get($index, $default);
    }

    /**
     * Gets a value.
     *
     * @param string $index
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($index, $default = null)
    {
        $index = strtr($index, $this->aliases);

        return static::getValue($this->values, $index, $default);
    }

    /**
     * Sets a value.
     *
     * @param string $index
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($index, $value)
    {
        $index = strtr($index, $this->aliases);

        Arr::set($this->values, $index, $value);

        return $this;
    }

    /**
     * Deletes a value.
     *
     * @param string $index
     *
     * @return $this
     */
    public function del($index)
    {
        $index = strtr($index, $this->aliases);

        Arr::del($this->values, $index);

        return $this;
    }

    /**
     * Adds a value array.
     *
     * @param string $index
     * @param array  $values
     * @param bool   $replace
     *
     * @return $this
     */
    public function add($index, array $values = [], $replace = true)
    {
        $value = $index ? $this->get($index) : $this->values;

        if (is_array($value)) {
            $arrays = $replace ? [$value, $values] : [$values, $value];
            $values = array_replace_recursive(...$arrays);
        }

        if ($index) {
            $this->set($index, $values);
        } else {
            $this->values = $values;
        }

        return $this;
    }

    /**
     * Sets a value using a update callback.
     *
     * @param string   $index
     * @param callable $callback
     *
     * @return $this
     */
    public function update($index, callable $callback)
    {
        $index = strtr($index, $this->aliases);

        Arr::update($this->values, $index, $callback);

        return $this;
    }

    /**
     * Adds an alias.
     *
     * @param string $name
     * @param string $index
     *
     * @return $this
     */
    public function addAlias($name, $index)
    {
        $this->aliases[$name] = $index;

        return $this;
    }

    /**
     * Gets a value from array or object.
     *
     * @param mixed            $object
     * @param string|array|int $index
     * @param mixed            $default
     *
     * @return mixed
     */
    public static function getValue($object, $index, $default = null)
    {
        $index = is_array($index) ? $index : explode('.', $index);

        while (!is_null($key = array_shift($index))) {
            if ((is_array($object) || $object instanceof \ArrayAccess) && isset($object[$key])) {
                $object = $object[$key];
            } elseif (is_object($object) && isset($object->$key)) {
                $object = $object->$key;
            } elseif (is_callable($callable = [$object, $key])) {
                $object = $callable();
            } else {
                return $default;
            }
        }

        return $object;
    }
}
