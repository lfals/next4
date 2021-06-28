<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 */

namespace YOOtheme;

get_header();

/**
 * @var Config $config
 */
$config = app(Config::class);

if ($config('app.isBuilder')) :

    echo get_section('builder');

elseif (have_posts()) :

    while (have_posts()) : the_post();

        get_template_part('templates/post/content', 'page');

        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;

endif;

get_footer();
