<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;

class AnalyticsListener
{
    public static function initHead(Config $config, Metadata $metadata)
    {
        $keys = [
            'google_analytics',
            'google_analytics_anonymize',
        ];

        if ($config("~theme.{$keys[0]}")) {

            foreach ($keys as $key) {
                $config->set("theme.data.{$key}", trim($config("~theme.{$key}")));
            }

            $metadata->set('script:analytics', ['src' => Path::get('../app/analytics.min.js'), 'defer' => true]);
        }
    }
}
