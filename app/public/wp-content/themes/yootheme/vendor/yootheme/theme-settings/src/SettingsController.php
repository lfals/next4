<?php

namespace YOOtheme\Theme;

use YOOtheme\Application;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class SettingsController
{
    public static function import(Request $request, Response $response, Application $app)
    {
        $config = $request('config');
        $updater = $app(Updater::class);

        return $response->withJson($updater->update($config, []));
    }
}
