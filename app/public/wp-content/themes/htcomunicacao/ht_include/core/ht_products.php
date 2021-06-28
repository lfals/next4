<?php
function ht_get_product($id = null)
{
  if(empty($id))
    $p = get_queried_object();
  else
    $p = $id;

  $content = [
    "title" => $p->post_title,
    "codigo" => get_field("ht_product_code", $p),
    "descricao" => get_field("ht_product_description", $p),
    "galeria" => get_field("ht_product_gallery", $p),
    "video" => get_field("ht_product_video", $p),
    "options" => get_field("ht_product_options", $p),
    "content" => get_field("ht_product_content", $p),
  ];

  return $content;
}

function ht_get_taxonomies_list()
{
  $produtos = ht_get_products();
  if(!empty($produtos) && is_array($produtos))
  {
    foreach($produtos as $produto)
    {
      $produtos_list[] = $produto->ID;
    }
  }

  $produtosAll = ht_get_all_products();
  if(!empty($produtosAll) && is_array($produtosAll))
  {
    foreach($produtosAll as $produtoAll)
    {
      $produtosAll_list[] = $produtoAll->ID;
    }
  }

  $taxonomies = get_option( 'ht_products_taxonomies' );

  if($taxonomies){
    foreach($taxonomies as $taxonomy){
      $return[] = [
        "name" => $taxonomy[0],
        "slug" => $taxonomy[1],
        "list" => wp_get_object_terms($produtos_list, $taxonomy[1]),
      ];
    }
  }

  

  // $segmentos = wp_get_object_terms($produtos_list, "segmento");

  // $categorias = wp_get_object_terms($produtosAll_list, "categoria");

  // $marcas = wp_get_object_terms($produtos_list, "marca");

  // $return = [
  //   "categorias" => [
  //     "name" => "Categorias",
  //     "slug" => "categoria",
  //     "list" => $categorias
  //   ],
  //   "marcas" => [
  //     "name" => "Marcas",
  //     "slug" => "marca",
  //     "list" => $marcas,
  //   ],
  // ];

  return $return;
}

function ht_get_products()
{
  $taxonomies = $_GET["filtro"];

  $posts = new ht_post_group;
  $posts->set_arg("post_type", "produto");
  $posts->set_arg("post_per_page", -1);
  $posts->set_arg("orderby", "name");
  $posts->set_arg("order", "ASC");
  if($_GET["search"])
    $posts->set_arg("s", $_GET["search"]);
  if(!empty($taxonomies) && is_array($taxonomies))
  {
    $tax_query["relation"] = "IN";
    foreach($taxonomies as $key => $tax)
    {
      $tax_query[] = [
        "taxonomy" => $key,
        "terms" => $tax,
        "field" => "term_id",
        "operator" => "IN",
        "include_children" => true,
      ];
    }

    $posts->tax_query($tax_query);
  }

  $posts = $posts->get_post();

  return $posts;
}

function ht_get_all_products()
{
  $taxonomies = $_GET["filtro"];

  $posts = new ht_post_group;
  $posts->set_arg("post_type", "produto");
  $posts->set_arg("post_per_page", -1);
  $posts->set_arg("orderby", "name");
  $posts->set_arg("order", "ASC");

  $posts = $posts->get_post();

  return $posts;
}

function ht_get_cart_url()
{
  $nav = ht_get_nav();

  return $nav["nav"]["cart"]["url"];
}

function ht_get_product_url()
{
  return get_field("ht_options_products", "options") ;
}

function ht_get_trash_url(int $id = null, int $indice = null)
{
  $url = ht_get_cart_url();
  return "{$url}?id={$id}&index={$indice}&". md5("ht-dm-action") ."=". md5("remove-cart");
}

function ht_get_order_url()
{
  $url = get_field("ht_nav_register_pedidos", "options");

  if(!empty($url))
    return get_permalink($url);
  else
    return false;
}

function ht_add_to_cart()
{
  if($_POST[md5("ht-dm-action")] == md5("ht-add-cart"))
  {
    $post = get_post( sanitize_text_field( $_POST[md5("ht-dm-id")] ) );

    if(!empty($post) && get_class($post) == "WP_Post")
    {
      if( !empty( $_POST[md5("ht-dm-quantidade")] ) && is_numeric( $_POST[md5("ht-dm-quantidade")] ) )
        $quantidade = $_POST[md5("ht-dm-quantidade")];
      else
        $quantidade = 1;

      $static = ht_get_product($post);

      $_SESSION["cart"][] = [
        "id" => (int) $_POST[md5("ht-dm-id")],
        "produto" => $post,
        "titulo" => $static["title"],
        "quantidade" => $quantidade,
        "opcao" => $_POST[ md5("ht-dm-option") ],
      ];

      wp_redirect(ht_get_cart_url());
      exit;
    }
    else
    {
      wp_redirect(ht_get_product_url());
      exit;
    }
  }
  if($_GET[md5("ht-dm-action")] == md5("ht-add-cart"))
  {
    $post = get_post( sanitize_text_field( $_GET[md5("ht-dm-id")] ) );

    if(!empty($post) && get_class($post) == "WP_Post")
    {
      if( !empty( $_GET[md5("ht-dm-quantidade")] ) && is_numeric( $_GET[md5("ht-dm-quantidade")] ) )
        $quantidade = $_POST[md5("ht-dm-quantidade")];
      else
        $quantidade = 1;

      $static = ht_get_product($post);

      $_SESSION["cart"][] = [
        "id" => (int) $_GET[md5("ht-dm-id")],
        "produto" => $post,
        "titulo" => $static["title"],
        "quantidade" => $quantidade,
        "opcao" => $_POST[ md5("ht-dm-option") ],
      ];

      $_SESSION["ht-success"] = "Produto adicionado ao carrinho";
      wp_redirect(ht_get_cart_url());
      exit;
    }
    else
    {
      wp_redirect(ht_get_product_url());
      exit;
    }
  }
}

function ht_get_add_cart_url($id)
{
  $url = "?". md5("ht-dm-action") ."=". md5("ht-add-cart");
  $url .= "&". md5("ht-dm-id") ."={$id}";

  return ht_get_product_url() . $url;
}

function ht_remove_item_cart()
{
  //"{$url}?id={$id}&index={$index}&". md5("ht-dm-action") ."=". md5("remove-cart")

  if($_GET[md5("ht-dm-action")] == md5("remove-cart"))
  {
    $id = $_GET["id"];
    $indice = $_GET["index"];

    if(
      !empty($id) &&
      is_numeric($id)
    )
    {
      if($_SESSION["cart"][$indice]["id"] == $id)
        unset($_SESSION["cart"][$indice]);
      $_SESSION["ht-success"] = "Produto removido do carrinho com sucesso";
    }
    wp_redirect(ht_get_cart_url());
    exit;
  }
}

function ht_finish_order()
{
  if($_POST[md5("ht-dm-action")] == md5("ht-dm-finish"))
  {
    $_SESSION["finish"] = true;

    if(!is_user_logged_in())
    {
      $_SESSION["ht-error"] = "Você precisa estar logado para finalizar o pedido";
      wp_redirect(ht_get_cart_url());
      exit;
    }
    else
    {
      if(!empty($_SESSION["cart"]) && is_array($_SESSION["cart"]))
      {
        foreach($_SESSION["cart"] as $i=> $c)
        {
          unset($_SESSION["cart"][$i]["produto"]);
        }
        $post = new ht_custom_post("cotacao");
        $post = $post->save_post([
          "ht_cotacao_status" => "Pedido recebido",
          "post_status" => "publish",
          "ht_cotacao_dados" => json_encode($_SESSION["cart"],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
        wp_update_post([
          "ID" => $post,
          "post_title" => "Cotação #". str_pad($post, 8, '0', STR_PAD_LEFT),
        ]);
        $_SESSION["ht-success"] = "Pedido de cotação realizado com sucesso!";
        $_SESSION["cart"] = null;
        $_SESSION["finish"] = null;
        unset($_SESSION["cart"]);
        unset($_SESSION["finish"]);
        wp_redirect(ht_get_order_url());
        exit;
      }
      else
      {
        $_SESSION["ht-error"] = "Seu carrinho está vazio";
        wp_redirect(ht_get_cart_url());
      }
    }
  }
}

ht_add_to_cart();
ht_remove_item_cart();
ht_finish_order();
