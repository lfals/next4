<?php

namespace YOOtheme;

/**
 * Increase xdebug max nesting level.
 */
if ($level = ini_get('xdebug.max_nesting_level')) {
    ini_set('xdebug.max_nesting_level', max($level, 256));
}

/**
 * Gets a service from application.
 *
 * @param string $id
 * @param string ...$ids
 *
 * @return mixed
 */
function app($id = null, ...$ids) {

    $app = Application::getInstance();

    return $id ? $app($id, ...$ids) : $app;
}
