<?php

// Empty ?
if (!is_active_sidebar($name) or !$config("~theme.{$name}")) {
    return;
}

// Config
$config->addAlias('~section', "~theme.{$name}");

$id = "tm-{$name}";
$class = [$id];
$style = [];
$attrs = [
    'tm-header-transparent' => $config('~section.header_transparent') ? $config('~section.header_transparent') : false,
];
$attrs_overlay = [];
$attrs_container = [];
$attrs_viewport_height = [];
$attrs_image = [];
$attrs_video = [];
$attrs_section = [];
$attrs_placeholder = [];

// Section
$class[] = "uk-section-{$config('~section.style')}";
$class[] = $config('~section.overlap') ? 'uk-section-overlap' : '';
$attrs_section['class'][] = 'uk-section';

// Image
if ($config('~section.image')) {

    $attrs_image = $this->bgImage($config('~section.image'), [
        'width' => $config('~section.image_width'),
        'height' => $config('~section.image_height'),
        'size' => $config('~section.image_size'),
        'position' => $config('~section.image_position'),
        'visibility' => $config('~section.image_visibility'),
        'blend_mode' => $config('~section.media_blend_mode'),
        'background' => $config('~section.media_background'),
        'effect' => $config('~section.image_fixed') ? 'fixed' : false,
    ]);

    // Overlay
    if ($config('~section.media_overlay')) {
        $class[] = 'uk-position-relative';
        $attrs_overlay['style'] = "background-color: {$config('~section.media_overlay')};";
    }

}

// Video
if ($config('~section.video') && !$config('~section.image')) {

    // Settings
    $style[] = $config('~section.media_background') ? "background-color: {$config('~section.media_background')};" : '';
    $attrs_video['class'][] = $config('~section.media_blend_mode') ? "uk-blend-{$config('~section.media_blend_mode')}" : '';

    // Cover
    $class[] = 'uk-cover-container';
    $attrs_video['uk-cover'] = true;

    // Overlay
    $attrs_overlay['style'] = $config('~section.media_overlay') ? "background-color: {$config('~section.media_overlay')};" : '';

    // Video
    $attrs_video['width'] = $config('~section.video_width');
    $attrs_video['height'] = $config('~section.video_height');

    if ($iframe = $this->iframeVideo($config('~section.video'))) {

        $attrs_video['src'] = $iframe;
        $attrs_video['frameborder'] = '0';
        $attrs_video['allowfullscreen'] = true;

        $video = "<iframe{$this->attrs($attrs_video)}></iframe>";

    } else {

        $attrs_video['src'] = $config('~section.video');
        $attrs_video['controls'] = false;
        $attrs_video['loop'] = true;
        $attrs_video['autoplay'] = true;
        $attrs_video['muted'] = true;
        $attrs_video['playsinline'] = true;

        $video = "<video{$this->attrs($attrs_video)}></video>";
    }

} else {
    $video = '';
}

// Text color
if ($config('~section.style') == 'primary' || $config('~section.style') == 'secondary') {
    $class[] = $config('~section.preserve_color') ? 'uk-preserve-color' : '';
} elseif ($config('~section.image') || $video) {
    $class[] = $config('~section.text_color') ? "uk-{$config('~section.text_color')}" : '';
}

// Padding
switch ($config('~section.padding')) {
    case '':
        break;
    case 'none':
        $attrs_section['class'][] = 'uk-padding-remove-vertical';
        break;
    default:
        $attrs_section['class'][] = "uk-section-{$config('~section.padding')}";
}

if ($config('~section.padding') != 'none') {
    if ($config('~section.padding_remove_top')) {
        $attrs_section['class'][] = 'uk-padding-remove-top';
    }
    if ($config('~section.padding_remove_bottom')) {
        $attrs_section['class'][] = 'uk-padding-remove-bottom';
    }
}

// Height Viewport
if ($config('~section.height')) {

    if ($config('~section.height') == 'expand') {
        $attrs_section['uk-height-viewport'] = 'expand: true';
    } else {

        // Vertical alignment
        if ($config('~section.vertical_align')) {
            $attrs_section['class'][] = "uk-flex uk-flex-{$config('~section.vertical_align')}";
            $attrs_viewport_height['class'][] = 'uk-width-1-1';
        }

        $options = ['offset-top: true'];
        switch ($config('~section.height')) {
            case 'percent':
                $options[] = 'offset-bottom: 20';
                break;
            case 'section':
                $options[] = $config('~section.image') ? 'offset-bottom: ! +' : 'offset-bottom: true';
                break;
        }

        $attrs_section['uk-height-viewport'] = implode(';', array_filter($options));

    }

}

// Container and width
switch ($config('~section.width')) {
    case 'default':
        $attrs_container['class'][] = 'uk-container';
        break;
    case 'small':
    case 'large':
    case 'xlarge':
    case 'expand':
        $attrs_container['class'][] = "uk-container uk-container-{$config('~section.width')}";
}

// Make sure overlay and video is always below content
if ($attrs_overlay || $video) {
    $attrs_container['class'][] = $config('~section.width') ? 'uk-position-relative' : 'uk-position-relative uk-panel';
}

// Transparent Placeholder
if ($config('~section.header_transparent') && !$config('~section.header_transparent_noplaceholder')) {
    $attrs_placeholder = ['class' => 'tm-header-placeholder uk-margin-remove-adjacent'];
}

?>

<div<?= $this->attrs(compact('id', 'class', 'style'), $attrs, !$attrs_image ? $attrs_section : []) ?>>

    <?php if ($attrs_image) : ?>
    <div<?= $this->attrs($attrs_image, $attrs_section) ?>>
    <?php endif ?>

        <?= $video ?>

        <?php if ($attrs_overlay) : ?>
        <div class="uk-position-cover"<?= $this->attrs($attrs_overlay) ?>></div>
        <?php endif ?>

        <?php if ($attrs_viewport_height) : ?>
        <div<?= $this->attrs($attrs_viewport_height) ?>>
        <?php endif ?>

            <?php if ($attrs_container) : ?>
            <div<?= $this->attrs($attrs_container) ?>>
            <?php endif ?>

                <?php if ($attrs_placeholder) : ?>
                <div<?= $this->attrs($attrs_placeholder) ?>></div>
                <?php endif ?>

                <?= $view('~theme/templates/position', ['style' => 'grid']) ?>

            <?php if ($attrs_container) : ?>
            </div>
            <?php endif ?>

        <?php if ($attrs_viewport_height) : ?>
        </div>
        <?php endif ?>

    <?php if ($attrs_image) : ?>
    </div>
    <?php endif ?>

</div>
