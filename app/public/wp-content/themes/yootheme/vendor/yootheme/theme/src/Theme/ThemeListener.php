<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Metadata;
use YOOtheme\Path;

class ThemeListener
{
    public static function initHead(Config $config, Metadata $metadata)
    {
        $rtl = $config('~theme.direction') == 'rtl' ? '{.rtl,}' : '';
        $href = File::find("~theme/css/theme{.{$config('theme.id')},}{$rtl}.css");
        $debug = $config('app.debug') ? '' : '.min';
        $version = filectime($href);

        list($style) = explode(':', $config('~theme.style'));

        $metadata->set('style:theme', compact('href', 'version') + ($config('app.isCustomizer') ? ['id' => 'theme-style'] : []));

        if (filectime(__FILE__) >= $version) {
            $metadata->set('style:theme-update', ['href' => '~theme/css/theme.update.css']);
        }

        $metadata->set('script:theme-uikit', ['src' => "~assets/uikit/dist/js/uikit{$debug}.js"]);
        $metadata->set('script:theme-uikit-icons', ['src' => File::find("~assets/uikit/dist/js/uikit-icons{-{$style},}{$debug}.js")]);
        $metadata->set('script:theme', ['src' => '~theme/js/theme.js']);
        $metadata->set('script:theme-data', sprintf('var $theme = %s;', json_encode($config('theme.data', (object) []))));

        if ($config('app.isCustomizer')) {
            $metadata->set('script:customizer-site', ['src' => Path::get('../../assets/js/customizer.min.js')]);
        }

        if ($custom = File::get('~theme/css/custom.css')) {
            $metadata->set('style:theme-custom', ['href' => $custom]);
        }

        if ($custom = File::get('~theme/js/custom.js')) {
            $metadata->set('script:theme-custom', ['src' => $custom]);
        }
    }

    public static function loadMetadata(Config $config, $meta)
    {
        if (is_null($meta->version) and $version = $config('theme.version')) {
            $meta->version = $version;
        }

        return $meta;
    }
}
