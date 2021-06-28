<?php

namespace YOOtheme;

abstract class Memory
{
    /**
     * Try to raise memory_limit.
     *
     * @param string $memory
     *
     * @return bool|string
     */
    public static function raise($memory = '512M')
    {
        $limit = static::toBytes(@ini_get('memory_limit'));

        if ($limit !== -1 && $limit < static::toBytes($memory)) {
            return @ini_set('memory_limit', $memory);
        }

        return $limit;
    }

    /**
     * Converts a shorthand byte value to an integer byte value.
     *
     * @param string|int $value
     *
     * @return int
     */
    public static function toBytes($value)
    {
        $bytes = (int) $value;
        $value = substr(strtolower(trim($value)), -1);

        switch ($value) {
            case 'g':
                $bytes *= 1024;
            case 'm':
                $bytes *= 1024;
            case 'k':
                $bytes *= 1024;
        }

        return min($bytes, PHP_INT_MAX);
    }
}
