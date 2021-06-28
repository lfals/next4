<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;
use YOOtheme\View;

class WidgetsListener
{
    /**
     * @var string
     */
    public $style;

    /**
     * @var string
     */
    public $sidebar;

    /**
     * @var array
     */
    public $widgets = [];

    /**
     * @var array
     */
    public $position = [];

    /**
     * Initialize widgets and sidebars.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars
     * @link https://developer.wordpress.org/reference/hooks/widgets_init/
     *
     * @param Config $config
     */
    public function initWidgets(Config $config)
    {
        register_widget('BuilderWidget');
        register_widget('YOOtheme\Theme\BreadcrumbsWidget');

        foreach ($config('theme.positions') as $id => $name) {
            $this->registerSidebar($id, $name);
        }
    }

    public function isActiveSidebar(Config $config, $active, $sidebar)
    {
        return $active
            || has_nav_menu($sidebar)
            || in_array($sidebar, [$config('~theme.header.search'), $config('~theme.header.social')])
            || $sidebar == 'header-split' && is_active_sidebar('header');
    }

    public function beforeSidebar($sidebar)
    {
        $this->sidebar = $sidebar;
        if ($sidebar != 'header-split') {
            $this->widgets[$sidebar] = [];
        }
    }

    public function afterSidebar(Config $config, View $view, $sidebar)
    {
        global $wp_widget_factory, $wp_registered_sidebars;

        $search = $config('~theme.header.search');

        if ($sidebar == $search || $search && $sidebar == 'mobile') {
            $widget = $wp_widget_factory->widgets['WP_Widget_Search'];
            $widget->_set($widget->number + 1);
            $this->displayWidget($config, [], $widget, $wp_registered_sidebars[$sidebar]);
        }

        $items = $this->widgets[$sidebar];

        $social = $config('~theme.header.social');

        if ($sidebar == $social || $social && $sidebar == 'mobile') {

            $widget = $this->createWidget([
                'id' => 'social',
                'type' => 'social',
                'content' => $view('~theme/templates/socials'),
            ]);

            strpos($sidebar, 'left') ? array_unshift($items, $widget) : array_push($items, $widget);
        }

        $location = $sidebar == 'navbar-split' ? 'navbar' : $sidebar;

        if (has_nav_menu($location)) {

            $menu = get_nav_menu_locations();

            ob_start();
            wp_nav_menu([
                'theme_location' => $location,
                'menu' => $menu[$location],
                'split' => $location == 'navbar',
            ]);

            $widget = $this->createWidget([
                'id' => "menu-{$sidebar}",
                'type' => 'menu',
                'content' => ob_get_clean(),
            ]);

            array_unshift($items, $widget);
        }

        if ($sidebar == 'header' && $config('~theme.header.layout') == 'stacked-center-c') {
            if (!is_registered_sidebar('header-split')) {
                $this->registerSidebar('header-split', 'Header Split');
                $this->widgets['header-split'] = array_slice($items, ceil(count($items) / 2));
            }
            $items = array_slice($items, 0, ceil(count($items) / 2));
        }

        echo $view('~theme/templates/position', [
            'name' => $sidebar,
            'items' => $items,
            'style' => $this->style,
            'position' => $this->position,
        ]);

        $this->style = null;
        $this->sidebar = null;
        $this->position = null;
    }

    public function parseSidebarStyle($title, $raw)
    {
        global $wp_registered_sidebars;

        if (strpos($raw, ':')) {

            list($name, $style) = explode(':', $raw, 2);

            if (isset($wp_registered_sidebars[$name])) {
                $this->style = $style;
                return $name;
            }
        }

        return $title;
    }

    /**
     * @param Config     $config
     * @param array      $instance
     * @param \WP_Widget $widget
     * @param array      $args
     *
     * @return bool
     */
    public function displayWidget(Config $config, $instance, $widget, $args)
    {
        if ($instance === false || $this->sidebar === null && !$args['yoo_element']) {
            return $instance;
        }

        // disable wpautop filter for text-widget in navbar, header, header-split and toolbar position
        // re-add it afterwards for subsequent text-widgets
        if (in_array($this->sidebar, ['navbar', 'header', 'header-split', 'toolbar-left', 'toolbar-right', 'logo', 'logo-mobile'])) {
            $priority = has_filter('widget_text_content', 'wpautop');
            if ($priority !== false) {
                remove_filter('widget_text_content', 'wpautop', $priority);
                add_filter('widget_text_content', [$this, '_restore_textwidget_wpautop'], $priority + 1);
            }
        }

        ob_start();
        $widget->widget($args, $instance);
        $output = ob_get_clean();

        preg_match('/' . preg_quote($args['before_widget'], '/') . '(.*?)' . preg_quote($args['after_widget'], '/') . '/s', $output, $content);
        preg_match('/' . preg_quote($args['before_title'], '/') . '(.*?)' . preg_quote($args['after_title'], '/') . '/s', $output, $title);

        $type = strtr(str_replace('nav_menu', 'menu', $widget->id_base), '_', '-');
        $content = $content ? $content[1] : $output;

        if ($title) {
            $content = str_replace($title[0], '', $content);
        }

        // add 'uk-panel' to text widget content div class
        if ($type === 'text') {
            $content = substr_replace($content, 'uk-panel ', strpos($content, 'class="textwidget"') + strlen('class="'), 0);
        }

        if (!isset($widget->widget_cssclass)) {
            $widget->widget_cssclass = '';
        }

        $this->widgets[$this->sidebar][] = $this->createWidget([
            'id' => $widget->id,
            'type' => $type,
            'title' => $title ? $title[1] : '',
            'content' => $content,
            'attrs' => ['id' => "widget-{$widget->id}", 'class' => [trim("widget-{$type} {$widget->widget_cssclass}")]],
        ]);

        $config->update("~theme.modules.{$widget->id}", function ($values) use ($type, $instance) {

            if (isset($instance[$key = '_theme'])) {
                $config = $instance[$key];
            } else {
                $config = '{}';
            }

            return array_merge($values ?: [], json_decode($config, true), [
                'is_list' => $this->isList($type),
            ]);

        });

        return false;
    }

    public function _restore_textwidget_wpautop($content)
    {
        $current_priority = has_filter('widget_text_content', [$this, '_restore_textwidget_wpautop']);

        add_filter('widget_text_content', 'wpautop', $current_priority - 1);
        remove_filter('widget_text_content', [$this, '_restore_textwidget_wpautop'], $current_priority);

        return $content;
    }

    public function isList($type)
    {
        return in_array($type, ['recent-posts', 'pages', 'recent-comments', 'archives', 'categories', 'meta']);
    }

    public function editScreen(Config $config, Metadata $metadata, $screen)
    {
        if (in_array($screen->base, ['customize', 'widgets'])) {

            $data = $config->loadFile(Path::get('../config/widgets.json'));
            $metadata->set('script:widgets-data', sprintf('var $widgets = %s;', json_encode($data)));

            if ($screen->base === 'widgets') {
                $debug = $config('app.debug') ? '' : '.min';
                $metadata->set('script:uikit', ['src' => "~assets/uikit/dist/js/uikit{$debug}.js"]);
                $metadata->set('script:widgets', ['src' => Path::get('../app/widgets.min.js')]);
            }
        }
    }

    /**
     * @param \WP_Widget $widget
     * @param null       $return
     * @param array      $instance
     */
    public function editWidget($widget, $return, $instance)
    {
        $config = isset($instance[$key = '_theme']) ? esc_attr($instance[$key]) : '{}';

        echo "<input type=\"hidden\" name=\"{$widget->get_field_name($key)}\" value=\"{$config}\" data-widget>";
    }

    public function updateWidget($instance, $new_instance)
    {
        if (isset($new_instance['_theme'])) {
            $instance['_theme'] = $new_instance['_theme'];
        }

        return $instance;
    }

    public function createWidget($widget)
    {
        static $id = 0;

        return (object) array_merge([
            'id' => 'tm-' . (++$id),
            'title' => '',
            'position' => $this->sidebar,
            'attrs' => ['class' => []],
        ], (array) $widget);
    }

    protected function registerSidebar($id, $name)
    {
        register_sidebar([
            'id' => $id,
            'name' => $name,
            'before_widget' => '<content>',
            'after_widget' => '</content>',
            'before_title' => '<title>',
            'after_title' => '</title>',
        ]);
    }
}
