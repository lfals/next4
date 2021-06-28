<?php

namespace YOOtheme\Http\Message;

class InputStream extends Stream
{
    /**
     * @var bool
     */
    protected $eof = false;

    /**
     * @var string
     */
    protected $cache = '';

    /**
     * Constructor.
     *
     * @param string|resource $resource
     */
    public function __construct($resource = 'php://input')
    {
        parent::__construct($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if ($this->eof) {
            return $this->cache;
        }

        return $this->getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        $content = parent::read($length);

        if ($content && !$this->eof) {
            $this->cache .= $content;
        }

        if ($this->eof()) {
            $this->eof = true;
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        if ($this->eof) {
            return $this->cache;
        }

        $this->eof = true;

        return $this->cache = parent::getContents();
    }
}
