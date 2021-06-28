<?php

namespace YOOtheme\Image;

class Resource
{
    /**
     * @var array
     */
    public static $colors = [
        'aqua' => 0x00ffff,
        'black' => 0x000000,
        'blue' => 0x0000ff,
        'fuchsia' => 0xff00ff,
        'gray' => 0x808080,
        'green' => 0x008000,
        'lime' => 0x00ff00,
        'maroon' => 0x800000,
        'navy' => 0x000080,
        'olive' => 0x808000,
        'orange' => 0xffA500,
        'purple' => 0x800080,
        'red' => 0xff0000,
        'silver' => 0xc0c0c0,
        'teal' => 0x008080,
        'white' => 0xffffff,
        'yellow' => 0xffff00,
        'transparent' => 0x7fffffff,
    ];

    /**
     * Creates an image.
     *
     * @param string $file
     * @param string $type
     *
     * @return mixed
     */
    public static function create($file, $type)
    {
        return;
    }

    /**
     * Save image to file.
     *
     * @param mixed  $image
     * @param string $file
     * @param string $type
     * @param int    $quality
     * @param array  $info
     *
     * @return string|false
     */
    public static function save($image, $file, $type, $quality, $info = [])
    {
        return false;
    }

    /**
     * Do the image crop.
     *
     * @param mixed $image
     * @param int   $width
     * @param int   $height
     * @param int   $x
     * @param int   $y
     *
     * @return mixed
     */
    public static function doCrop($image, $width, $height, $x, $y)
    {
        return $image;
    }

    /**
     * Do the image copy.
     *
     * @param mixed  $image
     * @param int    $width
     * @param int    $height
     * @param int    $dstX
     * @param int    $dstY
     * @param int    $srcX
     * @param int    $srcY
     * @param int    $dstWidth
     * @param int    $dstHeight
     * @param int    $srcWidth
     * @param int    $srcHeight
     * @param string $background
     *
     * @return mixed
     */
    public static function doCopy($image, $width, $height, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight, $background = 'transparent')
    {
        return $image;
    }

    /**
     * Do the image resize.
     *
     * @param mixed  $image
     * @param int    $width
     * @param int    $height
     * @param int    $dstWidth
     * @param int    $dstHeight
     * @param string $background
     *
     * @return mixed
     */
    public static function doResize($image, $width, $height, $dstWidth, $dstHeight, $background = 'transparent')
    {
        return $image;
    }

    /**
     * Do the image rotate.
     *
     * @param mixed  $image
     * @param int    $angle
     * @param string $background
     *
     * @return mixed
     */
    public static function doRotate($image, $angle, $background = 'transparent')
    {
        return $image;
    }

    /**
     * Parses a color to decimal value.
     *
     * @param mixed $color
     *
     * @return int
     */
    public static function parseColor($color)
    {
        if (!is_string($color) && is_numeric($color)) {
            return $color;
        }

        $color = strtolower(trim($color));

        if (isset(static::$colors[$color])) {
            return static::$colors[$color];
        }

        if (is_string($color) && preg_match('/^(#|0x|)([0-9a-f]{3,6})/i', $color, $matches)) {

            $col = $matches[2];

            if (strlen($col) == 6) {
                return hexdec($col);
            }

            if (strlen($col) == 3) {

                $r = '';

                for ($i = 0; $i < 3; ++$i) {
                    $r .= $col[$i] . $col[$i];
                }

                return hexdec($r);
            }
        }

        if (is_string($color) && preg_match('/^rgb\(([0-9]+),([0-9]+),([0-9]+)\)/i', $color, $matches)) {

            list(, $r, $g, $b) = $matches;

            if ($r >= 0 && $r <= 0xff && $g >= 0 && $g <= 0xff && $b >= 0 && $b <= 0xff) {
                return ($r << 16) | ($g << 8) | ($b);
            }
        }

        throw new \InvalidArgumentException("Invalid color: {$color}");
    }

    /**
     * Parses a color to rgba string.
     *
     * @param mixed $color
     *
     * @return string
     */
    public static function parseColorRgba($color)
    {
        $value = static::parseColor($color);

        $a = ($value >> 24) & 0xFF;
        $r = ($value >> 16) & 0xFF;
        $g = ($value >> 8) & 0xFF;
        $b = $value & 0xFF;
        $a = (float) round((127 - $a) / 127, 2);

        return sprintf('rgba(%d, %d, %d, %.2F)', $r, $g, $b, $a);
    }
}
