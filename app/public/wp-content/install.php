<?php

if (isset($_REQUEST['step']) && $_REQUEST['step'] == 2) {
    add_action('shutdown', function () {
        global $wpdb, $wp_rewrite;

        if (!get_option('blogname', false)) {
            return;
        }

        $example = __DIR__ . '/sample_yootheme.json';
        $queries = json_decode(file_get_contents($example));
        $replace = [
            '@@SITE_URL@@' => get_option('siteurl'),
            '@@ADMIN_EMAIL@@' => get_option('admin_email'),
            '@@TABLE_PREFIX@@' => $wpdb->prefix,
        ];

        foreach ($queries as $query) {
            $wpdb->query(strtr($query, $replace));
        }

        $wp_rewrite->flush_rules();
        wp_cache_flush();

        unlink($example);
        unlink(__FILE__);
    });
}
