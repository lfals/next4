<?php

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

$el = $this->el($props['link'] && $element['overlay_link'] ? 'a' : 'div', [

    'class' => [
        'uk-cover-container',
        'uk-transition-toggle' => $isTransition = $element['overlay_hover'] || $element['image_transition'],
    ],

    'style' => [
        'background-color: ' . $props['media_background'] . ';' => $props['media_background'],
    ],

    'tabindex' => $isTransition ? 0 : null,
]);

$overlay = $this->el('div', [

    'class' => [
        'uk-{overlay_style}',
        'uk-transition-{overlay_transition} {@overlay_hover} {@overlay_cover}',

        'uk-position-cover {@overlay_cover}',
        'uk-position-{overlay_margin} {@overlay_cover}',
    ],

]);

$content = $this->el('div', [

    'class' => [
        $element['overlay_style'] ? 'uk-overlay' : 'uk-panel',
        'uk-padding {@!overlay_padding} {@!overlay_style}',
        'uk-padding-{!overlay_padding: |none}',
        'uk-padding-remove {@overlay_padding: none} {@overlay_style}',
        'uk-width-{overlay_maxwidth} {@!overlay_position: top|bottom}',
        'uk-position-{!overlay_position: .*center.*} [uk-position-{overlay_margin} {@overlay_style}]',

        'uk-transition-{overlay_transition} {@overlay_hover}' => !$element['overlay_transition_background'] || !$element['overlay_cover'],
        'uk-margin-remove-first-child',
    ],

]);

if (!$element['overlay_cover']) {
    $content->attr($overlay->attrs);
}

// Position
$center = $this->el('div', [

    'class' => [
        'uk-position-{overlay_position: .*center.*} [uk-position-{overlay_margin} {@overlay_style}]',
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Helper
$helper_condition_color = !$element['overlay_style'] || $element['overlay_mode'] == 'cover';
$helper_condition_toggle = ($props['text_color_hover'] || $element['text_color_hover']) && ($element['overlay_cover'] && $element['overlay_transition_background']);

$helper = $helper_condition_color || $helper_condition_toggle ? $this->el('div', [

    'class' => [
        // Needed to match helper `dìv` height if height is set to viewport
        'uk-grid-item-match' => $element['slider_width'] && $element['slider_height'],
        // Needs to be parent of `uk-light` or `uk-dark`
        'uk-{0}' => $helper_condition_color
            ? ($props['text_color'] ?: $element['text_color'])
            : false,
    ],

    // Inverse text color on hover
    'uk-toggle' => $helper_condition_toggle
        ? 'cls: uk-light uk-dark; mode: hover'
        : false,

]) : null;

?>

<?php if ($helper) : ?>
<?= $helper($props) ?>
<?php endif ?>

<?= $el($element, $attrs) ?>

        <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
        <div class="uk-position-cover <?= $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '' ?>">
        <?php endif ?>

            <?= $this->render("{$__dir}/template-image", compact('props')) ?>
            <?= $this->render("{$__dir}/template-video", compact('props')) ?>

        <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
        </div>
        <?php endif ?>

        <?php if ($props['media_overlay']) : ?>
        <div class="uk-position-cover" style="background-color:<?= $props['media_overlay'] ?>"></div>
        <?php endif ?>

        <?php if ($element['overlay_cover']) : ?>
        <?= $overlay($element, '') ?>
        <?php endif ?>

        <?php if ($props['title'] || $props['meta'] || $props['content'] || ($props['link'] && ($props['link_text'] || $element['link_text']))) : ?>

            <?php if ($this->expr($center->attrs['class'], $element)) : ?>
            <?= $center($element, $content($element, $this->render("{$__dir}/template-content", compact('props', 'link')))) ?>
            <?php else : ?>
            <?= $content($element, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
            <?php endif ?>

        <?php endif ?>

<?= $el->end() ?>

<?php if ($helper) : ?>
<?= $helper->end() ?>
<?php endif ?>