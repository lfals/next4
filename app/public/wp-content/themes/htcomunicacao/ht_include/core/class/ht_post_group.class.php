<?php
class ht_post_group{
  public $post_type;
  public $args;
  public function __construct($post_type = NULL){
    $this->args = array(
    	'posts_per_page'   => 300,
    	'offset'           => 0,
    	'category'         => '',
    	'category_name'    => '',
    	'orderby'          => 'date',
    	'order'            => 'DESC',
    	'include'          => '',
    	'exclude'          => '',
    	'meta_key'         => '',
    	'meta_value'       => '',
    	'post_type'        => 'post',
    	'post_mime_type'   => '',
    	'post_parent'      => '',
    	'author'	   => '',
    	'post_status'      => 'publish',
    	'suppress_filters' => true
    );
    if($post_type){
      $this->post_type = $post_type;
      $this->args["post_type"] = $post_type;
    }else{
      $this->post_type = "post";
    }
  }
  public function set_arg($propertie, $value = NULL){
      if(is_array($propertie)){
          $this->args = $propertie;
      }else{
          if(!$value){
              throw new Exception("Defina um valor para a propiedade {$propertie}");
          }else{
              $this->args[$propertie] = $value;
              //var_dump($this->post_arg);
          }
      }
  }
  public function meta_key($key = NULL, $value = NULL){
    if($key && $value){
      $this->args["meta_key"] = $key;
      $this->args["meta_value"] = $value;
    }
  }
  public function set_number_post($num = NULL){
    if($num){
      if(is_numeric($num)){
        $this->args['posts_per_page'] = (int)$num;
        return TRUE;
      }else
        return FALSE;
    }else{
      return NULL;
    }
  }
  public function set_order_by($orderby = NULL, $order = NULL, $meta_key = NULL){
    if($orderby){
      $this->args['orderby'] = $orderby;
      if($order)
        $this->args['order'] = $order;
      if($meta_key)
        $this->args['meta_key'] = $meta_key;
      return TRUE;
    }else
      return NULL;
  }
  public function tax_query($arg = NULL){
    if($arg){
      $this->args["tax_query"] = $arg;
      //var_dump($this->args["tax_query"]);
      return TRUE;
    }
    else{
        return NULL;
    }
  }
  public function meta_query($args = NULL){
    if($args){
      $this->args["meta_query"] = $args;
    }
  }
  public function tax($arg = NULL, $value = NULL){
    if($arg && $value){
      $this->args["$arg"] = $value;
    }
  }
  public function get_post(){
    $myposts = get_posts($this->args);
    // print "<pre>";
    // var_dump($this->args);
    // print "</pre>";
    $arr = NULL;
    foreach($myposts as $post){
      $arr[] = $post;
    }
    return $arr;
  }
}
