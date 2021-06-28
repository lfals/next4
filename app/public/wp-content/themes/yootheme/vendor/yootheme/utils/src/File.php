<?php

namespace YOOtheme;

/**
 * A static class which provides utilities for working with the file system.
 */
abstract class File
{
    /**
     * Gets a existing file or directory.
     *
     * @param string $path
     *
     * @return string|null
     *
     * @example
     * File::get('/path/file.php');
     * // => '/path/file.php'
     */
    public static function get($path)
    {
        $path = Path::resolveAlias($path);

        return file_exists($path) ? $path : null;
    }

    /**
     * Checks whether file or directory exists.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::exists('/path/resource');
     * // => true
     *
     * File::exists('/path/with/no/resource');
     * // => false
     */
    public static function exists($path)
    {
        return !is_null(static::get($path));
    }

    /**
     * Find file with glob pattern.
     *
     * @param string $path
     *
     * @return string|null
     *
     * @example
     * File::find('/path/*.php');
     * // => '/path/file.php'
     */
    public static function find($path)
    {
        return ($files = static::glob($path)) ? $files[0] : null;
    }

    /**
     * Glob files with braces support.
     *
     * @param string $pattern
     * @param int    $flags
     *
     * @return array
     *
     * @example
     * File::glob('/path/{*.ext,*.php');
     * // => ['/path/file.ext', '/path/file.php']
     */
    public static function glob($pattern, $flags = 0)
    {
        $pattern = Path::resolveAlias($pattern);

        if (defined('GLOB_BRACE') && !Str::startsWith($pattern, '{')) {
            return glob($pattern, $flags | GLOB_BRACE | GLOB_NOSORT);
        }

        return static::_glob($pattern, $flags);
    }

    /**
     * Copies file.
     *
     * @param string $from
     * @param string $to
     *
     * @return bool
     *
     * @example
     * File::copy('/path/file.ext', '/path/dest/file.ext');
     * // => true
     */
    public static function copy($from, $to)
    {
        $from = Path::resolveAlias($from);
        $to = Path::resolve(dirname($from), $to);

        return copy($from, $to);
    }

    /**
     * Renames a file or directory.
     *
     * @param string $from
     * @param string $to
     *
     * @return bool
     *
     * @example
     * File::rename('/path/resource', '/path/renamed');
     * // => true
     */
    public static function rename($from, $to)
    {
        $from = Path::resolveAlias($from);
        $to = Path::resolve(dirname($from), $to);

        return rename($from, $to);
    }

    /**
     * Deletes a file.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::delete('/path/file.ext');
     * // => true
     */
    public static function delete($path)
    {
        $path = Path::resolveAlias($path);

        return unlink($path);
    }

    /**
     * List files and directories inside the specified path.
     *
     * @param string      $path
     * @param bool|string $prefix
     *
     * @return string[]|false
     *
     * @example
     * File::listDir('/path/dir');
     * // => ['Dir1', 'Dir2', 'File.txt']
     *
     * File::listDir('/path/dir', true);
     * // => ['/path/dir/Dir1', '/path/dir/Dir2', '/path/dir/File.txt']
     */
    public static function listDir($path, $prefix = false)
    {
        $path = Path::resolveAlias($path);

        if (!static::exists($path)) {
            return false;
        }

        if ($prefix === true) {
            $prefix = $path;
        }

        if ($files = scandir($path)) {
            $files = array_values(array_diff($files, ['.', '..']));
        }

        if ($files && $prefix) {
            foreach ($files as &$file) {
                $file = Path::join($prefix, $file);
            }
        }

        return $files;
    }

    /**
     * Makes directory.
     *
     * @param string $path
     * @param int    $mode
     * @param bool   $recursive
     *
     * @return bool
     *
     * @example
     * File::makeDir('/path/dir/to/make');
     * // => true
     */
    public static function makeDir($path, $mode = 0777, $recursive = false)
    {
        $path = Path::resolveAlias($path);

        return is_dir($path) ?: mkdir($path, $mode, $recursive);
    }

    /**
     * Removes directory recursively.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::deleteDir('/path/dir/to/delete');
     * // => true
     */
    public static function deleteDir($path)
    {
        $path = Path::resolveAlias($path);
        $files = static::listDir($path, true);

        if (is_bool($files)) {
            return $files;
        }

        foreach ($files as $file) {

            // delete directory recursively
            if (is_dir($file) && !static::deleteDir($file)) {
                return false;
            }

            // delete file
            if (is_file($file) && !unlink($file)) {
                return false;
            }
        }

        return rmdir($path);
    }

    /**
     * Gets the last access time of file.
     *
     * @param string $path
     *
     * @return int|null
     *
     * @example
     * File::getATime('/path/file.ext');
     * // => 1551693515
     */
    public static function getATime($path)
    {
        $path = Path::resolveAlias($path);
        $time = fileatime($path);

        return is_int($time) ? $time : null;
    }

    /**
     * Gets the inode change time of file.
     *
     * @param string $path
     *
     * @return int|null
     *
     * @example
     * File::getCTime('/path/file.ext');
     * // => 1551693515
     */
    public static function getCTime($path)
    {
        $path = Path::resolveAlias($path);
        $time = filectime($path);

        return is_int($time) ? $time : null;
    }

    /**
     * Gets the last modified time of file.
     *
     * @param string $path
     *
     * @return int|null
     *
     * @example
     * File::getMTime('/path/file.ext');
     * // => 1551693515
     */
    public static function getMTime($path)
    {
        $path = Path::resolveAlias($path);
        $time = filemtime($path);

        return is_int($time) ? $time : null;
    }

    /**
     * Gets the file size.
     *
     * @param string $path
     *
     * @return int|false
     *
     * @example
     * File::getSize('/path/file.ext');
     * // => 4
     */
    public static function getSize($path)
    {
        $path = Path::resolveAlias($path);
        $size = filesize($path);

        return is_int($size) ? $size : null;
    }

    /**
     * Gets the file mime content type.
     *
     * @param string $path
     *
     * @return string|void
     *
     * @example
     * File::getMimetype('/path/file.ext');
     * // => text/plain
     */
    public static function getMimetype($path)
    {
        $path = Path::resolveAlias($path);

        if (is_callable('finfo_file')) {
            return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
        }

        if (is_callable('mime_content_type')) {
            return mime_content_type($path);
        }
    }

    /**
     * Gets the file extension.
     *
     * @param string $path
     *
     * @return string
     *
     * @example
     * File::getExtension('/path/file.ext');
     * // => ext
     */
    public static function getExtension($path)
    {
        $path = Path::resolveAlias($path);

        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Gets the contents form file.
     *
     * @param string $path
     *
     * @return string|null
     *
     * @example
     * File::getContents('/path/file.ext');
     * // => filecontent
     */
    public static function getContents($path)
    {
        $path = Path::resolveAlias($path);
        $data = file_get_contents($path);

        return is_string($data) ? $data : null;
    }

    /**
     * Writes the contents to file.
     *
     * @param string $path
     * @param mixed  $data
     * @param int    $flags
     *
     * @return int|null
     *
     * @example
     * File::putContents('/path/file.ext', 'content');
     * // => true
     */
    public static function putContents($path, $data, $flags = 0)
    {
        $path = Path::resolveAlias($path);
        $bytes = file_put_contents($path, $data, $flags);

        return is_int($bytes) ? $bytes : null;
    }

    /**
     * Checks if is a directory.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::isDir('/path/dir');
     * // => true
     */
    public static function isDir($path)
    {
        $path = Path::resolveAlias($path);

        return is_dir($path);
    }

    /**
     * Checks if is a file.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::isFile('/path/file.ext');
     * // => true
     */
    public static function isFile($path)
    {
        $path = Path::resolveAlias($path);

        return is_file($path);
    }

    /**
     * Checks if is a link.
     *
     * @param string $path
     *
     * @return bool
     *
     * @example
     * File::isLink('/path/link');
     * // => true
     */
    public static function isLink($path)
    {
        $path = Path::resolveAlias($path);

        return is_link($path);
    }

    /**
     * Glob files with braces support (Polyfill).
     *
     * @param string $pattern
     * @param int    $flags
     *
     * @return array
     */
    protected static function _glob($pattern, $flags = 0)
    {
        $files = [];

        foreach (Str::expandBraces($pattern) as $file) {
            $files = array_merge($files, glob($file, $flags | GLOB_NOSORT) ?: []);
        }

        return $files;
    }
}
