<?php if ($props['title'] || $props['content']) : ?>
<div>

    <?php if ($props['title'] && $props['link']) : ?>
    <<?= $props['title_element'] ?>><a href="<?= $props['link'] ?>"><?= $props['title'] ?></a></<?= $props['title_element'] ?>>
    <?php elseif ($props['title']) : ?>
    <<?= $props['title_element'] ?>><?= $props['title'] ?></<?= $props['title_element'] ?>>
    <?php endif ?>

    <?php if ($props['content']) : ?>
    <div><?= $props['content'] ?></div>
    <?php endif ?>

</div>
<?php endif ?>
