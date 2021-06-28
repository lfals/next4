<?php
class hattrick{
  
  private $css;
  private $js;

  public $login_logo = "https://lh3.googleusercontent.com/pw/ACtC-3fQtDDLvLtwIrhSt44fOw7_5pH8Exv1H7l6iFHiIaLewZL-XWZYnkgA7I2scE8HlVWt7enhoJhJdIqSD7MozOPfvWwxSvCidXzHGHb5D33bu47TGkcTZm1VsGpe8GujDn2UOx51SXU1tttEbcKcIwvJKg=w210-h115-no?authuser=0";
  public $login_header_url = "http://htcomunicacao.com.br";
  public $login_bg = "http://hattrickcomunicacao.com.br/feed/login/bg-body.png";

  public function __construct()
  {
    $home_exist = get_option( 'front_page_created' );
    $blog_exist = get_option( 'blog_page_created' );
    $theme_install = get_option( 'ht_theme_install' );

    if(!$home_exist){
      $home = wp_insert_post([
        "post_title" => "Home",
        "post_type" => "page",
        "post_name" => "home",
        "post_status" => "publish",
      ]);

      add_option( 'front_page_created', 'true' );
    }

    if(!$blog_exist){
      $blog = wp_insert_post([
        "post_title" => "Blog",
        "post_type" => "page",
        "post_name" => "blog",
        "post_status" => "publish",
      ]);

      add_option( 'blog_page_created', 'true' );
    }

    if( !$theme_install ){
      $home = get_page_by_title("Home");
      $blog = get_page_by_title("Blog");
      
      update_option( 'page_on_front', $home->ID );
      update_option( 'show_on_front', 'page' );

      update_option( 'page_for_posts', $blog->ID );
    }

    add_action("switch_theme", function(){
      delete_option("ht_theme_install");
      delete_option("ht_products_taxonomies");
      delete_option("front_page_created");
      delete_option("blog_page_created");

      update_option( 'show_on_front', 'posts' );
      update_option( 'page_on_front', 0 );
      update_option( 'page_for_posts', 0 );
    }, 10 , 2);

  }
  public function register_css($name, $path = NULL){
    if(is_array($name)){
      foreach($name as $i => $n){
          $this->css[] = $n;
      }
    }elseif(is_string($name)){
      if($path)
        $this->css[] = array($name, $path);
      else
        return FALSE;
    }elseif(!$name)
      return NULL;
  }
  public function register_js($name, $path = NULL){
    if(is_array($name)){
      foreach($name as $i => $n){
          $this->js[] = $n;
      }
    }elseif(is_string($name)){
      if($path)
        $this->js[] = array($name, $path);
      else
        return FALSE;
    }elseif(!$name)
      return NULL;
  }
  public function do_css(){
    if($this->css){
      foreach($this->css as $c){
        if($GLOBALS['pagenow'] != 'wp-login.php')
          if(!is_admin())
            wp_enqueue_style($c[0], $c[1], $c[2], $c[3], $c[4]);
      }

      return TRUE;
    }else
      return FALSE;
  }
  public function do_js(){
    if($this->js){
      foreach($this->js as $c){
        if($GLOBALS['pagenow'] != 'wp-login.php')
          //if(!is_admin())
            wp_enqueue_script($c[0], $c[1], $c[2], $c[3], $c[4]);
      }
      return TRUE;
    }else
      return FALSE;
  }
  public function do_woocoomerce(){ add_theme_support( 'woocommerce' ); }
  public function ht_woocommerce(){ add_action( 'after_setup_theme', array($this, "do_woocoomerce") ); }
  public function hide_admin_bar(){ add_filter('show_admin_bar', '__return_false'); }
  public function show_admin_bar(){ add_filter('show_admin_bar', '__return_true'); }
  public function add_thumb($size_h = NULL, $size_v = NULL){
    if(!$size_h)
      $size_h = 120;
    if(!$size_v)
      $size_v = 120;
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( $size_h, $size_v );
  }
  /*
  * Função para adicionar os campos de otmização SEO
  *
  * Adicionada em 26/09/2019
  */
  public function add_seo_fields($args = NULL){
    if(!$args)
      $args = array("post", "page");
    foreach($args as $a){
      $arr_post_type[] = array(
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => "$a",
        )
      );
    }
    if(function_exists('acf_add_local_field_group')){

      acf_add_local_field_group(array (
      	'key' => 'group_5c796a0a3317f',
      	'title' => 'Otimização SEO',
      	'fields' => array (
      		array (
      			'key' => 'field_5c796a69bd89a',
      			'label' => 'Tag title otimizada',
      			'name' => 'ht_seo_title',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array (
      			'key' => 'field_5c796a86bd89b',
      			'label' => 'Metatag description otimizada',
      			'name' => 'ht_seo_description',
      			'type' => 'textarea',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'maxlength' => 319,
      			'rows' => 5,
      			'new_lines' => '',
      		),

      	),
      	'location' => $arr_post_type,
      	'menu_order' => 10,
      	'position' => 'side',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'active' => 1,
      	'description' => '',
      ));
    }

  }
  /*
  * Função para adicionar os campos de otmização de compartilhamento do FB
  *
  * Adicionada em 26/09/2019
  */
  public function add_fb_fields($args = NULL){
    if(!$args)
      $args = array("post", "page");
    foreach($args as $a){
      $arr_post_type[] = array(
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => "$a",
        )
      );
    }
    if(function_exists('acf_add_local_field_group')){

      acf_add_local_field_group(array (
      	'key' => 'group_5c796b0b47308',
      	'title' => 'Otimização para Facebook',
      	'fields' => array (
      		array (
      			'key' => 'field_5c796b3205232',
      			'label' => 'Título',
      			'name' => 'ht_site_og_title',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array (
      			'key' => 'field_5c796b9305233',
      			'label' => 'Tipo',
      			'name' => 'ht_site_og_type',
      			'type' => 'select',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'choices' => array (
      				'activity' => 'activity',
      				'actor' => 'actor',
      				'album' => 'album',
      				'article' => 'article',
      				'athlete' => 'athlete',
      				'author' => 'author',
      				'band' => 'band',
      				'bar' => 'bar',
      				'blog' => 'blog',
      				'book' => 'book',
      				'cafe' => 'cafe',
      				'cause' => 'cause',
      				'city' => 'city',
      				'company' => 'company',
      				'country' => 'country',
      				'director' => 'director',
      				'drink' => 'drink',
      				'food' => 'food',
      				'game' => 'game',
      				'government' => 'government',
      				'hotel' => 'hotel',
      				'landmark' => 'landmark',
      				'movie' => 'movie',
      				'musician' => 'musician',
      				'non_profit' => 'non_profit',
      				'politician' => 'politician',
      				'product' => 'product',
      				'public_figure' => 'public_figure',
      				'restaurant' => 'restaurant',
      				'school' => 'school',
      				'song' => 'song',
      				'sport' => 'sport',
      				'sports_league' => 'sports_league',
      				'sports_team' => 'sports_team',
      				'state_province' => 'state_province',
      				'tv_show' => 'tv_show',
      				'university' => 'university',
      				'website' => 'website',
      			),
      			'default_value' => array (
                      'article'
      			),
      			'allow_null' => 0,
      			'multiple' => 0,
      			'ui' => 0,
      			'ajax' => 0,
      			'return_format' => 'value',
      			'placeholder' => '',
      		),

      		array (
      			'key' => 'field_5c796dbb05234',
      			'label' => 'Descrição',
      			'name' => 'ht_site_og_description',
      			'type' => 'textarea',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'maxlength' => 297,
      			'rows' => 5,
      			'new_lines' => '',
      		),
      		array (
      			'key' => 'field_5c796de905235',
      			'label' => 'Imagem',
      			'name' => 'ht_site_og_image',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array (
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'thumbnail',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      	),

      	'location' => $arr_post_type,
      	'menu_order' => 10,
      	'position' => 'side',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'active' => 1,
      	'description' => '',
      ));
    }

  }
  /*
  * Função para adicionar páginas de opção
  *
  * Adicionada em 26/09/2019
  */
  public function add_options_pages($page_title, $menu_slug, $menu_title = NULL, $parent_slug = NULL, $capability = "edit_posts", $position = 2){
    if($parent_slug && function_exists("acf_add_options_sub_page")){
      if(!$menu_title)
        $menu_title = $page_title;
      $args = array("page_title"  => $page_title,"menu_title"  => $menu_title,"menu_slug"   => $menu_slug,"parent_slug" => $parent_slug);
      $parent = acf_add_options_sub_page($args);
      $args = NULL;
    }elseif(function_exists("acf_add_options_page")){
      if(!$menu_title)
        $menu_title = $page_title;
      $args = array("page_title"  => $page_title,"menu_slug"   => $menu_slug,"capability"  => $capability,"position"    => $position );
      $parent = acf_add_options_page($args);
      $args = NULL;
    }else{return false;}
  }
  /*
  * Função para adicionar páginas de opção padrão
  *
  * Adicionada em 26/09/2019
  */
  public function add_default_options_pages(){
    $this->add_options_pages("Opções do site", "conf_site", "Opções do site");
    $this->add_options_pages("Configurar Informações", "conf_site_institucional", "Institucional", "conf_site");
    $this->add_options_pages("Configurar Navegação", "conf_site_navegacao", "Navegação", "conf_site");
    $this->add_options_pages("Depoimentos", "conf_testimony", "Depoimentos", "conf_site");
    $this->add_options_pages("Configurar Scripts", "conf_site_scripts", "Scripts", "conf_site");
    if( function_exists('acf_add_local_field_group') ){
      //Institucional
      acf_add_local_field_group(array(
      	'key' => 'group_5f42981875468',
      	'title' => 'Informações',
      	'fields' => array(
      		array(
      			'key' => 'field_5f42981ea3458',
      			'label' => 'Logo',
      			'name' => 'ht_option_logo',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'medium',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5f42983da3459',
      			'label' => 'Logo negativo',
      			'name' => 'ht_option_logo_negative',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'medium',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5f429855a345a',
      			'label' => 'Favicon',
      			'name' => 'ht_option_favicon',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'medium',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5f4298faa345b',
      			'label' => 'Endereço',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 0,
      		),
      		array(
      			'key' => 'field_5f429905a345c',
      			'label' => 'Endereço completo',
      			'name' => 'ht_option_address',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array(
      			'key' => 'field_5f42993fa345d',
      			'label' => 'Link da rota',
      			'name' => 'ht_option_rote',
      			'type' => 'url',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '50',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      		),
      		array(
      			'key' => 'field_5f429954a345e',
      			'label' => 'iFrame do Google Maps',
      			'name' => 'ht_option_map',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '50',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array(
      			'key' => 'field_5f429969a345f',
      			'label' => '',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 1,
      		),
      		array(
      			'key' => 'field_5f429dfcc0cb6',
      			'label' => 'Contato',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 0,
      		),
      		array(
      			'key' => 'field_5f429abba3460',
      			'label' => 'E-mail principal',
      			'name' => 'ht_option_mail',
      			'type' => 'email',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '25',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      		),
      		array(
      			'key' => 'field_5f429c46a3461',
      			'label' => 'WhatsApp',
      			'name' => 'ht_option_whatsapp',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '25',
      				'class' => 'ht-mask__tel',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array(
      			'key' => 'field_5f429c46a3w61',
      			'label' => 'Telefone fixo',
      			'name' => 'ht_option_phone',
      			'type' => 'text',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '25',
      				'class' => 'ht-mask__tel',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      			'prepend' => '',
      			'append' => '',
      			'maxlength' => '',
      		),
      		array(
      			'key' => 'field_5f429c6ea3462',
      			'label' => 'Link para WhatsApp',
      			'name' => 'ht_option_whatsapp_url',
      			'type' => 'url',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '25',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => '',
      		),
      		array(
      			'key' => 'field_5f429e0ec0cb7',
      			'label' => '',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 1,
      		),
      		array(
      			'key' => 'field_5f429cd6a3463',
      			'label' => 'Social',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 0,
      		),
      		array(
      			'key' => 'field_5f429ce0a3464',
      			'label' => 'Facebook',
      			'name' => 'ht_option_social_fb',
      			'type' => 'url',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => 'Ex.: https://facebook.com/seu_usuario',
      		),
      		array(
      			'key' => 'field_5f429ceda3465',
      			'label' => 'Instagram',
      			'name' => 'ht_option_social_ig',
      			'type' => 'url',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => 'Ex.: https://instagram.com/seu_usuario',
      		),
      		array(
      			'key' => 'field_5f429d05a3466',
      			'label' => 'YouTube',
      			'name' => 'ht_option_social_yt',
      			'type' => 'url',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'placeholder' => 'Ex.: https://youtube.com/',
      		),
          array(
      			'key' => 'field_5f42981ea3499',
      			'label' => 'OG Imagem Global',
      			'name' => 'ht_site_og_image',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '33.3',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'array',
      			'preview_size' => 'medium',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5f429d348b991',
      			'label' => 'Social',
      			'name' => '',
      			'type' => 'accordion',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'open' => 1,
      			'multi_expand' => 1,
      			'endpoint' => 1,
      		),

      	),
      	'location' => array(
      		array(
      			array(
      				'param' => 'options_page',
      				'operator' => '==',
      				'value' => 'conf_site_institucional',
      			),
      		),
      	),
      	'menu_order' => 0,
      	'position' => 'normal',
      	'style' => 'default',
      	'label_placement' => 'top',
      	'instruction_placement' => 'label',
      	'hide_on_screen' => '',
      	'active' => true,
      	'description' => '',
      ));
      //Scripts
      acf_add_local_field_group(array(
        'key' => 'group_5d8d12b2b92a1',
        'title' => "Partes de códigos",
        'fields' => array(
          array(
            'key' => 'field_5d8d12b7a0913',
            'label' => 'Códigos no cabeçalho',
            'name' => 'ht_options_script_header',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ),
          array(
            'key' => 'field_5d8d12c9a0914',
            'label' => 'Códigos no rodapé',
            'name' => 'ht_options_script_footer',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'conf_site_scripts',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ));
      //Navegação
      acf_add_local_field_group(array(
        'key' => 'group_5faead0846309',
        'title' => 'Navegação',
        'fields' => array(
          array(
            'key' => 'field_5faead0e3f4c5',
            'label' => 'Itens',
            'name' => 'ht_nav',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'collapsed' => 'field_5faead2a3f4c6',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => 'Novo item',
            'sub_fields' => array(
              array(
                'key' => 'field_5faead2a3f4c6',
                'label' => 'Rótulo',
                'name' => 'ht_nav_label',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ),
              array(
                'key' => 'field_5faead403f4c7',
                'label' => 'Link externo?',
                'name' => 'ht_nav_external',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '30',
                  'class' => '',
                  'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
              ),
              array(
                'key' => 'field_5faead5c3f4c8',
                'label' => 'Link',
                'name' => 'ht_nav_link',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                  array(
                    array(
                      'field' => 'field_5faead403f4c7',
                      'operator' => '==',
                      'value' => '1',
                    ),
                  ),
                ),
                'wrapper' => array(
                  'width' => '70',
                  'class' => '',
                  'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
              ),
              array(
                'key' => 'field_5faeadbe3f4c9',
                'label' => 'Link interno',
                'name' => 'ht_nav_link_internal',
                'type' => 'page_link',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                  array(
                    array(
                      'field' => 'field_5faead403f4c7',
                      'operator' => '!=',
                      'value' => '1',
                    ),
                  ),
                ),
                'wrapper' => array(
                  'width' => '40',
                  'class' => '',
                  'id' => '',
                ),
                'post_type' => '',
                'taxonomy' => '',
                'allow_null' => 0,
                'allow_archives' => 1,
                'multiple' => 0,
              ),
              array(
                'key' => 'field_5faeade53f4ca',
                'label' => 'Ancora',
                'name' => 'ht_nav_anchor',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                  array(
                    array(
                      'field' => 'field_5faead403f4c7',
                      'operator' => '!=',
                      'value' => '1',
                    ),
                  ),
                ),
                'wrapper' => array(
                  'width' => '30',
                  'class' => '',
                  'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ),
              array(
                'key' => 'field_5faeae113f4cb',
                'label' => 'Sub itens',
                'name' => 'ht_nav_subitem',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'collapsed' => 'field_5faeae4c3f4cc',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Novo sub item',
                'sub_fields' => array(
                  array(
                    'key' => 'field_5faeae4c3f4cc',
                    'label' => 'Rótulo',
                    'name' => 'ht_nav_subitem_label',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                      'width' => '',
                      'class' => '',
                      'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                  ),
                  array(
                    'key' => 'field_5faeae5e3f4cd',
                    'label' => 'Link externo?',
                    'name' => 'ht_nav_subitem_external',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                      'width' => '30',
                      'class' => '',
                      'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                  ),
                  array(
                    'key' => 'field_5faeae803f4ce',
                    'label' => 'Link',
                    'name' => 'ht_nav_subitem_link',
                    'type' => 'url',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                      array(
                        array(
                          'field' => 'field_5faeae5e3f4cd',
                          'operator' => '==',
                          'value' => '1',
                        ),
                      ),
                    ),
                    'wrapper' => array(
                      'width' => '70',
                      'class' => '',
                      'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                  ),
                  array(
                    'key' => 'field_5faeae9c3f4cf',
                    'label' => 'Link',
                    'name' => 'ht_nav_subitem_link_internal',
                    'type' => 'page_link',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                      array(
                        array(
                          'field' => 'field_5faeae5e3f4cd',
                          'operator' => '!=',
                          'value' => '1',
                        ),
                      ),
                    ),
                    'wrapper' => array(
                      'width' => '40',
                      'class' => '',
                      'id' => '',
                    ),
                    'post_type' => '',
                    'taxonomy' => '',
                    'allow_null' => 0,
                    'allow_archives' => 1,
                    'multiple' => 0,
                  ),
                  array(
                    'key' => 'field_5faeaebd3f4d0',
                    'label' => 'Ancora',
                    'name' => 'ht_nav_subitem_anchor',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                      array(
                        array(
                          'field' => 'field_5faeae5e3f4cd',
                          'operator' => '!=',
                          'value' => '1',
                        ),
                      ),
                    ),
                    'wrapper' => array(
                      'width' => '30',
                      'class' => '',
                      'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                  ),
                ),
              ),
            ),
          ),
          array(
            'key' => 'field_60183c8ae11fc',
            'label' => 'Contato',
            'name' => '',
            'type' => 'accordion',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'open' => 0,
            'multi_expand' => 0,
            'endpoint' => 0,
          ),
          array(
            'key' => 'ht_cta_group',
            'label' => 'CTA',
            'name' => 'ht_nav_contact_cta',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_60183b582666a',
                  'operator' => '!=',
                  'value' => '1',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '100',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array(
            'key' => 'field_60183b582666a',
            'label' => 'Link externo?',
            'name' => 'ht_nav_contact_external',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '30',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => 'field_60183b9c2666c',
            'label' => 'Link interno',
            'name' => 'ht_nav_contact_link_internal',
            'type' => 'page_link',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_60183b582666a',
                  'operator' => '!=',
                  'value' => '1',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '40',
              'class' => '',
              'id' => '',
            ),
            'post_type' => '',
            'taxonomy' => '',
            'allow_null' => 0,
            'allow_archives' => 1,
            'multiple' => 0,
          ),
          array(
            'key' => 'field_60183be42666d',
            'label' => 'Ancora',
            'name' => 'ht_nav_contact_anchor',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_60183b582666a',
                  'operator' => '!=',
                  'value' => '1',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '30',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array(
            'key' => 'field_60183b7d2666b',
            'label' => 'Link',
            'name' => 'ht_nav_contact',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_60183b582666a',
                  'operator' => '==',
                  'value' => '1',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '70',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'conf_site_navegacao',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
      ));
    }
  }
  /*
  * Função para adicionar o dashboard padrão
  *
  * Adicionada em 27/09/2019
  */
 
  /*
  * Função para remover boxes do dashboard. O action não funcionou com função anonima.
  *
  * Adicionada em 27/09/2019
  */
  public function dashboard_remove_meta_box(){
    remove_meta_box("dashboard_browser_nag","dashboard","normal");
    remove_meta_box("dashboard_right_now","dashboard","normal");
    remove_meta_box("dashboard_activity","dashboard","normal");
    remove_meta_box("dashboard_quick_press","dashboard","core");
    remove_meta_box("dashboard_primary","dashboard","core");
    remove_meta_box("dashboard_primary","dashboard","side");
    remove_meta_box("dashboard_primary","dashboard","normal");
    remove_meta_box("dashboard_quick_press","dashboard","side");
  }
  /*
  * Função para remover os itens do menu que não utilizaremos
  *
  * Adicionada em 29/09/2019
  */
  public function remove_menu_itens($args = NULL){
    add_action('admin_menu', function() use($args){
      if(!$args){
        remove_menu_page( 'edit-comments.php' );
        remove_menu_page( 'upload.php' );
      }elseif(is_string($args)){
        remove_menu_page( $args );
      }elseif(is_array($args)){
        foreach($args as $a){
          remove_menu_page( $a );
        }
      }else{
        return false;
      }
    });
  }

  public static function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if($page) { return $page->ID; } else { return null; }
  }

  /**
   * Criado em 04/01/2021
   */

  public function products($taxonomies = null, $icon = "dashicons-store")
  {
    if($taxonomies == null){
      $taxonomies = [
        [ "Categoria","categoria" ],
        [ "Marca", "marca" ],
      ];
    }
    $tax = get_option( 'ht_products_taxonomies' );
    if(!$tax){
      add_option( 'ht_products_taxonomies', $taxonomies );
    }else{
      update_option( 'ht_products_taxonomies', $taxonomies );
    }

    $produto = new ht_custom_post("Produtos", "produto");
    $produto->set_arg("menu_icon", $icon);

    foreach($taxonomies as $taxonomy){
      $produto->add_taxonomy($taxonomy[0], $taxonomy[1]);
    }

    $produto->do_post();

    // $page_exist = get_option("product_page_created");

    // if(!$page_exist){
    //   $page = wp_insert_post([
    //     "post_title" => "Catálogo",
    //     "post_type" => "page",
    //     "post_name" => "catalogo",
    //     "post_status" => "publish",
    //     "page_template" => "page-template-produtos.php",
    //   ]);

    //   add_option("product_page_created", "true");
    // }

    add_action( 'admin_init', function () {
      $id = 'products_page';
      
      add_settings_field( $id, 'Página de produtos:', function(){
        $id = 'products_page';
        wp_dropdown_pages( array(
            'name'              => $id,
            'show_option_none'  => '&mdash; Selecionar &mdash;',
            'option_none_value' => '0',
            'selected'          => get_option( $id ),
        ) );
        update_post_meta( get_option( $id ), '_wp_page_template', 'page-template-produtos.php' );
      }, 'reading', 'default', array(
          'label_for' => 'field-' . $id,
          'class'     => 'row-' . $id,
      ) );
    } );

    add_filter( 'whitelist_options', function ( $options ) {
      $options['reading'][] = 'products_page';
  
      return $options;
    } );  

    add_filter( 'display_post_states', function($post_states, $post){
       ;
      if($post->ID == get_option("products_page")){
        $post_states[] = 'Págiana de produtos';
      }
    
      return $post_states;
    }, 10, 2 );
    
  }

}