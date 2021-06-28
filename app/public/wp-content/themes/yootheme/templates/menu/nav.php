<?php

foreach ($items as $item) {

    $attrs = ['class' => []];
    $children = isset($item->children);
    $indention = str_pad("\n", $level + 1, "\t");
    $title = $item->title;

    // Config
    $config->addAlias('~menuitem', "~theme.menu.items.{$item->id}");

    // Active?
    if ($item->active) {
        $attrs['class'][] = 'uk-active';
    }

    // Icon
    $icon = $config('~menuitem.icon');
    if ($view->isImage($icon)) {
        $icon = "<img src=\"{$icon}\" alt=\"{$item->title}\">";
    } elseif ($icon) {
        $icon = "<span class=\"uk-margin-small-right\" uk-icon=\"icon: {$icon}\"></span>";
    }

    // Show Icon only
    if ($icon && $config('~menuitem.icon-only')) {
        $title = '';
    }

    // Header
    if ($item->type == 'header' || ($item->type === 'custom' && $item->url === '#')) {

        $title = $icon . $title;

        // Divider
        if ($item->divider && !$children) {
            $title = '';
            $attrs['class'][] = 'uk-nav-divider';
        } elseif ($config('~menu.accordion') && $children) {
            $title = "<a href>{$title}</a>";
            if ($level === 1) {
                $attrs['class'][] = 'js-accordion';
            }
        } else {
            $attrs['class'][] = 'uk-nav-header';
        }

    // Link
    } else {

        $link = [];

        if (isset($item->url)) {
            $link['href'] = $item->url;
        }

        if (isset($item->target)) {
            $link['target'] = $item->target;
        }

        if (isset($item->anchor_title)) {
            $link['title'] = $item->anchor_title;
        }

        if (isset($item->anchor_rel)) {
            $link['rel'] = $item->anchor_rel;
        }

        // Additional Class
        if (isset($item->class)) {
            $link['class'] = $item->class;
        }

        $title = "<a{$this->attrs($link)}>{$icon}{$title}</a>";
    }

    // Children?
    if ($children) {

        $attrs['class'][] = 'uk-parent';

        $children = ['class' => []];

        if ($level == 1) {
            $children['class'][] = 'uk-nav-sub';
        }

        $children = "{$indention}<ul{$this->attrs($children)}>\n{$this->self(['items' => $item->children, 'level' => $level + 1])}</ul>";
    }

    echo "{$indention}<li{$this->attrs($attrs)}>{$title}{$children}</li>";
}
