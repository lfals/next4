<?php

namespace YOOtheme\View;

use YOOtheme\Event;
use YOOtheme\Metadata;

/**
 * Manages HTML elements belonging to the metadata content category.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Content_categories#Metadata_content
 */
class MetadataManager implements Metadata, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $prefix = ['article', 'fb', 'og', 'twitter'];

    /**
     * @var array
     */
    protected $metadata = [];

    /**
     * {@inheritdoc}
     */
    public function all(...$names)
    {
        if (!$names) {
            return $this->metadata;
        }

        $result = [];

        foreach ($names as $name) {

            $prefix = substr($name, -1) === '*' ? substr($name, 0, -1) : false;

            foreach ($this->metadata as $metadata) {
                if (isset($this->metadata[$name]) || $prefix && substr($metadata->name, 0, strlen($prefix)) === $prefix) {
                    $result[$metadata->name] = $metadata;
                }
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return isset($this->metadata[$name]) ? $this->metadata[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value, array $attributes = [])
    {
        if (is_array($value) && !is_callable($value)) {
            list($value, $attributes) = [null, array_merge($value, $attributes)];
        }

        $metadata = new MetadataObject($name, $value, $attributes);
        $metadata = $this->resolveMetadata($metadata);
        $metadata = Event::emit('metadata.load|filter', $metadata, $this);

        return $this->metadata[$metadata->name] = $metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function del($name)
    {
        unset($this->metadata[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array $metadata)
    {
        foreach ($metadata as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $filter)
    {
        return array_filter($this->metadata, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return join("\n", $this->metadata);
    }

    /**
     * Returns an iterator for metadata tags.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->metadata);
    }

    /**
     * Resolves the metadata.
     *
     * @param MetadataObject $metadata
     *
     * @return MetadataObject
     */
    protected function resolveMetadata(MetadataObject $metadata)
    {
        if (is_string($metadata->value)) {
            $metadata = $this->resolveAttributes($metadata);
        }

        if ($metadata->tag === 'style' && !isset($metadata->value)) {
            return $metadata->withTag('link')->withAttribute('rel', 'stylesheet');
        }

        if (in_array($metadata->tag, $this->prefix)) {
            return $metadata->withTag('meta');
        }

        return $metadata;
    }

    /**
     * Resolve the metadata attributes.
     *
     * @param MetadataObject $metadata
     *
     * @return MetadataObject
     */
    protected function resolveAttributes($metadata)
    {
        if ($metadata->tag === 'base') {
            return $metadata->withAttributes([
                'href' => $metadata->value,
            ]);
        }

        if ($metadata->tag === 'link') {
            return $metadata->withAttributes([
                'href' => $metadata->value,
                'rel' => str_replace('link:', '', $metadata->name),
            ]);
        }

        if ($metadata->tag === 'meta') {
            return $metadata->withAttributes([
                'name' => str_replace('meta:', '', $metadata->name),
                'content' => $metadata->value,
            ]);
        }

        if (in_array($metadata->tag, $this->prefix)) {
            return $metadata->withAttributes([
                'property' => $metadata->name,
                'content' => $metadata->value,
            ]);
        }

        return $metadata;
    }
}
