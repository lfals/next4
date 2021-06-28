<?php

namespace YOOtheme\Builder;

use YOOtheme\Builder;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Storage;

class BuilderController
{
    public function index(Request $request, Response $response, Storage $storage, Builder $builder)
    {
        $library = $storage('library', []);
        $library = array_map('json_encode', $library);
        $library = array_map([$builder, 'load'], $library);

        return $response->withJson($library);
    }

    public function encodeLayout(Request $request, Response $response, Builder $builder)
    {
        $builder = $builder->withParams(['context' => 'save']);

        return $response->withJson($builder->load(json_encode($request('layout'))));
    }

    public function addElement(Request $request, Response $response, Storage $storage)
    {
        if ($request('id') && $request('element')) {
            $storage->set("library.{$request('id')}", $request('element'));
        }

        return $response->withJson(['message' => 'success']);
    }

    public function removeElement(Request $request, Response $response, Storage $storage)
    {
        if ($request('id')) {
            $storage->del("library.{$request('id')}");
        }

        return $response->withJson(['message' => 'success']);
    }
}
