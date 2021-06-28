<?php

$pagination = $props['pagination'];

$el = $this->el('div');

$list = $this->el('ul', [

    'class' => [
        'uk-pagination uk-margin-remove-bottom',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

    'uk-margin' => true,

]);

?>

<?= $el($props, $attrs) ?>

    <?= $list($props) ?>

    <?php if ($props['pagination_type'] == 'numeric') : ?>

        <?php foreach ($pagination as $key => $page) : ?>
            <?php if ($page->active) : ?>
                <li class="uk-active"><span><?= $page->text ?></span></li>
            <?php elseif ($page->link) : ?>
                <li>
                    <?php if (in_array($key, ['previous', 'next'], true)) : ?>
                        <a href="<?= $page->link ?>" title="<?= $page->text ?>">
                            <span uk-pagination-<?= $key ?>></span>
                        </a>
                    <?php elseif ($page->link) : ?>
                        <a href="<?= $page->link ?>"><?= $page->text ?></a>
                    <?php endif ?>
                </li>
            <?php else : ?>
                <li class="uk-disabled"><span><?= $page->text ?></span></li>
            <?php endif ?>
        <?php endforeach ?>

    <?php else : ?>

        <?php if (isset($pagination['previous'])) : ?>

            <?php if ($props['pagination_space_between']) : ?>
            <li class="uk-margin-auto-right">
            <?php else : ?>
            <li>
            <?php endif ?>

                <a href="<?= $pagination['previous']->link ?>"><span uk-pagination-previous></span> <?= $pagination['previous']->text ?></a>
            </li>

        <?php endif ?>

        <?php if (isset($pagination['next'])) : ?>

            <?php if ($props['pagination_space_between']) : ?>
            <li class="uk-margin-auto-left">
            <?php else : ?>
            <li>
            <?php endif ?>

                <a href="<?= $pagination['next']->link ?>"><?= $pagination['next']->text ?> <span uk-pagination-next></span></a>
            </li>

        <?php endif ?>

    <?php endif ?>

    <?= $list->end() ?>

<?= $el->end() ?>
