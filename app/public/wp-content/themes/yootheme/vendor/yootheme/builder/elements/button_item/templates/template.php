<?php

$props['id'] = "js-{$this->uid()}";

// Button
$button = $this->el('a', [

    'class' => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}' => ['button_style' => $props['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
    ], $element),

    'title' => ['{link_title}'],

]);

$button->attr($props['link_target'] == 'modal' ? [
    'href' => ['#{id}'],
    'uk-toggle' => true,
] : [
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,
]);

?>

<?= $button($props) ?>

<?php if ($props['icon']) : ?>

    <?php if ($props['icon_align'] == 'left') : ?>
    <span uk-icon="<?= $props['icon'] ?>"></span>
    <?php endif ?>

    <span class="uk-text-middle"><?= $props['content'] ?></span>

    <?php if ($props['icon_align'] == 'right') : ?>
    <span uk-icon="<?= $props['icon'] ?>"></span>
    <?php endif ?>

<?php else : ?>
<?= $props['content'] ?>
<?php endif ?>

</a>

<?= $this->render("{$__dir}/template-lightbox", compact('props')) ?>
