<?php

// Config
$config->addAlias('~site', '~theme.site');
$config->addAlias('~mobile', '~theme.mobile');

$outside = $config('~site.layout') == 'boxed' && $config('~site.boxed.header_outside');
$outside_transparent = $config('~site.toolbar_transparent') && $config('~site.boxed.header_transparent');

$attrs_toolbar = [];
$attrs_toolbar['class'][] = 'tm-toolbar';
$attrs_toolbar['class'][] = $outside && $outside_transparent ? "uk-{$config('~site.boxed.header_transparent')}" : 'tm-toolbar-default';
$attrs_toolbar['class'][] = !$outside && $config('~site.toolbar_transparent') ? 'tm-toolbar-transparent' : '';
$attrs_toolbar['class'][] = 'uk-visible@'.$config('~mobile.breakpoint');

// Width Container
$attrs_width_container = [];
$attrs_width_container['class'][] = 'uk-container uk-flex uk-flex-middle';

if ($outside) {
    $attrs_width_container['class'][] = $config('~site.toolbar_width') == 'expand' ? 'uk-container-expand' : 'tm-page-width';
} else {
    $attrs_width_container['class'][] = $config('~site.toolbar_width') != 'default' ? "uk-container-{$config('~site.toolbar_width')}" : '';
}

$attrs_width_container['class'][] = $config('~site.toolbar_center') ? 'uk-flex-center' : '';

?>

<div<?= $this->attrs($attrs_toolbar) ?>>
    <div<?= $this->attrs($attrs_width_container) ?>>

        <?php if (is_active_sidebar('toolbar-left') || ($config('~site.toolbar_center') && is_active_sidebar('toolbar-right'))) : ?>
        <div>
            <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">

                <?php if (is_active_sidebar('toolbar-left')) : ?>
                <?php dynamic_sidebar("toolbar-left:cell") ?>
                <?php endif ?>

                <?php if ($config('~site.toolbar_center') && is_active_sidebar('toolbar-right')) : ?>
                <?php dynamic_sidebar("toolbar-right:cell") ?>
                <?php endif ?>

            </div>
        </div>
        <?php endif ?>

        <?php if (!$config('~site.toolbar_center') && is_active_sidebar('toolbar-right')) : ?>
        <div class="uk-margin-auto-left">
            <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">
                <?php dynamic_sidebar("toolbar-right:cell") ?>
            </div>
        </div>
        <?php endif ?>

    </div>
</div>
