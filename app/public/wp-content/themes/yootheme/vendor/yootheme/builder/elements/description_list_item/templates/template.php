<?php

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

// Layout
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-{0}[@{title_grid_breakpoint}]' => $element['title_grid_width'] == 'expand' ? 'auto' : 'expand',
        $element['title_grid_column_gap'] == $element['title_grid_row_gap'] ? 'uk-grid-{title_grid_column_gap}' : '[uk-grid-column-{title_grid_column_gap}] [uk-grid-row-{title_grid_row_gap}]',
        $element['layout'] == 'grid-2-m'
            ? $element['title_leader'] && $element['title_grid_width'] == 'expand'
                ? 'uk-flex-bottom'
                : 'uk-flex-middle'
            : '',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-{title_grid_width}[@{title_grid_breakpoint}]',
        'uk-text-break {@title_grid_width: small|medium}',
    ],

]);

?>

<?php if ($element['layout'] == 'stacked') : ?>

    <?php if ($element['meta_align'] == 'above-title') : ?>
    <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
    <?php endif ?>

    <?= $this->render("{$__dir}/template-title", compact('props')) ?>

    <?php if (in_array($element['meta_align'], ['below-title', 'above-content'])) : ?>
    <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
    <?php endif ?>

    <?= $this->render("{$__dir}/template-content", compact('props')) ?>

    <?php if ($element['meta_align'] == 'below-content') : ?>
    <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
    <?php endif ?>

<?php elseif ($element['layout'] == 'grid-2') : ?>

    <?= $grid($element) ?>
        <?= $cell($element) ?>

            <?php if ($element['meta_align'] == 'above-title') : ?>
            <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
            <?php endif ?>

            <?= $this->render("{$__dir}/template-title", compact('props')) ?>

            <?php if ($element['meta_align'] == 'below-title') : ?>
            <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
            <?php endif ?>

        </div>
        <div>

            <?php if ($element['meta_align'] == 'above-content') : ?>
            <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
            <?php endif ?>

            <?= $this->render("{$__dir}/template-content", compact('props')) ?>

            <?php if ($element['meta_align'] == 'below-content') : ?>
            <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
            <?php endif ?>

        </div>
    </div>

<?php else : ?>

    <?= $grid($element) ?>
        <?= $cell($element) ?>
            <?= $this->render("{$__dir}/template-title", compact('props')) ?>
        </div>
        <div>
            <?= $this->render("{$__dir}/template-meta", compact('props')) ?>
        </div>
    </div>

    <?= $this->render("{$__dir}/template-content", compact('props')) ?>

<?php endif ?>
