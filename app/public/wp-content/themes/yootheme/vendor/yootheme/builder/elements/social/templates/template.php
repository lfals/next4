<?php

$el = $this->el('div');

// Grid
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-auto',
        'uk-flex-column {@grid: vertical}',
        'uk-grid-{grid_gap}',
        'uk-flex-inline', // allow text alignment
    ],

    'uk-grid' => true,

    'uk-toggle' => [
        'cls: uk-flex-column; mode: media; media: @{grid_vertical_breakpoint} {@grid: vertical}',
    ],

]);

?>

<?= $el($props, $attrs) ?>
    <?= $grid($props) ?>

    <?php foreach ($children as $child) : ?>
        <div><?= $builder->render($child, ['element' => $props]) ?></div>
    <?php endforeach ?>

    <?= $grid->end() ?>
<?= $el->end() ?>
