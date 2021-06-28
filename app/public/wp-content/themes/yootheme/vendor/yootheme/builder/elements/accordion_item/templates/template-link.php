<?php

if (!$element['show_link'] || !($props['link_text'] || $element['link_text']) || !$props['link']) {
    return;
}

// Link
$link = $this->el('a', [

    'class' => [
        'el-link',
        'uk-{link_style: link-\w+}',
        'uk-button uk-button-{!link_style: |link-\w+} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
    ],

    'href' => $props['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,
]);

$link_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_margin}]-top {@!link_margin: remove}',
    ],

]);

?>

<?= $link_container($element, $link($element, $props['link_text'] ?: $element['link_text'])) ?>

