<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\View;

class MenuWalker extends \Walker_Nav_Menu
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \WP_Post
     */
    protected $item;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $parents = [];

    /**
     * @var array
     */
    protected $arguments = [];

    protected $hasActive = false;

    /**
     * Constructor.
     *
     * @param View   $view
     * @param Config $config
     * @param array  $arguments
     */
    public function __construct(View $view, Config $config, array $arguments = [])
    {
        $this->view = $view;
        $this->config = $config;
        $this->arguments = $arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $this->item->children = [];
        $this->parents[] = $this->item;
    }

    /**
     * {@inheritdoc}
     */
    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        array_splice($this->parents, -1);
    }

    /**
     * {@inheritdoc}
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;

        // normalize menu item
        $item->id = $item->ID;
        $item->level = $depth + 1;
        $item->anchor_title = $item->attr_title;
        $item->anchor_rel = $item->xfn;
        $item->divider = $item->type === 'custom' && $item->url === '#' && preg_match('/---+/i', $item->title);
        $item->type = $item->type === 'custom' && $item->url === '#' ? 'header' : $item->type;

        // set parent
        if (count($this->parents)) {
            $this->parents[count($this->parents) - 1]->children[] = $item;
        } else {
            $this->items[] = $item;
        }

        // Unset active class for posts_page if currently on none blog page
        if (in_array('current_page_parent', $classes)
            && $item->object_id == get_option('page_for_posts')
            && !is_singular('post') && !is_category() && !is_tag() && !is_date() && get_query_var('post_type') !== 'post'
        ) {
            unset($classes[array_search('current_page_parent', $classes)]);
        }

        // Set item classes
        $item->class = implode(' ', $classes);

        // set current
        $item->active = !empty($item->active)
            || $item->url == 'index.php' && (is_home() || is_front_page())
            || is_page() && in_array($item->object_id, get_post_ancestors(get_the_ID()))
            || preg_match('/\bcurrent-([a-z]+-ancestor|menu-(item|parent))\b/', $item->class);

        $this->hasActive = $this->hasActive || $item->active;

        $this->item = $item;
    }

    public function end_el(&$output, $object, $depth = 0, $args = [])
    {
        if (!isset($object->children)) {
            return;
        }

        foreach ($object->children as $child) {
            if ($child->active) {
                $object->active = true;
                break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function walk($elements, $max_depth, ...$args)
    {
        parent::walk($elements, $max_depth, ...$args);

        if (!$this->hasActive) {
            $this->setActive($this->items);
        }

        // set menu config
        $this->config->set('~menu', $this->arguments);

        echo $this->view->render('~theme/templates/menu/menu', ['items' => $this->items]);
    }

    protected function setActive($items)
    {
        foreach ($items as $item) {
            $item->active = preg_match('/\bcurrent_page_(item|parent)\b/', $item->class);

            if ($item->children) {
                $this->setActive($item->children);
            }
        }
    }
}
