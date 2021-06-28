<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\File;

class WooCommerceListener
{
    /**
     * Initialize theme config.
     *
     * @param Config $config
     */
    public static function initTheme(Config $config)
    {
        // ignore files from being compiled into theme.css
        if (!class_exists('WooCommerce')) {
            $config->set('styler.ignore_less.woocommerce', 'woocommerce.less');
        }
    }

    /**
     * Initialize customizer config.
     *
     * @param Config $config
     */
    public static function initCustomizer(Config $config)
    {
        $file = File::find("~theme/css/theme{.{$config('theme.id')},}.css");
        $compiled = strpos(File::getContents($file), '.woocommerce');

        // check if theme css needs to be updated
        if (class_exists('WooCommerce') xor $compiled) {
            $config->set('customizer.sections.styler.update', true);
        }
    }

    /**
     * Remove WooCommerce general style.
     *
     * @param array $styles
     *
     * @return array
     */
    public static function removeStyle($styles)
    {
        unset($styles['woocommerce-general']);

        return $styles;
    }

    /**
     * Stop template matching if WooCommerce page.
     *
     * @return void|false
     */
    public static function matchTemplate()
    {
        if (is_callable('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
            return false;
        }
    }
}
