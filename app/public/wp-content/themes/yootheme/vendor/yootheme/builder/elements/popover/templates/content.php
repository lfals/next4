<?php if ($props['background_image']) : ?>
<img src="<?= $props['background_image'] ?>" alt="<?= $props['background_image_alt'] ?>">
<?php endif ?>

<?php if (count($children) > 1) : ?>
<ul>
    <?php foreach ($children as $child) : ?>
    <li>

        <?= $builder->render($child, ['element' => $props]) ?>

    </li>
    <?php endforeach ?>
</ul>
<?php elseif (count($children) == 1) : ?>
<div>

    <?= $builder->render($children[0], ['element' => $props]) ?>

</div>
<?php endif ?>
