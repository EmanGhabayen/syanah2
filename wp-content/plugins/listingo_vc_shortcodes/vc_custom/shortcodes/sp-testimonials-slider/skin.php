<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Testimonials Slider
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Testimonial_Slider')) {

    class SC_VC_Skin_SP_Testimonial_Slider extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_testimonial_slider", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sp_testimonials" => array(),
                "nav" => 'true',
                "loop" => 'true',
                "autoplay" => 'true',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_testimonial_slider', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $testimonials = array();
            if (isset($sp_testimonials)) {
                $testimonials = vc_param_group_parse_atts($sp_testimonials);
            }

            $flag = rand(999, 9999);

            $slide_nav = !empty($nav) && $nav === 'true' ? 'true' : 'false';
            $slide_autoplay = !empty($autoplay) && $autoplay === 'true' ? 'true' : 'false';
            $slide_loop = !empty($loop) && $loop === 'true' ? 'true' : 'false';
            ob_start();
            ?>
            <div class="sp-sc-testimonials-slider tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($testimonials)) { ?>
                    <div id="tg-testimonialsvtwo-<?php echo esc_attr($flag); ?>" class="tg-testimonialsvtwo tg-haslayout owl-carousel">
                        <?php
                        $count = 1;
                        foreach ($testimonials as $key => $testimonial) {
                            $test_thumbnail = !empty($testimonial['testimonial_image']) ? $testimonial['testimonial_image'] : '';
                            $test_author = !empty($testimonial['testimonail_author']) ? $testimonial['testimonail_author'] : '';
                            $test_description = !empty($testimonial['testimonial_description']) ? $testimonial['testimonial_description'] : '';
                            $test_heading = !empty($testimonial['testimonail_heading']) ? $testimonial['testimonail_heading'] : '';
                            $user_rating = !empty($testimonial['user_rating']) ? $testimonial['user_rating'] : '';

                            $thumb_meta = array();
                            $thumbnail = '';
                            if (!empty($test_thumbnail)) {
                                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($test_thumbnail);
                                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($test_thumbnail, 0, 0);
                            }
                            $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];

                            if (!empty($test_author) ||
								!empty($test_description) ||
								!empty($test_thumbnail) ||
								!empty($test_heading) ||
								!empty($user_rating)) {
                                ?>
                                <div class="item">
                                    <div class="tg-testimonialvtwo">
                                        <?php if (!empty($thumbnail)) { ?>
                                            <figure> 
                                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">	
                                            </figure>
                                        <?php } ?>
                                        <?php if (!empty($user_rating) || !empty($test_author) || !empty($test_description) || !empty($test_heading)) {?>
                                            <div class="tg-testimonialcontent">
                                                <?php
                                                if (!empty($user_rating)) {
                                                    $percentage = $user_rating/5*100;
                                                    ?>
                                                    <span class="tg-stars"><span style="width:<?php echo intval( $percentage );?>%"></span></span>
                                                <?php } ?>
                                                <?php if (!empty($test_heading) || !empty($test_author)) { ?>
                                                    <div class="tg-title">
                                                        <?php if (!empty($test_heading)) { ?>
                                                            <h2><?php echo esc_attr($test_heading); ?></h2>
                                                        <?php } ?>
                                                        <?php if (!empty($test_author)) { ?>
                                                            <span><?php echo esc_attr($test_author); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($test_description)) { ?>
                                                    <?php echo wp_kses_post(do_shortcode($test_description)); ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div> 
                            <?php } ?>
                            <?php
                            $count++;
                        }
                        ?>
                    </div>
                <?php } ?>
                <?php
                $script = " ;
                jQuery('#tg-testimonialsvtwo-" . esc_js($flag) . "').owlCarousel({
                    items:1,
                    nav:" . esc_js($slide_nav) . ",
                    margin:0,
                    loop:" . esc_js($slide_loop) . ",
                    autoplay:" . esc_js($slide_autoplay) . ",
					rtl: " . listingo_owl_rtl_check() . ",
                    dotsClass: 'tg-sliderdots',
                    navClass: ['tg-prev', 'tg-next'],
                    navContainerClass: 'tg-slidernav tg-slidernavthree',
                    navText: ['<span class=\'lnr lnr-chevron-left\'></span>', '<span class=\'lnr lnr-chevron-right\'></span>'],
                });";
                wp_add_inline_script('listingo_callbacks', $script, 'after')
                ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Testimonial_Slider();
}
