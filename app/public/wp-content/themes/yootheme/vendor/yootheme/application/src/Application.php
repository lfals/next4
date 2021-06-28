<?php

namespace YOOtheme;

use Psr\Http\Message\ResponseInterface;
use YOOtheme\Application\LoaderTrait;
use YOOtheme\Configuration\Configuration;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class Application extends Container
{
    use LoaderTrait;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * Constructor.
     *
     * @param string $cache
     */
    public function __construct($cache = null)
    {
        $this->config = new Configuration($cache);

        $this->set(static::class, $this);
        $this->setAlias('app', static::class);

        $this->set(Config::class, $this->config);
        $this->setAlias('config', Config::class);
    }

    /**
     * Gets global application.
     *
     * @param null|mixed $cache
     *
     * @return static
     */
    public static function getInstance($cache = null)
    {
        return static::$instance ?: static::$instance = new static($cache);
    }

    /**
     * Run application.
     *
     * @param bool $send
     *
     * @return ResponseInterface
     */
    public function run($send = true)
    {
        try {
            $response = Event::emit('app.request|middleware', [$this, 'handle'], $this->request);
        } catch (\Exception $exception) {
            $response = Event::emit('app.error|filter', $this->response, $exception);
        }

        return $send ? $response->send() : $response;
    }

    /**
     * Handles a request.
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $this->set(Request::class, $request);

        $route = $request->getAttribute('route');
        $result = $this->call($route->getCallable());

        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result) || (is_object($result) && method_exists($result, '__toString'))) {
            return $this->response->write((string) $result);
        }

        return $this->response;
    }
}
