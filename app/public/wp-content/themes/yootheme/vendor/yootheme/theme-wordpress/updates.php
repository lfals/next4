<?php

use YOOtheme\Arr;

return [

    '1.20.0-beta.6' => function ($config, array $params) {

        // Deprecated Blog settings
        if (!empty($config) && !Arr::has($config, 'post.image_margin')) {

            if (Arr::get($config, 'post.meta_align') == 'top') {
                Arr::set($config, 'post.meta_margin', Arr::get($config, 'post.image_align') == 'top' ? 'large' : 'medium');
            }

            if (Arr::get($config, 'post.meta_align') == 'bottom') {
                Arr::set($config, 'post.title_margin', Arr::get($config, 'post.image_align') == 'top' ? 'large' : 'medium');
            }

            if (Arr::get($config, 'post.content_width') === true) {
                Arr::set($config, 'post.content_width', 'small');
            }

            if (Arr::get($config, 'post.content_width') === false) {
                Arr::set($config, 'post.content_width', '');
            }

            if (Arr::get($config, 'post.header_align') === true) {
                Arr::set($config, 'blog.header_align', 1);
            }

        }

        return $config;
    },

];
