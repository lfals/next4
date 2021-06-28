<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

use function YOOtheme\app;
use YOOtheme\Arr;
use function YOOtheme\link_pages;
use YOOtheme\Path;
use YOOtheme\View;

class PostType
{
    /**
     * @param \WP_Post_Type $type
     *
     * @return array
     */
    public static function config(\WP_Post_Type $type)
    {
        $taxonomies = array_column(array_filter(get_object_taxonomies($type->name, 'object'), function ($taxonomy) {
            return $taxonomy->public && $taxonomy->show_ui && $taxonomy->show_in_nav_menus;
        }), 'name', 'label');

        $fields = [

            'title' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Title',
                    'filters' => ['limit'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::title',
                ],
            ],

            'content' => [
                'type' => 'String',
                'args' => [
                    'show_intro_text' => [
                        'type' => 'Boolean',
                    ],
                ],
                'metadata' => [
                    'label' => 'Content',
                    'arguments' => [
                        'show_intro_text' => [
                            'label' => 'Intro Text',
                            'description' => 'Show or hide the intro text.',
                            'type' => 'checkbox',
                            'default' => true,
                            'text' => 'Show intro text',
                        ],
                    ],
                    'filters' => ['limit'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::content',
                ],
            ],

            'teaser' => [
                'type' => 'String',
                'args' => [
                    'show_excerpt' => [
                        'type' => 'Boolean',
                    ],
                ],
                'metadata' => [
                    'label' => 'Teaser',
                    'arguments' => [
                        'show_excerpt' => [
                            'label' => 'Excerpt',
                            'description' => 'Display the excerpt field if it has content, otherwise the intro text.',
                            'type' => 'checkbox',
                            'default' => true,
                            'text' => 'Prefer excerpt over intro text',
                        ],
                    ],
                    'filters' => ['limit'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::teaser',
                ],
            ],

            'excerpt' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Excerpt',
                    'filters' => ['limit'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::excerpt',
                ],
            ],

            'date' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Date',
                    'filters' => ['date'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::date',
                ],
            ],

            'modified' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Modified',
                    'filters' => ['date'],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::modified',
                ],
            ],

            'commentCount' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Comment Count',
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::commentCount',
                ],
            ],

            'metaString' => [
                'type' => 'String',
                'args' => [
                    'format' => [
                        'type' => 'String',
                    ],
                    'separator' => [
                        'type' => 'String',
                    ],
                    'link_style' => [
                        'type' => 'String',
                    ],
                    'show_publish_date' => [
                        'type' => 'Boolean',
                    ],
                    'show_author' => [
                        'type' => 'Boolean',
                    ],
                    'show_comments' => [
                        'type' => 'Boolean',
                    ],
                    'show_taxonomy' => [
                        'type' => 'String',
                    ],
                    'date_format' => [
                        'type' => 'String',
                    ],
                ],
                'metadata' => [
                    'label' => 'Meta',
                    'arguments' => [

                        'format' => [
                            'label' => 'Format',
                            'description' => 'Display the meta text in a sentence or a horizontal list.',
                            'type' => 'select',
                            'default' => 'list',
                            'options' => [
                                'List' => 'list',
                                'Sentence' => 'sentence',
                            ],
                        ],
                        'separator' => [
                            'label' => 'Separator',
                            'description' => 'Set the separator between fields.',
                            'default' => '|',
                            'enable' => 'arguments.format === "list"',
                        ],
                        'link_style' => [
                            'label' => 'Link Style',
                            'description' => 'Set the link style.',
                            'type' => 'select',
                            'default' => '',
                            'options' => [
                                'Default' => '',
                                'Muted' => 'link-muted',
                                'Text' => 'link-text',
                                'Heading' => 'link-heading',
                                'Reset' => 'link-reset',
                            ],
                        ],
                        'show_publish_date' => [
                            'label' => 'Display',
                            'description' => 'Show or hide fields in the meta text.',
                            'type' => 'checkbox',
                            'default' => true,
                            'text' => 'Show date',
                        ],
                        'show_author' => [
                            'type' => 'checkbox',
                            'default' => true,
                            'text' => 'Show author',
                        ],
                        'show_comments' => [
                            'type' => 'checkbox',
                            'default' => true,
                            'text' => 'Show comment count',
                        ],
                        'show_taxonomy' => [
                            'type' => 'select',
                            'default' => $type->name === 'post' ? 'category' : '',
                            'show' => (bool) $taxonomies,
                            'options' => [
                                'Hide Term List' => '',
                            ] + array_combine(array_map(function ($name) { return "Show {$name}"; }, array_keys($taxonomies)), $taxonomies),
                        ],
                        'date_format' => [
                            'label' => 'Date Format',
                            'description' => 'Select a predefined date format or enter a custom format.',
                            'type' => 'data-list',
                            'default' => '',
                            'options' => [
                                'Aug 6, 1999 (M j, Y)' => 'M j, Y',
                                'August 06, 1999 (F d, Y)' => 'F d, Y',
                                '08/06/1999 (m/d/Y)' => 'm/d/Y',
                                '08.06.1999 (m.d.Y)' => 'm.d.Y',
                                '6 Aug, 1999 (j M, Y)' => 'j M, Y',
                                'Tuesday, Aug 06 (l, M d)' => 'l, M d',
                            ],
                            'enable' => 'arguments.show_publish_date',
                            'attrs' => [
                                'placeholder' => 'Default',
                            ],
                        ],
                    ],
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::metaString',
                ],
            ],

            'featuredImage' => [
                'type' => 'Attachment',
                'metadata' => [
                    'label' => 'Featured Image',
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::featuredImage',
                ],
            ],

            'link' => [
                'type' => 'String',
                'metadata' => [
                    'label' => 'Link',
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::link',
                ],
            ],

            'author' => [
                'type' => 'User',
                'metadata' => [
                    'label' => 'Author',
                ],
                'extensions' => [
                    'call' => __CLASS__ . '::author',
                ],
            ],

        ];

        $metadata = [
            'type' => true,
            'label' => $type->labels->singular_name,
        ];

        $features = [
            'title' => 'title',
            'author' => 'author',
            'editor' => 'content',
            'excerpt' => 'excerpt',
            'thumbnail' => 'featuredImage',
            'comments' => 'commentCount',
        ];

        // omit unsupported static features
        if ($values = array_diff_key($features, get_all_post_type_supports($type->name))) {
            $fields = Arr::omit($fields, $values);
        }

        return compact('fields', 'metadata');
    }

    public static function title($post)
    {
        return get_the_title($post);
    }

    public static function content($postObj, $args)
    {
        global $page, $numpages, $multipage, $post;

        $args += ['show_intro_text' => true];

        // Hint: this returns different results depending on the current view (archive vs. single page)
        $content = get_the_content('', !$args['show_intro_text'], $postObj);
        $content = str_replace("<span id=\"more-{$postObj->ID}\"></span>", '', $content);

        if ($multipage && $postObj === $post) {
            $title = sprintf(__('Page %s of %s', 'yootheme'), $page, $numpages);
            $content = '<p class="uk-text-meta tm-page-break' . ($page == '1' ? ' tm-page-break-first-page' : '') . "\">{$title}</p>{$content}" . link_pages();
        }

        if (!has_blocks($content)) {
            $content = wpautop($content);
        }

        return $content;
    }

    public static function teaser($post, $args)
    {
        $args += ['show_excerpt' => true];

        if ($args['show_excerpt'] && has_excerpt($post)) {
            return get_the_excerpt($post);
        }

        $extended = get_extended($post->post_content);
        $teaser = $extended['main'];

        // Having multiple `<!-- wp:more -->` blocks confuses the parse_blocks function
        if (has_blocks($teaser)) {
            $teaser = do_blocks($teaser);
        }

        return $teaser;
    }

    public static function excerpt($post)
    {
        return get_the_excerpt($post);
    }

    public static function date($post)
    {
        return $post->post_date;
    }

    public static function modified($post)
    {
        return $post->post_modified;
    }

    public static function commentCount($post)
    {
        return $post->comment_count;
    }

    public static function link($post)
    {
        $link = get_permalink($post);
        if (is_string($link)) {
            return $link;
        }
    }

    public static function featuredImage($post)
    {
        return get_post_thumbnail_id($post) ?: null;
    }

    public static function author($post)
    {
        return get_userdata($post->post_author) ?: null;
    }

    public static function metaString($post, array $args)
    {
        $args += [
            'format' => 'list',
            'separator' => '|',
            'link_style' => '',
            'show_publish_date' => true,
            'show_author' => true,
            'show_comments' => true,
            'show_taxonomy' => $post->post_type === 'post' ? 'category' : '',
            'date_format' => '',
        ];

        return app(View::class)->render(Path::get('../../templates/meta'), compact('post', 'args'));
    }
}
