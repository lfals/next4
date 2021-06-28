<?php

namespace YOOtheme\Encryption;

abstract class Library
{
    /**
     * Encrypts data with given parameters.
     *
     * @param string $data
     * @param string $key
     * @param string $iv
     *
     * @return string
     */
    abstract public function encrypt($data, $key, $iv);

    /**
     * Decrypts data with given parameters.
     *
     * @param string $data
     * @param string $key
     * @param string $iv
     *
     * @return string
     */
    abstract public function decrypt($data, $key, $iv);

    /**
     * Generates an initialization vector.
     *
     * @return string
     */
    abstract public function generateIv();
}
