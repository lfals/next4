<?php

$el = $this->el('div');

// Icon
$icon = $this->el('span', [

    'class' => [
        'uk-text-{icon_color} {@!link}',
    ],

    'uk-icon' => [
        'icon: {icon};',
        'width: {icon_width}; height: {icon_width}; {@!link_style: button}',
    ],

], '');

// Link
$link = [

    'class' => [
        'uk-icon-link {@!link_style}',
        'uk-icon-button {@link_style: button}',
        'uk-link-{link_style: muted|text|reset}',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,

];

echo $el($props, $attrs, $props['link'] ? $icon($props, $link, '', 'a') : $icon($props));
