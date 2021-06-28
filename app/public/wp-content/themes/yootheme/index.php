<?php
/**
 * The main template file.
 *
 * The most generic template file in the WordPress file hierarchy.
 * Used if WordPress cannot find any other matching template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

namespace YOOtheme;

get_header();

$config = app(Config::class);

?>

<?php if (have_posts()) :

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

    <div<?= get_attrs($attrs) ?>>
        <?php while(have_posts()) : the_post() ?>
        <div><?php get_template_part('templates/post/content', get_post_format()) ?></div>
        <?php endwhile ?>
    </div>

    <?php

    get_template_part('templates/pagination');

else :

    get_template_part('templates/post/content', 'none');

endif;

get_footer();
