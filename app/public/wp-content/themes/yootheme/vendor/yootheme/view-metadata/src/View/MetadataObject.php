<?php

namespace YOOtheme\View;

class MetadataObject
{
    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @var array
     */
    public $attributes;

    /**
     * Constructor.
     *
     * @param string $name
     * @param mixed  $value
     * @param array  $attributes
     */
    public function __construct($name, $value, array $attributes = [])
    {
        $tag = substr($name, 0, strpos($name, ':'));

        $this->tag = $tag ?: $name;
        $this->name = $name;
        $this->value = $value;
        $this->attributes = $attributes;
    }

    /**
     * Gets an attribute value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Checks if a attribute value exists.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Gets the rendered tag as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Renders the tag.
     *
     * @return string
     */
    public function render()
    {
        $metadata = $this;

        if (is_callable($callback = $this->value)) {
            $metadata = $callback($this) ?: $this;
        }

        return HtmlElement::tag($metadata->tag, $metadata->attributes, $metadata->value);
    }

    /**
     * Gets the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets the tag.
     *
     * @param string $tag
     *
     * @return static
     */
    public function withTag($tag)
    {
        $clone = clone $this;
        $clone->tag = $tag;

        return $clone;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return static
     */
    public function withName($name)
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    /**
     * Gets the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value.
     *
     * @param string $value
     *
     * @return static
     */
    public function withValue($value)
    {
        $clone = clone $this;
        $clone->value = $value;

        return $clone;
    }

    /**
     * Gets a attribute.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return array
     */
    public function getAttribute($name, $default = null)
    {
        return isset($this->$name) ? $this->$name : $default;
    }

    /**
     * Adds a attribute.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return static
     */
    public function withAttribute($name, $value)
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;

        return $clone;
    }

    /**
     * Gets a attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Merges multiple attributes.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function withAttributes(array $attributes)
    {
        $clone = clone $this;
        $clone->attributes = array_merge($this->attributes, $attributes);

        return $clone;
    }
}
