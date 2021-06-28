<?php

namespace YOOtheme\Builder\Wordpress\PopularPosts;

use WordPressPopularPosts\Helper;
use YOOtheme\Str;

class SourceListener
{
    public static function initSource($source)
    {
        if (!class_exists(Helper::class)) {
            return;
        }

        $arguments = [
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
        ];

        foreach (get_post_types($arguments, 'objects') as $name => $type) {

            if (!$type->rest_base || $name === $type->rest_base) {
                continue;
            }

            $query = Str::camelCase([$type->rest_base, 'Query'], true);

            $source->objectType($query, Type\PopularPostsQueryType::config($type));
        }
    }
}
