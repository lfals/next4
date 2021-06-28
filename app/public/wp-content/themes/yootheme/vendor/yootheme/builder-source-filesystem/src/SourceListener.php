<?php

namespace YOOtheme\Builder\Source\Filesystem;

use YOOtheme\Config;
use YOOtheme\Path;

class SourceListener
{
    public static function initSource(Config $config, $source)
    {
        $rootDir = Path::relative($config('app.rootDir'), $config('app.uploadDir'));

        $source->queryType(Type\FileQueryType::config($rootDir));
        $source->queryType(Type\FilesQueryType::config($rootDir));
        $source->objectType('File', Type\FileType::config());
    }
}
