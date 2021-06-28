<?php

namespace YOOtheme\Theme\Wordpress;

return [

    'routes' => [
        ['get', '/finder', [FinderController::class, 'index']],
    ],

];
