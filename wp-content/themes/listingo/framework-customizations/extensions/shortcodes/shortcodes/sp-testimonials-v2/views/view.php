<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$testimonials = !empty($atts['testimonials']) ? $atts['testimonials'] : array();
$loop = !empty($atts['loop']) && $atts['loop'] === 'true' ? 'true' : 'false';
$nav = !empty($atts['nav']) && $atts['nav'] === 'true' ? 'true' : 'false';
$autoplay = !empty($atts['autoplay']) && $atts['autoplay'] === 'true' ? 'true' : 'false';
$flag = rand(999, 9999);
?>

<div class="sp-sc-testimonials-slider tg-haslayout">
    <?php if (!empty($testimonials)) { ?>
        <div id="tg-testimonialsvtwo-<?php echo esc_attr($flag); ?>" class="tg-testimonialsvtwo tg-haslayout owl-carousel">
            <?php
            foreach ($testimonials as $key => $testimonial) {
                $test_thumbnail = !empty($testimonial['testimonial_image']['url']) ? $testimonial['testimonial_image']['url'] : '';
                $test_author = !empty($testimonial['testimonail_author']) ? $testimonial['testimonail_author'] : '';
                $test_description = !empty($testimonial['testimonial_description']) ? $testimonial['testimonial_description'] : '';
                $test_heading = !empty($testimonial['testimonail_heading']) ? $testimonial['testimonail_heading'] : '';
                $user_rating = !empty($testimonial['user_rating']) ? $testimonial['user_rating'] : 0;

                if (!empty($test_author) ||
					!empty($test_description) ||
					!empty($test_thumbnail) ||
					!empty($test_heading) ) {
                    ?>
                    <div class="item">
                        <div class="tg-testimonialvtwo">
                            <?php if (!empty($test_thumbnail)) { ?>
                                <figure>
                                    <img src="<?php echo esc_url($test_thumbnail); ?>" alt="<?php echo esc_html_e('Testimonial', 'listingo'); ?>">	
                                </figure>
                            <?php } ?>
                            <?php if (!empty($user_rating) || $test_author || $test_description || $test_heading) { ?>
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
                                        <blockquote><q><?php echo (do_shortcode($test_description)); ?></q></blockquote>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div> 
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <?php
    $script = "
		jQuery('#tg-testimonialsvtwo-" . esc_js($flag) . "').owlCarousel({
			items:1,
			nav:" . esc_js($nav) . ",
			margin:0,
			loop:" . esc_js($loop) . ",
			autoplay:" . esc_js($autoplay) . ",
			rtl: " . listingo_owl_rtl_check() . ",
			dotsClass: 'tg-sliderdots',
			navClass: ['tg-prev', 'tg-next'],
			navContainerClass: 'tg-slidernav tg-slidernavthree',
			navText: ['<span class=\'lnr lnr-chevron-left\'></span>', '<span class=\'lnr lnr-chevron-right\'></span>'],
		});";
		wp_add_inline_script('listingo_callbacks', $script, 'after');
    ?>
</div>