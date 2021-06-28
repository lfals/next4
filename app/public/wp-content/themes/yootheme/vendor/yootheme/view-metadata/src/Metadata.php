<?php

namespace YOOtheme;

use YOOtheme\View\MetadataObject;

interface Metadata
{
    /**
     * Gets all metadata tags.
     *
     * @param array $names
     *
     * @return MetadataObject[]
     */
    public function all(...$names);

    /**
     * Gets a metadata tag.
     *
     * @param string $name
     *
     * @return MetadataObject|null
     */
    public function get($name);

    /**
     * Sets a metadata tag.
     *
     * @param string $name
     * @param mixed  $value
     * @param array  $attributes
     *
     * @return MetadataObject
     */
    public function set($name, $value, array $attributes = []);

    /**
     * Deletes a metadata tag.
     *
     * @param string $name
     */
    public function del($name);

    /**
     * Merges multiple metadata tags.
     *
     * @param array $metadata
     */
    public function merge(array $metadata);

    /**
     * Filters metadata tags using a callback.
     *
     * @param callable $filter
     *
     * @return MetadataObject[]
     */
    public function filter(callable $filter);

    /**
     * Renders metadata tags.
     *
     * @return string
     */
    public function render();
}
