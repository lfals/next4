<ul>
    <?php foreach ($children as $child) : ?>
    <li><?= $builder->render($child, ['element' => $props]) ?></li>
    <?php endforeach ?>
</ul>
