<?php
class ht_custom_post{
    public $post_name;
    public $post_slug;
    public $post_labels = array();
    public $post_arg = array();
    public $taxonomy_name;
    public function __construct($name, $slug = NULL){
        if(!$name){
            throw new Exception('Defina o nome do Post Type');
        }else{
            if(!$slug)
                $slug = $name;
            $this->post_name = $name;
            $this->post_slug = $slug;
        }
        //$this->do_post();
    }
    protected function arg(){
        $args = array(
			'labels'              => $this->labels(),
			'hierarchical'        => false,
			'supports'            => array( 'title','editor','thumbnail','comments', 'revisions', 'trackbacks' ),
			'public'              => true,
            'menu_position'       => 5,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array('slug' => $this->post_slug,'with_front' => true),
			'capability_type'     => 'post'
		);
        return array_merge($args, $this->post_arg);
    }
    protected function labels(){
        $label = array(
            'name'              => "{$this->post_name}",
            'singular_name'     => "{$this->post_name}",
            'view_item'         => __("Ver {$this->post_name}"),
            'edit_item'         => __("Editar {$this->post_name}"),
            'vsearch_items'     => __("Buscar {$this->post_name}"),
            'update_item'       => __("Atualizar {$this->post_name}"),
            'parent_item_colon' => __("Parente post {$this->post_name}"),
            'menu_name'         => __("{$this->post_name}"),
            'add_new'           => __("Adicionar novo(a)"),
            'add_new_item'      => __("Adicionar novo(a)"),
            'new_item'          => __("Novo(a) {$this->post_name}"),
            'all_items'         => __("Todos os(as) {$this->post_name}"),
            'not_found'         => __("Nenhum post {$this->post_name} encontrado"),
            'not_found_in_trash'=> __("Nenhum post {$this->post_name} encontrado na lixeira")
        );
        return array_merge( $label, $this->post_labels );
    }
    public function set_arg($propertie, $value = NULL){
        if(is_array($propertie) && $propertie != "taxonomies"){
            $this->post_arg = $propertie;
        }else{
            if(!$value){
                throw new Exception("Defina um valor para a propiedade {$propertie}");
            }else{
                $this->post_arg[$propertie] = $value;
                //var_dump($this->post_arg);
            }
        }
    }
    public function set_label($propertie, $value = NULL){
        if(is_array($propertie)){
            $this->post_labels = $propertie;
        }else{
            $this->post_label[$propertie] = $value;
        }
    }
    public function do_post(){
      if($this->taxonomy_name){
        //$tax =
        $this->set_arg("taxonomies", array($this->taxonomy_name));
      }
      //var_dump($this->arg());
      register_post_type($this->post_slug, $this->arg());
      add_action( 'init', array( $this, 'do_post' ) );
    }
    #ADD 15/06/2016
    public function add_taxonomy($taxonomy_name, $slug, $taxonomy_args = NULL){
      $args = array(
        'labels' => array(
          'name'              => __($taxonomy_name),
          'singular_name'     => __($taxonomy_name),
          'all_items'         => __("Todas as {$taxonomy_name}"),
          'edit_item'         => __("Editar {$taxonomy_name}"),
          'view_item'         => __("Ver {$taxonomy_name}"),
          'update_item'       => __("Atualizar {$taxonomy_name}"),
          'add_new_item'      => __("Adicionar novo {$taxonomy_name}"),
          'new_item_name'     => __("Novo nome para {$taxonomy_name}"),
          'parent_item'       => __("Filho de {$taxonomy_name}"),
          'parent_item_colon' => __("{$taxonomy_name}: "),
          'search_items'      => __("Procurar por {$taxonomy_name}"),
          'popular_items'     => __("Populares em {$taxonomy_name}"),
          'add_or_remove_items' => __("Adicionar ou remover itens de {$taxonomy_name}"),
          'choose_from_most_used' => __("Escolher de {$taxonomy_name} mais usada")
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_tagcloud'       => true,
        'show_in_quick_edit'  => true,
        'meta_box_cb'         => null,
        'show_admin_column'   => true,
        'description'         => '',
        'hierarchical'        => true,
        'query_var'           => true,
        'rewrite'             => array("slug" => $slug )
      );
      if($taxonomy_name){
        $this->taxonomy_name = $taxonomy_name;
        if(is_array($taxonomy_args)){
            $aux_args = array_merge($args, $taxonomy_args);
        }else{
          $aux_args = $args;
        }
        register_taxonomy( $slug, array($this->post_slug), $args );
        //add_action( 'init', array( $this, 'add_taxonomy' ) );
        return TRUE;
      }else{
        return FALSE;
      }
    }
    /*
    * Função para gerenciar as tabelas exibidas
    *
    * Adicionada em 26/09/2019
    */
    public function manage_columns($args = NULL){
      foreach($args as $i => $a){
        $labels[$a["column"]]   = $a["label"];
        $fields[$i]   = array( "column" => $a["column"], "postmeta" => $a["postmeta"] );
      }
      add_filter("manage_{$this->post_slug}_posts_columns", function() use($labels){
        $columns = $labels;
        return $columns;
      });
      add_action("manage_{$this->post_slug}_posts_custom_column", function($column_name) use ($fields){
        global $post;
        foreach($fields as $f){
          if($f["postmeta"] == "post_date" && $column_name == $f["column"]){
            $dataFormatada = new DateTime($post->post_date);
            print $dataFormatada->format('d/m/Y H:i');
          }elseif(get_post_meta( $post->ID, $f["postmeta"] )[0] && $column_name == $f["column"]){
            print get_post_meta( $post->ID, $f["postmeta"] )[0];
          }else{
            print " ";
          }
        }
      },10,1);
    }
    /*
    * Função para remover o link de View da listagem de posts
    *
    * Adicionada em 29/09/2019
    */
    public function revome_view_row(){
      add_filter( 'post_row_actions', function($actions, $post){
        if( $post->post_type === $this->post_slug ) unset( $actions['view'] );
        return $actions;
      }, 10, 2 );
    }
    /*
    * Função para criar ou editar posts (para editar, basta passar o argumento ID)
    *
    * Adicionada em 27/09/2019
    */
    public function save_post($args){
      if(!is_array($args))
        return false;
      if(!$args["post_type"]) $args["post_type"] = $this->post_slug;

      foreach($args as $i => $a){
        switch ($i) {
          case "ID":
            $atr["ID"] = $a;
            break;

          case "post_author":
            $atr["post_author"] = $a;
            break;

          case "post_date":
            $atr["post_date"] = $a;
            break;

          case "post_date_gmt":
            $atr["post_date_gmt"] = $a;
            break;

          case "post_content":
            $atr["post_date_gmt"] = $a;
            break;

          case "post_content_filtered":
            $atr["post_content_filtered"] = $a;
            break;

          case "post_title":
            $atr["post_title"] = $a;
            break;

          case "post_excerpt":
            $atr["post_excerpt"] = $a;
            break;

          case "post_status":
            $atr["post_status"] = $a;
            break;

          case "post_type":
            $atr["post_type"] = $a;
            break;

          case "comment_status":
            $atr["comment_status"] = $a;
            break;

          case "ping_status":
            $atr["ping_status"] = $a;
            break;

          case "post_password":
            $atr["post_password"] = $a;
            break;

          case "post_name":
            $atr["post_name"] = $a;
            break;

          case "to_ping":
            $atr["to_ping"] = $a;
            break;

          case "pinged":
            $atr["pinged"] = $a;
            break;

          case "post_modified":
            $atr["post_modified"] = $a;
            break;

          case "post_modified_gmt":
            $atr["post_modified_gmt"] = $a;
            break;

          case "post_parent":
            $atr["post_parent"] = $a;
            break;

          case "menu_order":
            $atr["menu_order"] = $a;
            break;

          case "post_mime_type":
            $atr["post_mime_type"] = $a;
            break;

          case "guid":
            $atr["guid"] = $a;
            break;

          case "post_category":
            $atr["post_category"] = $a;
            break;

          case "tags_input":
            $atr["tags_input"] = $a;
            break;

          case "tax_input":
            $atr["tax_input"] = $a;
            break;

          case "meta_input":
            $atr["meta_input"] = $a;
            break;

          default:
            $postmeta["$i"] = $a;
            break;
        }
      }

      $post = wp_insert_post($atr);
      foreach($postmeta as $key => $meta){
        update_post_meta($post, "{$key}", "{$meta}");
      }

      return $post;
    }
}
