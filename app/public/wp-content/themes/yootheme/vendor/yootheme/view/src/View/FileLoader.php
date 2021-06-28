<?php

namespace YOOtheme\View;

use YOOtheme\File;
use YOOtheme\Str;

class FileLoader
{
    public function __invoke($name, $parameters, $next)
    {
        if (!Str::endsWith($name, '.php')) {
            $name .= '.php';
        }

        return $next(File::find($name) ?: $name, $parameters);
    }
}
