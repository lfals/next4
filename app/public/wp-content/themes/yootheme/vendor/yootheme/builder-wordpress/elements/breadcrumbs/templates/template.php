<?php

namespace YOOtheme;

$items = $props['items'];

$el = $this->el('div');

$list = $this->el('ul', [

    'class' => [
        'uk-breadcrumb uk-margin-remove-bottom',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

]);

?>

<?php if ($items) : ?>

    <?= $el($props, $attrs) ?>

        <?= $list($props) ?>

        <?php foreach ($items as $i => $item) : ?>

            <?php if (!empty($item->link)) : ?>
                <li><a href="<?= $item->link ?>"><?= $item->name ?></a></li>
            <?php else : ?>
                <li><span><?= $item->name ?></span></li>
            <?php endif ?>

        <?php endforeach ?>

        <?= $list->end() ?>

    <?= $el->end() ?>

<?php endif ?>
