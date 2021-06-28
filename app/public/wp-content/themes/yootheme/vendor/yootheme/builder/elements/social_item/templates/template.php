<?php

$image = $props['image'] ? $this->el('image', [
    'src' => $props['image'],
    'alt' => true,
    'width' => $element['icon_width'] ?: 20,
    'height' => $element['icon_width'] ?: 20,
    'uk-svg' => true,
    'thumbnail' => true,
]) : null;

// Icon
$icon = $this->el('a', [

    'class' => [
        'el-link',
        'uk-icon-link {@!link_style}',
        'uk-icon-button {@link_style: button}',
        'uk-link-{link_style: muted|text|reset}',
    ],

    'href' => $props['link'],
    'target' => ['_blank {@link_target}'],
    'rel' => 'noreferrer',

]);

if (!$props['image']) {

    $icon->attr([
        'uk-icon' => [
            'icon: {0};' => $props['icon'] ?: $this->e($props['link'], 'social'),
            'width: {icon_width};',
            'height: {icon_width};',
        ],
    ]);

}

?>

<?= $icon($element) ?>
<?= $image ?>
<?= $icon->end() ?>