<?php

// Config
$config->addAlias('~logo', '~theme.logo');
$config->addAlias('~site', '~theme.site');
$config->addAlias('~header', '~theme.header');
$config->addAlias('~navbar', '~theme.navbar');
$config->addAlias('~mobile', '~theme.mobile');

// Options
$layout = $config('~header.layout');
$logo = $config('~logo.image') || $config('~logo.text') || is_active_sidebar('logo');
$class = array_merge(['tm-header', "uk-visible@{$config('~mobile.breakpoint')}"], isset($class) ? (array) $class : []);
$attrs = array_merge(['uk-header' => true], isset($attrs) ? (array) $attrs : []);
$attrs_sticky = [];

// Navbar Container
$attrs_navbar_container = [];
$attrs_navbar_container['class'][] = 'uk-navbar-container';
$attrs_navbar_container['class'][] = $config('~navbar.style') ? "uk-navbar-{$config('~navbar.style')}" : '';

// Dropdown options
if (!preg_match('/^(offcanvas|modal)/', $layout)) {

    $attrs_navbar = [
        'class' => [
            'uk-navbar',
        ],
        'uk-navbar' => json_encode(array_filter([
            'align' => $config('~navbar.dropdown_align'),
            'boundary' => '!.uk-navbar-container',
            'boundary-align' => $config('~navbar.dropdown_boundary'),
            'dropbar' => $config('~navbar.dropbar') ? true : null,
            'dropbar-anchor' => $config('~navbar.dropbar') ? '!.uk-navbar-container' : null,
            'dropbar-mode' => $config('~navbar.dropbar'),
        ])),
    ];

} else {

    $attrs_navbar = [
        'class' => [
            'uk-navbar',
        ],
        'uk-navbar' => true,
    ];

}

// Sticky
if ($sticky = $config('~navbar.sticky')) {

    $attrs_sticky = array_filter([
        'uk-sticky' => true,
        'media' => "@{$config('~mobile.breakpoint')}",
        'show-on-up' => $sticky == 2,
        'animation' => $sticky == 2 ? 'uk-animation-slide-top' : '',
        'cls-active' => 'uk-navbar-sticky',
        'sel-target' => '.uk-navbar-container',
    ]);

}

// Outside
$outside = $config('~site.layout') == 'boxed' && $config('~site.boxed.header_outside');

if ($outside && $config('~site.boxed.header_transparent')) {

    $class[] = 'tm-header-transparent';

    if ($sticky) {
        $attrs_sticky['cls-inactive'] = "uk-navbar-transparent uk-{$config('~site.boxed.header_transparent')}";
        $attrs_sticky['top'] = '300';
        if ($sticky == 1) {
            $attrs_sticky['animation'] = 'uk-animation-slide-top';
        }
    } else {
        $attrs_navbar_container['class'][] = "uk-navbar-transparent uk-{$config('~site.boxed.header_transparent')}";
    }

}

// Width Container
$attrs_width_container = [];
$attrs_width_container['class'][] = 'uk-container';

if ($outside) {
    $attrs_width_container['class'][] = $config('~header.width') == 'expand' ? 'uk-container-expand' : 'tm-page-width';
} else {
    $attrs_width_container['class'][] = $config('~header.width') != 'default' ? "uk-container-{$config('~header.width')}" : '';
}

?>

<div class="tm-header-mobile uk-hidden@<?= $config('~mobile.breakpoint') ?>">
<?= $view('~theme/templates/header-mobile') ?>
</div>

<?php if (!$config('~site.toolbar_transparent') && (is_active_sidebar('toolbar-left') || is_active_sidebar('toolbar-right'))) : ?>
<?= $view('~theme/templates/toolbar') ?>
<?php endif ?>

<div<?= $this->attrs(['class' => $class], $attrs) ?>>

<?php if ($config('~site.toolbar_transparent') && (is_active_sidebar('toolbar-left') || is_active_sidebar('toolbar-right'))) : ?>
<?= $view('~theme/templates/toolbar') ?>
<?php endif ?>

<?php

/*
 * Horizontal layouts
 */

if (in_array($layout, ['horizontal-left', 'horizontal-center', 'horizontal-right', 'horizontal-center-logo'])) :

    $attrs_width_container['class'][] = $logo && $config('~header.logo_padding_remove') && $config('~header.width') == 'expand' && $layout != 'horizontal-center-logo' ? 'uk-padding-remove-left' : '';

    ?>

    <?php if ($sticky) : ?>
    <div<?= $this->attrs($attrs_sticky) ?>>
    <?php endif ?>

        <div<?= $this->attrs($attrs_navbar_container) ?>>

            <div<?= $this->attrs($attrs_width_container) ?>>
                <nav<?= $this->attrs($attrs_navbar) ?>>

                    <?php if (($logo && $layout != 'horizontal-center-logo') || (in_array($layout, ['horizontal-left', 'horizontal-center-logo']) && is_active_sidebar('navbar'))) : ?>
                    <div class="uk-navbar-left">

                        <?php if ($logo && $layout != 'horizontal-center-logo') : ?>
                            <?= $view('~theme/templates/header-logo', ['class' => 'uk-navbar-item']) ?>
                            <?php if (is_active_sidebar('logo')) : ?>
                                <?php dynamic_sidebar("logo") ?>
                            <?php endif ?>
                        <?php endif ?>

                        <?php if (in_array($layout, ['horizontal-left', 'horizontal-center-logo']) && is_active_sidebar('navbar')) : ?>
                            <?php dynamic_sidebar("navbar") ?>
                        <?php endif ?>

                    </div>
                    <?php endif ?>

                    <?php if (($logo && $layout == 'horizontal-center-logo') || ($layout == 'horizontal-center' && is_active_sidebar('navbar'))) : ?>
                    <div class="uk-navbar-center">

                        <?php if ($logo && $layout == 'horizontal-center-logo') : ?>
                            <?= $view('~theme/templates/header-logo', ['class' => 'uk-navbar-item']) ?>
                            <?php if (is_active_sidebar('logo')) : ?>
                                <?php dynamic_sidebar("logo") ?>
                            <?php endif ?>
                        <?php endif ?>

                        <?php if ($layout == 'horizontal-center' && is_active_sidebar('navbar')) : ?>
                            <?php dynamic_sidebar("navbar") ?>
                        <?php endif ?>

                    </div>
                    <?php endif ?>

                    <?php if (is_active_sidebar('header') || $layout == 'horizontal-right' && is_active_sidebar('navbar')) : ?>
                    <div class="uk-navbar-right">

                        <?php if ($layout == 'horizontal-right' && is_active_sidebar('navbar')) : ?>
                            <?php dynamic_sidebar("navbar") ?>
                        <?php endif ?>

                        <?php dynamic_sidebar("header") ?>

                    </div>
                    <?php endif ?>

                </nav>
            </div>

        </div>

    <?php if ($sticky) : ?>
    </div>
    <?php endif ?>

<?php endif ?>

<?php

/*
 * Stacked Center layouts
 */

if (in_array($layout, ['stacked-center-a', 'stacked-center-b', 'stacked-center-split'])) : ?>

    <?php if ($logo && $layout != 'stacked-center-split' || $layout == 'stacked-center-a' && is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-top<?= $outside && $config('~site.boxed.header_transparent') ? " uk-{$config('~site.boxed.header_transparent')}" : '' ?>">
        <div<?= $this->attrs($attrs_width_container) ?>>

            <?php if ($logo) : ?>
            <div class="uk-text-center">
                <?= $view('~theme/templates/header-logo') ?>
                <?php if (is_active_sidebar('logo')) : ?>
                    <?php dynamic_sidebar("logo") ?>
                <?php endif ?>
            </div>
            <?php endif ?>

            <?php if ($layout == 'stacked-center-a' && is_active_sidebar('header')) : ?>
            <div class="tm-headerbar-stacked uk-grid-medium uk-child-width-auto uk-flex-center uk-flex-middle" uk-grid>
                <?php dynamic_sidebar("header:cell") ?>
            </div>
            <?php endif ?>

        </div>
    </div>
    <?php endif ?>

    <?php if (is_active_sidebar('navbar')) : ?>

        <?php if ($sticky) : ?>
        <div<?= $this->attrs($attrs_sticky) ?>>
        <?php endif ?>

            <div<?= $this->attrs($attrs_navbar_container) ?>>

                <div<?= $this->attrs($attrs_width_container) ?>>
                    <nav<?= $this->attrs($attrs_navbar) ?>>

                        <div class="uk-navbar-center">

                            <?php if ($layout == 'stacked-center-split') : ?>

                                <div class="uk-navbar-center-left uk-preserve-width"><div>
                                    <?php dynamic_sidebar("navbar-split") ?>
                                </div></div>

                                <?= $view('~theme/templates/header-logo', ['class' => 'uk-navbar-item']) ?>
                                <?php if (is_active_sidebar('logo')) : ?>
                                    <?php dynamic_sidebar("logo") ?>
                                <?php endif ?>

                                <div class="uk-navbar-center-right uk-preserve-width"><div>
                                    <?php dynamic_sidebar("navbar") ?>
                                </div></div>

                            <?php else: ?>
                                <?php dynamic_sidebar("navbar") ?>
                            <?php endif ?>

                        </div>

                    </nav>
                </div>

            </div>

        <?php if ($sticky) : ?>
        </div>
        <?php endif ?>

    <?php endif ?>

    <?php if (in_array($layout, ['stacked-center-b', 'stacked-center-split']) && is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-bottom<?= $outside && $config('~site.boxed.header_transparent') ? " uk-{$config('~site.boxed.header_transparent')}" : '' ?>">
        <div<?= $this->attrs($attrs_width_container) ?>>
            <div class="uk-grid-medium uk-child-width-auto uk-flex-center uk-flex-middle" uk-grid>
                <?php dynamic_sidebar("header:cell") ?>
            </div>
        </div>
    </div>
    <?php endif ?>

<?php endif ?>

<?php

/*
 * Stacked Center C layout
 */

if ($layout == 'stacked-center-c') : ?>

    <?php if ($logo || is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-top<?= $outside && $config('~site.boxed.header_transparent') ? " uk-{$config('~site.boxed.header_transparent')}" : '' ?>">
        <div<?= $this->attrs($attrs_width_container) ?>>
            <div class="uk-position-relative uk-flex uk-flex-center uk-flex-middle">

                <?php if (is_active_sidebar('header')) : ?>
                <div class="uk-position-center-left">
                    <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid>
                        <?php dynamic_sidebar("header:cell") ?>
                    </div>
                </div>
                <?php endif ?>

                <?= $logo ? $view('~theme/templates/header-logo') : '' ?>
                <?php if (is_active_sidebar('logo')) : ?>
                    <?php dynamic_sidebar("logo") ?>
                <?php endif ?>

                <?php if (is_active_sidebar('header-split')) : ?>
                <div class="uk-position-center-right">
                    <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid>
                        <?php dynamic_sidebar("header-split:cell") ?>
                    </div>
                </div>
                <?php endif ?>

            </div>
        </div>
    </div>
    <?php endif ?>

    <?php if (is_active_sidebar('navbar')) : ?>

        <?php if ($sticky) : ?>
        <div<?= $this->attrs($attrs_sticky) ?>>
        <?php endif ?>

            <div<?= $this->attrs($attrs_navbar_container) ?>>

                <div<?= $this->attrs($attrs_width_container) ?>>
                    <nav<?= $this->attrs($attrs_navbar) ?>>

                        <div class="uk-navbar-center">
                            <?php dynamic_sidebar("navbar") ?>
                        </div>

                    </nav>
                </div>

            </div>

        <?php if ($sticky) : ?>
        </div>
        <?php endif ?>

    <?php endif ?>

<?php endif ?>

<?php

/*
 * Stacked Left layouts
 */

if ($layout == 'stacked-left-a' || $layout == 'stacked-left-b') :

    $attrs_width_container['class'][] = 'uk-flex uk-flex-middle';
    $attrs_navbar['class'][] = 'uk-flex-auto';

    ?>

    <?php if ($logo || is_active_sidebar('header')) : ?>
    <div class="tm-headerbar-top<?= $outside && $config('~site.boxed.header_transparent') ? " uk-{$config('~site.boxed.header_transparent')}" : '' ?>">
        <div<?= $this->attrs($attrs_width_container) ?>>

            <?= $logo ? $view('~theme/templates/header-logo') : '' ?>
            <?php if (is_active_sidebar('logo')) : ?>
                <?php dynamic_sidebar("logo") ?>
            <?php endif ?>

            <?php if (is_active_sidebar('header')) : ?>
            <div class="uk-margin-auto-left">
                <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid>
                    <?php dynamic_sidebar("header:cell") ?>
                </div>
            </div>
            <?php endif ?>

        </div>
    </div>
    <?php endif ?>

    <?php if (is_active_sidebar('navbar')) : ?>

        <?php if ($sticky) : ?>
        <div<?= $this->attrs($attrs_sticky) ?>>
        <?php endif ?>

            <div<?= $this->attrs($attrs_navbar_container) ?>>

                <div<?= $this->attrs($attrs_width_container) ?>>
                    <nav<?= $this->attrs($attrs_navbar) ?>>

                        <?php if ($layout == 'stacked-left-a') : ?>
                        <div class="uk-navbar-left">
                            <?php dynamic_sidebar("navbar") ?>
                        </div>
                        <?php endif ?>

                        <?php if ($layout == 'stacked-left-b') : ?>
                        <div class="uk-navbar-left uk-flex-auto">
                            <?php dynamic_sidebar("navbar") ?>
                        </div>
                        <?php endif ?>

                    </nav>
                </div>

            </div>

        <?php if ($sticky) : ?>
        </div>
        <?php endif ?>

    <?php endif ?>

<?php endif ?>

<?php

/*
 * Toggle layouts
 */

if (preg_match('/^(offcanvas|modal)/', $layout)) :

    $attrs_width_container['class'][] = $logo && $config('~header.logo_padding_remove') && $config('~header.width') == 'expand' && !$config('~header.logo_center') ? 'uk-padding-remove-left' : '';

    $attrs_toggle = [];
    $attrs_toggle['class'][] = strpos($layout, 'modal') === 0 ? 'uk-modal-body uk-padding-large uk-margin-auto uk-height-viewport' : 'uk-offcanvas-bar';
    $attrs_toggle['class'][] = $config('~navbar.toggle_menu_center') ? 'uk-text-center' : '';
    $attrs_toggle['class'][] = 'uk-flex uk-flex-column';

    ?>

    <?php if ($sticky) : ?>
    <div<?= $this->attrs($attrs_sticky) ?>>
    <?php endif ?>

        <div<?= $this->attrs($attrs_navbar_container) ?>>
            <div<?= $this->attrs($attrs_width_container) ?>>
                <nav<?= $this->attrs($attrs_navbar) ?>>

                    <?php if ($logo) : ?>
                    <div class="<?= $config('~header.logo_center') ? 'uk-navbar-center' : 'uk-navbar-left' ?>">
                        <?= $view('~theme/templates/header-logo', ['class' => 'uk-navbar-item']) ?>
                        <?php if (is_active_sidebar('logo')) : ?>
                            <?php dynamic_sidebar("logo") ?>
                        <?php endif ?>
                    </div>
                    <?php endif ?>

                    <?php if (is_active_sidebar('header') || is_active_sidebar('navbar')) : ?>
                    <div class="uk-navbar-right">

                        <?php dynamic_sidebar("header") ?>

                        <?php if (is_active_sidebar('navbar')) : ?>

                            <a class="uk-navbar-toggle" href="#tm-navbar" uk-toggle>
                                <?php if ($config('~navbar.toggle_text')) : ?>
                                <span class="uk-margin-small-right"><?= __('Menu', 'yootheme') ?></span>
                                <?php endif ?>
                                <div uk-navbar-toggle-icon></div>
                            </a>

                            <?php if (strpos($layout, 'offcanvas') === 0) : ?>
                            <div id="tm-navbar" uk-offcanvas="flip: true"<?= $this->attrs($config('~navbar.offcanvas') ?: []) ?>>
                                <div<?= $this->attrs($attrs_toggle) ?>>

                                    <button class="uk-offcanvas-close uk-close-large" type="button" uk-close></button>

                                    <?php dynamic_sidebar("navbar") ?>

                                </div>
                            </div>
                            <?php endif ?>

                            <?php if (strpos($layout, 'modal') === 0) : ?>
                            <div id="tm-navbar" class="uk-modal-full" uk-modal>
                                <div class="uk-modal-dialog uk-flex">

                                    <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>

                                    <div <?= $this->attrs($attrs_toggle) ?>>
                                        <?php dynamic_sidebar("navbar") ?>
                                    </div>

                                </div>
                            </div>
                            <?php endif ?>

                        <?php endif ?>

                    </div>
                    <?php endif ?>

                </nav>
            </div>
        </div>

    <?php if ($sticky) : ?>
    </div>
    <?php endif ?>

<?php endif ?>

</div>
