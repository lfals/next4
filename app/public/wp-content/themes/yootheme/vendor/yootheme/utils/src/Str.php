<?php

namespace YOOtheme;

/**
 * A static class which provides utilities for working with strings.
 */
abstract class Str
{
    /**
     * @var string
     */
    public static $encoding = 'UTF-8';

    /**
     * Checks if string matches a given pattern.
     *
     * @param string $pattern
     * @param string $string
     *
     * @return bool
     *
     * @example
     * Str::is('foo/*', 'foo/bar/baz');
     * // => true
     */
    public static function is($pattern, $string)
    {
        static $cache;

        $string = (string) $string;
        $pattern = (string) $pattern;

        if ($pattern === $string) {
            return true;
        }

        if (empty($cache[$pattern])) {

            $regexp = addcslashes($pattern, '/\\.+^$()=!<>|#');
            $regexp = strtr($regexp, ['*' => '.*', '?' => '.?']);
            $regexp = static::convertBraces($regexp);

            $cache[$pattern] = "#^{$regexp}$#s";
        }

        return (bool) preg_match($cache[$pattern], $string);
    }

    /**
     * Checks if string contains a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @example
     * Str::contains('taylor', 'ylo');
     * // => true
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle, 0, static::$encoding) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if string starts with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @example
     * Str::startsWith('jason', 'jas');
     * // => true
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && (string) $needle === substr($haystack, 0, strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if string ends with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @example
     * Str::endsWith('jason', 'on');
     * // => true
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the string length.
     *
     * @param string $string
     *
     * @return int
     *
     * @example
     * Str::length('foo bar baz');
     * // => 11
     */
    public static function length($string)
    {
        return mb_strlen($string, static::$encoding);
    }

    /**
     * Convert string to lower case.
     *
     * @param string $string
     *
     * @return string
     *
     * @example
     * Str::lower('fOo Bar bAz');
     * // => foo bar baz
     */
    public static function lower($string)
    {
        return mb_strtolower($string, static::$encoding);
    }

	/**
	 * Converts the first character of string to lower case.
	 *
	 * @param string $string
	 *
	 * @return string
	 *
	 * @example
	 * Str::lowerFirst('FOO BAR BAZ');
	 * // => fOO BAR BAZ
	 */
	public static function lowerFirst($string)
	{
		return static::lower(static::substr($string, 0, 1)) . static::substr($string, 1);
	}

    /**
     * Converts string to upper case.
     *
     * @param string $string
     *
     * @return string
     *
     * @example
     * Str::upper('fOo Bar bAz');
     * // => FOO BAR BAZ
     */
    public static function upper($string)
    {
        return mb_strtoupper($string, static::$encoding);
    }

    /**
     * Converts the first character of string to upper case.
     *
     * @param string $string
     *
     * @return string
     *
     * @example
     * Str::upperFirst('foo bar baz');
     * // => Foo bar baz
     */
    public static function upperFirst($string)
    {
        return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Converts string to title case.
     *
     * @param string|string[] $string
     *
     * @return string
     *
     * @example
     * Str::titleCase('jefferson costella');
     * // => Jefferson Costella
     */
    public static function titleCase($string)
    {
        return mb_convert_case(join(' ', (array) $string), MB_CASE_TITLE, static::$encoding);
    }

    /**
     * Converts string to camel case (https://en.wikipedia.org/wiki/Camel_case).
     *
     * @param string|string[] $string
     * @param bool            $upper
     *
     * @return string
     *
     * @example
     * Str::camelCase('Yootheme Framework');
     * // => yoothemeFramework
     */
    public static function camelCase($string, $upper = false)
    {
        $string = join(' ', (array) $string);
        $string = str_replace(['-', '_'], ' ', $string);
        $string = str_replace(' ', '', ucwords($string));

        return $upper ? $string : lcfirst($string);
    }

    /**
     * Converts string to snake case (https://en.wikipedia.org/wiki/Snake_case).
     *
     * @param string|string[] $string
     * @param string          $delimiter
     *
     * @return string
     *
     * @example
     * Str::snakeCase('Yootheme Framework');
     * // => yootheme_framework
     */
    public static function snakeCase($string, $delimiter = '_')
    {
        $string = join(' ', (array) $string);
        $string = preg_replace('/[^a-zA-Z0-9]/u', ' ', $string);
        $string = preg_replace('/\s+/u', $delimiter, trim($string));
        $string = preg_replace('/([^_])(?=[A-Z])/u', "$1{$delimiter}", $string);

        return strtolower($string);
    }

    /**
     * Returns part of a string.
     *
     * @param string   $string
     * @param int      $start
     * @param int|null $length
     *
     * @return string
     *
     * @example
     * Str::substr('Yootheme Framework', 3, 5);
     * // => theme
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, static::$encoding);
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param string $string
     * @param int    $length
     * @param string $omission
     * @param bool   $exact
     *
     * @return string
     *
     * @example
     * Str::limit('hi-diddly-ho there, neighborino', 24);
     * // => hi-diddly-ho there, n...
     */
    public static function limit($string, $length = 100, $omission = '...', $exact = true)
    {
        $strLength = static::length($string);
        $omitLength = $length - static::length($omission);

        if ($omitLength <= 0) {
            return '';
        }

        if ($strLength <= $length) {
            return $string;
        }

        if (!$exact and $position = mb_strpos($string, ' ', $omitLength, static::$encoding)) {
            $omitLength = $position;
        }

        return static::substr($string, 0, $omitLength) . $omission;
    }

    /**
     * Limit the number of words in a string.
     *
     * @param string $string
     * @param int    $words
     * @param string $omission
     *
     * @return string
     *
     * @example
     * Str::words('Taylor Otwell', 1);
     * // => Taylor...
     */
    public static function words($string, $words = 100, $omission = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $string, $matches);

        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
        }

        return rtrim($matches[0]) . $omission;
    }

    /**
     * Generates a "random" alpha-numeric string.
     *
     * @param int $length
     *
     * @throws \Exception
     *
     * @return string
     *
     * @example
     * Str::random();
     * // => X2wvU09F1j4ZCzKD
     */
    public static function random($length = 16)
    {
        $string = '';

        if (is_callable('random_bytes')) {

            while (($len = strlen($string)) < $length) {
                $bytes = random_bytes($size = $length - $len);
                $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
            }

        } else {
            // @codeCoverageIgnoreStart
            $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $string = substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
            // @codeCoverageIgnoreEnd
        }

        return $string;
    }

    /**
     * Expand a glob braces to array.
     *
     * @param string $pattern
     *
     * @return array
     *
     * @example
     * Str::expandBraces('foo/{2,3}/bar');
     * // => ['foo/2/bar', 'foo/3/bar']
     */
    public static function expandBraces($pattern)
    {
        $braces = [];
        $expanded = [];
        $callback = function ($matches) use (&$braces) {

            $index = '{' . count($braces) . '}';
            $braces[$index] = $matches[0];

            return $index;
        };

        if (preg_match($regex = '/{((?:[^{}]+|(?R))*)}/', $pattern, $matches, PREG_OFFSET_CAPTURE)) {

            list($matches, $replaces) = $matches;

            foreach (explode(',', preg_replace_callback($regex, $callback, $replaces[0])) as $replace) {
                $expand = substr_replace($pattern, strtr($replace, $braces), $matches[1], strlen($matches[0]));
                $expanded = array_merge($expanded, static::expandBraces($expand));
            }
        }

        return $expanded ?: [$pattern];
    }

    /**
     * Converts a glob braces to a regex.
     *
     * @param string $pattern
     *
     * @return string
     *
     * @example
     * Str::convertBraces('foo/{2,3}/bar');
     * // => foo/(2|3)/bar
     */
    public static function convertBraces($pattern)
    {
        if (preg_match_all('/{((?:[^{}]+|(?R))*)}/', $pattern, $matches, PREG_OFFSET_CAPTURE)) {

            list($matches, $replaces) = $matches;

            foreach ($matches as $i => $m) {
                $replace = str_replace(',', '|', static::convertBraces($replaces[$i][0]));
                $pattern = substr_replace($pattern, "({$replace})", $m[1], strlen($m[0]));
            }
        }

        return $pattern;
    }
}
