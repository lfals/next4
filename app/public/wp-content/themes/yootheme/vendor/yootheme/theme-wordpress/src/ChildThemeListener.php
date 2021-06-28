<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Event;
use YOOtheme\File;

class ChildThemeListener
{
    /**
     * @link https://developer.wordpress.org/reference/hooks/init/
     *
     * @param Config $config
     */
    public static function initConfig(Config $config)
    {
        if (!is_child_theme()) {
            return;
        }

        $childDir = get_stylesheet_directory();

        // add childDir to config
        $config->set('theme.childDir', $childDir);

        // add ~theme alias resolver
        Event::on('path ~theme', function ($path, $file) use ($childDir) {
            return $file && File::find($childDir . $file) ? $childDir . $file : $path;
        });
    }

    /**
     * Copy theme config in child-theme on first activation.
     *
     * Theme functions attached to this hook are only triggered in the theme (and/or child theme) being activated
     *
     * @link https://developer.wordpress.org/reference/hooks/after_switch_theme/
     */
    public static function copyConfig()
    {
        if (!is_child_theme()) {
            return;
        }

        $config = json_decode(get_theme_mod('config', '{}'), true);

        // if child-theme config is empty, get parent theme_mods (contain menu, widgets and theme configuration)
        if (empty($config)) {

            $theme = wp_get_theme();

            if ($theme_mods = get_option("theme_mods_{$theme->template}")) {
                update_option("theme_mods_{$theme->stylesheet}", $theme_mods);
            }
        }
    }
}
