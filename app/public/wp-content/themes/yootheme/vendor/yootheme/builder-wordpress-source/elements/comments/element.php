<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node, $params) {

            global $withcomments, $post;

            if (!(is_single() || is_page() || $withcomments) || empty($post)) {
                return false;
            }

            if (!comments_open() && !get_comments_number() || post_password_required()) {
                return false;
            }

            wp_enqueue_script('comment-reply');

            $view = app(View::class);

            $view->addGlobal('comments.props', $node->props);
            $view->addGlobal('comments.attrs', $node->attrs);

        },

    ],

];
