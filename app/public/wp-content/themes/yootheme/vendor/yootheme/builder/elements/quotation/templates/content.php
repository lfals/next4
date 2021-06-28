<?php if ($props['content']) : ?>
<blockquote>

    <?= $props['content'] ?>

    <?php if ($props['footer'] || $props['author']) : ?>
    <footer>

        <?= $props['footer'] ?>

        <?php if ($props['author'] && $props['link']) : ?>
        <cite><a href="<?= $props['link'] ?>"><?= $props['author'] ?></a></cite>
        <?php elseif ($props['author']) : ?>
        <cite><?= $props['author'] ?></cite>
        <?php endif ?>

    </footer>
    <?php endif ?>

</blockquote>
<?php endif ?>
