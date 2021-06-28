<?php if ($props['image']) : ?>
<img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
<?php endif ?>

<?php if ($props['content'] && $props['link']) : ?>
<a href="<?= $props['link'] ?>"><?= $props['content'] ?></a>
<?php elseif ($props['content']) : ?>
<div><?= $props['content'] ?></div>
<?php endif ?>
