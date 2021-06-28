<?php

$el = $this->el('div', [

    'class' => [
        'uk-child-width-auto',
        $props['grid_column_gap'] == $props['grid_row_gap'] ? 'uk-grid-{grid_column_gap}' : '[uk-grid-column-{grid_column_gap}] [uk-grid-row-{grid_row_gap}]',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

    'uk-countdown' => [
        'date: {date}',
    ],

    'uk-grid' => true,
]);

// Label
$label = $this->el('div', [

    'class' => [
        'uk-countdown-label',
        'uk-text-center',
        'uk-visible@s',
        'uk-margin[-{label_margin}]',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?php foreach (['days', 'hours', 'minutes', 'seconds'] as $unit) : ?>

    <div>

        <div class="uk-countdown-number uk-countdown-<?= $unit ?>"></div>

        <?php if ($props['show_label']) : ?>
            <?= $label($props, $props["label_{$unit}"] ?: ucfirst($unit)) ?>
        <?php endif ?>

    </div>

    <?php if ($props['show_separator'] && $unit !== 'seconds') : ?>
        <div class="uk-countdown-separator">:</div>
    <?php endif ?>

    <?php endforeach ?>

</div>
