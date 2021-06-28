<?php

namespace YOOtheme;

$view = app(View::class);
$globals = $view->getGlobals();
$props = $globals['comments.props'];
$attrs = $globals['comments.attrs'];

$el = $view->el('div', [

    'id' => [
        'comments',
    ],

]);

// Title
$title = $view->el($props['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?php if (have_comments()) : ?>

        <?= $title($props) ?>
            <?php if ($props['title_color'] == 'background') : ?>
            <span class="uk-text-background"><?php printf(_n(__('Comment'), __('Comments (%s)'), get_comments_number()), number_format_i18n(get_comments_number())) ?></span>
            <?php elseif ($props['title_decoration'] == 'line') : ?>
            <span><?php printf(_n(__('Comment'), __('Comments (%s)'), get_comments_number()), number_format_i18n(get_comments_number())) ?></span>
            <?php else : ?>
            <?php printf(_n(__('Comment'), __('Comments (%s)'), get_comments_number()), number_format_i18n(get_comments_number())) ?>
            <?php endif ?>
        <?= $title->end() ?>

        <ul class="uk-comment-list uk-margin-medium-top">
            <?php wp_list_comments([
                'style' => 'ul',
                'short_ping' => true,
                'callback' => function ($comment, $args, $depth) use ($view) {
                    echo $view->render(__DIR__ . '/comment', compact('comment', 'args', 'depth'));
                },
            ]) ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <ul class="uk-pagination uk-flex-between">
            <li><?php previous_comments_link('<span uk-pagination-previous></span> ' . __('Older Comments')) ?></li>
            <li><?php next_comments_link(__('Newer Comments') . ' <span uk-pagination-next></span>') ?></li>
        </ul>
        <?php endif ?>

    <?php endif ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="uk-margin-medium uk-text-danger"><?php _e('Comments are closed.') ?></p>
    <?php endif ?>

    <?php get_template_part('vendor/yootheme/builder-wordpress-source/elements/comments/templates/commentform') ?>

<?= $el->end() ?>