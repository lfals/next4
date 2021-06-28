<?php

namespace YOOtheme\Theme\Wordpress;

class CommentListener
{
    /**
     * Add comment scripts.
     *
     * @link https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
     */
    public static function addScript()
    {
        if (is_singular() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Filter comment classes.
     *
     * @link https://developer.wordpress.org/reference/hooks/comment_class/
     *
     * @param mixed $classes
     */
    public static function filterClass($classes)
    {
        if (in_array('byuser', $classes)) {
            $classes[] = 'uk-comment-primary';
        }

        return $classes;
    }

    /**
     * Filter comment reply link.
     *
     * @link https://developer.wordpress.org/reference/hooks/comment_reply_link/
     *
     * @param mixed $link
     */
    public static function filterReplyLink($link)
    {
        return str_replace('comment-reply-link', 'comment-reply-link uk-button uk-button-text', $link);
    }

    /**
     * Filter comment cancel reply link.
     *
     * @link https://developer.wordpress.org/reference/hooks/cancel_comment_reply_link/
     *
     * @param mixed $link
     */
    public static function filterCancelLink($link)
    {
        return str_replace('href="', 'class="uk-link-muted" href="', $link);
    }

    /**
     * Filter comment author link.
     *
     * @link https://developer.wordpress.org/reference/hooks/get_comment_author_link/
     *
     * @param mixed $link
     */
    public static function filterAuthorLink($link)
    {
        return str_replace("class='url'", 'class="uk-link-reset"', $link);
    }
}
