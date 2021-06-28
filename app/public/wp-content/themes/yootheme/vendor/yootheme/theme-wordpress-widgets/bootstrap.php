<?php

use function YOOtheme\app;
use YOOtheme\Theme\WidgetsListener;

/**
 * Require widget.
 */
require 'src/BuilderWidget.php';

/**
 * Helper functions.
 */
function get_current_sidebar() {
    return app(WidgetsListener::class)->sidebar;
}

return [

    'actions' => [

        'widgets_init' => [
            WidgetsListener::class => '@initWidgets',
        ],

        'current_screen' => [
            WidgetsListener::class => '@editScreen',
        ],

        'in_widget_form' => [
            WidgetsListener::class => ['@editWidget', 10, 3],
        ],

    ] + (!is_admin() ? [

        'dynamic_sidebar_before' => [
            WidgetsListener::class => '@beforeSidebar',
        ],

        'dynamic_sidebar_after' => [
            WidgetsListener::class => '@afterSidebar',
        ],

    ] : []),

    'filters' => [

        'widget_update_callback' => [
            WidgetsListener::class => ['@updateWidget', 10, 3],
        ],

    ] + (!is_admin() ? [

        'widget_display_callback' => [
            WidgetsListener::class => ['@displayWidget', 10, 3],
        ],

        'is_active_sidebar' => [
            WidgetsListener::class => ['@isActiveSidebar', null, 2],
        ],

        'sanitize_title' => [
            WidgetsListener::class => ['@parseSidebarStyle', 10, 2],
        ],

    ] : []),

    'services' => [
        WidgetsListener::class => '',
    ],

];
