<?php

// Video
if (!$props['video']) {
    return;
}

$attrs_video = [

    'class' => [
        'uk-blend-{media_blend_mode}',
        'uk-visible@{media_visibility}',
    ],
    'width' => ['{video_width}'],
    'height' => ['{video_height}'],
    'uk-cover' => true,

];

if ($iframe = $this->iframeVideo($props['video'])) {

    $attrs_video += [
        'src' => $iframe,
        'frameborder' => '0',
        'allowfullscreen' => true,
    ];

    echo $this->el('iframe', $attrs_video)->render($props, '');

} elseif ($props['video']) {

    $attrs_video += [
        'src' => $props['video'],
        'controls' => false,
        'loop' => true,
        'autoplay' => true,
        'muted' => true,
        'playsinline' => true,
    ];

    echo $this->el('video', $attrs_video)->render($props, '');
}
