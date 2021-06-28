<?php

namespace YOOtheme\View;

use YOOtheme\View;

class SectionHelper
{
    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var array
     */
    protected $openSections = [];

    /**
     * Constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $view['sections'] = $this;
        $view->addFunction('section', [$this, 'get']);
    }

    /**
     * Gets a section.
     *
     * @param string       $name
     * @param string|false $default
     *
     * @return string|false
     */
    public function get($name, $default = false)
    {
        if (empty($this->sections[$name])) {
            return $default;
        }

        return array_reduce($this->sections[$name], function ($result, $content) {

            if (is_callable($content)) {
                $result = $content($result);
            } elseif (is_string($content)) {
                $result .= $content;
            }

            return $result;
        });
    }

    /**
     * Sets a section value.
     *
     * @param string          $name
     * @param string|callable $content
     */
    public function set($name, $content)
    {
        $this->sections[$name] = [$content];
    }

    /**
     * Adds a section value by appending it.
     *
     * @param string          $name
     * @param string|callable $content
     */
    public function add($name, $content)
    {
        $this->sections[$name][] = $content;
    }

    /**
     * Checks if a section exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists($name)
    {
        return isset($this->sections[$name]);
    }

    /**
     * Starts a new section.
     *
     * @param string $name
     */
    public function start($name)
    {
        if (ob_start()) {
            $this->openSections[] = $name;
        }
    }

    /**
     * Stops a section.
     *
     * @throws \LogicException
     */
    public function stop()
    {
        if (!$name = array_pop($this->openSections)) {
            throw new \LogicException('Cannot stop a section without first starting one.');
        }

        $this->sections[$name] = [ob_get_clean()];
    }
}
