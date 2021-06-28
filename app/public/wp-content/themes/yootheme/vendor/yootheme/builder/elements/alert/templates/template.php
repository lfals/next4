<?php

$el = $this->el('div', [

    'class' => [
        'uk-alert',
        'uk-alert-{alert_style}',
        'uk-padding {@alert_size}',
    ],

]);

// Title
$title = $this->el($props['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-display-inline uk-text-middle {@title_inline}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-panel',
        'uk-text-{content_style}',
        'uk-display-inline uk-text-middle {@title_inline}',
        'uk-margin[-{content_margin}]-top {@!content_margin: remove} {@!title_inline}',
    ],

]);

// Link
$link = $props['link'] ? $this->el('a', [

    'class' => [
        'el-link uk-link-reset',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,

]) : null;

?>

<?= $el($props, $attrs) ?>

    <?php if ($props['link']) : ?>
    <?= $link($props) ?>
    <?php endif ?>

        <?php if ($props['title']) : ?>
        <?= $title($props, $props['title']) ?>
        <?php endif ?>

        <?php if ($props['content']) : ?>
        <?= $content($props, $props['content']) ?>
        <?php endif ?>

    <?php if ($props['link']) : ?>
    <?= $link->end() ?>
    <?php endif ?>

<?= $el->end() ?>
