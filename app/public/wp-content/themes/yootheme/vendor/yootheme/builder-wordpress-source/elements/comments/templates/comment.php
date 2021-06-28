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
                    <div class="uk-h3 uk-comment-title uk-margin-remove"><?php comment_author_link($comment) ?></div>
                    <p class="uk-comment-meta uk-margin-remove-top">
                        <a class="uk-link-reset" href="<?= esc_url(get_comment_link($comment, $args)) ?>">
                            <time datetime="<?php comment_time('c') ?>"><?php printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time()) ?></time>
                        </a>
                    </p>
                </div>
            </div>
            <div class="uk-position-top-right uk-hidden-hover">
                <?php comment_reply_link(array_merge($args, [
                    'depth' => $depth,
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
