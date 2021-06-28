<?php

namespace YOOtheme\Http\Message;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    const PATH = '/(?:[^a-zA-Z0-9_\-\.~:@&=\+\$,\/;%]+|%(?![A-Fa-f0-9]{2}))/';

    const QUERY = '/(?:[^a-zA-Z0-9_\-\.~!\$&\'\(\)\*\+,;=%:@\/\?]+|%(?![A-Fa-f0-9]{2}))/';

    /**
     * @var string
     */
    protected $scheme = '';

    /**
     * @var string
     */
    protected $userInfo = '';

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var null|int
     */
    protected $port;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var string
     */
    protected $fragment = '';

    /**
     * @var array
     */
    protected static $schemes = [
        'http' => 80,
        'https' => 443,
    ];

    /**
     * Constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        extract(parse_url($url));

        $this->scheme = isset($scheme) ? static::filterScheme($scheme) : '';
        $this->host = isset($host) ? $host : '';
        $this->port = isset($port) ? static::filterPort($port) : null;
        $this->path = empty($path) ? '/' : static::filterPath($path);
        $this->query = isset($query) ? static::filterQuery($query) : '';
        $this->fragment = isset($fragment) ? static::filterQuery($fragment) : '';
        $this->userInfo = isset($user) ? $user : '';

        if (isset($pass)) {
            $this->userInfo .= ":$pass";
        }
    }

    /**
     * Creates an instance from server globals.
     *
     * @param array $server
     *
     * @return static
     */
    public static function fromGlobals(array $server = [])
    {
        if (!$server) {
            $server = $_SERVER;
        }

        $http = isset($server['HTTPS']) ? 'https://' : 'http://';
        $host = isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : '';
        $path = isset($server['REQUEST_URI']) ? $server['REQUEST_URI'] : '';

        return new static($http . $host . $path);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthority()
    {
        $port = $this->getPort();
        $user = $this->getUserInfo();

        return ($user ? $user . '@' : '') . $this->getHost() . ($port !== null ? ':' . $port : '');
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * {@inheritdoc}
     */
    public function withScheme($scheme)
    {
        $clone = clone $this;
        $clone->scheme = static::filterScheme($scheme);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function withUserInfo($user, $password = null)
    {
        $userInfo = $user;

        if ($password) {
            $userInfo .= ":$password";
        }

        $clone = clone $this;
        $clone->userInfo = $userInfo;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function withHost($host)
    {
        $clone = clone $this;
        $clone->host = $host;

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        if (isset(static::$schemes[$this->scheme]) && $this->port == static::$schemes[$this->scheme]) {
            return;
        }

        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function withPort($port)
    {
        $clone = clone $this;
        $clone->port = static::filterPort($port);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function withPath($path)
    {
        $clone = clone $this;
        $clone->path = static::filterPath($path);

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function withQuery($query)
    {
        $clone = clone $this;
        $clone->query = static::filterQuery(ltrim($query, '?'));

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function withFragment($fragment)
    {
        $clone = clone $this;
        $clone->fragment = static::filterQuery(ltrim($fragment, '#'));

        return $clone;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $scheme = $this->getScheme();
        $authority = $this->getAuthority();
        $path = $this->getPath();
        $query = $this->getQuery();
        $fragment = $this->getFragment();

        return ($scheme ? $scheme . ':' : '') . ($authority ? '//' . $authority : '') . $path . ($query ? '?' . $query : '') . ($fragment ? '#' . $fragment : '');
    }

    /**
     * Filter URI scheme.
     *
     * @param string $scheme
     *
     * @return string
     */
    protected static function filterScheme($scheme)
    {
        $scheme = strtolower($scheme);
        $scheme = rtrim($scheme, ':/');

        if ($scheme !== '' && !isset(static::$schemes[$scheme])) {
            throw new \InvalidArgumentException('Uri scheme must be one of: "", "http", "https"');
        }

        return $scheme;
    }

    /**
     * Filter URI port.
     *
     * @param int|null $port
     *
     * @return int|null
     */
    protected static function filterPort($port)
    {
        if (is_null($port) || (is_integer($port) && ($port >= 1 && $port <= 65535))) {
            return $port;
        }

        throw new \InvalidArgumentException('Uri port must be null or an integer between 1 and 65535');
    }

    /**
     * Filter URI path.
     *
     * @param string $path
     *
     * @return string
     */
    protected static function filterPath($path)
    {
        return preg_replace_callback(static::PATH, function ($match) {
            return rawurlencode($match[0]);
        }, $path);
    }

    /**
     * Filters the query string or fragment of a URI.
     *
     * @param string $query
     *
     * @return string
     */
    protected static function filterQuery($query)
    {
        return preg_replace_callback(static::QUERY, function ($match) {
            return rawurlencode($match[0]);
        }, $query);
    }
}
