<?php

namespace YOOtheme\Wordpress;

use YOOtheme\Url;

class Router
{
    public static function generate($pattern = '', array $parameters = [], $secure = null)
    {
        return Url::to(admin_url('admin-ajax.php'), ['p' => $pattern, 'action' => 'kernel'] + $parameters, $secure);
    }
}
