<?php

namespace YOOtheme;

class UrlResolver
{
    public static function resolve(Config $config, $path, $parameters, $secure, callable $next)
    {
        $root = $config('app.rootDir');
        $path = Path::resolveAlias($path);

        if (Str::startsWith($path, $root)) {
            $path = ltrim(substr($path, strlen($root)), '/');
        }

        return $next($path, $parameters, $secure);
    }
}
