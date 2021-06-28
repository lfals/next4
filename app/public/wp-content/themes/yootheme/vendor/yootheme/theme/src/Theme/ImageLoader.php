<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\Image;

class ImageLoader
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var array
     */
    protected $convert = [];

    /**
     * Constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        // convert jpeg, png images to webp if supported
        if (is_callable('imagewebp') && strpos($config('req.accept'), 'image/webp') !== false) {
            $this->convert = ['png' => 'webp,100', 'jpeg' => 'webp,85'];
        }
    }

    public function __invoke(Image $image)
    {
        $params = $image->getAttribute('params', []);

        // convert image type?
        if ($this->convert && $this->config->get('~theme.webp') && !isset($params['type'])) {

            $type = $image->getType();

            if (isset($this->convert[$type])) {
                $params['type'] = $this->convert[$type];
            }
        }

        // image covers
        if (isset($params['covers']) && $params['covers'] && !isset($params['sizes'])) {
            $img = $image->apply($params);
            $ratio = round($img->width / $img->height * 100);
            $params['sizes'] = "(max-aspect-ratio: {$img->width}/{$img->height}) {$ratio}vh";
        }

        // set default srcset
        if (isset($params['srcset']) && $params['srcset'] === '1') {
            $params['srcset'] = '768,1024,1366,1600,1920,200%';
        }

        $image->setAttribute('params', $params);
    }
}
