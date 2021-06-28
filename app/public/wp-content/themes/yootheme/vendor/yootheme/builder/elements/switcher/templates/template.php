<?php

$props['connect'] = "js-{$this->uid()}";

$el = $this->el('div');

// Nav Alignment
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['switcher_grid_column_gap'] == $props['switcher_grid_row_gap'] ? 'uk-grid-{switcher_grid_column_gap}' : '[uk-grid-column-{switcher_grid_column_gap}] [uk-grid-row-{switcher_grid_row_gap}]',
        'uk-flex-middle {@switcher_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-{switcher_grid_width}@{switcher_grid_breakpoint}',
        'uk-flex-last@{switcher_grid_breakpoint} {@switcher_position: right}',
    ],

]);

// Content
$content = $this->el('ul', [
    'id' => ['{connect}'],
    'class' => 'uk-switcher',
    'uk-height-match' => ['row: false {@switcher_height}'],
]);

?>

<?= $el($props, $attrs) ?>

    <?php if (in_array($props['switcher_position'], ['left', 'right'])) : ?>

        <?= $grid($props) ?>
            <?= $cell($props, $this->render("{$__dir}/template-nav", compact('props'))) ?>
            <div>

                <?= $content($props) ?>
                    <?php foreach ($children as $child) :

                        $content_item = $this->el('li', [

                            'class' => [
                                'el-item',
                                'uk-margin-remove-first-child' => !$child->props['image'] || !in_array($props['image_align'], ['left', 'right']),
                            ],

                        ]);

                    ?>
                    <?= $content_item($props) ?>
                        <?= $builder->render($child, ['element' => $props]) ?>
                    <?= $content_item->end() ?>
                    
                    <?php endforeach ?>
                <?= $content->end() ?>

            </div>
        </div>

    <?php else : ?>

        <?= $props['switcher_position'] == 'top' ? $this->render("{$__dir}/template-nav", compact('props')) : '' ?>

        <?= $content($props) ?>

            <?php foreach ($children as $child) :

                $content_item = $this->el('li', [

                    'class' => [
                        'el-item',
                        'uk-margin-remove-first-child' => !$child->props['image'] || !in_array($props['image_align'], ['left', 'right']),
                    ],

                ]);

            ?>
            <?= $content_item($props) ?>
                <?= $builder->render($child, ['element' => $props]) ?>
            <?= $content_item->end() ?>
            <?php endforeach ?>
            
        <?= $content->end() ?>

        <?= $props['switcher_position'] == 'bottom' ? $this->render("{$__dir}/template-nav", compact('props')) : '' ?>

    <?php endif ?>

</div>
