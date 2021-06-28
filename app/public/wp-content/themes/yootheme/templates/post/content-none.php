<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

namespace YOOtheme;

?>

<h1><?php _e('Nothing Found', 'yootheme') ?></h1>

<?php if (is_home() && current_user_can('publish_posts')) : ?>

    <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'yootheme'), esc_url(admin_url('post-new.php'))) ?></p>

<?php elseif (is_search()) : ?>

    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'yootheme') ?></p>

    <?php get_search_form() ?>

<?php else : ?>

    <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'yootheme') ?></p>

    <?php get_search_form() ?>

<?php endif ?>