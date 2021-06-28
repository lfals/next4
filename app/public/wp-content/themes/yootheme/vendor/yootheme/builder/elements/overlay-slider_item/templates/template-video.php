<?php

if (!$props['video'] || $props['image']) {
    return;
}

$hasWidthAndHeight = $element['slider_width'] && $element['slider_height'];

$attrs = [

    'class' => [
        'el-image',
        'uk-blend-{0}' => $props['media_blend_mode'],
        'uk-transition-{image_transition} uk-transition-opaque' => !$hasWidthAndHeight,
    ],

    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => $hasWidthAndHeight,
    'uk-video' => [
        'automute: true' => !$hasWidthAndHeight,
    ],

];

if ($iframe = $this->iframeVideo($props['video'])) {

    $video = $this->el('iframe', [

        'class' => [
            'uk-disabled',
        ],

        'src' => $iframe,
        'frameborder' => '0',
        'allowfullscreen' => true,
        'uk-responsive' => !$hasWidthAndHeight,
    ]);

    echo $video($element, $attrs, '');

} elseif ($props['video']) {

    $video = $this->el('video', [
        'src' => $props['video'],
        'controls' => false,
        'loop' => true,
        'autoplay' => true,
        'muted' => true,
        'playsinline' => true,
    ]);

    echo $video($element, $attrs, '');
}
