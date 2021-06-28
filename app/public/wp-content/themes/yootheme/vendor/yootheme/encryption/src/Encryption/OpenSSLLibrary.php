<?php

namespace YOOtheme\Encryption;

class OpenSSLLibrary extends Library
{
    const CIPHER = 'AES-128-CBC';

    /**
     * {@inheritdoc}
     */
    public function encrypt($data, $key, $iv)
    {
        return openssl_encrypt($data, static::CIPHER, $key, 0, $iv);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($data, $key, $iv)
    {
        return openssl_decrypt($data, static::CIPHER, $key, 0, $iv);
    }

    /**
     * {@inheritdoc}
     */
    public function generateIv()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length(static::CIPHER));
    }
}
