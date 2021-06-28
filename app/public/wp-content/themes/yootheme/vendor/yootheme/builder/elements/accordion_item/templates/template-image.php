<?php

// Display
if (!$element['show_image'] || !$props['image']) {
    return;
}

// Image
echo $this->el('image', [

    'class' => [
        'el-image',
        'uk-border-{image_border}',
        'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
        'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@image_align: bottom}',
    ],

    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => (bool) $element['image_svg_inline'],
    'thumbnail' => true,

])->render($element);
