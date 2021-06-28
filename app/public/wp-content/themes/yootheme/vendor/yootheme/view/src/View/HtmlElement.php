<?php

namespace YOOtheme\View;

use YOOtheme\Arr;

class HtmlElement
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $attrs;

    /**
     * @var mixed
     */
    public $contents;

    /**
     * @var callable
     */
    protected $transform;

    /**
     * Constructor.
     *
     * @param string   $name
     * @param array    $attrs
     * @param mixed    $contents
     * @param callable $transform
     */
    public function __construct($name, array $attrs = [], $contents = '', callable $transform = null)
    {
        $this->name = $name;
        $this->attrs = $attrs;
        $this->contents = $contents;
        $this->transform = $transform;
    }

    /**
     * Renders element shortcut.
     *
     * @see render()
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Render element shortcut.
     *
     * @param array      $params
     * @param null|mixed $attrs
     * @param null|mixed $contents
     * @param null|mixed $name
     *
     * @return string
     *
     * @see render()
     */
    public function __invoke(array $params = [], $attrs = null, $contents = null, $name = null)
    {
        return $this->render($params, $attrs, $contents, $name);
    }

    /**
     * Renders the element tag.
     *
     * @param array  $params
     * @param array  $attrs
     * @param string $contents
     * @param string $name
     *
     * @return string
     */
    public function render(array $params = [], $attrs = null, $contents = null, $name = null)
    {
        $element = isset($attrs) ? $this->copy($attrs, $contents, $name) : $this;

        if ($transform = $this->transform and $result = $transform($element, $params)) {
            return $result;
        }

        return self::tag($element->name, $element->attrs, $element->contents, $params);
    }

    /**
     * Renders element closing tag.
     *
     * @return string
     */
    public function end()
    {
        return self::isSelfClosing($this->name) ? '' : "</{$this->name}>";
    }

    /**
     * Adds an attribute.
     *
     * @param string|array $name
     * @param mixed|null   $value
     *
     * @return $this
     */
    public function attr($name, $value = null)
    {
        $attrs = is_array($name) ? $name : [$name => $value];

        $this->attrs = Arr::merge($this->attrs, $attrs);

        return $this;
    }

    /**
     * Copy instance.
     *
     * @param array  $attrs
     * @param string $contents
     * @param string $name
     *
     * @return static
     */
    public function copy($attrs = null, $contents = null, $name = null)
    {
        $clone = clone $this;

        if (is_array($attrs)) {
            $clone->attr($attrs);
        } elseif (isset($attrs)) {
            $contents = $attrs;
        }

        if (isset($name)) {
            $clone->name = $name;
        }

        if (isset($contents)) {
            $clone->contents = $contents;
        }

        return $clone;
    }

    /**
     * Renders element tag.
     *
     * @param string $name
     * @param array  $attrs
     * @param string $contents
     * @param array  $params
     *
     * @return string
     */
    public static function tag($name, $attrs = null, $contents = null, array $params = [])
    {
        $tag = $contents === false || self::isSelfClosing($name);

        if (is_array($attrs)) {
            $attrs = self::attrs($attrs, $params);
        }

        if (is_array($contents)) {
            $contents = join($contents);
        }

        return $tag ? "<{$name}{$attrs}>" : "<{$name}{$attrs}>{$contents}</{$name}>";
    }

    /**
     * Renders tag attributes.
     *
     * @param array $attrs
     * @param array $params
     *
     * @return string
     */
    public static function attrs(array $attrs, array $params = [])
    {
        $output = [];

        foreach ($attrs as $key => $value) {

            if (is_array($value)) {
                $value = self::expr($value, $params);
            }

            if (empty($value) && !is_numeric($value)) {
                continue;
            }

            if (is_numeric($key)) {
               $output[] = $value;
            } elseif ($value === true) {
               $output[] = $key;
            } elseif ($value !== '') {
               $output[] = sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false));
            }
        }

        return $output ? ' ' . implode(' ', $output) : '';
    }

    /**
     * Evaluate expression attribute.
     *
     * @param array $expressions
     * @param array $params
     *
     * @return string|null
     */
    public static function expr($expressions, array $params = [])
    {
        $output = [];

        if (func_num_args() > 2) {
            $params = call_user_func_array('array_replace', array_slice(func_get_args(), 1));
        }

        foreach ((array) $expressions as $expression => $condition) {

            if (!$condition) {
                continue;
            }

            if (is_int($expression)){
                $expression = $condition;
            }

            if ($expression = self::evaluateExpression($expression, array_replace($params, (array) $condition))) {
                $output[] = $expression;
            }
        }

        return $output ? join(' ', $output) : null;
    }

    /**
     * Checks if tag name is self closing.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isSelfClosing($name)
    {
        static $tags;

        if (is_null($tags)) {
            $tags = array_flip(['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr']);
        }

        return isset($tags[strtolower($name)]);
    }

    /**
     * Parse expression string.
     *
     * @param string $expression
     *
     * @return array
     */
    protected static function parseExpression($expression)
    {
        static $expressions;

        if (isset($expressions[$expression])) {
            return $expressions[$expression];
        }

        $optionals = [];

        // match all optionals
        $output = preg_replace_callback('/\[((?:[^\[\]]+|(?R))*)\]/', function ($matches) use (&$optionals) {
            return '%' . array_push($optionals, $matches[1]) . '$s';
        }, $expression);

        // match all parameters
        preg_match_all('/\{\s*(@?)(!?)(\w+)\s*(?::\s*([^{}]*(?:\{(?-1)\}[^{}]*)*))?\}/', $output, $parameters, PREG_SET_ORDER);

        return $expressions[$expression] = [$output, $parameters, $optionals];
    }

    /**
     * Evaluate expression string.
     *
     * @param string $expression
     * @param array  $params
     *
     * @return string
     */
    protected static function evaluateExpression($expression, array $params = [])
    {
        if (strpos($expression, '{') === false) {
            return trim($expression);
        }

        list($output, $parameters, $optionals) = self::parseExpression($expression);

        foreach ($parameters as $match) {

            list($parameter, $empty, $negate, $name) = $match;

            $regex = isset($match[4]) ? "/^({$match[4]})$/" : '';
            $value = isset($params[$name]) ? $params[$name] : '';
            $result = !$regex && $value || $regex && preg_match($regex, $value);

            if ($result && !$negate || !$result && $negate) {
                $output = str_replace($parameter, $empty ? '' : $value, $output);
            } else {
                return '';
            }
        }

        if ($optionals) {

            $args = [$output];

            foreach ($optionals as $match) {
                $args[] = self::evaluateExpression($match, $params);
            }

            $output = call_user_func_array('sprintf', $args);
        }

        return trim($output);
    }
}
