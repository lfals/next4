<?php

namespace YOOtheme\Theme;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class SystemCheckController
{
    public static function index(Request $request, Response $response, SystemCheck $systemCheck)
    {
        return $response->withJson([
            'requirements' => $systemCheck->getRequirements(),
            'recommendations' => $systemCheck->getRecommendations(),
        ]);
    }
}
