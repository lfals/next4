<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\View;

class MenuListener
{
    /**
     * Register navigation menus.
     *
     * @link https://developer.wordpress.org/themes/functionality/navigation-menus
     *
     * @param Config $config
     */
    public static function registerMenus(Config $config)
    {
        foreach ($config('theme.menus') as $id => $name) {
            register_nav_menu($id, __($name));
        }
    }

    /**
     * Filters the arguments used to display a navigation menu.
     *
     * @link https://developer.wordpress.org/reference/hooks/wp_nav_menu_args/
     *
     * @param Config $config
     * @param View   $view
     * @param mixed  $args
     */
    public static function filterMenuArgs(Config $config, View $view, $args)
    {
        return array_replace($args, [
            'walker' => new MenuWalker($view, $config, $args + ['position' => get_current_sidebar()]),
            'container' => false,
            'fallback_cb' => false,
            'items_wrap' => '%3$s',
        ]);
    }

    /**
     * Filters the arguments for the Navigation Menu widget.
     *
     * @link https://developer.wordpress.org/reference/hooks/widget_nav_menu_args/
     *
     * @param mixed $nav_menu_args
     * @param mixed $nav_menu
     * @param mixed $args
     * @param mixed $instance
     */
    public static function filterWidgetArgs($nav_menu_args, $nav_menu, $args, $instance)
    {
        $menu_args = array_replace($nav_menu_args, json_decode(isset($instance[$key = '_theme']) ? $instance[$key] : '{}', true));

        if (isset($args['yoo_element'])) {
            $menu_args = array_merge($menu_args, $args['yoo_element']->props);
        }

        return $menu_args;
    }
}
