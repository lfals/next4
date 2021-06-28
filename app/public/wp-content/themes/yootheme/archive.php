<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#category
 */

namespace YOOtheme;

get_header();

$config = app(Config::class);

?>

<?php if (have_posts()) :

    // Header
    $title = get_the_archive_title();
    $description = get_the_archive_description();

    $attrs_title = [];
    $attrs_description = [];

    if ($description) {
        $attrs_description['class'][] = 'uk-margin-medium-bottom';
    } else {
        $attrs_title['class'][] = 'uk-margin-medium-bottom';
    }

    if ($config('~theme.post.header_align')) {
        $attrs_title['class'][] = 'uk-text-center';
        $attrs_description['class'][] = 'uk-text-center';
    }

    // Grid
    $columns = $config('~theme.blog.column', 1);

    $attrs = [];
    $options = [];

    $options[] = $config('~theme.blog.grid_masonry') ? 'masonry: true' : '';
    $options[] = $config('~theme.blog.grid_parallax') ? "parallax: {$config('~theme.blog.grid_parallax')}" : '';
    $attrs['uk-grid'] = implode(';', array_filter($options)) ?: true;

    // Columns
    $breakpoint = $config('~theme.blog.grid_breakpoint');
    $breakpoints = ['s', 'm', 'l', 'xl'];
    $pos = array_search($breakpoint, $breakpoints);

    if ($pos === false || $columns === 1) {
        $attrs['class'][] = "uk-child-width-1-{$columns}";
    } else {
        for ($i = $columns; $i > 0; $i--) {
            if (($pos > -1) && ($i > 1)) {
                $attrs['class'][] = "uk-child-width-1-{$i}@{$breakpoints[$pos]}";
                $pos--;
            }
        }
    }

    $column_gap = $config('~theme.blog.grid_column_gap');
    $row_gap = $config('~theme.blog.grid_row_gap');

    if ($column_gap == $row_gap) {
        $attrs['class'][] = $column_gap ? "uk-grid-{$column_gap}" : '';
    } else {
        $attrs['class'][] = $column_gap ? "uk-grid-column-{$column_gap}" : '';
        $attrs['class'][] = $row_gap ? "uk-grid-row-{$row_gap}" : '';
    }

    ?>

    <?php if (!is_category() || $config('~theme.blog.category_title')) : ?>

        <h1 class="uk-h3"<?= get_attrs($attrs_title) ?>><?= $title ?></h1>

        <?php if ($description) : ?>
        <div<?= get_attrs($attrs_description) ?>><?= $description ?></div>
        <?php endif ?>

    <?php endif ?>

    <div<?= get_attrs($attrs) ?>>
        <?php while(have_posts()) : the_post() ?>
        <div><?php get_template_part('templates/post/content', get_post_format()) ?></div>
        <?php endwhile ?>
    </div>

    <?php

    get_template_part('templates/pagination', 'archive');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
