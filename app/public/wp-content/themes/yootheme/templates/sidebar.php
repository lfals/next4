<?php

// Config
$config->addAlias('~sidebar', '~theme.main_sidebar');

// Attrs
$id = 'tm-sidebar';
$class = ["tm-sidebar uk-width-{$config('~sidebar.width')}@{$config('~sidebar.breakpoint')}"];

if ($config('~sidebar.first')) {
    $class[] = "uk-flex-first@{$config('~sidebar.breakpoint')}";
}

?>

<aside<?= $this->attrs(compact('id', 'class')) ?>>
    <?php dynamic_sidebar("sidebar:grid-stack") ?>
</aside>
