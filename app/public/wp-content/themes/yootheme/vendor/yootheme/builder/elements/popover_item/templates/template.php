<?php

// Display
foreach (['title', 'meta', 'content', 'image', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

// Resets
if ($element['card_link']) {
    $element['title_link'] = '';
    $element['image_link'] = '';
}

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));

// Item
$el = $this->el($props['link'] && $element['card_link'] ? 'a' : 'div', [
    'class' => [
        'el-item',
        'uk-card uk-card-{card_style}',
        'uk-card-{card_size}',
        'uk-card-hover {@link_type: element}' => $props['link'],
        'uk-card-body' => !($props['image'] && $element['image_card_padding']),
        'uk-margin-remove-first-child' => !($props['image'] && $element['image_card_padding']),
    ],
]);

// Content
$content = $this->el('div', [

    'class' => [
        'uk-card-body uk-margin-remove-first-child' => $props['image'] && $element['image_card_padding'],
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($props['image'] && $element['image_card_padding']) {
    $props['image'] = $this->el('div', ['class' => [
        'uk-card-media-top',
    ]], $props['image'])->render($element);
}

?>

<?= $el($element) ?>

    <?= $props['image'] ?>

    <?php if ($this->expr($content->attrs['class'], $element)) : ?>
        <?= $content($element, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
    <?php else : ?>
        <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
    <?php endif ?>

<?= $el->end() ?>
