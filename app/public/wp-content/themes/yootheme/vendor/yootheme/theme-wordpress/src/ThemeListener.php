<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Event;
use YOOtheme\View;

class ThemeListener
{
    /**
     * Fires before the header template file is loaded.
     *
     * @link https://developer.wordpress.org/reference/hooks/get_header/
     *
     * @param Config $config
     * @param View   $view
     */
    public static function onHeader(Config $config, View $view)
    {
        $config->set('~theme.site_url', get_bloginfo('url'));
        $config->set('~theme.direction', is_rtl() ? 'rtl' : 'lrt');
        $config->set('~theme.page_class', ''); // TODO: implement page class builder

        if ($config('~theme.disable_wpautop')) {
            remove_filter('the_content', 'wpautop');
            remove_filter('the_excerpt', 'wpautop');
        }

        if ($config('~theme.disable_emojis')) {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        }

        $view['sections']->add('breadcrumbs', function () use ($config, $view) {
            return $view->render('~theme/templates/breadcrumbs', ['items' => Breadcrumbs::getItems([
                'show_current' => $config('~theme.site.breadcrumbs_show_current'),
                'show_home' => $config('~theme.site.breadcrumbs_show_home'),
                'home_text' => $config('~theme.site.breadcrumbs_home_text'),
            ])]);
        });

        Event::emit('theme.head');
    }

    /**
     * Filters the path of the current template before including it.
     *
     * @link https://developer.wordpress.org/reference/hooks/template_include/
     *
     * @param Config $config
     * @param string $template
     *
     * @return string
     */
    public static function includeTemplate(Config $config, $template)
    {
        if (is_home() || is_category() || is_tag()) {
            $config->set('~theme.page_layout', 'blog');
        } elseif (is_singular('post')) {
            $config->set('~theme.page_layout', 'post');
        }

        return $template;
    }

    /**
     * Filters list of allowed mime types and file extensions.
     *
     * @link https://developer.wordpress.org/reference/hooks/upload_mimes/
     *
     * @param mixed $mimes
     */
    public static function addSvg($mimes)
    {
        $mimes['svg|svgz'] = 'image/svg+xml';

        return $mimes;
    }

    /**
     * Filters the “real” file type of the given file..
     *
     * @link https://developer.wordpress.org/reference/hooks/wp_check_filetype_and_ext/
     *
     * @param mixed $data
     * @param mixed $file
     * @param mixed $filename
     * @param mixed $mimes
     */
    public static function addSvgType($data, $file, $filename, $mimes)
    {
        if (empty($data['type']) && substr($filename, -4) === '.svg') {
            $data['ext'] = 'svg';
            $data['type'] = 'image/svg+xml';
        }

        return $data;
    }

    /**
     * Prints scripts or data in the head tag on the front end.
     *
     * @link https://developer.wordpress.org/reference/hooks/wp_head/
     *
     * @param Config $config
     */
    public static function addScript(Config $config)
    {
        if ($script = $config('~theme.custom_js', '')) {

            if (stripos(trim($script), '<script') !== 0) {
                $script = "<script>{$script}</script>";
            }

            echo $script;
        }
    }

    /**
     * Fires when scripts and styles are enqueued.
     *
     * @link https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
     *
     * @param Config $config
     */
    public static function addJQuery(Config $config)
    {
        if ($config('~theme.jquery') || strpos($config('~theme.custom_js', ''), 'jQuery') !== false) {
            wp_enqueue_script('jquery');
        }
    }

    /**
     * Disables the site icon meta tags.
     *
     * @link https://developer.wordpress.org/reference/hooks/site_icon_meta_tags/
     */
    public static function filterMetaTags()
    {
        return [];
    }
}
