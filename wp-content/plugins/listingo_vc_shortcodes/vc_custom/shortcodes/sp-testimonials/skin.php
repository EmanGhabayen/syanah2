<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Testimonial
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Testimonial')) {

    class SC_VC_Skin_SP_Testimonial extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_testimonial", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "enable_quote" => 'enable',
                "testimonials" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_testimonial', $args);


            $owl_flag1 = $this->listingo_vc_shortcodes_unique_increment();
            $owl_flag2 = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $testimonial = array();
            if (isset($testimonials)) {
                $testimonial = vc_param_group_parse_atts($testimonials);
            }
            //Get first index level thumbnail
            if (!empty($testimonial[0])) {
                $thumb_meta_lg = array();
                $thumbnail_lg = get_template_directory_uri() . '/images/img-400x400.jpg';
                if (!empty($testimonial[0]['testimonial_image'])) {
                    $thumbnail_lg = $this->listingo_vc_shortcodes_get_image_source($testimonial[0]['testimonial_image'], intval(0), intval(0));
                    $thumb_meta_lg = $this->listingo_vc_shortcodes_get_image_metadata($testimonial[0]['testimonial_image']);
                }
                $image_alt_lg = !empty($thumb_meta_lg['alt']) ? $thumb_meta_lg['alt'] : $thumb_meta_lg['title'];
            }
            ob_start();
            ?>
            <div class="sp-sc-testimonials <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="row">
                    <?php if (!empty($testimonial) && is_array($testimonial)) { ?>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-left">
                            <figure class="tg-clientlargedp">
                                <?php if (!empty($thumbnail_lg)) { ?>
                                    <img src="<?php echo esc_url($thumbnail_lg); ?>" alt="<?php echo esc_attr($image_alt_lg); ?>">
                                <?php } ?>
                                <?php if (isset($enable_quote) && $enable_quote === 'enable') { ?>
                                    <span class="tg-quotes"><i class="fa fa-quote-right"></i></span>
                                <?php } ?>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 pull-left">
                            <div class="tg-testimonials">
                                <div id="tg-testimonialcontentslider-<?php echo esc_attr($owl_flag1); ?>" class="owl-carousel tg-testimonialcontentslider">
                                    <?php
                                    foreach ($testimonial as $testimonail) {
                                        extract($testimonail);

                                        if (!empty($testimonail_heading) ||
                                                !empty($testimonail_author) ||
                                                !empty($testimonial_description)) {
                                            ?>
                                            <div class="item">
                                                <div class="tg-testimonial">
                                                    <?php if (!empty($testimonail_author)) { ?>
                                                        <h2><?php echo esc_attr($testimonail_author); ?></h2>
                                                    <?php } ?>
                                                    <?php if (!empty($testimonail_heading)) { ?>
                                                        <h3><?php echo esc_attr($testimonail_heading); ?></h3>
                                                    <?php } ?>
                                                    <?php if (!empty($testimonial_description)) { ?>
                                                        <blockquote>
                                                            <q><?php echo wp_strip_all_tags(do_shortcode($testimonial_description)); ?></q>
                                                        </blockquote>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div id="tg-testimonialnavigationslider-<?php echo esc_attr($owl_flag2); ?>" class="owl-carousel tg-testimonialnavigationslider">
                                    <?php
                                    foreach ($testimonial as $testimonial_navi) {
                                        extract($testimonial_navi);

                                        $thumb_meta = array();
                                        $thumbnail = get_template_directory_uri() . '/images/img-400x400.jpg';
                                        if (!empty($testimonial_image)) {
                                            $thumbnail = $this->listingo_vc_shortcodes_get_image_source($testimonial_image, 0, 0);
                                            $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($testimonial_image);
                                        }
                                        $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
                                        if (!empty($thumbnail)) {
                                            ?>
                                            <div class="item">
                                                <figure>
                                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                                                </figure>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    $script = "jQuery(document).ready(function () {
						var sync1 = jQuery('#tg-testimonialcontentslider-" . esc_js($owl_flag1) . "');
						var sync2 = jQuery('#tg-testimonialnavigationslider-" . esc_js($owl_flag2) . "');
						var slidesPerPage = 5;
						var syncedSecondary = true;
						sync1.owlCarousel({
							items: 1,
							loop: true,
							nav: false,
							dots: false,
							autoplay: true,
							rtl: " . listingo_owl_rtl_check() . ",
							slideSpeed: 2000,
							responsiveRefreshRate: 200,
							navText: ['<svg width=\"100%\" height=\"100%\" viewBox=\"0 0 11 20\"><path style=\"fill:none;stroke-width: 1px;stroke: #000;\" d=\"M9.554,1.001l-8.607,8.607l8.607,8.606\"/></svg>', '<svg width=\"100%\" height=\"100%\" viewBox=\"0 0 11 20\" version=\"1.1\"><path style=\"fill:none;stroke-width: 1px;stroke: #000;\" d=\"M1.054,18.214l8.606,-8.606l-8.606,-8.607\"/></svg>'],
						}).on('changed.owl.carousel', syncPosition);
						sync2.on('initialized.owl.carousel', function () {
							sync2.find('.owl-item').eq(0).addClass('current');
						})
								.owlCarousel({
									items: slidesPerPage,
									dots: false,
									nav: false,
									margin: 5,
									rtl: " . listingo_owl_rtl_check() . ",
									smartSpeed: 200,
									slideSpeed: 500,
									slideBy: slidesPerPage,
									responsiveRefreshRate: 100,
								}).on('changed.owl.carousel', syncPosition2);
						function syncPosition(el) {
							var count = el.item.count - 1;
							var current = Math.round(el.item.index - (el.item.count / 2) - .5);
							if (current < 0) {
								current = count;
							}
							if (current > count) {
								current = 0;
							}
							sync2
									.find('.owl-item')
									.removeClass('current')
									.eq(current)
									.addClass('current')
							var onscreen = sync2.find('.owl-item.active').length - 1;
							var start = sync2.find('.owl-item.active').first().index();
							var end = sync2.find('.owl-item.active').last().index();
							var currentImage = jQuery('#tg-testimonialnavigationslider-" . esc_js($owl_flag2) . " .owl-item.current figure img').attr('src');
							var currentAlt = jQuery('#tg-testimonialnavigationslider-" . esc_js($owl_flag2) . " .owl-item.current figure img').attr('alt');
							jQuery('.tg-clientlargedp').find('img').attr('src', currentImage);
							jQuery('.tg-clientlargedp').find('img').attr('alt', currentAlt);
							if (current > end) {
								sync2.data('owl.carousel').to(current, 100, true);
							}
							if (current < start) {
								sync2.data('owl.carousel').to(current - onscreen, 100, true);
							}
						}
						function syncPosition2(el) {
							if (syncedSecondary) {
								var number = el.item.index;
								sync1.data('owl.carousel').to(number, 100, true);
							}
						}
						sync2.on('click', '.owl-item', function (e) {
							e.preventDefault();
							var number = jQuery(this).index();
							sync1.data('owl.carousel').to(number, 300, true);
						});
						jQuery('#tg-testimonialnavigationslider-" . esc_js($owl_flag2) . " .owl-item figure img').on('click', function () {
							var _this = jQuery(this);
							var img_src = _this.attr('src');
							var img_alt = _this.attr('alt');
							jQuery('.tg-clientlargedp').find('img').attr('src', img_src);
							jQuery('.tg-clientlargedp').find('img').attr('alt', img_alt);
						});
					});";
                    wp_add_inline_script('listingo_callbacks', $script, 'after')
                    ?>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Testimonial();
}
