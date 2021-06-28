<?php

namespace YOOtheme;

interface Encrypter
{
    /**
     * Encrypts data with given parameters.
     *
     * @param mixed $data
     * @param bool  $serialize
     *
     * @return string
     */
    public function encrypt($data, $serialize = true);

    /**
     * Decrypts data with given parameters.
     *
     * @param string $data
     * @param bool   $serialize
     *
     * @return bool|mixed
     */
    public function decrypt($data, $serialize = true);
}
