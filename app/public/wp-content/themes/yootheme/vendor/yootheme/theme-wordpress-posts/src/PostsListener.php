<?php

namespace YOOtheme\Theme\Wordpress;

class PostsListener
{
    public static function addScripts($hook)
    {
        // is edit page, post?
        if (!in_array($hook, ['post.php', 'post-new.php'])) {
            return;
        }

        $url = get_template_directory_uri();
        $link = add_query_arg(['url' => urlencode(get_permalink()), 'autofocus[section]' => 'builder'], wp_customize_url());

        // redirect to customizer?
        if ($hook == 'post-new.php' && isset($_GET['yootheme-builder'])) {
            wp_redirect($link); exit;
        }

        add_action('edit_form_after_title', function ($post) use ($link) {
            printf('<div class="tm-editor" hidden><a href="%s" class="tm-button">%s</a><a href class="tm-link">%s</a></div>', $link, __('YOOtheme Builder', 'yootheme'), __('&#8592; Back to Classic Editor', 'yootheme'));
        });

        add_action('media_buttons', function ($editor_id) use ($link) {
            if ($editor_id === 'content') {
                printf('<a href="%s" class="button button-primary">%s</a>', $link, __('YOOtheme Builder', 'yootheme'));
            }
        });

        add_filter('wp_editor_settings', function ($settings) {

            if (preg_match('/<!--\s?{/', get_post_field('post_content'))) {
                $settings['default_editor'] = 'html';
            }

            return $settings;
        });

        printf('<script>var $customizer = %s;</script>', json_encode(compact('link')));

        wp_enqueue_script('posts-builder', "{$url}/vendor/yootheme/theme-wordpress-posts/app/posts.min.js", [], false, true);
    }

    public static function saveDraft()
    {
        global $wp_customize;

        $url = $wp_customize->get_preview_url();
        $post = get_post(url_to_postid($url));

        // is auto-draft?
        if ($post && $post->post_status == 'auto-draft') {

            // update post
            wp_update_post([
                'ID' => $post->ID,
                'post_status' => 'draft',
                'post_title' => __('Draft') . " #{$post->ID}",
            ], true);

            // update return url
            $wp_customize->set_return_url(get_edit_post_link($post->ID));
        }
    }

    public static function postType($result)
    {
        return in_array(get_post_type(), ['page', 'post']) && preg_match('/<!--\s?{/', get_post_field('post_content')) ? false : $result;
    }

    public static function postStates($post_states, $post)
    {
        // is builder?
        if ($post and $post->builder = preg_match('/<!--\s?{/', $post->post_content)) {

            $post_states = (array) $post_states;

            // remove gutenberg?
            $key = array_search('Gutenberg', $post_states);

            if ($key !== false) {
                unset($post_states[$key]);
            }

            $post_states['yootheme'] = __('YOOtheme', 'yootheme');
        }

        return $post_states;
    }

    public static function postActions($actions, $post)
    {
        if (!empty($post->builder)) {

            $link = add_query_arg(['url' => urlencode(get_permalink($post->ID)), 'autofocus[section]' => 'builder'], wp_customize_url());
            $actions['yootheme'] = sprintf('<a href="%s" class="tm-button">%s</a>', $link, __('YOOtheme Builder', 'yootheme'));

            unset($actions['classic']);
        }

        return $actions;
    }
}
