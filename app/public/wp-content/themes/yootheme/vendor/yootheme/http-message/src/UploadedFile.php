<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $error;

    /**
     * @var bool
     */
    protected $sapi = false;

    /**
     * @var bool
     */
    protected $moved = false;

    /**
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Constructor.
     *
     * @param string $file
     * @param string $name
     * @param string $type
     * @param int    $size
     * @param int    $error
     * @param mixed  $sapi
     */
    public function __construct($file, $name = null, $type = null, $size = null, $error = UPLOAD_ERR_OK, $sapi = false)
    {
        $this->file = $file;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->error = $error;
        $this->sapi = $sapi;
    }

    /**
     * {@inheritdoc}
     */
    public function getStream()
    {
        if ($this->moved) {
            throw new \RuntimeException(sprintf('Uploaded file %1s has already been moved', $this->name));
        }

        if (!$this->stream) {
            $this->stream = new Stream($this->file);
        }

        return $this->stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientFilename()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientMediaType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function moveTo($targetPath)
    {
        if ($this->moved) {
            throw new \RuntimeException('Uploaded file already moved');
        }

        if (!is_writable(dirname($targetPath))) {
            throw new \InvalidArgumentException('Upload target path is not writable');
        }

        $targetIsStream = strpos($targetPath, '://') > 0;

        if ($targetIsStream) {

            if (!copy($this->file, $targetPath)) {
                throw new \RuntimeException(sprintf('Error moving uploaded file %1s to %2s', $this->name, $targetPath));
            }

            if (!unlink($this->file)) {
                throw new \RuntimeException(sprintf('Error removing uploaded file %1s', $this->name));
            }

        } elseif ($this->sapi) {

            if (!is_uploaded_file($this->file)) {
                throw new \RuntimeException(sprintf('%1s is not a valid uploaded file', $this->file));
            }

            if (!move_uploaded_file($this->file, $targetPath)) {
                throw new \RuntimeException(sprintf('Error moving uploaded file %1s to %2s', $this->name, $targetPath));
            }

        } else {

            if (!rename($this->file, $targetPath)) {
                throw new \RuntimeException(sprintf('Error moving uploaded file %1s to %2s', $this->name, $targetPath));
            }

        }

        $this->moved = true;
    }

    /**
     * Normalize uploaded files, i.e. $_FILES.
     *
     * @param array $files
     *
     * @return array
     */
    public static function normalizeFiles(array $files)
    {
        $parsed = [];

        foreach ($files as $field => $file) {

            if (!isset($file['error'])) {

                if (is_array($file)) {
                    $parsed[$field] = static::normalizeFiles($file);
                }

                continue;
            }

            $parsed[$field] = [];

            if (!is_array($file['error'])) {

                $parsed[$field] = new static(
                    $file['tmp_name'],
                    isset($file['name']) ? $file['name'] : null,
                    isset($file['type']) ? $file['type'] : null,
                    isset($file['size']) ? $file['size'] : null,
                    $file['error'], true);

            } else {

                $subArray = [];

                foreach ($file['error'] as $i => $error) {

                    $subArray[$i]['name'] = $file['name'][$i];
                    $subArray[$i]['type'] = $file['type'][$i];
                    $subArray[$i]['tmp_name'] = $file['tmp_name'][$i];
                    $subArray[$i]['error'] = $file['error'][$i];
                    $subArray[$i]['size'] = $file['size'][$i];

                    $parsed[$field] = static::normalizeFiles($subArray);
                }
            }
        }

        return $parsed;
    }
}
