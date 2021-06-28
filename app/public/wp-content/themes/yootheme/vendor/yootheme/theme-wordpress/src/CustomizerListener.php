<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Event;
use YOOtheme\Metadata;
use YOOtheme\Path;

class CustomizerListener
{
    public static function initConfig(Config $config, Metadata $metadata, $customizer)
    {
        /** @var \WP_Customize_Manager $customizer */

        // add settings
        $customizer->add_setting('config');
        $customizer->add_setting('page');
        $customizer->add_setting('template');
        $customizer->remove_setting('site_icon');

        // encode config
        add_filter('customize_sanitize_js_config', function () use ($config) {
            return base64_encode(json_encode($config('~theme')));
        });

        // decode config
        add_filter('customize_sanitize_config', function ($value) {
            return base64_decode($value);
        });

        // decode page
        add_filter('customize_sanitize_page', function ($value) {
            return json_decode(base64_decode($value), true);
        });

        // decode template
        add_filter('customize_sanitize_template', function ($value) {
            return json_decode(base64_decode($value), true);
        });

        // remove page
        add_action('customize_save', function ($customizer) {
            /** @var \WP_Customize_Manager $customizer */
            $customizer->remove_setting('page');
            $customizer->remove_setting('template');
        });

        // add data
        $metadata->set('script:customizer-data', function ($script) use ($config) {
            return $script->withValue(sprintf('var $customizer = JSON.parse(atob("%s"));', base64_encode(json_encode($config('customizer', [])))));
        });
    }

    public static function addAssets(Config $config, Metadata $metadata)
    {
        // add config
        $config->set('customizer.404', home_url('index.php?p=-1'));
        $config->addFile('customizer', Path::get('../config/customizer.json'));

        // init customizer
        Event::emit('customizer.init');

        // add assets
        $metadata->set('style:customizer', ['href' => Path::get('../assets/css/admin.css')]);
        $metadata->set('script:customizer', ['src' => Path::get('../app/customizer.min.js')]);
    }
}
