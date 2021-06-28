<?php

$el = $this->el('div', [

    'class' => [
        'uk-position-relative',
        'uk-position-z-index',
    ],

    'uk-height-viewport' => $props['viewport_height'] ? [
        'offset-top: true;',
        'offset-bottom: 20; {@viewport_height: percent}',
        'offset-bottom: !.uk-section +; {@viewport_height: section}',
    ] : false,

    'style' => !$props['viewport_height'] ? [
        'width: {width}px {@!width_breakpoint}',
        'height: {height}px {@!width}',
    ] : false,

    'uk-responsive' => !$props['viewport_height'] ? [
        'width: {width}; height: {height}',
    ] : false,

    'uk-map' => true,

]);

$script = $this->el('script', ['type' => 'application/json'], json_encode($options));

// Width and Height
$props['width'] = trim($props['width'], 'px');
$props['height'] = trim($props['height'] ?: '300', 'px');

?>

<?= $el($props, $attrs) ?>
    <?= $script() ?>
    <?php foreach ($children as $child) : ?>
        <?php if (!empty($child->props['show'])) : ?>
        <template>
            <?= $builder->render($child, ['element' => $props]) ?>
        </template>
        <?php endif ?>
    <?php endforeach ?>
<?= $el->end() ?>
