<?php

namespace YOOtheme;

// Helper functions.

function get_view(...$args) {
    return app(View::class)->render(...$args);
}

function get_attrs(...$args) {
    return app(View::class)->attrs(...$args);
}

function get_section(...$args) {
    return app(View::class)->section(...$args);
}

function get_builder($node, $params = []) {

    // support old builder arguments
    if (!is_string($node)) {
        $node = json_encode($node);
    }

    if (is_string($params)) {
        $params = ['prefix' => $params];
    }

    return app(Builder::class)->render($node, $params);
}

function get_post_date($post = null, $format = '') {
    return '<time datetime="' . esc_attr(get_the_date('c', $post)) . '">' . esc_html(get_the_date($format, $post)) . '</time>';
}

function get_post_author($post = null) {

    if ($post) {
        $authordata = get_userdata($post->post_author);
    } else {
        global $authordata;
    }

    return '<a href="' . esc_url(get_author_posts_url($authordata->ID)) . '">' . esc_html(apply_filters('the_author', $authordata->display_name)) . '</a>';
}

function link_pages() {

    global $page, $numpages, $multipage, $more;

    return $multipage ? app(View::class)('~theme/templates/pagebreak', compact('page', 'numpages', 'more')) : '';
}
