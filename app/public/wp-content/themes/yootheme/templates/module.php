<?php

// Config
$config->addAlias('~header', '~theme.header');
$config->addAlias('~module', "~theme.modules.{$module->id}");

$class = [];
$badge = [];
$title = [];

$layout = $config('~header.layout');

// Debug
if ($position == 'debug') {
    echo $module->content;
    return;
}

// Navbar Split
if ($position == 'navbar-split' && $module->type == 'menu') {
    echo $module->content;
    return;
}

if ($position == 'navbar') {

    $alignment = false;

    if ($index == 1 && preg_match('/(offcanvas|modal)-top-b/', $layout)) {
        $alignment = 'uk-margin-auto-top';
    } elseif ($index == 0 && preg_match('/(offcanvas|modal)-center-b/', $layout)) {
        $alignment = 'uk-margin-auto-vertical';
    } elseif ($index == 1 && $layout == 'stacked-left-b') {
        $alignment = 'uk-margin-auto-left';
    }

    if ($module->type == 'menu' && preg_match('/^(horizontal|stacked)/', $layout)) {

        if ($alignment) {
            echo "<div class=\"{$alignment}\">{$module->content}</div>";
        } else {
            echo $module->content;
        }

        return;

    }

    if (preg_match('/^(offcanvas|modal)-/', $layout)) {

        if ($alignment) {
            $class[] = $alignment;
        } elseif (!(preg_match('/(offcanvas|modal)-center-b/', $layout) && $index === 1)) {
            $class[] = 'uk-margin-top';
        }

    } else {

        if ($alignment) {
            $class[] = $alignment;
        }

        if ($module->type == 'search' && $config('~header.search_style') == 'modal' && preg_match('/^(horizontal|stacked)/', $layout)) {
            $class[] = 'uk-navbar-toggle';
        } else {
            $class[] = 'uk-navbar-item';
        }

    }

} elseif ($position == 'header' && preg_match('/^(offcanvas|modal|horizontal)/', $layout)) {

    if ($module->type == 'menu') {
        echo $module->content;
        return;
    }

    $class[] = 'uk-navbar-item';

} elseif (($position == 'logo' && preg_match('/^(offcanvas|modal|horizontal|stacked-center-split)/', $layout)) || $position == 'logo-mobile') {

    $class[] = 'uk-navbar-item';

} elseif (in_array($position, ['header', 'header-split', 'mobile', 'toolbar-right', 'toolbar-left', 'logo'])) {

    $class[] = 'uk-panel';

} else {

    $class[] = $config('~module.style') ? "uk-card uk-card-body uk-{$config('~module.style')}" : 'uk-panel';

}

// Class
if ($cls = (array) $config('~module.class')) {
    $class = array_merge($class, $cls);
}

// Visibility
if ($visibility = $config('~module.visibility')) {
    $class[] = "uk-visible@{$visibility}";
}

// Grid + sidebar positions
if (!preg_match('/^(toolbar-(left|right)|navbar|header(-split)?|logo(-mobile)?|debug)$/', $position)) {

    // Title?
    if ($config('~module.showtitle') && !empty($module->title)) {

        $title['class'] = [];
        $title_element = $config('~module.title_tag', 'h3');

        // Style?
        $title['class'][] = $config('~module.title_style') ? "uk-{$config('~module.title_style')}" : '';
        $title['class'][] = $config('~module.style') && !$config('~module.title_style') ? 'uk-card-title' : '';

        // Decoration?
        $title['class'][] = $config('~module.title_decoration') ? "uk-heading-{$config('~module.title_decoration')}" : '';

        // Header Class?
        $title['class'][] = $config('~module.title_class', '');

    }

    // Text alignment
    if ($config('~module.text_align') && $config('~module.text_align') != 'justify' && $config('~module.text_align_breakpoint')) {
        $class[] = "uk-text-{$config('~module.text_align')}@{$config('~module.text_align_breakpoint')}";
        if ($config('~module.text_align_fallback')) {
            $class[] = "uk-text-{$config('~module.text_align_fallback')}";
        }
    } elseif ($config('~module.text_align')) {
        $class[] = "uk-text-{$config('~module.text_align')}";
    }

    // List
    if ($config('~module.is_list')) {
        $class[] = 'tm-child-list';

        // List Style?
        if ($config('~module.list_style')) {
            $class[] = "tm-child-list-{$config('~module.list_style')}";
        }

        // Link Style?
        if ($config('~module.link_style')) {
            $class[] = "uk-link-{$config('~module.link_style')}";
        }
    }

}

// Grid positions
if (preg_match('/^(top|bottom|builder-\d+)$/', $position)) {

    // Max Width?
    if ($config('~module.maxwidth')) {
        $class[] = "uk-width-{$config('~module.maxwidth')}";

        // Center?
        if ($config('~module.maxwidth_align')) {
            $class[] = 'uk-margin-auto';
        }

    }

}

if (empty($title) && empty($module->content)) {
    return;
}

?>

<div<?= $this->attrs(compact('class'), $module->attrs) ?>>

    <?php if ($title) : ?>
    <<?= $title_element ?><?= $this->attrs($title) ?>>

        <?php if ($config('~module.title_decoration') == 'line') : ?>
            <span><?= $module->title ?></span>
        <?php else: ?>
            <?= $module->title ?>
        <?php endif ?>

    </<?= $title_element ?>>
    <?php endif ?>

    <?= $module->content ?>

</div>
