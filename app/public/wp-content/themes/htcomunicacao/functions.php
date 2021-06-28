<?php
/* Adicionar Loader das Classes */
require_once __DIR__ . "/ht_include/core/class/loader.php";
require_once __DIR__ . "/ht_include/setup.php";
/* Helpers do tema HT */
require_once __DIR__ . "/ht_include/core/ht_helpers.php";
require_once __DIR__ . "/ht_include/core/ht_products.php";
/* Setup padrão HT */
require_once __DIR__ . "/core/setup.php";
require_once __DIR__ . "/core/actions.php";

/** Funções do Tema */

add_shortcode("code", function($params, $content = NULL){
    $params = shortcode_atts([
        "lang" => "none",
    ], $params);

    return "<pre><code class=\"language-{$params["lang"]}\">{$content}</code></pre>";
});