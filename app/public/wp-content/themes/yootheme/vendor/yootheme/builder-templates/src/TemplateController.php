<?php

namespace YOOtheme\Builder\Templates;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Storage;

class TemplateController
{
    public static function saveTemplate(Request $request, Response $response, Storage $storage)
    {
        // Can't name 'tpl' request param 'template' because of conflict when PECL extension "json_post" is enabled
        $storage->set("templates.{$request('id')}", $request('tpl'));

        return $response->withJson(['message' => 'success']);
    }

    public static function deleteTemplate(Request $request, Response $response, Storage $storage)
    {
        $storage->del("templates.{$request('id')}");

        return $response->withJson(['message' => 'success']);
    }

    public static function reorderTemplates(Request $request, Response $response, Storage $storage)
    {
        $sorting = $request('templates');
        $templates = $storage->get('templates');

        $storage->set('templates', array_merge(array_intersect_key(array_flip($sorting), $templates), $templates));

        return $response->withJson(['message' => 'success']);
    }
}
