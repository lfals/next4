<?php

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

// Image
$image = $this->el('image', [
    'class' => ['el-image'],
    'src' => $props['image'] ?: $props['hover_image'],
    'alt' => $props['image_alt'],
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'uk-cover' => (bool) $props['image_min_height'],
    'thumbnail' => [$props['image_width'], $props['image_height']],
]);

// Hover Image
$image_hover = $props['image'] && $props['hover_image'] ? $this->el('image', [
    'class' => ['el-hover-image'],
    'src' => $props['hover_image'],
    'alt' => true,
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'uk-cover' => true,
    'thumbnail' => [$props['image_width'], $props['image_height']],
]) : null;

// Container
$container = $this->el('div', [
    'class' => ['uk-position-cover'],
]);

// Transition
if (!$props['image_transition'] && $props['hover_image']) {
    $props['image_transition'] = 'fade';
}

$transition = $this->expr([
    'uk-transition-{image_transition}' => !$props['image'] && $props['hover_image'],
    'uk-transition-{image_transition} uk-transition-opaque' => $props['image'] && !$props['hover_image'],
], $props);

// Placeholder and min height
$placeholder = '';

if ($props['image_min_height']) {

    $width = $props['image_width'];
    $height = $props['image_height'];

    /** @var Image $placeholder */
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

    echo $placeholder . ($transition ? $container($props, ['class' => [$transition]], $image($props)) : $image($props));

} else {
    echo $image($props, ['class' => [$transition]]);
}

if ($image_hover) {
    echo $container($props, ['class' => ['uk-transition-{image_transition}']], $image_hover($props));
}
