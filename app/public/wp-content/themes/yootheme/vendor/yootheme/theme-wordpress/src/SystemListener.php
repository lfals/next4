<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class SystemListener
{
    /**
     * Check permission of current user.
     *
     * @param Request  $request
     * @param callable $next
     *
     * @return Response
     */
    public static function checkPermission($request, callable $next)
    {
        // check user capabilities
        if (!$request->getAttribute('allowed') && !current_user_can('edit_theme_options')) {
            $request->abort(403, 'Insufficient User Rights.');
        }

        return $next($request);
    }
}
