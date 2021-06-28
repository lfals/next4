<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

namespace YOOtheme;

get_header();

?>

<?php if (have_posts()) :

    $attrs_title['class'][] = 'uk-h3 uk-margin-medium-bottom';

    ?>

    <div<?= get_attrs($attrs_title) ?>><?php printf(__( 'Search Results for &#8220;%s&#8221;' ), '<span>' . get_search_query() . '</span>') ?></div>

    <div class="uk-grid uk-child-width-1-1" uk-grid>
        <?php while (have_posts()) : the_post() ?>
        <div><?php get_template_part('templates/post/content', 'search') ?></div>
        <?php endwhile ?>
    </div>

    <?php

    get_template_part('templates/pagination', 'search');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
