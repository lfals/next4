<?php

namespace YOOtheme\Image;

class GDResource extends Resource
{
    /**
     * {@inheritdoc}
     */
    public static function create($file, $type)
    {
        $image = false;

        if ($type == 'png') {
            $image = imagecreatefrompng($file);
        }

        if ($type == 'gif') {
            $image = imagecreatefromgif($file);
        }

        if ($type == 'jpeg') {
            $image = imagecreatefromjpeg($file);
        }

        if ($type == 'webp') {
            $image = imagecreatefromwebp($file);
        }

        return $image ? static::normalizeImage($image) : false;
    }

    /**
     * {@inheritdoc}
     */
    public static function save($image, $file, $type, $quality, $info = [])
    {
        if ($type == 'jpeg') {

            if (!imagejpeg($image, $file, round($quality))) {
                return false;
            }

            if (!empty($info['APP13']) and $iptc = iptcparse($info['APP13'])) {
                return $data = static::embedIptc($iptc, $file) and file_put_contents($file, $data) ? $file : false;
            }

            return $file;
        }

        if ($type == 'png') {

            imagealphablending($image, false);
            imagesavealpha($image, true);

            return imagepng($image, $file, 9) ? $file : false;
        }

        if ($type == 'gif') {
            return imagegif($image, $file) ? $file : false;
        }

        if ($type == 'webp') {
            return imagewebp($image, $file, round($quality)) ? $file : false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function doCrop($image, $width, $height, $x, $y)
    {
        $cropped = static::createImage($width, $height);

        imagecopy($cropped, $image, 0, 0, intval($x), intval($y), imagesx($image), imagesy($image));
        imagedestroy($image);

        return $cropped;
    }

    /**
     * {@inheritdoc}
     */
    public static function doCopy($image, $width, $height, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight, $background = 'transparent')
    {
        $resampled = static::createImage($width, $height, $background);

        imagecopyresampled($resampled, $image, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
        imagedestroy($image);

        return $resampled;
    }

    /**
     * {@inheritdoc}
     */
    public static function doResize($image, $width, $height, $dstWidth, $dstHeight, $background = 'transparent')
    {
        return static::doCopy($image, $width, $height, ($width - $dstWidth) / 2, ($height - $dstHeight) / 2, 0, 0, $dstWidth, $dstHeight, imagesx($image), imagesy($image), $background);
    }

    /**
     * {@inheritdoc}
     */
    public static function doRotate($image, $angle, $background = 'transparent')
    {
        $rotated = imagerotate($image, $angle, static::parseColor($background));

        imagedestroy($image);

        return $rotated;
    }

    /**
     * Creates an image resource.
     *
     * @param int   $width
     * @param int   $height
     * @param mixed $color
     *
     * @return resource
     */
    protected static function createImage($width, $height, $color = 'transparent')
    {
        $rgba = static::parseColor($color);
        $image = imagecreatetruecolor($width, $height);

        imagefill($image, 0, 0, $rgba);

        if ($color == 'transparent') {
            imagecolortransparent($image, $rgba);
        }

        return $image;
    }

    /**
     * Normalizes an image to be true color and transparent color.
     *
     * @param resource $image
     *
     * @return resource
     */
    protected static function normalizeImage($image)
    {
        if (imageistruecolor($image) && imagecolortransparent($image) == -1) {
            return $image;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $canvas = static::createImage($width, $height);

        imagecopy($canvas, $image, 0, 0, 0, 0, $width, $height);
        imagedestroy($image);

        return $canvas;
    }

    /**
     * Embeds an image IPTC data.
     *
     * @param array  $iptc
     * @param string $file
     *
     * @return string
     */
    protected static function embedIptc(array $iptc, $file)
    {
        $iptcdata = '';

        foreach ($iptc as $tag => $value) {

            $tag = explode('#', $tag, 2);
            $value = join(' ', (array) $value);
            $length = strlen($value);
            $iptcdata .= chr(0x1C) . chr($tag[0]) . chr($tag[1]);

            if ($length < 0x8000) {
                $iptcdata .= chr($length >> 8) . chr($length & 0xFF);
            } else {
                $iptcdata .= chr(0x80) . chr(0x04) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
            }

            $iptcdata .= $value;
        }

        return iptcembed($iptcdata, $file);
    }
}
