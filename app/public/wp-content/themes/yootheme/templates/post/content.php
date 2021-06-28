<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy
 */

namespace YOOtheme;

global $multipage, $numpages, $page;

list($config, $view) = app(Config::class, View::class);

if (!is_single()) {
    $config->add('~theme.post', $config('~theme.blog'));
}

$attrs_container = [];

// Image
$attrs_image['class'][] = 'uk-text-center';
$attrs_image['class'][] = $view->margin($config('~theme.post.image_margin'));

// Container
if ($config('~theme.post.column', 1) == 1
    && $config('~theme.post.content_width')
    && $config('~theme.post.content_width') != $config('~theme.post.width')
) {
    $attrs_container['class'][] = "uk-container uk-container-{$config('~theme.post.content_width')}";
}

// Title
$attrs_title['property'] = 'headline';
$attrs_title['class'][] = "{$view->margin($config('~theme.post.title_margin'))} uk-margin-remove-bottom";
$attrs_title['class'][] = $config('~theme.post.header_align') ? 'uk-text-center' : '';
$attrs_title['class'][] = $config('~theme.post.title_style') ? "uk-{$config('~theme.post.title_style')}" : 'uk-article-title';

// Content
$attrs_content['class'][] = $view->margin($config('~theme.post.content_margin'));
$attrs_content['class'][] = $config('~theme.post.content_align') ? 'uk-text-center' : '';
$attrs_content['class'][] = is_single() && $config('~theme.post.content_dropcap') ? 'uk-dropcap' : '';

// Tags
$attrs_tags['class'][] = $config('~theme.post.header_align') ? 'uk-text-center' : '';

// Button
$attrs_button['class'][] = "uk-button uk-button-{$config('~theme.post.button_style')}";
$attrs_button_container['class'][] = $config('~theme.post.header_align') ? 'uk-text-center' : '';
$attrs_button_container['class'][] = "uk-margin-{$config('~theme.post.button_margin')}";

// Image template
$image = function ($attr) use ($config, $view) {

    if (!$src = get_the_post_thumbnail_url()) {
        return;
    }

    $image = app(ImageProvider::class);
    $meta = get_post_meta(get_post_thumbnail_id());
    $src = Path::relative(Url::base(), set_url_scheme($src, 'relative'));
    $alt = isset($meta['_wp_attachment_image_alt']) ? $meta['_wp_attachment_image_alt'] : '';

    if ($view->isImage($src) == 'svg') {
        $thumbnail = $image->replace($view->image($src, ['width' => $config('~theme.post.image_width'), 'height' => $config('~theme.post.image_height'), 'uk-img' => true, 'property' => 'url', 'alt' => $alt]));
    } else {
        $thumbnail = $image->replace($view->image([$src, 'thumbnail' => [$config('~theme.post.image_width'), $config('~theme.post.image_height')], 'srcset' => true], ['uk-img' => true, 'property' => 'url', 'alt' => $alt]));
    }

    ?>

    <?php if ($thumbnail) : ?>
        <div<?= $view->attrs($attr) ?> property="image" typeof="ImageObject">
            <meta property="url" content="<?= get_the_post_thumbnail_url() ?>">
            <?php if (is_single()) : ?>
                <?= $thumbnail ?>
            <?php else : ?>
                <a href="<?php the_permalink() ?>"><?= $thumbnail ?></a>
            <?php endif ?>
        </div>
    <?php endif ?>

    <?php
};

?>

<article id="post-<?php the_ID() ?>" <?php post_class('uk-article') ?> typeof="Article" vocab="http://schema.org/">

    <meta property="name" content="<?= esc_html(get_the_title()) ?>">
    <meta property="author" typeof="Person" content="<?= esc_html(get_the_author()) ?>">
    <meta property="dateModified" content="<?= get_the_modified_date('c') ?>">
    <meta class="uk-margin-remove-adjacent" property="datePublished" content="<?= get_the_date('c') ?>">

    <?php if ($config('~theme.post.image_align') == 'top') : ?>
    <?= $image($attrs_image) ?>
    <?php endif ?>

    <?php if ($attrs_container) : ?>
    <div<?= $view->attrs($attrs_container) ?>>
    <?php endif ?>

        <?php if ($config('~theme.post.meta_align') == 'top') : ?>
        <?= $view('~theme/templates/meta', ['post' => get_post(), 'config' => $config]) ?>
        <?php endif ?>

        <?php
            if (is_single()) {
                the_title('<h1' . $view->attrs($attrs_title) . '>', '</h1>');
            } else {
                the_title('<h2' . $view->attrs($attrs_title) . '><a class="uk-link-reset" href="' . esc_url(get_permalink()) . '">', '</a></h2>');
            }
        ?>

        <?php if ($config('~theme.post.meta_align') == 'bottom') : ?>
        <?= $view('~theme/templates/meta', ['post' => get_post(), 'config' => $config]) ?>
        <?php endif ?>

        <?php if ($config('~theme.post.image_align') == 'between') : ?>

            <?php if ($attrs_container) : ?>
            </div>
            <?php endif ?>

            <?= $image($attrs_image) ?>

            <?php if ($attrs_container) : ?>
            <div<?= $view->attrs($attrs_container) ?>>
            <?php endif ?>

        <?php endif ?>

        <?php

            // Execute 'the_content()' (wp-includes/post-template.php)
            // e.g. Toolset plugin relies on this function to be called to apply their content filter
            ob_start();
            the_content('');
            $content = ob_get_clean();

            // Get extended content (wp-includes/post.php)
            $extended = get_extended($post->post_content);
            $extended['excerpt'] = $config('~theme.post.content_excerpt') && has_excerpt() ? get_the_excerpt() : '';

            // Use the content excerpt?
            if ($extended['excerpt']) {
                $content = $extended['excerpt'];
            }

        ?>

        <?php if ($content && (is_single() || $config('~theme.blog.content'))) : ?>
            <div<?= $view->attrs($attrs_content) ?> property="text">

                <?php if (is_single() && $multipage) : ?>
                    <p class="uk-text-meta tm-page-break <?= ($page == '1') ? 'tm-page-break-first-page' : '' ?>"><?= sprintf(__('Page %s of %s', 'yootheme'), $page, $numpages) ?></p>
                <?php endif ?>

                <?php if (is_numeric($config('~theme.post.content_length')) && $config('~theme.post.content_length') >= 0) : ?>
                    <?= Str::limit(strip_tags($content), $config('~theme.post.content_length'), '...', false) ?>
                <?php else : ?>
                    <?= $content ?>
                <?php endif ?>

                <?php if (is_single()) {
                    echo link_pages();
                } ?>

            </div>
        <?php endif ?>

        <?php if ($config('~theme.post.tags') && $tags = get_the_tags()) : ?>
        <p<?= $view->attrs($attrs_tags) ?>>
            <?php $i = 1 ?>
            <?php foreach ($tags as $tag) :
                $seperator = $i++ < count($tags) ? ',' : '' ?>
                <a href="<?= get_tag_link($tag->term_id) ?>"><?= $tag->name ?></a><?= $seperator ?>
            <?php endforeach ?>
        </p>
        <?php endif ?>

        <?php if (!is_single() && $config('~theme.post.button') && ($config('~theme.post.content_length') || $extended['extended'] || $extended['excerpt'])) : ?>
        <p<?= get_attrs($attrs_button_container) ?>>
            <a<?= get_attrs($attrs_button) ?> href="<?= get_permalink() ?>"><?= $extended['more_text'] ?: __('Continue reading', 'yootheme') ?></a>
        </p>
        <?php endif ?>

        <?php if ($edit = get_edit_post_link()) : ?>
        <p>
            <a href="<?= esc_url($edit) ?>"><?= sprintf(__('%1$s Edit', 'yootheme'), '<span uk-icon="pencil"></span>') ?></a>
        </p>
        <?php endif ?>

        <?php if (is_single() && $config('~theme.post.navigation')) : ?>
        <ul class="uk-pagination uk-margin-medium">
            <?php if ($prev = get_previous_post_link('%link', sprintf(__('%1$s Previous', 'yootheme'), '<span uk-pagination-previous></span>'))) : ?>
            <li><?= $prev ?></li>
            <?php endif ?>
            <?php if ($next = get_next_post_link('%link', sprintf(__('Next %1$s', 'yootheme'), '<span uk-pagination-next></span>'))) : ?>
            <li class="uk-margin-auto-left"><?= $next ?></li>
            <?php endif ?>
        </ul>
        <?php endif ?>

        <?php if (is_single() && get_the_author_meta('description')) : ?>
        <hr class="uk-margin-medium-top">
        <div class="uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m">
                <?= get_avatar(get_the_author_meta('user_email')) ?>
            </div>
            <div class="uk-width-expand@m">
                <h4 class="uk-margin-small-bottom"><?php the_author() ?></h4>
                <div><?php the_author_meta('description') ?></div>
            </div>
        </div>
        <hr>
        <?php endif ?>

    <?php if ($attrs_container) : ?>
    </div>
    <?php endif ?>

</article>
