<?php

namespace YOOtheme\Builder\Wordpress\Source;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class SourceController
{
    /**
     * @param Request  $request
     * @param Response $response
     *
     * @throws \Exception
     *
     * @return Response
     */
    public static function posts(Request $request, Response $response)
    {
        $names = [];

        foreach ((array) $request('ids') as $id) {
            if ($post = get_post($id)) {
                $names[$id] = $post->post_title;
            }
        }

        return $response->withJson($names);
    }
}
