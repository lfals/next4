<?php

namespace YOOtheme;

$date = !empty($args['show_publish_date']) ? get_post_date($post, $args['date_format']) : '';
$author = !empty($args['show_author']) ? get_post_author($post) : '';
$terms = !empty($args['show_taxonomy']) ? get_the_term_list($post->ID, $args['show_taxonomy'], '', ', ') : '';

$renderComments = function ($p) {
    global $post;

    $_post = $post;
    $post = $p;

    ob_start();
    comments_popup_link(__('Leave a Comment', 'yootheme'), __('1 Comment', 'yootheme'), __('% Comments', 'yootheme'));

    $post = $_post;

    return ob_get_clean();
};

$comments = !empty($args['show_comments']) && !post_password_required($post) && (comments_open($post) || get_comments_number($post)) ? $renderComments($post) : '';

if (!$date && !$author && !$terms && !$comments) {
    return;
}

if ($args['link_style']) {
    echo "<span class=\"uk-{$args['link_style']}\">";
}

switch ($args['format']) {

    case 'list':

        echo implode(" {$args['separator']} ", array_filter([$date, $author, $terms, $comments]));

        break;

    default: // sentence

        if ($author && $date) {
            printf(__('Written by %s on %s.', 'yootheme'), get_post_author($post), $date);
        } elseif ($author) {
            printf(__('Written by %s.', 'yootheme'), get_post_author($post));
        } elseif ($date) {
            printf(__('Written on %s.', 'yootheme'), $date);
        }

        if ($terms) {
            echo ' ';
            printf(__('Posted in %1$s.', 'yootheme'), $terms);
        }

        if ($comments) {
            echo " {$comments}";
        }

}

if ($args['link_style']) {
    echo '</span>';
}
