<?php

namespace YOOtheme\Builder\Wordpress;

use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Http\Uri;
use YOOtheme\Path;
use YOOtheme\Url;

class BuilderController
{
    public static function loadImage(Request $request, Response $response, Config $config)
    {
        $src = $request('src');
        $md5 = $request('md5');

        $uri = new Uri($src);
        $file = basename($uri->getPath());

        if ($uri->getHost() === 'images.unsplash.com') {
            $file .= ".{$uri->getQueryParam('fm', 'jpg')}";
        }

        $upload = $config('app.uploadDir');

        // file exists already?
        while ($iterate = @md5_file("{$upload}/{$file}")) {

            if ($iterate === $md5 || is_null($md5)) {
                return $response->withJson(Path::relative(Url::base(), Url::to("{$upload}/{$file}")));
            }

            $file = preg_replace_callback('/-?(\d*)(\.[^.]+)?$/', function ($match) {
                return sprintf('-%02d%s', intval($match[1]) + 1, isset($match[2]) ? $match[2] : '');
            }, $file, 1);
        }

        // set upload dir to base
        add_filter('upload_dir', function ($upload) {

            // Subdirectory if uploads use year/month folders option is on.
            if ($upload['subdir']) {
                $upload['url'] = $upload['baseurl'];
                $upload['path'] = $upload['basedir'];
            }

            return $upload;
        });

        // download file
        $tmp = download_url($src);

        if (is_wp_error($tmp)) {
            $request->abort(500, "{$file}: {$tmp->get_error_message()}");
        }

        // import file to uploads dir
        $id = media_handle_sideload([
            'name' => $file,
            'tmp_name' => $tmp,
        ], 0);

        if (is_wp_error($id)) {
            $request->abort(500, "{$file}: {$id->get_error_message()}");
        }

        $attachment = set_url_scheme(wp_get_attachment_url($id), 'relative');

        return $response->withJson(Path::relative(Url::base(), $attachment));
    }
}
