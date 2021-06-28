<?php

foreach ($items as $item) {

    if ($item->type == 'header') {
        continue;
    }

    $attrs = ['class' => []];
    $title = $item->title;

    // Config
    $config->addAlias('~menuitem', "~theme.menu.items.{$item->id}");

    // Parent?
    if (isset($item->children)) {
        $attrs['class'][] = 'uk-parent';
    }

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

    if ($subtitle = $config('~menuitem.subtitle')) {
        $subtitle = "<div>{$subtitle}</div>";
    }

    echo "<li{$this->attrs($attrs)}><a{$this->attrs($link)}>{$icon}{$title}{$subtitle}</a></li>";
}
