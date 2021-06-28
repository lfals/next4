<?php

if (!$props['image']) {
    return;
}

// Image
$image = $this->el('image', [

    'class' => [
        'el-image',
        'uk-preserve-width',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
        'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
    ],

    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => $element['image_svg_inline'],
    'thumbnail' => true,
]);

echo $image($element);
