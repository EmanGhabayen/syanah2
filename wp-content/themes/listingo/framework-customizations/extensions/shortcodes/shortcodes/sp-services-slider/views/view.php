<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$heading 		= !empty($atts['service_heading']) ? $atts['service_heading'] : '';
$description 	= !empty($atts['service_description']) ? $atts['service_description'] : '';
$services_list  = !empty($atts['service_list']) ? $atts['service_list'] : array();
$flag			= rand(1,9999);
?>

<div class="sp-services-slider-wrap tg-haslayout">
	<?php if (!empty($heading) || !empty($description)) { ?>
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
			<?php if (!empty($heading)) { ?>
				<div class="tg-sectiontitle">
					<h2><?php echo esc_attr($heading); ?></h2>
				</div>
			<?php } ?>
			<?php if (!empty($description)) { ?>
				<div class="tg-description">
					<?php echo wp_kses_post(wpautop(do_shortcode($description))); ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<?php if (!empty($services_list)) { ?>
		<div class="tg-advantagies">
			<div class="tg-haslayout sp-services-slider owl-carousel" id="services-slider-<?php echo esc_attr( $flag );?>">
				<?php
				$count = 1;
				foreach ($services_list as $key => $service) {
					$service_icon = $service['service_icon'];
					$service_title = !empty($service['service_title']) ? $service['service_title'] : '';
					$service_desc = !empty($service['service_desc']) ? $service['service_desc'] : '';
					$service_link = !empty($service['service_link']) ? $service['service_link'] : '#';
					$target = !empty($service['link_target']) ? $service['link_target'] : '_self';

					$count_color = '#ec407a';
					if (!empty($service['enable_count']['show']) && $service['enable_count']['gadget'] == 'show') {
						$count_color = $service['enable_count']['show']['counter_color'];
					} else {
						$count--;
					}

					$thumb_meta = array();
					if (!empty($service_icon) && $service_icon['type'] === 'custom-upload') {
						$thumb_meta = listingo_get_image_metadata($service_icon['attachment-id']);
					}
					$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
					$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

					?>
					<div class="item">
						<div class="tg-advantage tg-advantageplan">
							<span class="tg-advantageicon">
								<?php if (!empty($service['enable_count']['show']) && $service['enable_count']['gadget'] === 'show') { ?>
									<i class="tg-badge" style="background: <?php echo esc_attr($count_color); ?>;"><?php echo intval($count); ?></i>
								<?php } ?>
								<?php
								if (isset($service_icon['type']) && $service_icon['type'] === 'icon-font') {
									do_action('enqueue_unyson_icon_css');
									if (!empty($service_icon['icon-class'])) {
										?>
										<em><i class="<?php echo esc_attr($service_icon['icon-class']); ?>"></i></em>
										<?php
									}
								} else if (isset($service_icon['type']) && $service_icon['type'] === 'custom-upload') {
									if (!empty($service_icon['url'])) {
										?>
										<em><img src="<?php echo esc_url($service_icon['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
										<?php
									}
								}
								?>
							</span>
							<?php if (!empty($service_title)) { ?>
								<div class="tg-title">
									<h3>
										<a href="<?php echo esc_url($service_link); ?>" target="<?php echo esc_attr($target); ?>">
											<?php echo esc_attr($service_title); ?>
										</a>
									</h3>
								</div>
							<?php } ?>
							<?php if (!empty($service_desc)) { ?>
								<div class="tg-description">
									<?php echo wp_kses_post(wpautop(do_shortcode($service_desc))); ?>
								</div>
							<?php } ?>
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
						jQuery('#services-slider-".$flag."').owlCarousel({
							items:4,
							nav:false,
							loop:true,
							autoplay:true,
							rtl: ".listingo_owl_rtl_check().",
							smartSpeed:450,
							dots: true,
							animateOut: 'fadeOut',
							animateIn: 'fadeIn',
							responsive: {
								0: {items: 1, },
								640: {items: 2, },
								768: {items: 3, },
								991: {items: 4, },
							}
						});
					});";
			   wp_add_inline_script('owl.carousel', $script, 'after');
	   		?>
		</div>
	<?php } ?>
</div>