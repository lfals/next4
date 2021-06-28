<?php

return [

    'config' => function () {

        $request = [
            'ip' => '127.0.0.1',
            'url' => '/',
            'method' => 'GET',
            'secure' => '',
            'host' => 'localhost',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'acceptCharset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'acceptLanguage' => 'en-us,en;q=0.5',
            'query' => $_GET,
            'body' => $_POST,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
        ];

        $server = [
            'SCRIPT_NAME' => 'script',
            'REMOTE_ADDR' => 'ip',
            'REQUEST_URI' => 'url',
            'REQUEST_METHOD' => 'method',
            'REQUEST_TIME' => 'time',
            'REQUEST_TIME_FLOAT' => 'time',
            'HTTPS' => 'secure',
            'HTTP_HOST' => 'host',
            'HTTP_ACCEPT' => 'accept',
            'HTTP_ACCEPT_CHARSET' => 'acceptCharset',
            'HTTP_ACCEPT_LANGUAGE' => 'acceptLanguage',
            'HTTP_ACCEPT_ENCODING' => 'acceptEncoding',
            'HTTP_USER_AGENT' => 'useragent',
            'DOCUMENT_ROOT' => 'rootDir',
        ];

        foreach (array_intersect_key($server, $_SERVER) as $key => $name) {
            $request[$name] = $_SERVER[$key];
        }

        $request['script'] = parse_url($request['script'], PHP_URL_PATH);
        $request['scriptDir'] = dirname($request['script']);
        $request['secure'] = $request['secure'] && $request['secure'] !== 'off';
        $request['protocol'] = $request['secure'] ? 'https' : 'http';
        $request['origin'] = "{$request['protocol']}://{$request['host']}";
        $request['href'] = $request['origin'] . $request['url'];
        $request['siteUrl'] = $request['origin'];

        $url = parse_url($request['href']);

        if (stripos($url['path'], $request['script']) === 0) {
            $request['baseUrl'] = rtrim(str_replace('index.php', '', $request['script']), '/');
        } elseif ($request['scriptDir'] !== '/' && stripos($url['path'], $request['scriptDir']) === 0) {
            $request['baseUrl'] = $request['scriptDir'];
        }

        if (isset($request['baseUrl'])) {
            $request['siteUrl'] .= $request['baseUrl'];
        }

        if (isset($url['host'])) {
            $request['hostname'] = $url['host'];
        }

        if (isset($url['query'])) {
            $request['queryStr'] = $url['query'];
        }

        return ['req' => $request];
    },

];
