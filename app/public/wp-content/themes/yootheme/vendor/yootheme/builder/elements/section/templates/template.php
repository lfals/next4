<?php

$props += [
    'media_overlay' => null,
    'media_overlay_gradient' => null,
];

// Resets
if (!($props['image'] || $props['video'])) {
    $props['media_overlay'] = false;
    $props['media_overlay_gradient'] = false;
}
if (!$props['height'] || $props['height'] == 'expand') { $props['vertical_align'] = false; }
if ($props['image']) { $props['video'] = false; }

$el = $this->el('div', $attrs);

$el->attr([

    'class' => [
        'uk-section-{style}',
        'uk-section-overlap {@overlap}',
        'uk-preserve-color {@style: primary|secondary}' => $props['preserve_color'] || ($props['text_color'] && ($props['image'] || $props['video'])),
        'uk-{text_color}' => $props['image'] || $props['video'],
        'uk-position-relative {@image}' => $props['media_overlay'] || $props['media_overlay_gradient'],
        'uk-cover-container {@video}',
    ],

    'style' => ['background-color: {media_background};{@video}'],

    'tm-header-transparent' => ['{header_transparent}'],
]);

if ($props['animation']) {
    $el->attr('uk-scrollspy', [
        'target: [uk-scrollspy-class];',
        'cls: uk-animation-{animation};',
        'delay: {0};' => $props['animation_delay'] ?: 'false',
    ]);
}

// Section
$attrs_section = [
    'class' => [
        'uk-section',
        'uk-section-{!padding: |none}',
        'uk-padding-remove-vertical {@padding: none}',
        'uk-padding-remove-top {@!padding: none} {@padding_remove_top}',
        'uk-padding-remove-bottom {@!padding: none} {@padding_remove_bottom}',
        'uk-flex [uk-flex-{vertical_align} {@!title}] {@vertical_align}',
    ],
];

// Image
$image = $props['image'] ? $this->el('div', $this->bgImage($props['image'], [
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
])) : null;

// Video
$props['video'] = $this->render("{$__dir}/template-video");

// Height Viewport
$attrs_section['uk-height-viewport'] = $props['height'] == 'expand'
    ? 'expand: true;'
    : ($props['height']
        ? [
            'offset-top: true;',
            'offset-bottom: {0};' => $props['height'] == 'percent'
                ? '20'
                : ($props['height'] == 'section'
                    ? ($props['image'] ? '! +' : 'true')
                    : false),
        ]
        : false);

$overlay = ($props['media_overlay'] || $props['media_overlay_gradient']) && ($props['image'] || $props['video'])
    ? $this->el('div', [
        'class' => ['uk-position-cover'],
        'style' => [
            'background-color: {media_overlay};',
            // `background-clip` fixes sub-pixel issue
            'background-image: {media_overlay_gradient}; background-clip: padding-box',
        ],
    ]) : null;

$container = $props['width'] || $props['video'] || $overlay
    ? $this->el('div', ['class' => [
        'uk-container {@width}',
        'uk-container-{width: xsmall|small|large|xlarge|expand}',
        'uk-padding-remove-horizontal {@padding_remove_horizontal} {@width} {@!width:expand}',
        'uk-container-expand-{width_expand} {@width} {@!width:expand}',

        // Make sure overlay and video is always below content
        'uk-position-relative [{@!width} uk-panel]' => $overlay || $props['video'],
    ],
    ]) : null;

$title = $this->el('div', [
    'class' => [
        'tm-section-title',
        'uk-position-{title_position} uk-position-medium',
        !in_array($props['title_position'], ['center-left', 'center-right']) ? 'uk-margin-remove-vertical' : 'uk-text-nowrap',
        'uk-visible@{title_breakpoint}',
    ],
]);

$placeholder = $props['header_transparent'] && !$props['header_transparent_noplaceholder']
    ? $this->el('div', ['class' => 'tm-header-placeholder uk-margin-remove-adjacent'])
    : null;

?>

<?= $el($props, !$image ? $attrs_section : []) ?>

    <?php if ($props['image']) : ?>
    <?= $image($props, $attrs_section) ?>
    <?php endif ?>

        <?= $props['video'] ?>

        <?php if ($overlay) : ?>
        <?= $overlay($props, '') ?>
        <?php endif ?>

        <?php if ($props['title']) : ?>
        <?= $this->el('div', ['class' => [
            'uk-position-relative',
            'uk-width-1-1 uk-flex uk-flex-{vertical_align}',
        ]])->render($props) ?>
        <?php endif ?>

            <?php if ($props['vertical_align']) : ?>
            <div class="uk-width-1-1">
            <?php endif ?>

                <?php if ($container) : ?>
                <?= $container($props) ?>
                <?php endif ?>

                    <?php if ($placeholder) : ?>
                    <?= $placeholder($props, '') ?>
                    <?php endif ?>

                    <?= $builder->render($children) ?>

                <?php if ($container) : ?>
                </div>
                <?php endif ?>

            <?php if ($props['vertical_align']) : ?>
            </div>
            <?php endif ?>

        <?php if ($props['title']) : ?>
            <?= $title($props) ?>
                <div class="<?= $props['title_rotation'] == 'left' ? 'tm-rotate-180' : '' ?>"><?= $props['title'] ?></div>
            </div>
        </div>
        <?php endif ?>

    <?php if ($props['image']) : ?>
    </div>
    <?php endif ?>

</div>
