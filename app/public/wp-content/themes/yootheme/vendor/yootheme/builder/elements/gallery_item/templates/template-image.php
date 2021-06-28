<?php

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

$image = $this->el('image', [
    'class' => ['el-image'],
    'src' => $props['image'] ?: $props['hover_image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => (bool) $element['image_min_height'],
    'thumbnail' => [$element['image_width'], $element['image_height'], $element['image_orientation']],
]);

// Hover Image
$image_hover = $props['image'] && $props['hover_image'] ? $this->el('image', [
    'class' => ['el-hover-image'],
    'src' => $props['hover_image'],
    'alt' => true,
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => true,
    'thumbnail' => [$element['image_width'], $element['image_height'], $element['image_orientation']],
]) : null;

// Container
$container = $this->el('div', [
    'class' => ['uk-position-cover'],
]);

// Transition
if (!$element['image_transition'] && $props['hover_image']) {
    $element['image_transition'] = 'fade';
}

$transition = $this->expr([
    'uk-transition-{image_transition}' => !$props['image'] && $props['hover_image'],
    'uk-transition-{image_transition} uk-transition-opaque' => $props['image'] && !$props['hover_image'],
], $element);

// Placeholder and min height
$placeholder = '';

if ($element['image_min_height']) {

    $width = $element['image_width'];
    $height = $element['image_height'];

    if ((!$width || !$height) and $placeholder = $imageProvider->create($props['image'], false)) {

        if ($width || $height) {
            $placeholder = $placeholder->thumbnail($width, $height);
        }

        $width = $placeholder->getWidth();
        $height = $placeholder->getHeight();
    }

    if ($width && $height) {
        $placeholder = "<canvas width=\"{$width}\" height=\"{$height}\"></canvas>";
    }

    echo $placeholder . ($transition ? $container($element, ['class' => [$transition]], $image($element)) : $image($element));

} else {
    echo $image($element, ['class' => [$transition]]);
}

if ($image_hover) {
    echo $container($element, ['class' => ['uk-transition-{image_transition}']], $image_hover($element));
}
