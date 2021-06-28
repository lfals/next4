<?php

namespace YOOtheme;

$root = __DIR__;
$cache = "{$root}/cache";
$loader = require "{$root}/vendor/autoload.php";

if (!is_dir($cache)) {
    mkdir($cache);
}

Path::setAlias('~theme', $root);
Path::setAlias('~yootheme', "{$root}/vendor/yootheme");
Path::setAlias('~assets/uikit', "{$root}/vendor/assets/uikit");

$app = Application::getInstance($cache);
$app->load('~theme/vendor/yootheme/{application,encryption,image,translation,http{-message,-server},view{,-metadata}}/bootstrap.php');

return $app;
