<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class Message implements MessageInterface
{
    /**
     * @var StreamInterface
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var array
     */
    protected $headerNames = [];

    /**
     * @var string
     */
    protected $version = '1.1';

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        if (!preg_match('/^[1-9]\d*(?:\.\d)?$/', $version)) {
            throw new \InvalidArgumentException(sprintf('Invalid HTTP version. (%s)', $version));
        }

        $clone = clone $this;
        $clone->version = $version;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headerNames[strtolower($name)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return $this->hasHeader($name) ? $this->headers[$this->headerNames[strtolower($name)]] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        return implode(',', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        $clone = clone $this;

        if ($clone->hasHeader($name)) {
            unset($clone->headers[$clone->headerNames[strtolower($name)]]);
        }

        $clone->headers[$name] = (array) $value;
        $clone->headerNames[strtolower($name)] = $name;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        if (!$this->hasHeader($name)) {
            return $this->withHeader($name, $value);
        }

        $clone = clone $this;
        $clone->headers[$this->headerNames[strtolower($name)]][] = $value;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return $this;
        }

        $clone = clone $this;
        unset($clone->headers[$this->headerNames[strtolower($name)]], $clone->headerNames[strtolower($name)]);

        return $clone;
    }

    /**
     * Sets an array of headers on the instance.
     *
     * @param array $headers
     */
    protected function setHeaders(array $headers)
    {
        $this->headers = [];
        $this->headerNames = [];

        foreach ($headers as $name => $value) {
            $this->headers[$name] = (array) $value;
            $this->headerNames[strtolower($name)] = $name;
        }
    }
}
