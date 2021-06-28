<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Storage;
use YOOtheme\Url;

class SettingsListener
{
    public static function initCustomizer(Config $config, Storage $storage)
    {
        $key = 'news';
        $hash = hash_file('crc32b', File::find('~theme/NEWS.md'));

        if ($storage($key) !== $hash) {
            $storage->set($key, $hash);
            $config->set('customizer.news', true);
        }
    }

    public static function initHead(Config $config)
    {
        $assets = "~yootheme/theme-{$config('app.platform')}/assets";

        $config->set('~theme.body_class', [$config('~theme.page_class')]);
        $config->set('~theme.favicon', Url::to($config('~theme.favicon') ?: "{$assets}/images/favicon.png"));
        $config->set('~theme.touchicon', Url::to($config('~theme.touchicon') ?: "{$assets}/images/apple-touch-icon.png"));
    }
}
