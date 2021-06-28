<?php

namespace YOOtheme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

return [

    'events' => [

        'app.request' => [
            CsrfMiddleware::class => ['@handle', 10],
            RouterMiddleware::class => [['@handleRoute', 30], ['@handleStatus', 20]],
        ],

        'app.error' => [
            RouterMiddleware::class => ['@handleError', 10],
        ],

        'url.resolve' => [
            UrlResolver::class => 'resolve',
        ],

    ],

    'aliases' => [

        Routes::class => 'routes',
        Request::class => ['request', ServerRequestInterface::class],
        Response::class => ['response', ResponseInterface::class],

    ],

    'services' => [

        Request::class => function (Config $config) {
            return Request::fromGlobals($config('req.href'));
        },

        Response::class => function () {
            return (new Response())
                ->withHeader('Expires', 'Mon, 1 Jan 2001 00:00:00 GMT')
                ->withHeader('Cache-Control', 'no-cache, must-revalidate, max-age=0');
        },

        Routes::class => '',
        Router::class => '',
        RouterMiddleware::class => '',
    ],

];
