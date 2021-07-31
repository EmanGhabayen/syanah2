<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Search_Form')) {

    class SC_VC_Skin_Listingo_Search_Form extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_search_form", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sec_title" => '',   
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args)); 

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_search_form', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            //setting search URL            
            $uniq_flag = rand(1,99999);
			
            if (function_exists('fw_get_db_settings_option')) {
                $zip_search = fw_get_db_settings_option('zip_search');
                $misc_search = fw_get_db_settings_option('misc_search');
                $dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
                $language_search = fw_get_db_settings_option('language_search');
                $country_cities = fw_get_db_settings_option('country_cities');
                $dir_radius = fw_get_db_settings_option('dir_radius');
                $dir_location = fw_get_db_settings_option('dir_location');
                $dir_keywords = fw_get_db_settings_option('dir_keywords');
            } else {
                $dir_radius = '';
                $dir_location = '';
                $dir_keywords = '';
                $misc_search = '';
                $zip_search = '';
                $dir_search_insurance = '';
                $language_search = '';
                $country_cities = '';
            }
			
            ob_start();
            ?>       
            <div class="sp-search-provider-banner tg-haslayout has_ui_slider <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="tg-homebannerandslider">
                    <div class="container-fluid">
                        <div class="row">
                            <form class="sp-form-search" action="<?php echo listingo_get_search_page_uri();?>" method="get">   
                                <div class="tg-accordionandcategorysearch hidden-xs">
                                    <div class="tg-categoreyaccordion">
                                        <div class="tg-themescrollbar">
                                            <div id="tg-accordion" class="tg-accordion" role="tablist" aria-multiselectable="true">
                                                <?php 
                                                $args = array('posts_per_page' => '-1',
                                                    'post_type'     => 'sp_categories',
                                                    'post_status'   => 'publish',
                                                    'suppress_filters' => false
                                                );
                                                $options = '';
                                                $cust_query = get_posts($args);
                                                if (!empty($cust_query)) {
                                                    $counter = 0;
                                                    foreach ($cust_query as $key => $dir) {
                                                        $counter++;
                                                        $terms = get_the_terms($dir->ID, 'sub_category');
                                                        $category_icon = '';
                                                        $category_color = '';
                                                        if (function_exists('fw_get_db_post_option')) {
                                                            $categoy_bg_img = fw_get_db_post_option($dir->ID, 'category_image', true);
                                                            $category_icon = fw_get_db_post_option($dir->ID, 'category_icon', true);
                                                            $category_color = fw_get_db_post_option($dir->ID, 'category_color', true);
                                                        }
                                                        if (!empty($categoy_bg_img['url'])) {
                                                            $thumnail = $categoy_bg_img['url'];
                                                        }
                                                        $thumb_meta = array();
                                                        if (!empty($categoy_bg_img['attachment_id'])) {
                                                            $thumb_meta = listingo_get_image_metadata($categoy_bg_img['attachment_id']);
                                                        }
                                                        if( !empty( $category_color ) ){
                                                            $icon_color = 'style=background:'.$category_color;
                                                        }
                                                        
                                                        $is_activ = $counter === 1  ? 'checked' : '';
                                                    ?>
                                                    <div class="tg-panel">
                                                        <div class="tg-accordionheading tg-automotive tg-radio">
                                                            <input type="radio" <?php echo esc_attr( $is_activ );?> id="tg-cat-<?php echo esc_attr( $dir->ID );?>" name="category" value="<?php echo esc_attr( $dir->post_name );?>">
                                                            <label for="tg-cat-<?php echo esc_attr( $dir->ID );?>">
                                                                <?php
                                                                    if (isset($category_icon['type']) && $category_icon['type'] === 'icon-font') {
                                                                        do_action('enqueue_unyson_icon_css');
                                                                        if (!empty($category_icon['icon-class'])) {
                                                                            ?>
                                                                            <span <?php echo ( $icon_color );?> class="<?php echo esc_attr($category_icon['icon-class']); ?> tg-categoryicon"></span>
                                                                            <?php
                                                                        }
                                                                    } else if (isset($category_icon['type']) && $category_icon['type'] === 'custom-upload') {
                                                                        if (!empty($category_icon['url'])) {
                                                                            ?>
                                                                            <span <?php echo ( $icon_color );?> class="tg-categoryicon">
                                                                                <img src="<?php echo esc_url($category_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                                            </span>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
                                                                <span class="tg-catenameandtypes"> 
                                                                    <span class="tg-categoryname sp-parent-cat">
                                                                        <?php echo esc_attr( get_the_title($dir->ID) );?>
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="tg-panelcontent">
                                                            <?php
                                                                if (!empty($terms)) {
                                                                foreach ($terms as $pterm) {
                                                            ?>
                                                            <div class="tg-subcategoryradio tg-radio">
                                                                <input type="radio" id="tg-subcat-<?php echo esc_attr( $pterm->term_id );?>" name="category" value="<?php echo esc_attr( $pterm->slug );?>">
                                                                <label for="tg-subcat-<?php echo esc_attr( $pterm->term_id );?>">
                                                                    <span class="tg-categoryname sp-child-cat"><?php echo esc_attr( $pterm->name );?></span>
                                                                </label>
                                                            </div>
                                                            <?php }}?>
                                                        </div>
                                                    </div>
                                                <?php }}?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tg-categorysearch">
                                        <fieldset>
                                            <input type="search" name="search" class="form-control cat-search-text" placeholder="<?php esc_html_e('Search Category', 'listingo_vc_shortcodes'); ?>">
                                            <button class="tg-btnsearch" type="submit"><i class="lnr lnr-magnifier"></i></button>
                                        </fieldset>
                                        <?php
                                            $script = "
                                                    jQuery('.cat-search-text').on('keyup', function(){
                                                      var matcher = new RegExp(jQuery(this).val(), 'gi');
                                                      jQuery('.tg-panel').show().not(function(){
                                                          return matcher.test(jQuery(this).find('.sp-parent-cat, .sp-child-cat').text())
                                                      }).hide();
                                                    });
                                                ";
                                            wp_add_inline_script('listingo_callbacks', $script, 'after');
                                        ?>
                                    </div>
                                </div>
                                <div class="tg-searchbox">
                                    <div class="tg-formtheme tg-formsearch">
                                        <fieldset>
                                            <?php if( !empty( $sec_title ) ) {?>
                                                <legend><?php echo esc_attr( $sec_title );?></legend>
                                            <?php }?>
                                            <?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
                                                <div class="form-group">
                                                    <?php do_action('listingo_get_search_keyword'); ?>
                                                </div>
                                            <?php }?>
                                            <?php if (!empty($dir_location) && $dir_location === 'enable') { ?>
                                                <div class="form-group tg-inputwithicon">
                                                    <?php do_action('listingo_get_search_geolocation'); ?>
                                                </div>
                                            <?php }?>
                                            <?php if (!empty($country_cities) && $country_cities === 'enable') { ?>
                                                <div class="form-group tg-select">
                                                    <span class="tg-select">
                                                        <select name="country" class="sp-country-select">
                                                            <option value=""><?php esc_html_e('Choose Country', 'listingo_vc_shortcodes'); ?></option>
                                                            <?php listingo_get_term_options('', 'countries'); ?>
                                                        </select>
                                                    </span>
                                                </div>
                                                <div class="form-group tg-select">
                                                    <span class="tg-select">
                                                        <select name="city" class="sp-city-select">
                                                            <option value=""><?php esc_html_e('Choose city', 'listingo_vc_shortcodes'); ?></option>
                                                        </select>
                                                    </span>
                                                </div>
                                            <?php }?>
                                            <?php if (!empty($zip_search) && $zip_search === 'enable') { ?>
                                                <div class="form-group">
                                                    <?php do_action('listingo_get_search_zip'); ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($misc_search) && $misc_search === 'enable') { ?>
                                            <div class="form-group">
                                                <div class="tg-checkbox">
                                                    <input type="checkbox" id="withprofilephoto" name="photo" value="true">
                                                    <label for="withprofilephoto"><?php esc_html_e('Find Only With Profile Photo', 'listingo_vc_shortcodes'); ?></label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="tg-btns">
                                               	<?php do_action('listingo_get_search_permalink_setting');?>
                                                <button class="tg-btn" type="submit"><?php esc_html_e('Search Now', 'listingo_vc_shortcodes');?></button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Search_Form();
}
