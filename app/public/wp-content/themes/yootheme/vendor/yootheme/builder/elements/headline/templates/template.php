<?php

$el = $this->el($props['title_element'], [

    'class' => [
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin-remove {position: absolute}',
    ],

]);

// Link
$link = $props['link'] ? $this->el('a', [

    'class' => [
        'el-link',
        'uk-link-{0}' => $props['link_style'] ? 'heading' : 'reset',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,

], $props['content']) : null;

?>

<?= $el($props, $attrs) ?>
    <?php if ($props['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $link ? $link($props) : $props['content'] ?></span>
    <?php elseif ($props['title_decoration'] == 'line') : ?>
    <span><?= $link ? $link($props) : $props['content'] ?></span>
    <?php else : ?>
    <?= $link ? $link($props) : $props['content'] ?>
    <?php endif ?>
<?= $el->end() ?>
