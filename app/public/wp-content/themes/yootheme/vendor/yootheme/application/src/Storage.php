<?php

namespace YOOtheme;

abstract class Storage implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * Gets a value (shortcut).
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function __invoke($key, $default = null)
    {
        return Arr::get($this->values, $key, $default);
    }

    /**
     * Checks if a key exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->values, $key);
    }

    /**
     * Gets a value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->values, $key, $default);
    }

    /**
     * Sets a value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        Arr::set($this->values, $key, $value);

        return $this;
    }

    /**
     * Deletes a value.
     *
     * @param string $key
     *
     * @return $this
     */
    public function del($key)
    {
        Arr::del($this->values, $key);

        return $this;
    }

    /**
     * Adds values from JSON.
     *
     * @param string $json
     *
     * @return $this
     */
    public function addJson($json)
    {
        $this->values = Arr::merge($this->values, json_decode($json, true) ?: []);

        return $this;
    }

    /**
     * Gets values which should be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->values;
    }
}
