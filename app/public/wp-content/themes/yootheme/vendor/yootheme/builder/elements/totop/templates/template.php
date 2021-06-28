<?php

$el = $this->el('div');

// Link
$link = $this->el('a', [
    'href' => '#', // WordPress Preview reloads if `href` is empty
    'title' => ['{link_title}'],
    'uk-totop' => true,
    'uk-scroll' => true,
]);

// Title
$title = $this->el('div', [

    'class' => [
        'el-title',
        'uk-text-{title_style}',
    ],

]);

// Grid
$grid = $this->el('div', [
    'class' => [
        'uk-child-width-expand[@{title_grid_breakpoint}]',
        $props['title_grid_column_gap'] == $props['title_grid_row_gap'] ? 'uk-grid-{title_grid_column_gap}' : '[uk-grid-column-{title_grid_column_gap}] [uk-grid-row-{title_grid_row_gap}]',
        'uk-flex-inline uk-flex-middle',
    ],
    'uk-grid' => true,
]);

$cell_title = $this->el('div', [
    'class' => [
        'uk-flex-first[@{title_grid_breakpoint}] uk-width-auto[@{title_grid_breakpoint}]',
    ],
]);

?>

<?php if ($props['title']) : ?>
<?= $el($props, $attrs) ?>
    <?= $grid($props) ?>
        <div>
            <?= $link($props, '') ?>
        </div>
        <?= $cell_title($props) ?>
            <?= $title($props, $props['title']) ?>
        <?= $cell_title->end() ?>
    <?= $grid->end() ?>
<?= $el->end() ?>
<?php else : ?>
<?= $el($props, $attrs, $link($props, '')) ?>
<?php endif ?>
