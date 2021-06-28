<?php

/**
 * Boostrap theme.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions
 */
$app = require 'bootstrap.php';
$app->load(__DIR__ . '/{vendor/yootheme/{platform-wordpress,theme{,-analytics,-cookie,-highlight,-settings,-wordpress*},styler,builder{,-source*,-templates,-newsletter,-wordpress*}}/bootstrap.php,config.php}');

/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if (!function_exists('wp_body_open')) {
    function wp_body_open() {
        do_action('wp_body_open');
    }
}
