<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

namespace YOOtheme;

get_header();

$config = app(Config::class);

if (have_posts()) :

    // Container
    $attrs_container = [];

    if ($content_width = $config('~theme.post.content_width')) {
        $attrs_container['class'][] = "uk-container uk-container-{$content_width}";
    }

    while (have_posts()) : the_post();

        get_template_part('templates/post/content', get_post_format());

        if ($attrs_container) :
            printf('<div%s>', get_attrs($attrs_container));
        endif;

        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

        if ($attrs_container) :
            echo '</div>';
        endif;

    endwhile;

endif;

get_footer();
