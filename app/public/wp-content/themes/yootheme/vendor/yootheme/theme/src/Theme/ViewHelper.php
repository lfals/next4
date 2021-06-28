<?php

namespace YOOtheme\Theme;

use YOOtheme\Config;
use YOOtheme\ImageProvider;
use YOOtheme\Str;
use YOOtheme\Url;
use YOOtheme\View;

class ViewHelper
{
    // https://developer.mozilla.org/en-US/docs/Web/Media/Formats/Image_types
    const REGEX_IMAGE = '#\.(avif|gif|a?png|jpe?g|svg|webp)$#i';

    const REGEX_VIDEO = '#\.(mp4|m4v|ogv|webm)$#i';

    const REGEX_VIMEO = '#(?:player\.)?vimeo\.com(?:/video)?/(\d+)#i';

    const REGEX_YOUTUBE = '#(?:youtube(-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})#i';

    const REGEX_UNSPLASH = '#images.unsplash.com/(?<id>(?:[\w-]+/)?[\w\-.]+)#i';

    /**
     * @var View
     */
    protected $view;

    /**
     * @var ImageProvider
     */
    protected $image;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Config        $config
     * @param View          $view
     * @param ImageProvider $image
     */
    public function __construct(Config $config, View $view, ImageProvider $image)
    {
        $this->view = $view;
        $this->image = $image;
        $this->config = $config;
    }

    /**
     * Register helper.
     *
     * @param View $view
     */
    public function register($view)
    {
        // Loaders
        $view->addLoader(function ($name, $parameters, $next) {

            $content = $next($name, $parameters);

            // Apply to root template view only
            if (empty($parameters['_root'])) {
                return $content;
            }

            return $this->image->replace($content);
        });

        // Functions
        $view->addFunction('social', [$this, 'social']);
        $view->addFunction('uid', [$this, 'uid']);
        $view->addFunction('iframeVideo', [$this, 'iframeVideo']);
        $view->addFunction('isVideo', [$this, 'isVideo']);
        $view->addFunction('isImage', [$this, 'isImage']);
        $view->addFunction('image', [$this, 'image']);
        $view->addFunction('bgImage', [$this, 'bgImage']);
        $view->addFunction('parallaxOptions', [$this, 'parallaxOptions']);
        $view->addFunction('striptags', [$this, 'striptags']);
        $view->addFunction('margin', [$this, 'margin']);

        // Components
        $view['html']->addComponent('image', [$this, 'comImage']);

    }

    public function social($link)
    {
        if (Str::startsWith($link, 'mailto:')) {
            return 'mail';
        }

        if (Str::startsWith($link, 'tel:')) {
            return 'receiver';
        }

        if (preg_match('#(google|goo)\.(.+?)/maps(?>\/?.+)?#i', $link)) {
            return 'location';
        }

        $icon = parse_url($link, PHP_URL_HOST);
        $icon = preg_replace('/.*?(\w{3,}[^.]).*/i', '$1', $icon);
        $icon = str_replace(['wa.me'], ['whatsapp'], $icon);

        $icons = ['500px', 'behance', 'discord', 'dribbble', 'etsy', 'facebook', 'flickr', 'foursquare', 'github', 'github-alt', 'gitter', 'google', 'instagram', 'joomla', 'linkedin', 'pagekit', 'pinterest', 'reddit', 'soundcloud', 'tiktok', 'tripadvisor', 'tumblr', 'twitch', 'twitter', 'uikit', 'vimeo', 'whatsapp', 'wordpress', 'xing', 'yelp', 'youtube'];

        if (!in_array($icon, $icons)) {
            $icon = 'social';
        }

        return $icon;
    }

    /**
     * @param string $link
     * @param array  $params
     * @param bool   $defaults
     *
     * @return string|void
     */
    public function iframeVideo($link, $params = [], $defaults = true)
    {
        $query = parse_url($link, PHP_URL_QUERY);

        if ($query) {
            parse_str($query, $_params);
            $params = array_merge($_params, $params);
        }

        if (preg_match(static::REGEX_VIMEO, $link, $matches)) {
            return Url::to("https://player.vimeo.com/video/{$matches[1]}", $defaults ? array_merge([
                'loop' => 1,
                'autoplay' => 1,
                'title' => 0,
                'byline' => 0,
                'setVolume' => 0,
            ], $params) : $params);
        }

        if (preg_match(static::REGEX_YOUTUBE, $link, $matches)) {

            if (!empty($params['loop'])) {
                $params['playlist'] = $matches[2];
            }

            if (empty($params['controls'])) {
                $params['disablekb'] = 1;
            }

            return Url::to("https://www.youtube{$matches[1]}.com/embed/{$matches[2]}", $defaults ? array_merge([
                'rel' => 0,
                'loop' => 1,
                'playlist' => $matches[2],
                'autoplay' => 1,
                'controls' => 0,
                'showinfo' => 0,
                'iv_load_policy' => 3,
                'modestbranding' => 1,
                'wmode' => 'transparent',
                'playsinline' => 1,
            ], $params) : $params);
        }
    }

    public function uid()
    {
        return substr(uniqid(), -3);
    }

    public function isVideo($link)
    {
        return $link && preg_match(static::REGEX_VIDEO, $link, $matches) ? $matches[1] : false;
    }

    /**
     * @param string|array $url
     * @param array        $attrs
     *
     * @return string
     */
    public function image($url, array $attrs = [])
    {
        $url = (array) $url;
        $path = array_shift($url);
        $isAbsolute = !$this->config->get('app.isCustomizer') && preg_match('/^\/|#|[a-z0-9-.]+:/', $path);
        $type = $this->isImage($path);

        if (isset($url['thumbnail']) && count($url['thumbnail']) > 1 && preg_match(static::REGEX_UNSPLASH, $path, $matches)) {
            $path = "https://images.unsplash.com/{$matches['id']}?fit=crop&w={$url['thumbnail'][0]}&h={$url['thumbnail'][1]}";
        }

        $params = $url && !$isAbsolute && !in_array($type, ['gif', 'svg']) ? '#' . http_build_query(array_map(function ($value) {
                return is_array($value) ? implode(',', $value) : $value;
            }, $url), '', '&') : '';

        $attrs['src'] = $path . $params;

        if (empty($attrs['alt'])) {
            $attrs['alt'] = true;
        }

        if (!empty($attrs['uk-img'])) {

            if (!$this->config->get('~theme.lazyload')) {
                unset($attrs['uk-img']);
            } else {
                if ($type === 'svg' && !empty($attrs['uk-svg'])) {
                    $attrs['uk-img'] = Url::to($attrs['src']);
                } else {
                    $attrs['data-src'] = $attrs['src'];
                }
                unset($attrs['src']);
            }

        }

        return "<img{$this->view->attrs($attrs)}>";
    }

    public function bgImage($url, array $params = [])
    {
        $attrs = [];
        $lazyload = $this->config->get('~theme.lazyload');
        $isResized = $params['width'] || $params['height'];
        $type = $this->isImage($url);
        $isAbsolute = preg_match('/^\/|#|[a-z0-9-.]+:/', $url);

        if (preg_match(static::REGEX_UNSPLASH, $url, $matches)) {
            $url = "https://images.unsplash.com/{$matches['id']}?fit=crop&w={$params['width']}&h={$params['height']}";
        } elseif ($type == 'svg' || $isAbsolute) {
            if ($isResized && !$params['size']) {
                $width = $params['width'] ? "{$params['width']}px" : 'auto';
                $height = $params['height'] ? "{$params['height']}px" : 'auto';
                $attrs['style'][] = "background-size: {$width} {$height};";
            }
        } elseif ($type != 'gif') {
            $url .= '#srcset=1';
            $url .= '&covers=' . ((int) ($params['size'] === 'cover'));
            $url .= '&thumbnail' . ($isResized ? "={$params['width']},{$params['height']}" : '');
        }

        if ($lazyload) {

            if ($image = $this->image->create($url, false)) {
                $attrs = array_merge($attrs, $this->image->getSrcsetAttrs($image, 'data-'));
            } else {
                $attrs['data-src'][] = Url::to($url);
            }

            $attrs['uk-img'] = true;

        } else {
            $attrs['style'][] = 'background-image: url(\'' . $this->image->getUrl($url) . '\');';
        }

        $attrs['class'] = [$this->view->cls([
            'uk-background-norepeat',
            'uk-background-{size}',
            'uk-background-{position}',
            'uk-background-image@{visibility}',
            'uk-background-blend-{blend_mode}',
            'uk-background-fixed{@effect: fixed}',
        ], $params)];

        $attrs['style'][] = $params['background'] ? "background-color: {$params['background']};" : '';

        switch ($params['effect']) {
            case '':
            case 'fixed':
                break;
            case 'parallax':

                $options = [];

                foreach(['bgx', 'bgy'] as $prop) {
                    $start = $params["parallax_{$prop}_start"];
                    $end = $params["parallax_{$prop}_end"];

                    if (strlen($start) || strlen($end)) {
                        $options[] = "{$prop}: " . (strlen($start) ? $start : 0) . ',' . (strlen($end) ? $end : 0);
                    }
                }

                $options[] = is_numeric($params['parallax_easing']) ? "easing: {$params['parallax_easing']}" : '';
                $options[] = $params['parallax_breakpoint'] ? "media: @{$params['parallax_breakpoint']}" : '';
                $options[] = !empty($params['parallax_target']) ? "target: {$params['parallax_target']}" : '';
                $attrs['uk-parallax'] = implode(';', array_filter($options));

                break;
        }

        return $attrs;
    }

    public function comImage($element, array $params = [])
    {
        $defaults = ['src' => '', 'width' => '', 'height' => ''];
        $attrs = array_merge($defaults, $element->attrs);
        $type = $this->isImage($attrs['src']);

        if (empty($attrs['alt'])) {
            $attrs['alt'] = true;
        }

        if ($type !== 'svg') {

            $query = [];

            if (!empty($attrs['thumbnail'])) {

                $query['thumbnail'] = is_array($attrs['thumbnail']) ? $attrs['thumbnail'] : [$attrs['width'], $attrs['height']];
                $query['srcset'] = true;

                // use unsplash resizing?
                if (preg_match(static::REGEX_UNSPLASH, $attrs['src'], $matches) && count($query['thumbnail']) > 1) {
                    $attrs['src'] = "https://images.unsplash.com/{$matches['id']}?fit=crop&w={$query['thumbnail'][0]}&h={$query['thumbnail'][1]}";
                }
            }

            if (!empty($attrs['uk-cover'])) {
                $query['covers'] = true;
            }

            if ($type === 'gif') {
                $attrs['uk-gif'] = true;
            } elseif ($this->config->get('app.isCustomizer') || !$this->isAbsolute($attrs['src']) && $type) {
                $attrs['src'] .= $query ? '#' . http_build_query(array_map(function ($value) {
                    return is_array($value) ? join(',', $value) : $value;
                }, $query), '', '&') : '';
            }

            // remove width/height for local images with "srcset"
            if (!filter_var($attrs['src'], FILTER_VALIDATE_URL)) {
                unset($attrs['width'], $attrs['height']);
            }

            unset($attrs['uk-svg']);
        }

        // use lazy loading?
        if ($this->config->get('~theme.lazyload')) {

            if ($type === 'svg' && !empty($attrs['uk-svg'])) {
                $attrs['uk-img'] = 'dataSrc:' . Url::to($attrs['src']);
            } else {
                $attrs['data-src'] = $attrs['src'];
            }

            if (empty($attrs['uk-img'])) {
                $attrs['uk-img'] = true;
            }

            unset($attrs['src']);
        } else {
            unset($attrs['uk-img']);
        }

        unset($attrs['thumbnail']);

        // update element
        $element->name = 'img';
        $element->attrs = $attrs;
    }

    public function isImage($link)
    {
        return $link && preg_match(static::REGEX_IMAGE, $link, $matches) ? $matches[1] : false;
    }

    public function isAbsolute($url)
    {
        return $url && preg_match('/^\/|#|[a-z0-9-.]+:/', $url);
    }

    public function parallaxOptions($params, $prefix = '')
    {
        return array_reduce(['x', 'y', 'scale', 'rotate', 'opacity'], function ($options, $prop) use ($params, $prefix) {
            $start = isset($params["{$prefix}parallax_{$prop}_start"]) ? $params["{$prefix}parallax_{$prop}_start"] : '';
            $end = isset($params["{$prefix}parallax_{$prop}_end"]) ? $params["{$prefix}parallax_{$prop}_end"] : '';
            $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;

            if (strlen($start) || strlen($end)) {
                $start = strlen($start) ? $start : $default;
                $middle = $prefix ? "{$default}," : '';
                $end = strlen($end) ? $end : $default;

                $options[] = "{$prop}: {$start},{$middle}{$end};";
            }

            return $options;
        }, []);
    }

    public function striptags($str, $allowable_tags = '<div><h1><h2><h3><h4><h5><h6><p><ul><ol><li><img><svg><br><span><strong><em><sup><del>')
    {
        return strip_tags($str, $allowable_tags);
    }

    /**
     * @param string $margin
     *
     * @return string|void
     */
    public function margin($margin)
    {
        switch ($margin) {
            case '':
                return;
            case 'default':
                return 'uk-margin-top';
            default:
                return "uk-margin-{$margin}-top";
        }
    }
}
