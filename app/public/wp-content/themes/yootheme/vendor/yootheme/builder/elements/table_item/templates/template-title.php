<?php

if (!$props['title']) {
    return;
}

// Title
$el = $this->el('div', [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
    ],

]);

if ($element['title_color'] === 'background') {
    $props['title'] = "<span class=\"uk-text-background\">{$props['title']}</span>";
}

echo $el($element, $props['title']);
