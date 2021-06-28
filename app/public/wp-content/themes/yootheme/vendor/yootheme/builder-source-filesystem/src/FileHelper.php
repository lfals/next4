<?php

namespace YOOtheme\Builder\Source\Filesystem;

use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;

class FileHelper
{
    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * Query files.
     *
     * @param array $args
     *
     * @return array
     */
    public function query(array $args = [])
    {
        $args += ['offset' => 0, 'limit' => 10, 'order' => '', 'order_direction' => 'ASC'];

        if (empty($args['pattern'])) {
            return [];
        }

        $pattern = $args['pattern'];
        $pattern = Str::startsWith($pattern, '~') ? $pattern : Path::join('~', $pattern);

        $files = File::glob($pattern, GLOB_NOSORT);

        // filter out any dir
        $files = array_filter($files, function ($file) {
            return File::isFile($file) && Str::startsWith($file, $this->rootDir);
        });

        // order
        if ($args['order'] === 'rand') {

            shuffle($files);

        } else {

            if ($args['order'] === 'name') {
                natcasesort($files);
            }

            // direction
            if ($args['order_direction'] === 'DESC') {
                $files = array_reverse($files);
            }
        }

        // offset/limit
        if ($args['offset'] || $args['limit']) {
            $files = array_slice($files, (int) $args['offset'], (int) $args['limit'] ?: null);
        }

        return $files;
    }
}
