<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * @var array
     */
    protected static $modes = [
        'readable' => ['r', 'r+', 'w+', 'a+', 'x+', 'c+'],
        'writable' => ['r+', 'w', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'],
    ];

    /**
     * Constructor.
     *
     * @param string|resource $resource
     * @param string          $mode
     */
    public function __construct($resource = null, $mode = 'r')
    {
        $resource = $resource ?: fopen('php://temp', 'r+');

        if (is_string($resource)) {
            $resource = fopen($resource, $mode);
        }

        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Invalid resource');
        }

        $this->resource = $resource;
        $this->metadata = stream_get_meta_data($resource);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        try {
            $this->rewind();
            return $this->getContents();
        } catch (\RuntimeException $e) {
            return '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if (isset($this->resource)) {
            if (is_resource($this->resource)) {
                fclose($this->resource);
            }

            $this->detach();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        if (!isset($this->resource)) {
            return;
        }

        $result = $this->resource;
        unset($this->resource);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        if (!isset($this->resource)) {
            return;
        }

        if ($this->getMetadata('uri')) {
            clearstatcache(true, $this->getMetadata('uri'));
        }

        $stats = fstat($this->resource);

        return isset($stats['size']) ? $stats['size'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        $result = ftell($this->resource);

        if ($result === false) {
            throw new \RuntimeException('Could not get the position of the pointer in stream');
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        return isset($this->resource) && feof($this->resource);
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        return isset($this->resource) && $this->getMetadata('seekable');
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->isSeekable() || fseek($this->resource, $offset, $whence) === -1) {
            throw new \RuntimeException('Could not seek in stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if (!$this->isSeekable() || rewind($this->resource) === false) {
            throw new \RuntimeException('Could not rewind stream');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return isset($this->resource) && in_array(rtrim($this->getMetadata('mode'), 'bt'), static::$modes['writable']);
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
        if (!$this->isWritable() || ($result = fwrite($this->resource, $string)) === false) {
            throw new \RuntimeException('Could not write to stream');
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        return isset($this->resource) && in_array(rtrim($this->getMetadata('mode'), 'bt'), static::$modes['readable']);
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        if (!$this->isReadable() || ($result = fread($this->resource, $length)) === false) {
            throw new \RuntimeException('Could not read from stream');
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        if (!$this->isReadable() || ($contents = stream_get_contents($this->resource)) === false) {
            throw new \RuntimeException('Could not get contents of stream');
        }

        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
        if ($key === null) {
            return $this->metadata;
        }

        return isset($this->metadata[$key]) ? $this->metadata[$key] : null;
    }
}
