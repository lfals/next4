<?php

// Resets
if (!$props['image']) {
    $props['media_overlay'] = false;
    $props['media_overlay_gradient'] = false;
}

// Cell
$el = $this->el('div', [

    'class' => [

        // Match child height
        // Can't use `uk-flex` and `uk-width-1-1` instead of `uk-grid-item-match` because it doesn't work with grid divider (it removes the ::before)
        'uk-grid-item-match' => $props['vertical_align'] || $props['style'] || $props['image'] || (!empty($props['element_absolute']) && !($props['style'] || $props['image'])),

        // Vertical alignment
        'uk-flex-{vertical_align} {@!style} {@!image}',

        // Text color
        'uk-{text_color}' => !$props['style'] || $props['image'],

        // Breakpoint widths
        'uk-width-{width_default}',
        'uk-width-{width_small}@s',
        'uk-width-{width_medium}@m',
        'uk-width-{width_large}@l',
        'uk-width-{width_xlarge}@xl',

        // Order first
        'uk-flex-first {@order_first: xs}',
        'uk-flex-first@{order_first} {@!order_first: xs}',

    ],

]);

// Overlay
$overlay = $props['image'] && ($props['media_overlay'] || $props['media_overlay_gradient'])
    ? $this->el('div', [
        'class' => ['uk-position-cover'],
        'style' => [
            'background-color: {media_overlay};',
            // `background-clip` fixes sub-pixel issue
            'background-image: {media_overlay_gradient}; background-clip: padding-box',
        ],
    ]) : null;

// Tile
$tile = $props['style'] || $props['image']
    ? $this->el('div', [
        'class' => [
            'uk-tile',

            // Needed if height matches parent
            'uk-width-1-1 {@image}',

            // Padding
            'uk-padding-remove {@padding: none}',
            'uk-tile-{!padding: |none}',

            // Vertical alignment
            'uk-flex uk-flex-{vertical_align}',

            // Match child height
            'uk-flex' => $overlay,

        ],

    ]) : null;

$tile_container = $this->el('div', [
    'class' => [
        'uk-tile-{style}',

        // Match child height
        'uk-flex {@image}',

        // Overlay
        'uk-position-relative' => $overlay,

        // Preserve color
        'uk-preserve-color {@style: primary|secondary}' => $props['preserve_color'] || ($props['text_color'] && $props['image']),
    ],
]);

// Image
if ($props['image']) {

    $tile->attr($this->bgImage($props['image'], [
        'width' => $props['image_width'],
        'height' => $props['image_height'],
        'size' => $props['image_size'],
        'position' => $props['image_position'],
        'visibility' => $props['media_visibility'],
        'blend_mode' => $props['media_blend_mode'],
        'background' => $props['media_background'],
        'effect' => $props['image_effect'],
        'parallax_bgx_start' => $props['image_parallax_bgx_start'],
        'parallax_bgy_start' => $props['image_parallax_bgy_start'],
        'parallax_bgx_end' => $props['image_parallax_bgx_end'],
        'parallax_bgy_end' => $props['image_parallax_bgy_end'],
        'parallax_easing' => $props['image_parallax_easing'],
        'parallax_breakpoint' => $props['image_parallax_breakpoint'],
    ]));

}

// Aligned container
// Make sure overlay is always below content
// Extra `div` needed because of of grid padding. Tile already has stacking context.
$container = $props['vertical_align'] || $overlay || !empty($props['element_absolute'])
    ? $this->el('div', [

        'class' => [

            'uk-panel uk-width-1-1',

        ],

    ]) : null;

?>

<?= $el($props, $attrs) ?>

    <?php if ($tile) : ?>
    <?= $tile_container($props, !$props['image'] ? $tile->attrs : []) ?>
    <?php endif ?>

        <?php if ($props['image']) : ?>
        <?= $tile($props) ?>
        <?php endif ?>

            <?php if ($overlay) : ?>
            <?= $overlay($props, '') ?>
            <?php endif ?>

            <?php if ($container) : ?>
            <?= $container($props) ?>
            <?php endif ?>

                <?= $builder->render($children) ?>

            <?php if ($container) : ?>
            </div>
            <?php endif ?>

        <?php if ($props['image']) : ?>
        </div>
        <?php endif ?>

    <?php if ($tile) : ?>
    </div>
    <?php endif ?>

</div>
