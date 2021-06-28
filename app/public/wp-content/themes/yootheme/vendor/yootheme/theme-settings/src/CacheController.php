<?php

namespace YOOtheme\Theme;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Path;

class CacheController
{
    public static function index(Request $request, Response $response)
    {
        return $response->withJson(['files' => iterator_count(static::getFiles())]);
    }

    public static function clear(Request $request, Response $response)
    {
        foreach (static::getFiles() as $file) {
            if ($file->isFile()) {
                unlink($file->getRealPath());
            } elseif ($file->isDir()) {
                rmdir($file->getRealPath());
            }
        }

        return $response->withJson(['message' => 'success']);
    }

    protected static function getFiles()
    {
        return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(Path::get('~theme/cache'), \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS), \RecursiveIteratorIterator::CHILD_FIRST);
    }
}
