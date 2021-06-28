<?php

namespace YOOtheme\Builder\Wordpress\Source;

use YOOtheme\Builder;
use YOOtheme\Builder\Templates\TemplateHelper;
use YOOtheme\Config;
use YOOtheme\Event;
use YOOtheme\View;

class TemplateListener
{
    public static function includeTemplate(TemplateHelper $helper, Builder $builder, Config $config, View $view, $tpl)
    {
        $template = Event::emit('builder.template', $tpl);

        if (empty($template['type'])) {
            return $tpl;
        }

        if ($config('app.isCustomizer')) {
            $config->set('customizer.view', $template['type']);
        }

        if ($view['sections']->exists('builder')) {
            return $tpl;
        }

        if ($matched = $helper->match($template)) {

            $template += $matched + ['layout' => [], 'params' => []];

            // set template identifier
            if ($config('app.isCustomizer')) {
                $config->set('customizer.template', $template['id']);
            }

            // get template from request?
            if ($templ = get_theme_mod('template') and $templ['id'] == $template['id']) {
                $template['layout'] = $templ['layout'];
            }

            if (!empty($template['layout'])) {
                $view['sections']->set('builder', function () use ($builder, $template) {
                    // render builder with template
                    return $builder->render(json_encode($template['layout']), $template['params'] + [
                        'prefix' => "template-{$template['id']}",
                    ]);
                });
            }

        }

        return $tpl;
    }

    public static function matchTemplate($tpl)
    {
        global $post;

        if (is_page() || is_single()) {
            return [
                'type' => "single-{$post->post_type}",
                'query' => !post_password_required($post)
                    ? ['terms' => array_column(wp_get_object_terms($post->ID, get_object_taxonomies($post)), 'term_id')]
                    : function () { return false; },
            ];
        }

        $pages = get_query_var('paged') && get_query_var('paged') !== 1 ? 'except_first' : 'first';

        if ($tpl === get_index_template()) {
            return [
                'type' => 'archive-post',
                'query' => compact('pages'),
            ];
        }

        $object = get_queried_object();

        if (is_post_type_archive()) {
            return [
                'type' => "archive-{$object->name}",
                'query' => compact('pages'),
            ];
        }

        if (is_author()) {
            return [
                'type' => 'author-archive',
                'query' => compact('pages'),
            ];
        }

        if (is_date()) {
            return [
                'type' => 'date-archive',
                'query' => [
                    'archive' => is_time() ? 'time' : (is_day() ? 'day' : (is_month() ? 'month' : 'year')),
                    'pages' => $pages,
                ],
            ];
        }

        if (is_tax() || is_category() || is_tag()) {
            return [
                'type' => "taxonomy-{$object->taxonomy}",
                'query' => ['terms' => $object->term_id, 'pages' => $pages],
            ];
        }

        if (is_search()) {
            return [
                'type' => 'search',
                'query' => compact('pages'),
            ];
        }

        if (is_404()) {
            return [
                'type' => 'error-404',
                'query' => [],
            ];
        }
    }
}
