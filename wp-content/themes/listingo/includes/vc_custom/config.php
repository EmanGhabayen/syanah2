<?php

/**
 * @Visual Composer Theme setup
 */
/**
 * @Visual Composer Settings
 * @return {}
 */
if (class_exists('Vc_Manager', false)) {

    //Force to init Visual Composer 
    if (!function_exists('listingo_vc_set_as_theme')) {

        function listingo_vc_set_as_theme() {
            vc_set_as_theme();
        }

        add_action('vc_before_init', 'listingo_vc_set_as_theme');
    }

     $templates_path = get_template_directory() . '/includes/vc_custom/vc_templates/';
     vc_set_shortcodes_templates_dir($templates_path);


    /**
     * @Extend Icons
     */
    if (!function_exists('vc_iconpicker_type_listingoicon')) {
        //add_filter('vc_iconpicker-type-listingoicon', 'vc_iconpicker_type_listingoicon');

        function vc_iconpicker_type_listingoicon($icons) {
            $listingoicon = array(
                "listingo" => array(
                    array("lnr lnr-map-marker" => esc_html__("marker", "listingo")),
                )
            );
            return $listingoicon;
        }

    }

    /**
     * @Remove Woocomerce Shortcode
     * @return {}
     */
    if (!function_exists('listingo_vc_remove_woocommerce')) {

        function listingo_vc_remove_woocommerce() {
            if (is_plugin_active('woocommerce/woocommerce.php')) {
                vc_remove_element('woocommerce_cart');
                vc_remove_element('woocommerce_checkout');
                vc_remove_element('woocommerce_order_tracking');
                vc_remove_element('woocommerce_my_account');
                vc_remove_element('product');
                vc_remove_element('products');
                vc_remove_element('add_to_cart');
                vc_remove_element('add_to_cart_url');
                vc_remove_element('product_page');
                vc_remove_element('product_categories');
                vc_remove_element('product_attribute');
            }
        }

    }

    add_action('vc_build_admin_page', 'listingo_vc_remove_woocommerce', 11);
    add_action('vc_load_shortcode', 'listingo_vc_remove_woocommerce', 11);

    if (class_exists('ListingoVCGlobalSettings')) {
        $dir = ListingoVCGlobalSettings::get_plugin_path();
        $scan = glob("$dir/vc_custom/shortcodes/*");
        foreach ($scan as $path) {
            if (file_exists("$path/core.php")) {
                if (is_admin()) {
                   @include "$path/core.php";
                } else {
                    @include "$path/skin.php";
                }
            }
        }
    }
}