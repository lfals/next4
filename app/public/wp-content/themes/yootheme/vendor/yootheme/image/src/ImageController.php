<?php

namespace YOOtheme;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class ImageController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        Memory::raise();
    }

    /**
     * Gets the image file.
     *
     * @param Request       $request
     * @param Response      $response
     * @param ImageProvider $provider
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function get(Request $request, Response $response, ImageProvider $provider)
    {
        $request->abortIf($request('hash') !== $provider->getHash($request('src')), 400, 'Invalid image hash');

        list($file, $params) = json_decode(base64_decode($request('src')));

        if (!$image = $provider->create($file)) {
            $request->abort(404, "Image '{$file}' not found");
        }

        if ($params) {
            $image = $image->apply($params);
        }

        if ($provider->cache && $request->getAttribute('save')) {

            if (!File::makeDir($provider->cache)) {
                $request->abort(500, 'Image cache dir not found');
            }

            return $response->withFile($image->save($image->getFilename($provider->cache)), "image/{$image->getType()}");
        }

        $image->save($path = stream_get_meta_data(tmpfile())['uri']);

        return $response
            ->withFile($path, "image/{$image->getType()}")
            ->withHeader('Cache-Control', 'max-age=3600')
            ->withHeader('Expires', (new \DateTime('+1 hour', new \DateTimeZone('GMT')))->format('D, d M Y H:i:s \G\M\T'));
    }
}
