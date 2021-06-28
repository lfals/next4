<?php

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

$el = $this->el('div');

// Video
$video = $this->el('video', [
    'class' => ['uk-box-shadow-{video_box_shadow}'],
    'width' => ['{video_width}'],
    'height' => ['{video_height}'],
], '');

// Iframe?
if ($iframe = $this->iframeVideo($props['video'], [], false)) {

    if ($props['video_width'] && !$props['video_height']) {
        $video->attr('height', round($props['video_width'] * 9 / 16));
    } elseif ($props['video_height'] && !$props['video_width']) {
        $video->attr('width', round($props['video_height'] * 16 / 9));
    }

    $iframe = $video($props, [
        'src' => $iframe,
        'frameborder' => 0,
        'allowfullscreen' => true,
        'uk-responsive' => true,
    ], '', 'iframe');

} else {

    $video->attr([
        'src' => ['{video}'],
        'controls' => $props['video_controls'],
        'loop' => $props['video_loop'],
        'muted' => $props['video_muted'],
        'playsinline' => $props['video_playsinline'],
        'preload' => ['none {@video_lazyload}'],
        'poster' => $props['video_poster'] && ($props['video_width'] || $props['video_height'])
            ? $imageProvider->getUrl("{$props['video_poster']}#thumbnail={$props['video_width']},{$props['video_height']}")
            : $props['video_poster'],
        $props['video_autoplay'] === 'inview' ? 'uk-video' : 'autoplay' => $props['video_autoplay'],
    ]);

}

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom {@video_box_decoration: shadow}',
        'tm-mask-default {@video_box_decoration: mask}',
        'tm-box-decoration-{video_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@video_box_decoration_inverse} {@video_box_decoration: default|primary|secondary}',
        'uk-inline {@!video_box_decoration: |shadow}',
    ],

]);

echo $el($props, $attrs, $props['video_box_decoration'] ? $decoration($props, $iframe ?: $video($props)) : ($iframe ?: $video($props)));
