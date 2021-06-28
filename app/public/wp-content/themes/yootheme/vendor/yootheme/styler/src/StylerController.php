<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Path;
use YOOtheme\Storage;
use YOOtheme\Url;

class StylerController
{
    public static function index(Request $request, Response $response, Storage $storage)
    {
        return $response->withJson((object) $storage('styler.library'));
    }

    public static function addStyle(Request $request, Response $response, Storage $storage)
    {
        $storage->set("styler.library.{$request('id')}", $request('style'));

        return $response->withJson(['message' => 'success']);
    }

    public static function removeStyle(Request $request, Response $response, Storage $storage)
    {
        $storage->del("styler.library.{$request('id')}");

        return $response->withJson(['message' => 'success']);
    }

    public static function loadStyle(Request $request, Response $response, Config $config, Styler $styler)
    {
        $styles = [];
        $imports = [];

        $resolve = function ($file, $replace = []) use (&$imports, &$resolve, $config) {

            if (!file_exists($file)) {
                return;
            }

            foreach ($config('styler.ignore_less', []) as $ignore) {
                if (strpos($file, $ignore)) {
                    return;
                }
            }

            $imports[Path::normalize(Url::to($file))] = $contents = @file_get_contents($file) ?: '';

            if (preg_match_all('/^@import.*"(.*)";/m', $contents, $matches)) {
                foreach ($matches[1] as $path) {
                    $resolve(dirname($file) . '/' . str_replace(array_keys($replace), array_values($replace), $path), $replace);
                }
            }

        };

        // add styles
        foreach ($styler->getThemes() as $theme) {

            $file = $theme['file'];
            $styles[$theme['id']] = [
                'filename' => Url::to($file),
                'contents' => file_get_contents($file),
            ];

            // add theme imports
            if ($theme['id'] == preg_replace('/(.+?)(?::.+)?$/', '$1', $request('id', ''))) {

                $resolve($file, ['@{internal-theme}' => $theme['id']]);

                if (isset($theme['styles'])) {
                    foreach (array_keys($theme['styles']) as $style) {
                        $resolve($file, ['@{internal-theme}' => $theme['id'], '@{internal-style}' => $style]);
                    }
                }
            }

        }

        // add imports
        foreach ($config('theme.styles.imports', []) as $path) {
            array_map($resolve, glob($path) ?: []);
        }

        $desturl = Url::to('~theme/css');

        return $response->withJson(compact('styles', 'imports', 'desturl'));
    }

    public static function saveStyle(Request $request, Response $response, Config $config, StyleFontLoader $font)
    {
        $upload = $request->getUploadedFile('files');

        $request->abortIf(!$upload || $upload->getError(), 400, 'Invalid file upload.')
                ->abortIf(!$contents = (string) $upload->getStream(), 400, 'Unable to read contents file.')
                ->abortIf(!$contents = @base64_decode($contents), 400, 'Base64 Decode failed.')
                ->abortIf(!$files = @json_decode($contents, true), 400, 'Unable to decode JSON from temporary file.');

        foreach ($files as $file => $data) {

            $dir = Path::get('~theme/css');
            $rtl = strpos($file, '.rtl') ? '.rtl' : '';

            try {

                // save fonts for theme style
                if ($matches = $font->parse($data)) {

                    list($import, $url) = $matches;

                    if ($fonts = $font->css($url, $dir)) {
                        $data = str_replace($import, $fonts, $data);
                    }
                }

            } catch (\RuntimeException $e) {}

            // save css for theme style
            if (!file_put_contents($file = "{$dir}/theme.{$config('theme.id')}{$rtl}.css", $data)) {
                $request->abort(500, sprintf('Unable to write file (%s).', $file));
            }

            // save css for theme as default/fallback
            if ($config('theme.default') && !file_put_contents($file = "{$dir}/theme{$rtl}.css", $data)) {
                $request->abort(500, sprintf('Unable to write file (%s).', $file));
            }
        }

        return $response->withJson(['message' => 'success']);
    }
}
