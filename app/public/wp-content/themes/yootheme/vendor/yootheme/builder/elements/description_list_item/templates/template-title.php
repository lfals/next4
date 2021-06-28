<?php

if (!$props['title']) {
    return;
}

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title uk-margin-remove',
        'uk-{title_style}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
    ],

]);

// Leader
if ($element['title_leader'] && $element['layout'] == 'grid-2-m' && $element['title_grid_width'] == 'expand') {
    $title->attr('uk-leader', $element['title_grid_breakpoint'] ? ['media: @{title_grid_breakpoint}'] : true);
}

// Color
if ($element['title_color'] == 'background') {
    $props['title'] = "<span class=\"uk-text-background\">{$props['title']}</span>";
}

// Colon
if ($element['title_colon']) {
    $props['title'] .= ':';
}

?>

<?php if ($props['title']) : ?>
<?= $title($element, $props['title']) ?>
<?php endif ?>
