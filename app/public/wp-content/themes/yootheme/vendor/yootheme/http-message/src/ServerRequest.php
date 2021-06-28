<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $serverParams = [];

    /**
     * @var array
     */
    protected $cookieParams = [];

    /**
     * @var array
     */
    protected $queryParams = [];

    /**
     * @var array
     */
    protected $uploadedFiles = [];

    /**
     * @var null|array|object
     */
    protected $parsedBody;

    /**
     * Creates an instance from server globals.
     *
     * @param string|UriInterface $uri
     *
     * @return static
     */
    public static function fromGlobals($uri)
    {
        $input = new InputStream();
        $files = isset($_FILES) ? UploadedFile::normalizeFiles($_FILES) : [];
        $headers = static::parseHeaders($_SERVER);
        $method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
        $version = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $_SERVER['SERVER_PROTOCOL']) : '1.1';
        $request = new static($uri, $method, $headers, $input);

        if ($method == 'POST' && preg_match('/^(application\/x-www-form-urlencoded|multipart\/form-data)/i', $request->getHeaderLine('Content-Type'))) {
            $request = $request->withParsedBody($_POST);
        }

        if ($override = $request->getHeaderLine('X-Http-Method-Override')) {
            $request = $request->withMethod($override);
        }

        return $request
            ->withServerParams($_SERVER)
            ->withCookieParams($_COOKIE)
            ->withQueryParams($_GET)
            ->withUploadedFiles($files)
            ->withProtocolVersion($version);
    }

    /**
     * {@inheritdoc}
     */
    public function getServerParams()
    {
        return $this->serverParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withServerParams(array $server)
    {
        $clone = clone $this;
        $clone->serverParams = $server;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getCookieParams()
    {
        return $this->cookieParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withCookieParams(array $cookies)
    {
        $clone = clone $this;
        $clone->cookieParams = $cookies;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * {@inheritdoc}
     */
    public function withQueryParams(array $query)
    {
        $clone = clone $this;
        $clone->queryParams = $query;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $clone = clone $this;
        $clone->uploadedFiles = $uploadedFiles;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getParsedBody()
    {
        if (isset($this->parsedBody)) {
            return $this->parsedBody;
        }

        if (stripos($this->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $this->parsedBody = json_decode((string) $this->getBody(), true);
        }

        return $this->parsedBody;
    }

    /**
     * {@inheritdoc}
     */
    public function withParsedBody($data)
    {
        $clone = clone $this;
        $clone->parsedBody = $data;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function withAttribute($name, $value)
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutAttribute($name)
    {
        $clone = clone $this;
        unset($clone->attributes[$name]);

        return $clone;
    }

    /**
     * Parse all headers.
     *
     * @param array $server
     *
     * @return array
     */
    protected static function parseHeaders(array $server)
    {
        $headers = [];

        foreach ($server as $name => $value) {

            $name = strtr(strtolower($name), '_', ' ');
            $name = strtr(ucwords($name), ' ', '-');

            if (strpos($name, 'Http-') === 0) {
                $headers[substr($name, 5)] = $value;
            } elseif (strpos($name, 'Content-') === 0) {
                $headers[$name] = $value;
            }
        }

        return $headers;
    }
}
