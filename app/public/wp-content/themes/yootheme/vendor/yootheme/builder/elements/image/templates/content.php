<?php if ($props['image'] && $props['link']) : ?>
<a href="<?= $props['link'] ?>"><img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>"></a>
<?php elseif ($props['image']) : ?>
<img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
<?php endif ?>