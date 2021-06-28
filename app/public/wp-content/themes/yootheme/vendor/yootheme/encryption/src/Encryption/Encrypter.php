<?php

namespace YOOtheme\Encryption;

use YOOtheme\Encrypter as EncrypterInterface;

class Encrypter implements EncrypterInterface
{
    /**
     * @var Library
     */
    protected $library;

    /**
     * @var string
     */
    protected $cipherKey;

    /**
     * @var string
     */
    protected $hashKey;

    /**
     * @var string
     */
    protected $hashAlgo = 'sha256';

    /**
     * Constructor.
     *
     * @param string $password
     * @param string $salt
     *
     * @throws \RuntimeException
     */
    public function __construct($password, $salt = '')
    {
        if (is_callable('openssl_encrypt')) {
            $this->library = new OpenSSLLibrary();
        } elseif (is_callable('mcrypt_encrypt')) {
            $this->library = new McryptLibrary();
        } else {
            throw new \RuntimeException('Encryption not supported. Install OpenSSL or Mcrypt.');
        }

        list($this->cipherKey, $this->hashKey) = static::generateKeys($this->hashAlgo, $password, $salt);
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($data, $serialize = true)
    {
        $iv = $this->library->generateIv();
        $data = $this->library->encrypt($serialize ? serialize($data) : $data, $this->cipherKey, $iv);
        $hash = hash_hmac($this->hashAlgo, $iv . $data, $this->hashKey);
        $encoded = array_map('base64_encode', [$iv, $data, $hash]);

        return implode('.', $encoded);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($data, $serialize = true)
    {
        $encoded = explode('.', $data);

        if (count($encoded) !== 3) {
            return false;
        }

        list($iv, $data, $hash) = array_map('base64_decode', $encoded);

        if (hash_hmac($this->hashAlgo, $iv . $data, $this->hashKey) !== $hash) {
            return false;
        }

        $data = $this->library->decrypt($data, $this->cipherKey, $iv);

        return $serialize ? unserialize($data) : $data;
    }

    /**
     * Generates a PBKDF2 key derivation of a supplied password.
     *
     * @param string $algorithm
     * @param string $password
     * @param string $salt
     * @param int    $iterations
     * @param int    $length
     * @param bool   $raw_output
     *
     * @return bool|string
     */
    public static function pbkdf2($algorithm, $password, $salt, $iterations, $length = 0, $raw_output = false)
    {
        if (is_callable('hash_pbkdf2')) {

            if (!$raw_output) {
                $length = $length * 2;
            }

            return hash_pbkdf2($algorithm, $password, $salt, $iterations, $length, $raw_output);
        }

        $output = '';
        $blocks = ceil($length / strlen(hash($algorithm, '', true)));

        for ($i = 1; $i <= $blocks; $i++) {

            $last = $salt . pack('N', $i);
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);

            for ($j = 1; $j < $iterations; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }

            $output .= $xorsum;
        }

        return $raw_output ? substr($output, 0, $length) : bin2hex(substr($output, 0, $length));
    }

    /**
     * Generates a cipher and a hash key using PBKDF2.
     *
     * @param string $algorithm
     * @param string $password
     * @param string $salt
     *
     * @return array
     */
    protected static function generateKeys($algorithm, $password, $salt)
    {
        $key = static::pbkdf2($algorithm, $password, $salt, strlen($password) >= 32 ? 1 : 1000, 32, true);

        return [substr($key, 0, 16), substr($key, 16)];
    }
}
