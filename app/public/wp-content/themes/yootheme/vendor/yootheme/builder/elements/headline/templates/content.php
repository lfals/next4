<?php if ($props['content'] && $props['link']) : ?>
<<?= $props['title_element'] ?>><a href="<?= $props['link'] ?>"><?= $props['content'] ?></a></<?= $props['title_element'] ?>>
<?php elseif ($props['content']) : ?>
<<?= $props['title_element'] ?>><?= $props['content'] ?></<?= $props['title_element'] ?>>
<?php endif ?>