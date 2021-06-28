<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @var UriInterface
     */
    protected $uri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $requestTarget;

    /**
     * Constructor.
     *
     * @param string|UriInterface $uri
     * @param string              $method
     * @param array               $headers
     * @param StreamInterface     $body
     */
    public function __construct($uri, $method = 'GET', array $headers = [], StreamInterface $body = null)
    {
        if (is_string($uri)) {
            $uri = new Uri($uri);
        } elseif (!$uri instanceof UriInterface) {
            throw new \InvalidArgumentException('URI must be a string or Psr\Http\Message\UriInterface');
        }

        if (!isset($headers['Host'])) {
            $headers['Host'] = $uri->getHost();
        }

        $this->uri = $uri;
        $this->body = $body;
        $this->method = strtoupper($method);
        $this->setHeaders($headers);
    }

    /**
     * {@inheritdoc}
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $clone = clone $this;
        $clone->uri = $uri;

        if (!$preserveHost and $host = $uri->getHost()) {
            return $clone->withHeader('Host', $host);
        }

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function withMethod($method)
    {
        $clone = clone $this;
        $clone->method = strtoupper($method);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget()
    {
        if (isset($this->requestTarget)) {
            return $this->requestTarget;
        }

        $target = $this->uri->getPath() ?: '/';

        if ($query = $this->uri->getQuery()) {
            $target .= '?' . $query;
        }

        return $this->requestTarget = $target;
    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget($requestTarget)
    {
        if (preg_match('#\s#', $requestTarget)) {
            throw new \InvalidArgumentException('Invalid request target provided; must be a string and cannot contain whitespace');
        }

        $clone = clone $this;
        $clone->requestTarget = $requestTarget;

        return $clone;
    }
}
