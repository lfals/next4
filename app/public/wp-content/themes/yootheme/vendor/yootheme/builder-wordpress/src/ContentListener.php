<?php

namespace YOOtheme\Builder\Wordpress;

use YOOtheme\Builder;
use YOOtheme\Config;
use YOOtheme\Http\Request;
use YOOtheme\Http\Response;
use YOOtheme\Path;
use YOOtheme\Str;
use YOOtheme\View;

class ContentListener
{
    const PATTERN = '/<!--\s?(\{(?:.*?)\})\s?-->/';

    public static function onTemplateInclude(Builder $builder, Config $config, View $view, $template)
    {
        if (!is_page() && !is_single()) {
            return $template;
        }

        global $post;

        if (post_password_required($post)) {
            return $template;
        }

        $content = isset($post->post_content) ? self::matchContent($post->post_content) : false;

        if ($config('app.isCustomizer')) {

            if ($page = get_theme_mod('page')) {
                if ($post->ID === $page['id']) {
                    $content = !empty($page['content']) ? json_encode($page['content']) : null;
                } else {
                    unset($page);
                }
            }

            $modified = !empty($page);

            $config->add('customizer.page', [
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => $content ? $builder->load($content) : $content,
                'modified' => $modified,
                'collision' => self::getCollisionInfo($post),
            ]);

        }

        // Render builder output
        if ($content) {
            // Delay rendering to ensure regular WordPress content flow (wp_enqueue_scripts hook before shortcode hooks)
            $view['sections']->set('builder', function () use ($builder, $content, $post) {
                return $builder->render($content, ['prefix' => 'page', 'post' => $post]);
            });
        }

        return $template;
    }

    public static function onLateTemplateInclude(Config $config, View $view, $template)
    {
        if ($view['sections']->exists('builder')) {
            $config->set('app.isBuilder', true);
            return Path::get('~theme/page.php');
        }

        return $template;
    }

    public static function onPrePostContent($content)
    {
        // Prevent content filters from corrupting builder JSON in post_content on save.
        if (self::matchContent($content)) {
            if (is_callable('kses_remove_filters')) {
                kses_remove_filters();
            }

            if (is_callable('wp_remove_targeted_link_rel_filters')) {
                wp_remove_targeted_link_rel_filters();
            }
        }

        return $content;
    }

    public static function onBuilderContent($content, $parameters)
    {
        $parameters += ['prefix' => ''];

        // Ensure `the_content` filter is only applied on main page content
        if (!Str::startsWith($parameters['prefix'], ['page', 'template-'])) {
            return do_shortcode($content);
        }

        // Remove wpautop filter
        $priority = has_filter('the_content', 'wpautop');

        if ($priority !== false) {
            remove_filter('the_content', 'wpautop', $priority);
        }

        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        if ($priority !== false) {
            add_filter('the_content', 'wpautop', $priority);
        }

        return $content;
    }

    public static function savePage(Request $request, Response $response, Builder $builder)
    {
        $request->abortIf(!$page = $request('page'), 400)
                ->abortIf(!$page = base64_decode($page), 400)
                ->abortIf(!$page = json_decode($page), 400)
                ->abortIf(!current_user_can('edit_post', $page->id), 403, 'Insufficient User Rights.');

        $collision = self::getCollisionInfo(get_post($page->id));

        if (!$request('overwrite') and $collision['contentHash'] !== $page->collision->contentHash) {
            return $response->withJSON(['hasCollision' => true, 'collision' => $collision]);
        }

        $data = [
            'ID' => $page->id,
            'post_content' => '',
            'page_template' => '', // Skip page_template (Prevents error "Invalid page template.")
        ];

        if ((array) $page->content) {

            $content = json_encode($page->content);
            $fulltext = json_encode($builder->withParams(['context' => 'save'])->load($content));
            $introtext = $builder->withParams(['context' => 'content'])->render($content);

            $data['post_content'] = wp_slash("{$introtext}\n<!--more-->\n<!-- {$fulltext} -->");
        }

        $updated = wp_update_post($data, true);

        if (is_wp_error($updated)) {
            $request->abort(500, $updated->get_error_message());
        }

        update_post_meta($page->id, '_edit_last', get_current_user_id());

        $post = get_post($page->id);

        return $response->withJSON([
            'id' => $page->id,
            'collision' => self::getCollisionInfo($post),
        ]);
    }

    protected static function getCollisionInfo($post)
    {
        $userId = get_post_meta($post->ID, '_edit_last', true) or
        $revs = wp_get_post_revisions($post->ID) and $lastRev = end($revs) and $userId = $lastRev->post_author;

        $modifiedBy = $userId ? get_userdata($userId)->data->display_name : '';

        return [
            'contentHash' => md5($post->post_content),
            'modifiedBy' => $modifiedBy,
        ];
    }

    protected static function matchContent($content)
    {
        return $content && strpos($content, '<!--') !== false && preg_match(self::PATTERN, $content, $matches) ? $matches[1] : null;
    }
}
