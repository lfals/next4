<?php

$link = $props['link'] ? $this->el('a', [
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($props['link'], '#') === 0,
]) : null;

if ($link && $props['overlay_link']) {

    $container->attr($link->attrs + [

        'class' => [
            // Needs to be child of `uk-light` or `uk-dark`
            'uk-link-toggle',
        ],

    ]);

    $props['title'] = $this->striptags($props['title']);
    $props['meta'] = $this->striptags($props['meta']);
    $props['content'] = $this->striptags($props['content']);

    if ($props['title'] && $props['title_hover_style'] != 'reset') {
        $props['title'] = $this->el('span', [
            'class' => [
                'uk-link-{title_hover_style: heading}',
                'uk-link {!title_hover_style}',
            ],
        ], $props['title'])->render($props);
    }

}

if ($link && $props['title'] && $props['title_link']) {

    $props['title'] = $link($props, [
        'class' => [
            'uk-link-{title_hover_style}',
        ],
    ], $this->striptags($props['title']));

}

if ($link && $props['link_text']) {

    if ($props['overlay_link']) {
        $link = $this->el('div');
    }

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
            'uk-transition-{link_transition} {@overlay_hover}',
            // Keep link style if overlay link
            'uk-link {@link_style:} {@overlay_link}',
            'uk-text-muted {@link_style: link-muted} {@overlay_link}',
        ],

    ]);

}

return $link;
