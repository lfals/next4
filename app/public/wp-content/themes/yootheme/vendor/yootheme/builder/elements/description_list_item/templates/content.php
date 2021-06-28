<?php if ($props['title']) : ?>
<h3><?= $props['title'] ?></h3>
<?php endif ?>

<?php if ($props['meta']) : ?>
<p><?= $props['meta'] ?></p>
<?php endif ?>

<?php if ($props['content'] && $props['link']) : ?>
<a href="<?= $props['link'] ?>"><?= $props['content'] ?></a>
<?php elseif ($props['content']) : ?>
<div><?= $props['content'] ?></div>
<?php endif ?>
