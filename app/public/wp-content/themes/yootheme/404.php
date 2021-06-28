<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header();

?>

<h1 class="uk-heading-medium uk-text-center"><?php _e('Oops! That page can&rsquo;t be found.', 'yootheme') ?></h1>

<p class="uk-text-large uk-text-center uk-margin-large-bottom"><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'yootheme') ?></p>

<div class="uk-text-center"><?php get_search_form() ?></div>

<?php

get_footer();
