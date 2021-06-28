<?php
/**
* Todo o setup do tema deve ser feito neste arquivo.
*
* Instanciando uma nova classe HT
*/
$ht = new hattrick;
/*
* Adicionando o CSS
*/
$ht->register_css(array(
  array("ht_main_css", get_template_directory_uri() ."/css/main.css"),
  array("ht_prism_css", get_template_directory_uri() ."/css/prism.css"),

));
$ht->do_css();
/*
* Adicionando o JS
*/
$ht->register_js(array(
  array('ht_main', get_stylesheet_directory_uri() . '/js/main.js'),
  array('ht_prism', get_stylesheet_directory_uri() . '/js/prism.js'),
));
$ht->do_js();
/*
* Adicionando os campos de otimização SEO nos tipos de post especificados em $postTypes
*/
$postTypesFields = array( "post", "page");
$ht->add_seo_fields($postTypesFields);
$ht->add_fb_fields($postTypesFields);
/*
* Configurando o dashboard, login e admin menu
* Para alterar o layout da página de login, atualize essas configuracoes
* $ht->login_logo = "url";
* $ht->$login_bg = "url";
* $ht->login_header_url = "url";
*/

/*
* Adicionando as option pages padrões
*/
$ht->add_default_options_pages();
// $ht->add_options_pages("Serviços", "conf_services", "Serviços", "conf_site");
/*
 * Limpa o menu do WP
 */
$ht->remove_menu_itens();
/*
* Tipos de post
*/
// $nome_do_post = new ht_custom_post("nome_do_post-plural", "nome_do_post");
// $nome_do_post->set_arg("menu_icon", "dashicons-insert"); Muda icone
// $nome_do_post->add_taxonomy("Segmento", "segmento"); Adiciona Taxonomy (não)
// $nome_do_post->do_post();


$linha = new ht_custom_post("Linhas", "linha");
$linha->set_arg("menu_icon", "dashicons-insert"); 
$linha->do_post();


$vaga = new ht_custom_post("Vagas", "vaga");
$vaga->set_arg("menu_icon", "dashicons-admin-users"); 
$vaga->do_post();

