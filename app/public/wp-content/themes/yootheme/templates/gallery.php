<?php
/**
 * Template part for displaying the gallery shortcode.
 *
 * original gallery shortcode is located in wp-includes/media.php
 *
 * @link https://codex.wordpress.org/Gallery_Shortcode
 */

namespace YOOtheme;

$post = get_post();

if (!empty($gallery_attr['ids'])) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if (empty($gallery_attr['orderby'])) {
        $gallery_attr['orderby'] = 'post__in';
    }
    $gallery_attr['include'] = $gallery_attr['ids'];
}

$atts = shortcode_atts(
    array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'figure',
        'icontag'    => 'div',
        'captiontag' => 'figcaption',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => '',
        'link' => '',
    ),
    $gallery_attr,
    'gallery'
);

$atts['columns'] = $atts['columns'] > 6 ? 6 : $atts['columns'];
$id = intval( $atts['id'] );

if (!empty($atts['include'])) {
    $_attachments = get_posts(
        array(
            'include'        => $atts['include'],
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        )
    );

    $attachments = array();
    foreach ($_attachments as $key => $val) {
        $attachments[$val->ID] = $_attachments[$key];
    }
} elseif (!empty($atts['exclude'])) {
    $attachments = get_children(
        array(
            'post_parent'    => $id,
            'exclude'        => $atts['exclude'],
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        )
    );
} else {
    $attachments = get_children(
        array(
            'post_parent'    => $id,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        )
    );
}

?>

<div uk-grid class="uk-child-width-1-<?= $atts['columns'] ?>">

    <?php foreach ($attachments as $image) : ?>
        <div class='uk-text-center'>

            <?php
            if (!empty($atts['link']) && 'file' === $atts['link']) {
                $img = wp_get_attachment_link($image->ID, $atts['size'], false, false, false);
            } elseif (!empty($atts['link']) && 'none' === $atts['link']) {
                $img = wp_get_attachment_image($image->ID, $atts['size']);
            } else {
                $img = wp_get_attachment_link($image->ID, $atts['size'], true, false, false);
            }
            ?>

            <?= $img ?>

            <?php if ($caption = wptexturize($image->post_excerpt)) : ?>
                <div class='uk-panel uk-padding-small'><?= $caption ?></div>
            <?php endif ?>

        </div>
    <?php endforeach ?>

</div>
