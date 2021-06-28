<?php

$el = $this->el('blockquote', [

    'class' => [
        'uk-margin-remove {position: absolute}',
    ],

]);

// Link
$link = $this->el('a', [

    'class' => [
        'uk-link-{link_style}',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
]);

?>

<?= $el($props, $attrs) ?>

    <?= $props['content'] ?>

    <?php if ($props['footer'] || $props['author']) : ?>
    <footer class="el-footer">

        <?= $props['footer'] ?>

        <?php if ($props['author']) : ?>
        <cite class="el-author"><?= $props['link'] ? $link($props, $props['author']) : $props['author'] ?></cite>
        <?php endif ?>

    </footer>
    <?php endif ?>

<?= $el->end() ?>
