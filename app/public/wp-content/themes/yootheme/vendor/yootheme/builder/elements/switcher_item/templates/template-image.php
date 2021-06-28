<?php

if (!$props['image']) {
    return;
}

$image = $this->el('image', [

    'class' => [
        'el-image',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
        'uk-box-shadow-hover-{image_hover_box_shadow} {@link}',
        'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
        'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration} {@image_align: bottom}',
    ],

    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-img' => 'target: !.uk-switcher',
    'uk-svg' => $element['image_svg_inline'],
    'thumbnail' => true,
]);

$props['image'] = $image($element);

// Box decoration
if ($element['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@image_align: bottom}',
        ],

    ]);

    $props['image'] = $decoration($element, $props['image']);
}

echo $props['image'];
