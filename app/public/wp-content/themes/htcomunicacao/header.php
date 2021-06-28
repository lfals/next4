<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <title><?php ht_title(); ?></title>
    <?php ht_meta_headers(); ?>
    <?php wp_head(); ?>
    <?php 
    if( function_exists('acf_add_options_page') ) {
        $script = get_field('ht_options_script_header', 'option');
        if (!empty($script)) print $script;
    } ?>
</head>
<body <?php body_class(); ?>>