<?php

namespace YOOtheme;

use YOOtheme\Http\Request;

class Router
{
    /**
     * @var Routes
     */
    protected $routes;

    /**
     * Constructor.
     *
     * @param Routes $routes
     */
    public function __construct(Routes $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Dispatches router for a request.
     *
     * @param Request $request
     *
     * @return Request
     */
    public function dispatch(Request $request)
    {
        $path = '/' . trim($request->getQueryParam('p'), '/');

        foreach ($this->routes->getIndex() as $route) {

            if ($route->getMethods() && !in_array($request->getMethod(), $route->getMethods())) {
                continue;
            }

            if (preg_match($this->getPattern($route), $path, $matches)) {

                $params = [];

                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = urldecode($value);
                    }
                }

                foreach ($route->getAttributes() as $name => $value) {
                    $request->setAttribute($name, $value);
                }

                $request->setAttribute('route', $route);
                $request->setAttribute('routeParams', $params);
                $request->setAttribute('routeStatus', 1);

                return $request;
            }
        }

        return $request->setAttribute('routeStatus', 0);
    }

    /**
     * Gets the route regex pattern.
     *
     * @param Route $route
     *
     * @return string
     */
    protected function getPattern(Route $route)
    {
        return '#^' . preg_replace_callback('#\{(\w+)\}#', function ($matches) {
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $route->getPath()) . '$#';
    }
}
