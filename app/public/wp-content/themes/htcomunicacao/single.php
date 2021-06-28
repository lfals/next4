<?php
/*  Arquivo que configura exibição do Post padrão Wordpress */
get_header();
get_template_part("template/global","header");
get_template_part("template/post","content");
get_template_part("template/global","footer");
get_template_part("template/global","footer-nav");
get_footer();
