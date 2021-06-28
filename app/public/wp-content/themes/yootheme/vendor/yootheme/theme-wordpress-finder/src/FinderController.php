<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\File;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\Url;

class FinderController
{
    public static function index(Request $request, Response $response, Config $config)
    {
        $root = $config('app.uploadDir');
        $path = Path::join($root, $request->getParam('folder'));

        if (!Str::startsWith($path, $root)) {
            $path = $root;
        }

        $files = [];

        foreach (File::listDir($path, true) ?: [] as $file) {

            $filename = basename($file);

            // ignore hidden files
            if (Str::startsWith($filename, '.')) {
                continue;
            }

            $url = URL::to($file);

            if (Str::startsWith($url, URL::base())) {
                $url = ltrim(substr($url, strlen(URL::base())), '/');
            }

            $files[] = [
                'name' => $filename,
                'path' => Path::relative($root, $file),
                'url' => $url,
                'type' => File::isDir($file) ? 'folder' : 'file',
                'size' => \size_format(File::getSize($file)),
            ];
        }

        return $response->withJson($files);
    }
}
