<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 */

// Add default posts and comments RSS feed links to head.
add_theme_support('automatic-feed-links');

// Let WordPress manage the document title.
add_theme_support('title-tag');

// Enable support for Post Thumbnails on posts and pages.
add_theme_support('post-thumbnails');

// Switch default core markup for search form, comment form, and comments to output valid HTML5.
add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

// Enable support for Post Formats. (https://developer.wordpress.org/themes/functionality/post-formats)
add_theme_support('post-formats', ['aside', 'image', 'video', 'quote', 'link']);

// Enable support for WooCommerce
add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-slider');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');

// Enable support for prefixed Widgetkit 2
add_theme_support('widgetkit-noconflict');

// Enable support for UIkit 3
add_theme_support('uikit3');

// Load theme translations
load_theme_textdomain('yootheme', get_template_directory() . '/language');
