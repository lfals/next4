<?php

namespace YOOtheme;

return [


    '2.4.14' => function ($config) {

        // Less
        if (Arr::get($config, 'less.@navbar-mode') === 'border') {
            Arr::set($config, 'less.@navbar-mode', 'border-always');
        }

        if (Arr::get($config, 'less.@navbar-nav-item-line-slide-mode') === 'false') {
            Arr::set($config, 'less.@navbar-nav-item-line-slide-mode', 'left');
        }

        return $config;
    },


    '2.1.0-beta.0.1' => function ($config) {

        // Less
        if (Arr::has($config, 'less.@width-xxlarge-width')) {
            Arr::set($config, 'less.@width-2xlarge-width', Arr::get($config, 'less.@width-xxlarge-width'));
            Arr::del($config, 'less.@width-xxlarge-width');
        }

        if (Arr::has($config, 'less.@global-xxlarge-font-size')) {
            Arr::set($config, 'less.@global-2xlarge-font-size', Arr::get($config, 'less.@global-xxlarge-font-size'));
            Arr::del($config, 'less.@global-xxlarge-font-size');
        }

        return $config;
    },

    '2.0.11.1' => function ($config) {
        $style = Arr::get($config, 'style');

        $mapping = [
            'framerate:dark-blue' => 'framerate:black-blue',
            'framerate:dark-lightblue' => 'framerate:dark-blue',
            'joline:black-pink' => 'joline:dark-pink',
            'max:black-black' => 'max:dark-black',
        ];

        if (array_key_exists($style, $mapping)) {
            Arr::set($config, 'style', $mapping[$style]);
        }

        return $config;
    },

    '2.0.8.1' => function ($config) {
        $style = Arr::get($config, 'style');

        $mapping = [
            'copper-hill:white-turquoise' => 'copper-hill:light-turquoise',
            'florence:white-lilac' => 'florence:white-beige',
            'pinewood-lake:white-green' => 'pinewood-lake:light-green',
            'pinewood-lake:white-petrol' => 'pinewood-lake:light-petrol',
        ];

        if (array_key_exists($style, $mapping)) {
            Arr::set($config, 'style', $mapping[$style]);
        }

        return $config;
    },

    '2.0.0-beta.5.1' => function ($config) {

        foreach (['blog.width', 'post.width', 'header.width'] as $prop) {

            if (Arr::get($config, $prop) == '') {
                Arr::set($config, $prop, 'default');
            }

            if (Arr::get($config, $prop) == 'none') {
                Arr::set($config, $prop, '');
            }

        }

        list($style) = explode(':', Arr::get($config, 'style'));

        foreach (['site.toolbar_width', 'header.width', 'top.width', 'bottom.width', 'blog.width', 'post.width'] as $prop) {

            if (!in_array($style, ['jack-baker', 'morgan-consulting', 'vibe'])) {
                if (Arr::get($config, $prop) == 'large') {
                    Arr::set($config, $prop, 'xlarge');
                }
            }

            if (in_array($style, ['craft', 'district', 'florence', 'makai', 'matthew-taylor', 'pinewood-lake', 'summit', 'tomsen-brody', 'trek', 'vision', 'yard'])) {
                if (Arr::get($config, $prop) == 'default') {
                    Arr::set($config, $prop, 'large');
                }
            }

        }

        // Less
        if (!in_array($style, ['jack-baker', 'morgan-consulting', 'vibe'])) {
            if (Arr::has($config, 'less.@container-large-max-width')) {
                Arr::set($config, 'less.@container-xlarge-max-width', Arr::get($config, 'less.@container-large-max-width'));
                Arr::del($config, 'less.@container-large-max-width');
            }
        }

        if (in_array($style, ['craft', 'district', 'florence', 'makai', 'matthew-taylor', 'pinewood-lake', 'summit', 'tomsen-brody', 'trek', 'vision', 'yard'])) {
            if (Arr::has($config, 'less.@container-max-width')) {
                Arr::set($config, 'less.@container-large-max-width', Arr::get($config, 'less.@container-max-width'));
                Arr::del($config, 'less.@container-max-width');
            }
        }

        return $config;

    },

    '1.22.0-beta.0.1' => function ($config) {

        // Rename Top and Bottom options
        foreach (['top', 'bottom'] as $position) {

            Arr::set($config, "{$position}.column_gap", Arr::get($config, "{$position}.grid_gutter", ''));
            Arr::set($config, "{$position}.row_gap", Arr::get($config, "{$position}.grid_gutter", ''));
            Arr::del($config, "{$position}.grid_gutter");

            Arr::set($config, "{$position}.divider", Arr::get($config, "{$position}.grid_divider", ''));
            Arr::del($config, "{$position}.grid_divider");

        }

        // Rename Blog options
        if (Arr::get($config, 'blog.column_gutter')) {
            Arr::set($config, 'blog.grid_column_gap', 'large');
        }
        Arr::set($config, 'blog.grid_row_gap', 'large');
        Arr::del($config, 'blog.column_gutter');

        Arr::set($config, 'blog.grid_breakpoint', Arr::get($config, 'blog.column_breakpoint', ''));
        Arr::del($config, 'blog.column_breakpoint');

        // Rename Sidebar options
        foreach (['width', 'breakpoint', 'first', 'gutter', 'divider'] as $prop) {
            if (Arr::has($config, "sidebar.{$prop}")) {
                Arr::set($config, "main_sidebar.{$prop}", Arr::get($config, "sidebar.{$prop}"));
                Arr::del($config, "sidebar.{$prop}");
            }
        }

        return $config;
    },

    '1.20.4.1' => function ($config) {

        // Less
        if (Arr::has($config, 'less.@theme-toolbar-padding-vertical')) {

            Arr::set($config, 'less.@theme-toolbar-padding-top', Arr::get($config, 'less.@theme-toolbar-padding-vertical'));
            Arr::set($config, 'less.@theme-toolbar-padding-bottom', Arr::get($config, 'less.@theme-toolbar-padding-vertical'));

            Arr::del($config, 'less.@theme-toolbar-padding-vertical');
        }

        // Header settings
        if (Arr::has($config, 'site.toolbar_fullwidth')) {

            if (Arr::get($config, 'site.toolbar_fullwidth')) {
                Arr::set($config, 'site.toolbar_width', 'expand');
            }

            Arr::del($config, 'site.toolbar_fullwidth');
        }

        return $config;
    },

    '1.20.0-beta.7' => function ($config) {

        // Remove empty menu items
        if (Arr::has($config, 'menu.items')) {
            Arr::set($config, 'menu.items', array_filter((array) Arr::get($config, 'menu.items', [])));
        }

        return $config;
    },

    '1.20.0-beta.6' => function ($config) {

        // Header settings
        if (Arr::has($config, 'header.fullwidth')) {

            if (Arr::get($config, 'header.fullwidth')) {
                Arr::set($config, 'header.width', 'expand');
            }

            Arr::del($config, 'header.fullwidth');
        }

        if (Arr::get($config, 'header.layout') == 'toggle-offcanvas') {
            Arr::set($config, 'header.layout', 'offcanvas-top-a');
        }

        if (Arr::get($config, 'header.layout') == 'toggle-modal') {
            Arr::set($config, 'header.layout', 'modal-center-a');
            Arr::set($config, 'navbar.toggle_menu_style', 'primary');
            Arr::set($config, 'navbar.toggle_menu_center', true);
        }

        if (Arr::get($config, 'mobile.animation') == 'modal' && !Arr::has($config, 'mobile.menu_center')) {
            Arr::set($config, 'mobile.menu_style', 'primary');
            Arr::set($config, 'mobile.menu_center', true);
            Arr::set($config, 'mobile.menu_center_vertical', true);
        }

        if (Arr::get($config, 'site.boxed.padding') && (!Arr::has($config, 'site.boxed.margin_top') || !Arr::has($config, 'site.boxed.margin_bottom'))) {
            Arr::set($config, 'site.boxed.margin_top', true);
            Arr::set($config, 'site.boxed.margin_bottom', true);
        }

        if (!Arr::has($config, 'cookie.mode') && Arr::get($config, 'cookie.active')) {
            Arr::set($config, 'cookie.mode', 'notification');
        }
        if (!Arr::has($config, 'cookie.button_consent_style')) {
            Arr::set($config, 'cookie.button_consent_style', Arr::get($config, 'cookie.button_style'));
        }

        foreach (['top', 'bottom'] as $position) {

            if (Arr::get($config, "{$position}.vertical_align") === true) {
                Arr::set($config, "{$position}.vertical_align", 'middle');
            }

            if (Arr::get($config, "{$position}.style") === 'video') {
                Arr::set($config, "{$position}.style", 'default');
            }

            if (Arr::get($config, "{$position}.width") == '1') {
                Arr::set($config, "{$position}.width", 'default');
            }

            if (Arr::get($config, "{$position}.width") == '2') {
                Arr::set($config, "{$position}.width", 'small');
            }

            if (Arr::get($config, "{$position}.width") == '3') {
                Arr::set($config, "{$position}.width", 'expand');
            }
        }

        foreach (Arr::get($config, 'less', []) as $key => $value) {

            if (in_array($key, ['@heading-primary-line-height', '@heading-hero-line-height-m', '@heading-hero-line-height'])) {
                Arr::del($config, "less.{$key}");
            } elseif (Str::contains($key, ['heading-primary-', 'heading-hero-'])) {
                Arr::set($config, 'less.' . strtr($key, [
                    'heading-primary-line-height-l' => 'heading-medium-line-height',
                    'heading-primary-' => 'heading-medium-',
                    'heading-hero-line-height-l' => 'heading-xlarge-line-height',
                    'heading-hero-' => 'heading-xlarge-',
                ]), $value);
                Arr::del($config, "less.{$key}");
            }

        }

        list($style) = explode(':', Arr::get($config, 'style'));

        $less = Arr::get($config, 'less', []);

        foreach ([
            [['fuse', 'horizon', 'joline', 'juno', 'lilian', 'vibe', 'yard'], ['medium', 'small']],
            [['trek', 'fjord'], ['medium', 'large']],
            [['juno', 'vibe', 'yard'], ['xlarge', 'medium']],
            [['district', 'florence', 'flow', 'nioh-studio', 'summit', 'vision'], ['xlarge', 'large']],
            [['lilian'], ['xlarge', '2xlarge']],
        ] as $change) {

            list($styles, $transform) = $change;

            if (in_array($style, $styles)) {
                foreach ($less as $key => $value) {
                    if (Str::contains($key, "heading-{$transform[0]}")) {
                        Arr::set($config, 'less.' . str_replace("heading-{$transform[0]}", "heading-{$transform[1]}", $key), $value);
                    }
                }
            }

        }

        return $config;
    },

];
