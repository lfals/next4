<?php

// Config
$config->addAlias('~mobile', '~theme.mobile');
$config->addAlias('~header', '~theme.header');
$config->addAlias('~navbar', '~theme.navbar');

// Menu ID
$attrs['id'] = $config('~menu.tag_id');

$hasHeaderParent = function ($items) {
    return array_filter($items, function ($item) {
        return $item->type == 'header' && !empty($item->children) && isset($item->url) && ($item->url === '#' || $item->url === '');
    });
};

// determine layout, strpos() on $config('~menu.position') to also find the virtual position 'navbar-split'
if (strpos($config('~menu.position'), 'navbar') === 0) {

    $layout = $config('~header.layout');

    if (preg_match('/^(offcanvas|modal)/', $layout)) {

        $type = 'nav';
        $attrs['class'][] = "uk-nav uk-nav-{$config('~navbar.toggle_menu_style')}";
        $attrs['class'][] = $config('~navbar.toggle_menu_divider') ? 'uk-nav-divider' : '';
        $attrs['class'][] = $config('~navbar.toggle_menu_center') ? 'uk-nav-center' : '';

        if ($hasHeaderParent($items)) {

            $config->set('~menu.accordion', true);
            $attrs['class'][] = 'uk-nav-parent-icon uk-nav-accordion';
            $attrs['uk-nav'] = 'targets: > .js-accordion';

        }

    } else {

        $type = 'navbar';
        $attrs['class'][] = 'uk-navbar-nav';

    }

    if ($layout == 'stacked-center-split' && $config('~menu.split')) {

        $length = ceil(count($items) / 2);

        if ($config('~menu.position') == 'navbar-split') {
            $items = array_slice($items, 0, $length);
        } else {
            $items = array_slice($items, $length);
        }
    }

} else if ($config('~menu.position') == 'header') {

    $layout = $config('~header.layout');

    if (preg_match('/^(stacked)/', $layout)) {

        $type = 'subnav';
        $attrs['class'][] = 'uk-subnav';

    } else {

        $type = 'navbar';
        $attrs['class'][] = 'uk-navbar-nav';

    }

} else if ($config('~menu.menu_style') == 'subnav' || in_array($config('~menu.position'), ['toolbar-left', 'toolbar-right', 'logo', 'logo-mobile'])) {

    $type = 'subnav';
    $attrs['class'][] = 'uk-subnav';

} else {

    $type = 'nav';
    $attrs['class'][] = 'uk-nav';

    if ($config('~menu.position') == 'mobile') {

        $attrs['class'][] = "uk-nav-{$config('~mobile.menu_style')}";
        $attrs['class'][] = $config('~mobile.menu_divider') ? 'uk-nav-divider' : '';
        $attrs['class'][] = $config('~mobile.menu_center') ? 'uk-nav-center' : '';

    } else {

        $attrs['class'][] = 'uk-nav-default';
        $attrs['class'][] = $config('~menu.menu_divider') ? 'uk-nav-divider' : '';

    }

    if ($hasHeaderParent($items)) {

        $config->set('~menu.accordion', true);
        $attrs['class'][] = 'uk-nav-parent-icon uk-nav-accordion';
        $attrs['uk-nav'] = 'targets: > .js-accordion';

    }
}

?>

<ul<?= $this->attrs($attrs) ?>>
    <?= $view("~theme/templates/menu/{$type}", ['items' => $items, 'level' => 1]) ?>
</ul>
