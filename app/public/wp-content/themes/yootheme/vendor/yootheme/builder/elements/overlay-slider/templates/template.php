<?php

// Resets
if ($props['overlay_link']) { $props['title_link'] = ''; }

// New logic shortcuts
$props['overlay_cover'] = $props['overlay_style'] && $props['overlay_mode'] == 'cover';

$el = $this->el('div', [

    'uk-slider' => $this->expr([
        'sets: {slider_sets};',
        'center: {slider_center};',
        'finite: {slider_finite};',
        'velocity: {slider_velocity};',
        'autoplay: {slider_autoplay}; [pauseOnHover: false; {@!slider_autoplay_pause}] [autoplayInterval: {slider_autoplay_interval}000;]',
    ], $props) ?: true,

]);

// Slider Items
$slider_items = $this->el('ul', [

    'class' => [
        'uk-slider-items',
        'uk-grid [uk-grid-{!slider_gap: default}] {@slider_gap}',
        'uk-grid-divider {@slider_gap} {@slider_divider}',
        'uk-grid-match {@slider_width} {@slider_height}',
    ],

    // Height Viewport
    'uk-height-viewport' => $props['slider_width'] && $props['slider_height'] ? [
        'offset-top: true;',
        'minHeight: {slider_min_height};',
        'offset-bottom: 20; {@slider_height: percent}',
        'offset-bottom: !.uk-section +; {@slider_height: section}',
    ] : false,

]);

$slider_item = $this->el('li', [

    'class' => [
        'el-item',
        'uk-width-{slider_width_default} {@slider_width}',
        'uk-width-{slider_width_small}@s {@slider_width}',
        'uk-width-{slider_width_medium}@m {@slider_width}',
        'uk-width-{slider_width_large}@l {@slider_width}',
        'uk-width-{slider_width_xlarge}@xl {@slider_width}',
    ],

]);

// Container
$container = $this->el('div', [

    'class' => [
        'uk-position-relative',
        'uk-visible-toggle {@slidenav} {@slidenav_hover}',
    ],

    'tabindex' => ['-1 {@slidenav} {@slidenav_hover}'],

]);

?>

<?= $el($props, $attrs) ?>

    <?= $container($props) ?>

        <?php if ($props['slidenav'] == 'outside') : ?>
        <div class="uk-slider-container">
        <?php endif ?>

            <?= $slider_items($props) ?>
                <?php foreach ($children as $child) : ?>
                <?= $slider_item($props, $builder->render($child, ['element' => $props])) ?>
                <?php endforeach ?>
            </ul>

        <?php if ($props['slidenav'] == 'outside') : ?>
        </div>
        <?php endif ?>

        <?php if ($props['slidenav']) : ?>
        <?= $this->render("{$__dir}/template-slidenav") ?>
        <?php endif ?>

    </div>

    <?php if ($props['nav']): ?>
    <?= $this->render("{$__dir}/template-nav") ?>
    <?php endif ?>

</div>
