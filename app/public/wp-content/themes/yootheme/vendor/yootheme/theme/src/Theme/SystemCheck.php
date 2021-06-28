<?php

namespace YOOtheme\Theme;

use YOOtheme\Path;

class SystemCheck
{
    /**
     * Gets the requirements.
     *
     * @return array
     */
    public function getRequirements()
    {
        $res = [];

        if (!extension_loaded('JSON')) {
            $res[] = 'common_json';
        }

        if (!extension_loaded('GD') || !is_callable('imagegif') || !is_callable('imagejpeg') || !is_callable('imagepng')) {
            $res[] = 'common_gd';
        }

        if (!extension_loaded('mbstring')) {
           $res[] = 'common_mbstring';
        }

        return $res;
    }

    /**
     * Gets the recommendations.
     *
     * @return array
     */
    public function getRecommendations()
    {
        $res = [];

        $current = phpversion();
        $required = '7.1.0';
        if (version_compare($required, $current, '>')) {
           $res[] = ['key' => 'common_php_ver', 'version' => $current];
        }

        if (extension_loaded('GD') && !is_callable('imagewebp')) {
            $res[] = 'common_webp';
        }

        if (!is_writable(Path::get('~theme/cache'))) {
            $res[] = 'common_cachedir';
        }

        $post_max_size = $this->parseSize(ini_get('post_max_size'));
        if ($post_max_size < $this->parseSize('8M')) {
            $res[] = 'common_post_max_size';
        }

        $upload_max_filesize = $this->parseSize(ini_get('upload_max_filesize'));
        if ($upload_max_filesize < $this->parseSize('8M')) {
            $res[] = 'common_upload_max_filesize';
        }

        $memory_limit = $this->parseSize(ini_get('memory_limit'));
        if ($memory_limit > 0 && $memory_limit < $this->parseSize('128M')) {
            $res[] = 'common_memory_limit';
        }

        $max_execution_time = $this->parseSize(ini_get('max_execution_time'));
        if (($max_execution_time > 0 && $max_execution_time < 60)) {
            $res[] = 'common_max_execution_time';
        }

        return $res;
    }

    protected function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9.\-]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }
}
