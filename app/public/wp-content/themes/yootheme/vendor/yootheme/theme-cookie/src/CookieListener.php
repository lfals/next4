<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;
use YOOtheme\View;

class CookieListener
{
    public static function initHead(Config $config, Metadata $metadata, View $view)
    {
        if (!$mode = $config('~theme.cookie.mode')) {
            return;
        }

        $config->set('theme.data.cookie', [
            'mode' => $mode,
            'template' => trim($view('~theme/templates/cookie')),
            'position' => $config('~theme.cookie.bar_position'),
        ]);

        if (!$config('app.isCustomizer')) {

            if ($custom = $config('~theme.cookie.custom_js')) {
                $metadata->set('script:cookie-custom', "(window.\$load = window.\$load || []).push(function(c,n) {try {{$custom}\n} catch (e) {console.error(e)} n()});\n");
            }

            $metadata->set('script:cookie', ['src' => Path::get('../app/cookie.min.js'), 'defer' => true]);
        }
    }
}
