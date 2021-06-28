<?php 
//Configurações padrão do tema
$ht = new hattrick;
//Adicionando o CSS padrão do tema
$ht->register_css(array(
    array("ht_theme_reset", get_template_directory_uri() ."/ht_include/css/reset.css"),
    array("ht_theme_main_css", get_template_directory_uri() ."/ht_include/css/main.css"),
    array("ht_theme_gallery_css", get_template_directory_uri() ."/ht_include/css/gallery.css"),
    array("ht_theme_blog_css", get_template_directory_uri() ."/ht_include/css/blog.css"),
    array("ht_theme_products_css", get_template_directory_uri() ."/ht_include/css/products.css"),
    array("ht_theme_home_css", get_template_directory_uri() ."/ht_include/css/home.css"),
    array("ht_theme_slider_css", get_template_directory_uri() ."/ht_include/css/slider.css"),
    array("ht_theme_header_css", get_template_directory_uri() ."/ht_include/css/header.css"),
    array("ht_theme_footer_css", get_template_directory_uri() ."/ht_include/css/footer.css"),
    array("ht_theme_contact_css", get_template_directory_uri() ."/ht_include/css/contact.css"),
    array("ht_theme_testimonal_css", get_template_directory_uri() ."/ht_include/css/testimonal.css"),
    array("ht_theme_fontawesome_css", get_template_directory_uri() . '/ht_include/css/vendor/all.css'),
    array("ht_theme_slick_css", get_template_directory_uri() . '/ht_include/css/vendor/slick.min.css'),
    array("ht_theme_lightgallery_css", get_template_directory_uri() . '/ht_include/css/vendor/lightgallery.min.css'),
    array("ht_theme_sweetalert2_css", get_template_directory_uri() . '/ht_include/css/vendor/sweetalert2.min.css'),
));
$ht->do_css();
//Adicionando o JS padrão do tema
$ht->register_js(array(
    array('jquery', get_template_directory_uri() . '/ht_include/js/vendor/jquery.min.js'),
    array('jquery_mobile', get_template_directory_uri() . '/ht_include/js/vendor/jquery.mobile.custom.min.js', array('jquery')),
    array('jquery_mask', get_template_directory_uri() . '/ht_include/js/vendor/jquery.mask.min.js', array('jquery')),
    array('slick_js', get_template_directory_uri() . '/ht_include/js/vendor/slick.min.js'),
    array('fontawesome_js', get_stylesheet_directory_uri() . '/ht_include/js/all.js'),
    array('lightgallery_js', get_template_directory_uri() . '/ht_include/js/vendor/lightgallery.min.js', array('jquery')),
    array('lg_fullscreen_js', get_template_directory_uri() . '/ht_include/js/vendor/lg-fullscreen.min.js', array('jquery')),
    array('lg_thumnail_js', get_template_directory_uri() . '/ht_include/js/vendor/lg-thumbnail.min.js', array('jquery')),
    array('lg_video_js', get_template_directory_uri() . '/ht_include/js/vendor/lg-video.min.js', array('jquery')),
    array('sweetalert2_js', get_template_directory_uri() . '/ht_include/js/vendor/sweetalert2.min.js', array('jquery')),
    array('ht_theme_produto_js', get_stylesheet_directory_uri() . '/ht_include/js/product.js'),
    array('ht_theme_main_js', get_stylesheet_directory_uri() . '/ht_include/js/main.js'),
));
$ht->do_js();
//Incluindo arquivo file.php caso seja necessário realizar uploads
if(!function_exists('wp_handle_upload')) { require_once( ABSPATH . 'wp-admin/includes/file.php' ); }
//Inserindo o arquivo admin.css no Dashboard
function ht_admin_css(){ if(file_exists(get_template_directory() ."/css/admin.css")) print "<style>@import \"". get_template_directory_uri() ."/css/admin.css\"</style>"; }
add_action('admin_head', 'ht_admin_css');
//Inserindo o arquivo admin.js no Dashboard
function ht_admin_js(){if(file_exists(get_template_directory() ."/js/admin.js")) print "<script src=\"". get_template_directory_uri() ."/js/admin.js\"></script>"; }
add_action('admin_head', 'ht_admin_js');