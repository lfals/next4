<?php

$el = $this->el('div', [

    'class' => [
        'uk-panel {@!style}',
        'uk-card uk-card-body uk-{style}',
        'tm-child-list [tm-child-list-{list_style}] [uk-link-{link_style}] {@is_list}',
    ],

]);

// Title
$title = $this->el('h3', [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-card-title {@style} {@!title_style}',
        'uk-text-{!title_color: |background}',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?php if ($props['showtitle']) : ?>
        <?= $title($props) ?>
        <?php if ($props['title_color'] == 'background') : ?>
            <span class="uk-text-background"><?= $widget->title ?></span>
        <?php elseif ($props['title_decoration'] == 'line') : ?>
            <span><?= $widget->title ?></span>
        <?php else: ?>
            <?= $widget->title ?>
        <?php endif ?>
        <?= $title->end() ?>
    <?php endif ?>

    <?= $widget->content ?>

</div>
