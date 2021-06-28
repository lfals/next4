<?php

$el = $this->el($props['list_element'], [

    'class' => [
        'uk-list',
        'uk-list-{list_marker}',
        'uk-list-{list_marker_color}',
        'uk-list-{list_style}',
        'uk-list-{list_size}',
        'uk-column-{column}[@{column_breakpoint}]',
        'uk-column-divider {@column} {@column_divider}',
        'uk-margin-remove {position: absolute}',
    ],

]);

?>

<?= $el($props, $attrs) ?>
    <?php foreach ($children as $child) : ?>
    <li class="el-item"><?= $builder->render($child, ['element' => $props]) ?></li>
    <?php endforeach ?>
<?= $el->end() ?>
