<?php

namespace YOOtheme\Theme;

use YOOtheme\Http\Uri;
use YOOtheme\HttpClientInterface;
use YOOtheme\Path;

class StyleFontLoader
{
    const PREFIX = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 ';

    /**
     * @var string
     */
    public $cache;

    /**
     * @var array
     */
    public $formats;

    /**
     * @var HttpClientInterface
     */
    public $client;

    /**
     * Constructor.
     *
     * @param HttpClientInterface $client
     * @param string              $cache
     */
    public function __construct(HttpClientInterface $client, $cache)
    {
        if (!is_dir($cache)) {
            mkdir($cache, 0777, true);
        }

        $formats = [
            'woff2' => self::PREFIX . 'Edge/16.246',
            'woff' => self::PREFIX . 'Edge/12.246',
        ];

        $this->cache = $cache;
        $this->client = $client;
        $this->formats = $formats;
    }

    /**
     * Creates CSS markup.
     *
     * @param string $url
     * @param string $basePath
     *
     * @return string|void
     */
    public function css($url, $basePath)
    {
        $date = date(DATE_W3C);
        $hash = hash('crc32b', "$url, $basePath");
        $file = "{$this->cache}/font-{$hash}.css";

        // is already cached?
        if (file_exists($file)) {
            return file_get_contents($file);
        }

        // load font url
        $fonts = $this->load($url);
        $relative = function ($path) use ($basePath) {
            return Path::relative($basePath, $path);
        };

        // relative font path
        foreach ($fonts as &$font) {
            $font['src'] = array_map($relative, $font['src']);
        }

        // generate fonts css
        $data = "/* {$url} generated on {$date} */\n";
        $data .= join(array_map([$this, 'cssFontFace'], $fonts));

        // save file in cache
        if ($fonts && @file_put_contents($file, $data)) {
            return $data;
        }
    }

    /**
     * Creates a single @font-face CSS markup.
     *
     * @param array $font
     *
     * @return string
     */
    public function cssFontFace(array $font)
    {
        $output = '@font-face {';

        foreach ($font as $name => $value) {

            if ($name == 'src') {

                $urls = [];

                foreach ($value as $format => $url) {
                    $urls[] = "url({$url}) format('{$format}')";
                }

                $value = join(', ', $urls);
            }

            $output .= "{$name}: {$value}; ";
        }

        return "$output}\n";
    }

    /**
     * Loads fonts from url.
     *
     * @param string $url
     *
     * @return array[]
     */
    public function load($url)
    {
        $fonts = [];

        foreach ($this->parseFontFamilies($url) as $url) {
            // load font formats based on user agents
            foreach ($this->formats as $userAgent) {

                $options = compact('userAgent');
                $response = $this->client->get($url, $options);

                if ($result = $this->parseFonts($response->getBody())) {
                    $fonts = array_replace_recursive($fonts, $result);
                }
            }
        }

        // load fonts and save them
        foreach ($fonts as &$font) {
            $font['src'] = array_map([$this, 'loadFont'], $font['src']);
        }

        return $fonts;
    }

    /**
     * Load font file from url.
     *
     * @param string $url
     * @param array  $options
     *
     * @return string|void
     */
    public function loadFont($url, array $options = [])
    {
        $hash = hash('crc32b', $url);
        $type = pathinfo($url, PATHINFO_EXTENSION);
        $file = "{$this->cache}/font-{$hash}.{$type}";

        // is already cached?
        if (file_exists($file)) {
            return $file;
        }

        // load font from url
        $data = $this->client->get($url, $options);

        // save file in cache
        if (@file_put_contents($file, $data->getBody())) {
            return $file;
        }
    }

    /**
     * Parses font @import from source.
     *
     * @param string $source
     *
     * @return array
     */
    public function parse($source)
    {
        return preg_match('/@import\s+url\((https?:\/\/fonts\.googleapis\.com[^)]+)\)\s*;?/i', $source, $matches) ? $matches : [];
    }

    /**
     * Parses fonts url from source.
     *
     * @param string $source
     *
     * @return array
     */
    public function parseFonts($source)
    {
        $fonts = [];

        foreach ($this->parseFontFaces($source) as $fontface) {

            $font = $src = [];

            foreach ($this->parseFontProperties($fontface) as $name => $value) {
                if ($name == 'src') {
                    $src = $this->parseFontSrc($value);
                } else {
                    $font[$name] = $value;
                }
            }

            if ($src) {
                $hash = hash('crc32b', json_encode($font));
                $fonts[$hash] = array_merge($font, compact('src'));
            }
        }

        return $fonts;
    }

    /**
     * Parses font url from source.
     *
     * @param string $source
     *
     * @return array
     */
    public function parseFontSrc($source)
    {
        return preg_match('/url\((https?:\/\/.+?)\)\s*format\(\'?(\w+)/', $source, $matches) ? [$matches[2] => $matches[1]] : [];
    }

    /**
     * Parses @font-face from source.
     *
     * @param string $source
     *
     * @return array
     */
    public function parseFontFaces($source)
    {
        return preg_match_all('/@font-face\s*{\s*([^}]+)/', $source, $matches) ? $matches[1] : [];
    }

    /**
     * Parses properties from source.
     *
     * @param string $source
     *
     * @return array
     */
    public function parseFontProperties($source)
    {
        return preg_match_all('/([\w-]+)\s*:\s*([^;]+)/', $source, $matches) ? array_combine($matches[1], $matches[2]) : [];
    }

    /**
     * Split url into separate urls, one per font family.
     *
     * @param string $url
     *
     * @return array
     */
    protected function parseFontFamilies($url)
    {
        $uri = new Uri($url);
        $query = $uri->getQueryParams();

        if (isset($query['family'], $query['subset'])) {
            return array_map(function ($family) use ($uri, $query) {
                return (string) $uri->withQueryParams(compact('family') + $query);
            }, explode('|', $query['family']));
        }

        return [$url];
    }
}
