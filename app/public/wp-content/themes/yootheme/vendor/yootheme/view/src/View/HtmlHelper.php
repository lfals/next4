<?php

namespace YOOtheme\View;

use YOOtheme\View;

class HtmlHelper
{
    /**
     * @var array
     */
    public $components = [];

    /**
     * Constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $element = __NAMESPACE__ . '\\HtmlElement';

        $view['html'] = $this;
        $view->addFunction('el', [$this, 'el']);
        $view->addFunction('link', [$this, 'link']);
        $view->addFunction('image', [$this, 'image']);
        $view->addFunction('form', [$this, 'form']);
        $view->addFunction('attrs', [$this, 'attrs']);
        $view->addFunction('expr', [$element, 'expr']);
        $view->addFunction('cls', [$element, 'expr']);
        $view->addFunction('tag', [$element, 'tag']);
    }

    /**
     * Creates an element.
     *
     * @param string $name
     * @param array  $attrs
     * @param mixed  $contents
     *
     * @return HtmlElement
     */
    public function el($name, array $attrs = [], $contents = false)
    {
        return new HtmlElement($name, $attrs, $contents, [$this, 'applyTransform']);
    }

    /**
     * Renders a link tag.
     *
     * @param string $title
     * @param string $url
     * @param array  $attrs
     *
     * @return string
     */
    public function link($title, $url = null, array $attrs = [])
    {
        return "<a{$this->attrs(['href' => $url], $attrs)}>{$title}</a>";
    }

    /**
     * Renders an image tag.
     *
     * @param array|string $url
     * @param array        $attrs
     *
     * @return string
     */
    public function image($url, array $attrs = [])
    {
        $url = (array) $url;
        $path = array_shift($url);
        $params = $url ? '#' . http_build_query(array_map(function ($value) {
            return is_array($value) ? implode(',', $value) : $value;
        }, $url), '', '&') : '';

        if (empty($attrs['alt'])) {
            $attrs['alt'] = true;
        }

        return "<img{$this->attrs(['src' => $path . $params], $attrs)}>";
    }

    /**
     * Renders a form tag.
     *
     * @param array $tags
     * @param array $attrs
     *
     * @return string
     */
    public function form($tags, array $attrs = [])
    {
        return HtmlElement::tag('form', $attrs, array_map(function ($tag) {
            return HtmlElement::tag($tag['tag'], array_diff_key($tag, ['tag' => null]));
        }, $tags));
    }

    /**
     * Renders tag attributes.
     *
     * @param array $attrs
     *
     * @return string
     */
    public function attrs(array $attrs)
    {
        $params = [];

        if (count($args = func_get_args()) > 1) {
            $attrs = call_user_func_array('array_merge_recursive', $args);
        }

        if (isset($attrs[':params'])) {
            $params = $attrs[':params']; unset($attrs[':params']);
        }

        return HtmlElement::attrs($attrs, $params);
    }

    /**
     * Adds a component.
     *
     * @param string   $name
     * @param callable $component
     */
    public function addComponent($name, callable $component)
    {
        $this->components[$name] = $component;
    }

    /**
     * Applies transform callbacks.
     *
     * @param HtmlElement $element
     * @param array       $params
     *
     * @return HtmlElement|void
     */
    public function applyTransform(HtmlElement $element, array $params = [])
    {
        if (empty($this->components[$element->name])) {
            return;
        }

        return call_user_func($this->components[$element->name], $element, $params);
    }
}
