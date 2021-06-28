<?php

$props['link_text'] = $props['link_text'] ?: $element['link_text'];

if (!$props['link'] || !$props['link_text']) {
    return;
}

// Link
$el = $this->el('a', [

    'class' => [
        'el-link',
        'uk-{link_style: link-\w+}',
        'uk-button uk-button-{!link_style: |link-\w+} [uk-button-{link_size}]',
        '{0} {@!link_style: |text|link-\w+} {@link_fullwidth}' => $element['table_responsive'] == 'responsive' ? 'uk-width-auto uk-width-1-1@m' : 'uk-width-1-1',
    ],

    'href' => $props['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,
]);

echo $el($element, $props['link_text']);
