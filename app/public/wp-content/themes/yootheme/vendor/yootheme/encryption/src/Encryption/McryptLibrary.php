<?php

namespace YOOtheme\Encryption;

class McryptLibrary extends Library
{
    const MODE = MCRYPT_MODE_CBC;

    const CIPHER = MCRYPT_RIJNDAEL_128;

    /**
     * {@inheritdoc}
     */
    public function encrypt($data, $key, $iv)
    {
        return mcrypt_encrypt(static::CIPHER, $key, $data, static::MODE, $iv);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($data, $key, $iv)
    {
        return mcrypt_decrypt(static::CIPHER, $key, $data, static::MODE, $iv);
    }

    /**
     * {@inheritdoc}
     */
    public function generateIv()
    {
        return mcrypt_create_iv(mcrypt_get_iv_size(static::CIPHER, static::MODE), MCRYPT_DEV_URANDOM);
    }
}
