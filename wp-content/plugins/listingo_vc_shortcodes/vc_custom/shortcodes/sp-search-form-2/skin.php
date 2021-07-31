<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Search_Form_two')) {

    class SC_VC_Skin_Listingo_Search_Form_two extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_search_form_two", array(
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
                "sub_title" => '', 
                "color"     => '',
				"btn_text"     => '',
				"sub_cats"     => 'no',
				"geo_type"     => 'geo',   
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args)); 

                $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_search_form_two', $args);

                $flag = $this->listingo_vc_shortcodes_unique_increment();
                $classes[] = $custom_classes;
                $classes[] = $css_class;
				
				
				$get_column_type	= listingo_get_column_type($sub_cats,$geo_type);
				$classes[] 			=  $get_column_type;

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

            $color  =  !empty( $color ) ? $color : '';
            ob_start();
			
            ?>       
            <div class="sp-search-provider-banner-v2 tg-mapinnerbanner tg-haslayout has_ui_slider <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="tg-searchbox">
                    <?php if (!empty($sec_title) || !empty($sub_title) ) { ?>
                        <div class="tg-bannercontent">
                            <?php if (!empty($sec_title)) { ?><h1 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($sec_title); ?></h1><?php }?>
                            <?php if (!empty($sub_title)) { ?><h2 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($sub_title); ?></h2><?php }?>
                        </div>
                    <?php }?>
                    <div class="tg-themeform tg-formsearch tg-haslayout">
                        <form class="sp-form-search" action="<?php echo listingo_get_search_page_uri();?>" method="get">  
                            <fieldset>
                                <?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
                                    <div class="form-group">
                                        <?php do_action('listingo_get_search_keyword'); ?>
                                    </div>
                                <?php }?>
                                <?php 
								if( isset( $geo_type ) && $geo_type === 'countries' ){
									do_action('listingo_get_countries_list');
								}else {
									if (!empty($dir_location) && $dir_location === 'enable') { ?>
										<div class="form-group tg-inputwithicon">
											<?php do_action('listingo_get_search_geolocation'); ?>
										</div>
									<?php }?>
								<?php }?>
                                <div class="form-group">
                                    <?php do_action('listingo_get_search_category'); ?>
                                </div>
                                <?php if (!empty($sub_cats) && $sub_cats === 'yes' ) { ?>
									<div class="form-group">
										<?php do_action('listingo_get_search_sub_category'); ?>
									</div>
								<?php }?>
                               	<?php do_action('listingo_get_search_permalink_setting');?>
                                <button class="tg-btn" type="submit"><?php if( !empty( $btn_text ) ){ echo esc_attr( $btn_text ); }else{?><i class="lnr lnr-magnifier"></i><?php }?></button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Search_Form_two();
}
