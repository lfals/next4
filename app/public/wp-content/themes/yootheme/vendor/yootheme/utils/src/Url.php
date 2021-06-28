<?php

namespace YOOtheme;

use YOOtheme\Http\Uri;

abstract class Url
{
    /**
     * @var Uri
     */
    protected static $base;

    /**
     * Gets the base URL.
     *
     * @param bool $secure
     *
     * @return string
     */
    public static function base($secure = null)
    {
        if (is_null($secure)) {
            return static::$base->getPath();
        }

        return (string) static::$base->withScheme($secure ? 'https' : 'http');
    }

    /**
     * Sets the base URL.
     *
     * @param string|Uri $base
     */
    public static function setBase($base)
    {
        static::$base = is_string($base) ? new Uri($base) : $base;
    }

    /**
     * Generates a URL to a path.
     *
     * @param string $path
     * @param array  $parameters
     * @param bool   $secure
     *
     * @return string
     */
    public static function to($path, array $parameters = [], $secure = null)
    {
        try {

            if (empty($parameters) && is_null($secure) && static::isValid($path)) {
                return $path;
            }

            return (string) Event::emit('url.resolve|middleware', [static::class, 'generate'], $path, $parameters, $secure);

        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * Generates a URL to a route.
     *
     * @param string $pattern
     * @param array  $parameters
     * @param bool   $secure
     *
     * @return string
     */
    public static function route($pattern = '', array $parameters = [], $secure = null)
    {
        return (string) Event::emit('url.route', $pattern, $parameters, $secure);
    }

    /**
     * Generates a URL to a path.
     *
     * @param string $path
     * @param array  $parameters
     * @param bool   $secure
     *
     * @return Uri
     */
    public static function generate($path, array $parameters = [], $secure = null)
    {
        $url = new Uri($path);

        if (!$url->getHost() && !Str::startsWith($url->getPath(), '/')) {
            $url = $url->withPath(Path::join(static::$base->getPath(), $url->getPath()));
        }

        if ($query = array_replace($url->getQueryParams(), $parameters)) {
            $url = $url->withQueryParams($query);
        }

        if (is_bool($secure)) {

            if (!$url->getHost()) {
                $url = $url->withHost(static::$base->getHost())->withPort(static::$base->getPort());
            }

            $url = $url->withScheme($secure ? 'https' : 'http');
        }

        return $url;
    }

    /**
     * Checks if the given path is a valid URL.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function isValid($path)
    {
        $valid = ['http://', 'https://', 'mailto:', 'tel:', '//', '#'];

        return Str::startsWith($path, $valid) || filter_var($path, FILTER_VALIDATE_URL);
    }
}
