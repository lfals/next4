<?php

namespace YOOtheme\Builder\Source\Filesystem\Type;

use function YOOtheme\app;
use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\Url;
use YOOtheme\View;

class FileType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'name' => [
                    'type' => 'String',
                    'args' => [
                        'title_case' => [
                            'type' => 'Boolean',
                        ],
                    ],
                    'metadata' => [
                        'label' => 'Name',
                        'arguments' => [
                            'title_case' => [
                                'label' => 'Convert',
                                'type' => 'checkbox',
                                'text' => 'Convert to title-case',
                            ],
                        ],
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::name',
                    ],
                ],

                'basename' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Basename',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::basename',
                    ],
                ],

                'dirname' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Dirname',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::dirname',
                    ],
                ],

                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Url',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::url',
                    ],
                ],

                'path' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Path',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::path',
                    ],
                ],

                'content' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Content',
                        'filters' => ['limit'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::content',
                    ],
                ],

                'size' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Size',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::size',
                    ],
                ],

                'extension' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Extension',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::extension',
                    ],
                ],

                'mimetype' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Mimetype',
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::mimetype',
                    ],
                ],

                'accessed' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Accessed',
                        'filters' => ['date'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::accessed',
                    ],
                ],

                'changed' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Changed',
                        'filters' => ['date'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::changed',
                    ],
                ],

                'modified' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Modified',
                        'filters' => ['date'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::modified',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'File',
            ],

        ];
    }

    public static function name($file, $args)
    {
        $name = basename($file, '.' . File::getExtension($file));

        if (!empty($args['title_case'])) {
            $name = Str::titleCase($name);
        }

        return $name;
    }

    public static function content($file)
    {
        return File::getContents($file);
    }

    public static function size($file)
    {
        return app(View::class)->formatBytes(File::getSize($file) ?: 0);
    }

    public static function accessed($file)
    {
        return File::getATime($file);
    }

    public static function changed($file)
    {
        return File::getCTime($file);
    }

    public static function modified($file)
    {
        return File::getMTime($file);
    }

    public static function mimetype($file)
    {
        return File::getMimetype($file);
    }

    public static function extension($file)
    {
        return File::getExtension($file);
    }

    public static function basename($file)
    {
        return basename($file);
    }

    public static function dirname($file)
    {
        return dirname(self::path($file));
    }

    public static function path($file)
    {
        return Path::relative('~', $file);
    }

    public static function url($file)
    {
        $url = URL::to($file);

        if (Str::startsWith($url, URL::base())) {
            $url = ltrim(substr($url, strlen(URL::base())), '/');
        }

        return $url;
    }
}
