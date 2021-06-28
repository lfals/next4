<?php

namespace YOOtheme\Theme\Wordpress;

return [

    'actions' => [

        'admin_enqueue_scripts' => [
            PostsListener::class => 'addScripts',
        ],

        'customize_controls_init' => [
            PostsListener::class => 'saveDraft',
        ],

    ],

    'filters' => [

        'page_row_actions' => [
            PostsListener::class => ['postActions', 15, 2],
        ],

        'post_row_actions' => [
            PostsListener::class => ['postActions', 15, 2],
        ],

        'display_post_states' => [
            PostsListener::class => ['postStates', 15, 2],
        ],

        'gutenberg_can_edit_post_type' => [
            PostsListener::class => 'postType',
        ],

        'use_block_editor_for_post_type' => [
            PostsListener::class => 'postType',
        ],

    ],

];
