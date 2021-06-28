<?php

namespace YOOtheme;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class RouterMiddleware
{
    const FOUND = 1;

    const NOT_FOUND = 0;

    const METHOD_NOT_ALLOWED = 2;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Handles the route dispatch.
     *
     * @param Request  $request
     * @param callable $next
     *
     * @return Response
     */
    public function handleRoute($request, callable $next)
    {
        return $next($this->router->dispatch($request));
    }

    /**
     * Handles the route status.
     *
     * @param Request  $request
     * @param callable $next
     *
     * @return Response
     */
    public function handleStatus($request, callable $next)
    {
        $status = $request->getAttribute('routeStatus');

        // Not found
        if ($status === static::NOT_FOUND) {
            $request->abort(404);
        }

        // Method not allowed
        if ($status === static::METHOD_NOT_ALLOWED) {
            $request->abort(405);
        }

        return $next($request);
    }

    /**
     * Handles an error.
     *
     * @param Response   $response
     * @param \Exception $exception
     *
     * @return Response
     */
    public function handleError($response, $exception)
    {
        if ($exception instanceof Http\Exception) {
            return $response->withStatus($exception->getCode(), $exception->getMessage());
        }

        return $response->withStatus(500, $exception->getMessage());
    }
}
