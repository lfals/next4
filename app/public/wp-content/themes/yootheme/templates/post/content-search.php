<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

namespace YOOtheme;

?>

<article id="post-<?php the_ID() ?>" <?php post_class('uk-article') ?>>

    <?php the_title(sprintf('<h2><a class="uk-link-reset" href="%s">', esc_url(get_permalink())), '</a></h2>') ?>

    <?php if ('post' === get_post_type()) : ?>
    <p class="uk-article-meta">
        <?php printf(__('Written by %s on %s.', 'yootheme'), get_post_author(), get_post_date()) ?>

        <?php
            if ($categories = get_the_category_list(__(', ', 'yootheme'))) {
                printf(__('Posted in %1$s.', 'yootheme'), $categories);
            }
        ?>
    </p>
    <?php endif ?>

    <div class="uk-margin-medium">
        <?php the_excerpt() ?>
    </div>

    <?php if ($edit = get_edit_post_link()) : ?>
    <p>
        <a href="<?= esc_url($edit) ?>"><?= sprintf(__('%1$s Edit', 'yootheme'), '<span uk-icon="pencil"></span>') ?></a>
    </p>
    <?php endif ?>

</article>
