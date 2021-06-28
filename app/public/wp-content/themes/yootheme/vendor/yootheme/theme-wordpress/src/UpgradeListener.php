<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Path;
use YOOtheme\Wordpress\Update;

class UpgradeListener
{
    public static function initUpdate(Config $config, Update $update)
    {
        $update->register(Path::basename('~theme'), 'theme', $config('theme.update'), [
            'key' => $config('~theme.yootheme_apikey'),
            'stability' => $config('~theme.minimum_stability'),
        ]);

        add_filter('upgrader_pre_install', function ($return, $package) {

            if (!is_wp_error($return)) {
                static::move($package);
            }

            return $return;

        }, 10, 2);

        add_filter('upgrader_post_install', function ($return, $package) {

            if (!is_wp_error($return)) {
                static::move($package, true);
            }

            return $return;

        }, 10, 2);

        // Check child theme's "theme.js" for jQuery
        if (is_child_theme()
            and $config('~theme.jquery') === null
            and $contents = @file_get_contents(get_stylesheet_directory() . '/js/theme.js')
            and strpos($contents, 'jQuery') !== false
        ) {
            $config->set('~theme.jquery', true);
            set_theme_mod('config', json_encode($config('~theme')));
        }

    }

    public static function move($package, $reverse = false)
    {
        /** @var \WP_Filesystem_Base $wp_filesystem */
        global $wp_filesystem;

        $themeDir = Path::get('~theme');
        $name = isset($package['theme']) ? $package['theme'] : '';
        $content = $wp_filesystem->wp_content_dir();

        if ($name != basename($themeDir)) {
            return;
        }

        $paths = [
            $themeDir,
            "{$content}/upgrade",
        ];

        list($source, $target) = $reverse ? array_reverse($paths) : $paths;

        $files = array_merge(
            glob("{$source}/fonts/*"),
            glob("{$source}/css/theme*.css")
        );

        foreach ($files as $file) {

            // skip theme.update.css
            if (strpos($file, 'update.css')) {
                continue;
            }

            $filename = ltrim(substr($file, strlen($source)), '\\/');
            $directory = dirname("{$target}/{$filename}");

            if (!$wp_filesystem->is_dir($directory)) {
                $wp_filesystem->mkdir($directory);
            }

            $wp_filesystem->move($file, "{$target}/{$filename}", true);
        }
    }
}
