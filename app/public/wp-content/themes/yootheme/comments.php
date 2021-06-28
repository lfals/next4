<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

if (post_password_required()) {
    return;
}

?>

<div id="comments" class="uk-margin-large-top">

    <?php if (have_comments()) : ?>

        <h2 class="uk-h3 uk-heading-bullet uk-margin-medium-bottom"><?php printf(_n(__('Comment'), __('Comments (%s)'), get_comments_number()), number_format_i18n(get_comments_number())) ?></h2>

        <ul class="uk-comment-list">
            <?php wp_list_comments([
                'style' => 'ul',
                'short_ping' => true,
                'callback' => 'comment_callback',
            ]) ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <ul class="uk-pagination uk-flex-between">
            <li class="nav-previous"><?php previous_comments_link('<span uk-pagination-previous></span> ' . __('Older Comments')) ?></li>
            <li class="nav-next"><?php next_comments_link(__('Newer Comments') . ' <span uk-pagination-next></span>') ?></li>
        </ul>
        <?php endif ?>

    <?php endif ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="uk-margin-medium uk-text-danger"><?php _e('Comments are closed.') ?></p>
    <?php endif ?>

    <?php get_template_part('commentform') ?>

</div>

<?php

/**
 * The template to display a comment.
 */
function comment_callback($comment, $args, $depth) {
?>
<li id="comment-<?php comment_ID() ?>">
    <article id="comment-article-<?php comment_ID() ?>" <?php comment_class('uk-comment uk-visible-toggle') ?> tabindex="-1">
        <header class="uk-comment-header uk-position-relative">
            <div class="uk-grid-medium uk-flex-middle" uk-grid>
                <?php if ($args['avatar_size'] != 0) : ?>
                <div class="uk-width-auto">
                    <?= get_avatar($comment, $args['avatar_size']) ?>
                </div>
                <?php endif ?>
                <div class="uk-width-expand">
                    <h3 class="uk-comment-title uk-margin-remove"><?php comment_author_link($comment) ?></h3>
                    <p class="uk-comment-meta uk-margin-remove-top">
                        <a class="uk-link-reset" href="<?= esc_url(get_comment_link($comment, $args)) ?>">
                            <time datetime="<?php comment_time('c') ?>"><?php printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time())
                        ?></time>
                        </a>
                    </p>
                </div>
            </div>
            <div class="uk-position-top-right uk-hidden-hover">
                <?php comment_reply_link(array_merge($args, [
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'add_below' => 'comment-article',
                ])) ?>
            </div>
        </header>

        <div class="uk-comment-body">

            <?php if ($comment->comment_approved == '0') : ?>
            <p><?php _e('Your comment is awaiting moderation.') ?></p>
            <?php endif ?>

            <?php comment_text() ?>

            <?php edit_comment_link(__('Edit')) ?>

        </div>

    </article>
<?php
}
