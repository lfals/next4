<?php

namespace YOOtheme;

interface Config
{
    /**
     * Gets a value (shortcut).
     *
     * @param string $index
     * @param mixed  $default
     *
     * @return mixed
     */
    public function __invoke($index, $default = null);

    /**
     * Gets a value.
     *
     * @param string $index
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($index, $default = null);

    /**
     * Sets a value.
     *
     * @param string $index
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($index, $value);

    /**
     * Deletes a value.
     *
     * @param string $index
     *
     * @return $this
     */
    public function del($index);

    /**
     * Adds a value array.
     *
     * @param string $index
     * @param array  $values
     * @param bool   $replace
     *
     * @return $this
     */
    public function add($index, array $values = [], $replace = true);

    /**
     * Sets a value using a update callback.
     *
     * @param string   $index
     * @param callable $callback
     *
     * @return $this
     */
    public function update($index, callable $callback);

    /**
     * Adds an alias.
     *
     * @param string $name
     * @param string $index
     *
     * @return $this
     */
    public function addAlias($name, $index);

    /**
     * Adds a file.
     *
     * @param string $index
     * @param string $file
     * @param bool   $replace
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function addFile($index, $file, $replace = true);

    /**
     * Loads a config file.
     *
     * @param string $file
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function loadFile($file);
}
