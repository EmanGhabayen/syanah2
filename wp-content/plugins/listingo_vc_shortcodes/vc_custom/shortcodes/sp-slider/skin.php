<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Slider
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Slider')) {

    class SC_VC_Skin_SP_Slider extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_slider", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "slider_view" => '',
                "show_pagination" => 'enable',
                "show_navigation" => 'enable',
                "slides" => '',
                "slider_images" => '',
                "image" => '',
                "title" => '',
                "sub_title" => '',
                "slide_description" => '',
                "slide_buttons" => '',
                "show_form" => '',
                "form_title" => '',
                "form_button_title" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_slider', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $slider_v1 = array();
            if (isset($slides)) {
                $slider_v1 = vc_param_group_parse_atts($slides);
            }

            $slider_v2 = array();
            if (!empty($slider_images)) {
                $slider_v2 = explode(',', $slider_images);
            }

            $slider_v3 = array();
            if (!empty($slider_images)) {
                $slider_v3 = explode(',', $slider_images);
            }

            $sliderv2_params = array();
            $sliderv2_params['title'] = $title;
            $sliderv2_params['sub_title'] = $sub_title;
            $sliderv2_params['slide_description'] = $slide_description;
            $sliderv2_params['slide_buttons'] = $slide_buttons;
            $sliderv2_params['show_form'] = $show_form;
            $sliderv2_params['form_title'] = $form_title;
            $sliderv2_params['form_button_title'] = $form_button_title;

            $sliderv3_params = array();
            $sliderv3_params['title'] = $title;
            $sliderv3_params['image'] = $image;
            $sliderv3_params['sub_title'] = $sub_title;
            $sliderv3_params['show_form'] = $show_form;
            $sliderv3_params['form_button_title'] = $form_button_title;

            $slider_class = 'sp-slider-v2';
            if (isset($slider_view) && $slider_view === 'view1') {
                $slider_class = 'sp-slider-v1';
            } else if(isset($slider_view) && $slider_view === 'view2') {
                 $slider_class = 'sp-slider-v2';
            } else {
                $slider_class = 'sp-slider-v3';
            }

            $dots_class = "false";
            if (!empty($show_pagination) && $show_pagination === 'enable') {
                $dots_class = "true";
            }

            $nav_class = "nav:false,";
            if (!empty($show_navigation) && $show_navigation === 'enable') {
                $nav_class = "nav:true,";
                $nav_class .= "navClass: ['tg-btnprev', 'tg-btnnext'],";
                $nav_class .= "navContainerClass: 'tg-featuredprofilesbtns',";
                $nav_class .= "navText: [
						'<span><em>prev</em><i class=\'fa fa-angle-left\'></i></span>',
						'<span><i class=\'fa fa-angle-right\'></i><em>next</em></span>',
					],";
            }

            ob_start();
            ?>
            <div class="sc-slider tg-haslayout <?php echo esc_attr($slider_class); ?> <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php
                if (isset($slider_view) && $slider_view === 'view1') {
                    $this->listingo_vc_prepare_slider_view1($slider_v1, $show_pagination, $show_navigation, $dots_class, $nav_class, $flag);
                } elseif(isset($slider_view) && $slider_view === 'view2') {
                    $this->listingo_vc_prepare_slider_view2($slider_v2, $show_pagination, $show_navigation, $dots_class, $nav_class, $flag, $sliderv2_params);
                } else {
                    $this->listingo_vc_prepare_slider_view3($slider_v3, $show_pagination, $show_navigation, $dots_class, $nav_class, $flag, $sliderv3_params, $image);
                }
                ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * SP Slider 1 View
         * @param type $slider_v1
         * @param type $show_pagination
         * @param type $show_navigation
         * @param type $dots_class
         * @param type $nav_class
         * @param type $flag
         */
        public function listingo_vc_prepare_slider_view1($slider_v1 = array(), $show_pagination = 'disable', $show_navigation = 'disable', $dots_class = '', $nav_class = '', $flag = '') {
            ob_start();
            if (!empty($slider_v1)) {
                ?>
                <div id="tg-homebanner-<?php echo esc_attr($flag); ?>" class="tg-homebanner owl-carousel">
                    <?php
                    foreach ($slider_v1 as $key => $slide) {
                        $slide_title = !empty($slide['title']) ? $slide['title'] : '';
                        $slide_sub_title = !empty($slide['sub_title']) ? $slide['sub_title'] : '';
                        $slide_description = !empty($slide['slide_description']) ? $slide['slide_description'] : '';
                        $slide_image = !empty($slide['slide_image']) ? $slide['slide_image'] : '';
                        $slide_buttons = !empty($slide['slide_buttons']) ? $slide['slide_buttons'] : array();

                        $thumb_meta = array();
                        $thumbnail = '';

                        if (!empty($slide_image)) {
                            $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($slide_image);
                            $thumbnail = $this->listingo_vc_shortcodes_get_image_source($slide_image, 0, 0);
                        }
                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];

                        $buttons = array();
                        if (isset($slide_buttons)) {
                            $buttons = vc_param_group_parse_atts($slide_buttons);
                        }
                        ?>
                        <figure class="tg-homebannerimg">
                            <?php if (!empty($thumbnail)) { ?>
                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php esc_attr($image_alt); ?>">
                            <?php } ?>
                            <figcaption>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8 col-lg-push-2">
                                        <?php if (!empty($slide_title) || !empty($slide_sub_title) || !empty($slide_description) || !empty($slide_buttons)) { ?>
                                            <div class="tg-bannercontent">
                                                <?php if (!empty($slide_title)) { ?>
                                                    <h1><?php echo esc_attr($slide_title); ?></h1>
                                                <?php } ?>
                                                <?php if (!empty($slide_sub_title)) { ?>
                                                    <h2><?php echo esc_attr($slide_sub_title); ?></h2>
                                                <?php } ?>
                                                <?php if (!empty($slide_description)) { ?>
                                                    <div class="tg-description">
                                                        <?php echo wp_kses_post(wpautop(do_shortcode($slide_description))); ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($buttons)) {?>
                                                    <div class="tg-btnbox">
														<?php
														foreach ($buttons as $value) {
															$link = '';
															if (!empty($value['button_link'])) {
																$link = vc_build_link($value['button_link']);
															}
															$title = !empty($link['title']) ? $link['title'] : '';
															$target = !empty($link['target']) ? $link['target'] : '_self';
															$link_url = !empty($link['url']) ? $link['url'] : '#';

															if (!empty($title)) {?>	
																<a class="tg-btn" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_attr($link_url); ?>"><?php echo esc_attr($title); ?></a>
															<?php
																}
															}
														?>
												   </div>
                                               <?php }?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    <?php } ?>
                </div>
                <?php
            }
              $script = "
                    jQuery(window).on('load', function(){
                            jQuery('#tg-homebanner-" . esc_js($flag) . "').owlCarousel({
                            items:1,
                            dots:" . esc_js($dots_class) . ",
                            " . ( $nav_class ) . "
                            loop:true,
							rtl: ".listingo_owl_rtl_check().",
                            autoplay:false,
                            smartSpeed:450,         
                            animateOut: 'fadeOut',
                            animateIn: 'fadeIn',   
                                                
                            });
                    });
                ";
            wp_add_inline_script('listingo_callbacks', $script, 'after');
            echo ob_get_clean();
        }

        /**
         * SP Slider View 2
         * @param type $slider_v2
         * @param type $show_pagination
         * @param type $show_navigation
         * @param type $dots_class
         * @param type $nav_class
         * @param type $flag
         * @param type $sliderv2_params
         */
        public function listingo_vc_prepare_slider_view2($slider_v2 = array(), $show_pagination = 'disable', $show_navigation = 'disable', $dots_class = '', $nav_class = '', $flag = '', $sliderv2_params = array()) {
            ob_start();

            $title = !empty($sliderv2_params['title']) ? $sliderv2_params['title'] : '';
            $sub_title = !empty($sliderv2_params['sub_title']) ? $sliderv2_params['sub_title'] : '';
            $slide_description = !empty($sliderv2_params['slide_description']) ? $sliderv2_params['slide_description'] : '';
            $form_title = !empty($sliderv2_params['form_title']) ? $sliderv2_params['form_title'] : '';
            $form_button = !empty($sliderv2_params['form_button_title']) ? $sliderv2_params['form_button_title'] : esc_html__('Search Now', 'listingo_vc_shortcodes');
            $slide_buttons = array();
            if (isset($sliderv2_params['slide_buttons'])) {
                $slide_buttons = vc_param_group_parse_atts($sliderv2_params['slide_buttons']);
            }

            $dir_search_page = array();
            if (function_exists('fw_get_db_settings_option')) {
                $dir_search_page = fw_get_db_settings_option('dir_search_page');
            }

            if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
                $search_page = get_permalink((int) $dir_search_page[0]);
            } else {
                $search_page = '';
            }
            ?>
            <div class="tg-bannerholder">
                <div class="tg-bannercontent">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 tg-verticalmiddle">
                                <?php if (!empty($title) || !empty($sub_title) || !empty($slide_description) || !empty($slide_buttons)) { ?>
                                    <div class="tg-bannercaption">
                                        <?php if (!empty($title)) { ?>
                                            <h1><?php echo esc_attr($title); ?></h1>
                                        <?php } ?>
                                        <?php if (!empty($sub_title)) { ?>
                                            <h2><?php echo esc_attr($sub_title); ?></h2>
                                        <?php } ?>
                                        <?php if (!empty($slide_description)) { ?>
                                            <div class="tg-description">
                                                <?php echo wp_kses_post(wpautop(do_shortcode($slide_description))); ?>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (!empty($slide_buttons)) {
                                            foreach ($slide_buttons as $value) {
                                                $link = '';
                                                if (!empty($value['button_link'])) {
                                                    $link = vc_build_link($value['button_link']);
                                                }
                                                $title = !empty($link['title']) ? $link['title'] : '';
                                                $target = !empty($link['target']) ? $link['target'] : '_self';
                                                $link_url = !empty($link['url']) ? $link['url'] : '#';

                                                if (!empty($title)) {
                                                    ?>	
                                                    <div class="tg-btnbox">
                                                        <a class="tg-btn" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_attr($link_url); ?>"><?php echo esc_attr($title); ?></a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>					
                            </div>
                            <?php
                            if (!empty($sliderv2_params['show_form']) && $sliderv2_params['show_form'] === 'enable') { ?>
                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 tg-verticalmiddle">
                                    <div class="tg-searchbox">
                                        <form class="tg-formtheme tg-formsearch" method="get" action="<?php echo esc_url($search_page); ?>">
                                            <fieldset>
                                                <?php if (!empty($form_title)) { ?>
                                                    <legend><?php echo esc_attr($form_title); ?></legend>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <?php do_action('listingo_get_search_keyword'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <?php do_action('listingo_get_search_geolocation'); ?>
                                                </div>
                                                <div class="form-group tg-inputwithicon">
                                                    <?php do_action('listingo_get_search_category'); ?>										
                                                </div>						
                                                <div class="tg-btns">
                                                    <button class="tg-btn" type="submit"><?php echo esc_attr($form_button); ?></button>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($slider_v2)) { ?>
                    <div id="tg-homebannervtwo-<?php echo esc_attr($flag); ?>" class="tg-homebanner tg-homebannervtwo owl-carousel">
                        <?php
                        foreach ($slider_v2 as $image) {
                            $thumb_meta = array();
                            $thumbnail = '';

                            if (!empty($image)) {
                                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($image);
                                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($image, intval(0), intval(0));
                            }
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
                            if (!empty($thumbnail)) {
                                ?>
                                <figure class="tg-homebannerimg">
                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                    <figcaption></figcaption>
                                </figure>	
                                <?php
                            }
                        }
                        ?>			
                    </div>
                    <?php
                    $script = "
                        jQuery(window).on('load', function(){
                                jQuery('#tg-homebannervtwo-" . esc_js($flag) . "').owlCarousel({
                                items:1,
                                dots:" . esc_js($dots_class) . ",
                                                " . ( $nav_class ) . "
                                loop:true,
								rtl: ".listingo_owl_rtl_check().",
                                autoplay:false,
                                smartSpeed:450,
                                animateOut: 'fadeOut',
                                animateIn: 'fadeIn',    
                                                    
                                });
                        });
                    ";
                    wp_add_inline_script('listingo_callbacks', $script, 'after');
                    ?>
                <?php } ?>
            </div>
            <?php
            echo ob_get_clean();
        }

        //testing
              /**
         * SP Slider View 2
         * @param type $slider_v2
         * @param type $show_pagination
         * @param type $show_navigation
         * @param type $dots_class
         * @param type $nav_class
         * @param type $flag
         * @param type $sliderv2_params
         */
        public function listingo_vc_prepare_slider_view3($slider_v3 = array(), $show_pagination = 'disable', $show_navigation = 'disable', $dots_class = '', $nav_class = '', $flag = '', $sliderv3_params = array(), $image = array()) {
            ob_start();

            $title = !empty($sliderv3_params['title']) ? $sliderv3_params['title'] : '';
            $sub_title = !empty($sliderv3_params['sub_title']) ? $sliderv3_params['sub_title'] : '';
            $slide_description = !empty($sliderv3_params['slide_description']) ? $sliderv3_params['slide_description'] : '';
            $form_title = !empty($sliderv3_params['form_title']) ? $sliderv3_params['form_title'] : '';
            $form_button = !empty($sliderv3_params['form_button_title']) ? $sliderv3_params['form_button_title'] : esc_html__('Search Now', 'listingo_vc_shortcodes');
            $slide_buttons = array();
            if (isset($sliderv3_params['slide_buttons'])) {
                $slide_buttons = vc_param_group_parse_atts($sliderv3_params['slide_buttons']);
            }

            $dir_search_page = array();
            if (function_exists('fw_get_db_settings_option')) {
                $dir_search_page = fw_get_db_settings_option('dir_search_page');
            }

            if (isset($dir_search_page[0]) && !empty($dir_search_page[0])) {
                $search_page = get_permalink((int) $dir_search_page[0]);
            } else {
                $search_page = '';
            }

            $thumb_meta = array();
            if (!empty($image)) {
                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($image);
                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($image, 0, 0);
            }          
                                    
            ?>
            <div class="tg-bannerholder">
                <div class="tg-bannercontent">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-lg-push-2 col-xs-12 sp-search-form3">
                                <?php if (!empty($title) || !empty($sub_title) || !empty( $thumbnail )) { ?>                                    
                                    <div class="tg-bannercaption">
                                        <?php if ( !empty( $thumbnail ) ) { ?>
                                            <figure class="sp-top-image">
                                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php esc_html_e('Image', 'listingo_vc_shortcodes'); ?>">
                                            </figure>
                                        <?php } ?>
                                        <?php if (!empty($title)) { ?>
                                            <h1><?php echo esc_attr($title); ?></h1>
                                        <?php } ?>
                                        <?php if (!empty($sub_title)) { ?>
                                            <h2><?php echo esc_attr($sub_title); ?></h2>
                                        <?php } ?>                                                                 
                                    </div>
                                <?php } ?> 
                                <?php
                                if (!empty($sliderv3_params['show_form']) && $sliderv3_params['show_form'] === 'enable') { ?>
                                    <div class="tg-verticalmiddle">
                                        <div class="tg-searchbox3">
                                            <form class="tg-formtheme tg-formsearch" method="get" action="<?php echo esc_url($search_page); ?>">
                                                <fieldset>                                                                                             
                                                    <div class="form-group">
                                                        <?php do_action('listingo_get_search_geolocation'); ?>
                                                    </div>                                                                
                                                    <div class="tg-btns">
                                                        <button class="tg-btn" type="submit"><?php echo esc_attr($form_button); ?></button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>                 
                            </div>                   
                        </div>
                    </div>
                </div>
                <?php if (!empty($slider_v3)) { ?>
                    <div id="tg-homebannervtwo-<?php echo esc_attr($flag); ?>" class="tg-homebanner tg-homebannervtwo owl-carousel">
                        <?php
                        foreach ($slider_v3 as $image) {
                            $thumb_meta = array();
                            $thumbnail = '';

                            if (!empty($image)) {
                                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($image);
                                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($image, intval(0), intval(0));
                            }
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
                            if (!empty($thumbnail)) {
                                ?>
                                <figure class="tg-homebannerimg">
                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                    <figcaption></figcaption>
                                </figure>   
                                <?php
                            }
                        }
                        ?>          
                    </div>
                    <?php
                    $script = "
                        jQuery(window).on('load', function(){
                                jQuery('#tg-homebannervtwo-" . esc_js($flag) . "').owlCarousel({
                                items:1,
                                dots:" . esc_js($dots_class) . ",
                                                " . ( $nav_class ) . "
                                loop:true,
                                rtl: ".listingo_owl_rtl_check().",
                                autoplay:true,
                                smartSpeed:450,
                                animateOut: 'fadeOut',
                                animateIn: 'fadeIn',    
                                                    
                                });
                        });
                    ";
                    wp_add_inline_script('listingo_callbacks', $script, 'after');
                    ?>
                <?php } ?>
            </div>
            <?php
            echo ob_get_clean();
        }

        //testing
    }

    new SC_VC_Skin_SP_Slider();
}
