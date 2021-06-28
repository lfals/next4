<?php

$el = $this->el('div');

// Nav
$nav = $this->el('ul', [

    'class' => [
        'uk-margin-remove-bottom',
        'uk-nav uk-nav-{nav_style} [uk-nav-divider {@nav_divider}]',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?= $nav($props) ?>
    <?php foreach ($children as $child) : ?>
    <li class="el-item"><?= $builder->render($child, ['element' => $props]) ?></li>
    <?php endforeach ?>
    </ul>

</div>
