<?php

namespace YOOtheme\Theme\Wordpress;

class PostListener
{
    /**
     * Filters post galleries.
     *
     * @link https://developer.wordpress.org/reference/hooks/post_gallery/
     *
     * @param mixed $output
     * @param mixed $attr
     */
    public static function filterGallery($output, $attr)
    {
        ob_start();

        set_query_var('gallery_attr', $attr);
        get_template_part('templates/gallery');

        return ob_get_clean();
    }
}
