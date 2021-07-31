<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Slider
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Sponsor_Slider')) {

    class SC_VC_Skin_SP_Sponsor_Slider extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_sponsor_slider", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
				"heading" => '',
				"description" => '',
				"loop" => 'true',
				"autoplay" => 'true',
                "sponsers_list" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));
							
			$loop       = !empty($loop) && $loop === 'true' ? 'true' : 'false';
			$autoplay   = !empty($autoplay) && $autoplay === 'true' ? 'true' : 'false';
			
            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_sponsor_slider', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
			$classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
			
			$sponsors = array();
            if (isset($sponsers_list)) {
                $sponsors = vc_param_group_parse_atts($sponsers_list);
            }
			?>
		
			<div class="sp-sponsers-slider-wrap tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?><?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>">
				<?php if (!empty($heading) || !empty($description)) { ?>
					<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
						<div class="tg-bannercontent">
							<?php if (!empty($heading)) { ?>
								<h1><?php echo esc_attr($heading); ?></h1>
							<?php } ?>
							<?php if (!empty($description)) { ?>
								<h2><?php echo wp_kses_post(wpautop(do_shortcode($description))); ?></h2>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<?php if (!empty($sponsors)) { ?>
					<div class="tg-advantagies">
						<div class="tg-haslayout sp-sponsers-slider owl-carousel" id="sponsers-slider-<?php echo esc_attr( $flag );?>">
							<?php
							$count = 1;
							foreach ($sponsors as $key => $sponser) {
								$sponser_icon  = !empty($sponser['sponsor_image']) ? $sponser['sponsor_image'] : ''; 
								$sponser_title = !empty($sponser['sponser_title']) ? $sponser['sponser_title'] : '';
								$sponser_link  = !empty($sponser['sponser_link']) ? $sponser['sponser_link'] : '#';
								$target        = !empty($sponser['link_target']) ? $sponser['link_target'] : '_self';

								$thumb_meta = array();
								if (!empty($sponser_icon)) {
									$thumb_meta = listingo_get_image_metadata($sponser_icon['attachment_id']);
								}
								$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
								$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

								?>
								<div class="item">
									<div class="tg-advantage tg-advantageplan">
										<a href="<?php echo esc_url($sponser_link); ?>" target="<?php echo esc_attr($target); ?>">
											<span class="tg-sponserlogo">
												<em><img src="<?php echo esc_url($sponser_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
											</span>
											<?php if (!empty($sponser_title)) { ?>
												<div class="tg-title">
													<h3><?php echo esc_attr($sponser_title); ?></h3>
												</div>
											<?php } ?>
										</a>
									</div>
								</div>

								<?php
								$count++;
							}
							?>
						</div>
						<?php
						   $script = "
								jQuery(document).ready(function(){
									jQuery('#sponsers-slider-".$flag."').owlCarousel({
										items:5,
										nav: true,
										loop:".esc_js($loop).",
										autoplay:".esc_js($autoplay).",
										rtl: ".listingo_owl_rtl_check().",
										smartSpeed:450,
										dots:'false',
										animateOut: 'fadeOut',
										animateIn: 'fadeIn',
										navClass: ['sp-prev', 'sp-next'],
										navContainerClass: 'sp-slidernav',
										navText: ['<span class=\"fa fa-angle-left\"></span>', '<span class=\"fa fa-angle-right\"></span>'],
										responsive: {
											0: {items: 2, },
											640: {items: 2, },
											768: {items: 4, },
											992: {items: 5, }
										}
									});
								});";
						   wp_add_inline_script('owl.carousel', $script, 'after');
						?>
					</div>
				<?php } ?>
			</div>
		 <?php  
		}
	}
	
	new SC_VC_Skin_SP_Sponsor_Slider();
}
    
