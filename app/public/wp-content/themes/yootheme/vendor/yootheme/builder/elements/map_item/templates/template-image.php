<?php

if (!$props['image']) {
    return;
}

echo $this->el('image', [

    'class' => [
        'el-image',
        'uk-responsive-width',
        'uk-margin-auto',
        'uk-display-block',
        'uk-border-{image_border}',
        'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
    ],

    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => $element['image_svg_inline'],
    'thumbnail' => true,

])->render($element);
