<?php

// Marker
$marker = $this->el('a', [

    'class' => 'el-marker uk-position-absolute uk-transform-center',

    'style' => [
        'top: {0};' => (is_numeric(rtrim($props['position_y'], '%')) ? (float) $props['position_y'] : 50) . '%',
        'left: {0};' => (is_numeric(rtrim($props['position_x'], '%')) ? (float) $props['position_x'] : 50) . '%',
    ],

    'href' => '#', // WordPress Preview reloads if `href` is empty
    'uk-marker' => true,
]);

// Drop
$drop = $this->el('div', [

    'style' => [
        'width: {0}px;' => rtrim($element['drop_width'], 'px') ?: 300,
    ],

    'uk-drop' => [
        'pos: {0};' => $props['drop_position'] ?: $element['drop_position'],
        'mode: click;' => $element['drop_mode'] == 'click',
    ],

]);

echo $marker($element, '') . $drop($element, $builder->render($child));
