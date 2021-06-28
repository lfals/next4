<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Http\Uri;
use YOOtheme\Str;
use YOOtheme\Url;

class UrlListener
{
    const REGEX_URL = '/
                        \s                                      # match a space
                        (?<attr>(?:data-)?(?:href|src|poster))= # match the attribute
                        ([\"\'])                                # start with a single or double quote
                        (?!\/|\#|[a-z0-9\-\.]+\:)               # make sure it is a relative path
                        (?<url>[^\"\'>]+)                       # match the actual src value
                        \2                                      # match the previous quote
                       /xiU';

    public static function resolveRelativeUrl($name, $parameters, $next)
    {
        if (!is_string($content = $next($name, $parameters))) {
            return $content;
        }

        // Apply to root template view only
        if (empty($parameters['_root'])) {
            return $content;
        }

        return preg_replace_callback(static::REGEX_URL, function ($matches) {
            return sprintf(' %s="%s"', $matches['attr'], Url::to($matches['url']));
        }, $content);
    }

    public static function routeQueryParams(Config $config, $path, $parameters, $secure, callable $next)
    {
        /** @var Uri $uri */
        $uri = $next($path, $parameters, $secure);

        if (Str::startsWith($uri->getQueryParam('p'), 'theme/') && $config('app.isCustomizer')) {

            $query = $uri->getQueryParams();
            $query['wp_customize'] = 'on';

            $uri = $uri->withQueryParams($query);
        }

        return $uri;
    }
}
