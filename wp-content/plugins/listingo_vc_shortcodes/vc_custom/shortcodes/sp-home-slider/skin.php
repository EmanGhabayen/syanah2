<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Home Slider
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Home_Slider')) {

    class SC_VC_Skin_SP_Home_Slider extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_home_slider", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "slides" => array(),
                "nav" => 'true',
                "loop" => 'true',
                "autoplay" => 'true',
                "slides" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));


            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_home_slider', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $slider = array();
            if (isset($slides)) {
                $slider = vc_param_group_parse_atts($slides);
            }

            $slide_nav = !empty($nav) && $nav === 'true' ? 'true' : 'false';
            $slide_autoplay = !empty($autoplay) && $autoplay === 'true' ? 'true' : 'false';
            $slide_loop = !empty($loop) && $loop === 'true' ? 'true' : 'false';
            ob_start();
            ?>
            <div class="sp-sc-home-banner-slider tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($slides)) {?>
                    <div id="tg-homebannervthree-<?php echo esc_attr( $flag );?>" class="tg-homebannervthree tg-haslayout owl-carousel">
                        <?php
                        foreach ($slider as $key => $banner_slide) {
                            $slide_img = !empty($banner_slide['bg_image']) ? $banner_slide['bg_image'] : '';
                            $slide_title = !empty($banner_slide['slide_title']) ? $banner_slide['slide_title'] : '';
                            $slide_desc = !empty($banner_slide['slide_desc']) ? $banner_slide['slide_desc'] : '';
                            $slide_btns = !empty($banner_slide['slide_btns']) ? $banner_slide['slide_btns'] : array();

                            $thumb_meta = array();
                            $thumbnail = '';
                            if (!empty($slide_img)) {
                                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($slide_img);
                                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($slide_img, 0, 0);
                            }
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];

                            $buttons = array();
                            if (isset($slide_btns)) {
                                $buttons = vc_param_group_parse_atts($slide_btns);
                            }
                            if (!empty($slide_title) ||
                                    !empty($slide_desc) ||
                                    !empty($buttons) ||
                                    !empty($thumbnail)) {
                                ?>
                                <figure class="tg-homebannerimg item">
                                    <?php if (!empty($thumbnail)) { ?>
                                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php esc_html_e('Banner Image', 'listingo_vc_shortcodes') ?>">
                                    <?php } ?>
                                    <?php
                                    if (!empty($slide_title) ||
                                            !empty($slide_desc) ||
                                            !empty($buttons)) {
                                        ?>
                                        <figcaption>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8 col-lg-push-2">
                                                        <div class="tg-bannercontent">
                                                            <?php if (!empty($slide_title)) { ?>
                                                                <h1><?php echo force_balance_tags($slide_title); ?></h1>
                                                            <?php } ?>
                                                            <?php if (!empty($slide_desc)) { ?>
                                                                <div class="tg-description">
                                                                    <?php echo wpautop(do_shortcode($slide_desc)); ?>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (!empty($buttons)) { ?>
                                                                <div class="tg-btnbox">
                                                                    <?php
                                                                    foreach ($buttons as $key => $value) {
                                                                        $link = '';
                                                                        $btn_active = '';
                                                                        if (!empty($value['btn_link'])) {
                                                                            $link = vc_build_link($value['btn_link']);
                                                                        }
                                                                        if (!empty($value['btn_active'])) {
                                                                            $btn_active = !empty($value['btn_active']) && $value['btn_active'] === 'active' ? 'tg-active' : '';
                                                                        }
                                                                        $btn_title = !empty($link['title']) ? $link['title'] : '';
                                                                        $btn_link = !empty($link['url']) ? $link['url'] : '#';
                                                                        $btn_target = !empty($link['target']) ? $link['target'] : '_self';

                                                                        if (!empty($btn_title)) {
                                                                            ?>
                                                                            <a class="tg-btn tg-btnvtwo <?php echo esc_attr($btn_active); ?>" target="<?php echo esc_attr($btn_target); ?>" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_attr($btn_title); ?></a>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </figcaption>
                                    <?php } ?>
                                </figure>
                                <?php
                            }
                        }

                        $script = '
							setTimeout(function(){ 
							 jQuery("#tg-homebannervthree-' . esc_js($flag) . '").owlCarousel({
                                items:1,
                                nav: ' . esc_js($slide_nav) . ',
                                loop:' . esc_js($slide_loop) . ',
                                dots:false,
                                autoplay:' . esc_js($slide_autoplay) . ',
                                smartSpeed:450,
								rtl: ' . listingo_owl_rtl_check() . ',
                                navClass: ["tg-btnprev", "tg-btnnext"],
                                animateOut: "fadeOut",
                                animateIn: "fadeIn",
                                navContainerClass: "tg-featuredprofilesbtnsvtwo",
                                navText: [
                                     "<span>'.esc_html__('PR','listingo_vc_shortcodes').'<em>'.esc_html__('EV','listingo_vc_shortcodes').'</em></span>",
                        			"<span>'.esc_html__('NE','listingo_vc_shortcodes').'<em>'.esc_html__('XT','listingo_vc_shortcodes').'</em></span>",
                                ],  
                            });
							
							}, 700);
                           
                        ';
                        wp_add_inline_script('listingo_callbacks', $script, 'after');
                        ?>
                    </div>
                <?php } ?>
            </div>

            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Home_Slider();
}
