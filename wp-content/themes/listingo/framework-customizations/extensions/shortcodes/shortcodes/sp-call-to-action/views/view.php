<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$name = !empty($atts['cta_button_text']) ? $atts['cta_button_text'] : esc_html__('Join Now', 'listingo');
$link = !empty($atts['cta_link']) ? $atts['cta_link'] : '#';
$target = !empty($atts['cta_link_target']) ? $atts['cta_link_target'] : '_self';

$cta_logo = '';
if (!empty($atts['cta_logo']['url'])) {
    $cta_logo = $atts['cta_logo']['url'];
}

$thumb_meta = array();
if (!empty($atts['cta_logo']['attachment_id'])) {
    $thumb_meta = listingo_get_image_metadata($atts['cta_logo']['attachment_id']);
}

$image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
$image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

$cta_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
if (!empty($atts['cta_logo']['url'])) {
    $cta_class = 'col-xs-12 col-sm-12 col-md-8 col-lg-8';
}

?>
<div class="sp-sc-calltoaction">
	<div class="row">
		<?php if (!empty($cta_logo)) { ?>
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
				<figure class="tg-noticeboard">
					<img src="<?php echo esc_url($cta_logo); ?>" alt="<?php echo esc_attr($image_alt); ?>">
				</figure>
			</div>
		<?php } ?>
		<?php
		if (!empty($atts['cta_heading']) ||
			!empty($atts['cta_sub_heading']) ||
			!empty($atts['cta_description']) ||
			!empty($name)) {
			?>
			<div class="<?php echo esc_attr($cta_class); ?> pull-left">
				<div class="tg-secureandreliable">
					<div class="tg-textshortcode">
						<?php if (!empty($atts['cta_heading'])) { ?>
							<h2><?php echo esc_attr($atts['cta_heading']); ?></h2>
						<?php } ?>
						<?php if (!empty($atts['cta_sub_heading'])) { ?>
							<h3><?php echo esc_attr($atts['cta_sub_heading']); ?></h3>
						<?php } ?>
						<?php if (!empty($atts['cta_description'])) { ?>
							<div class="tg-description">
								<?php echo wp_kses_post(wpautop(do_shortcode($atts['cta_description']))); ?>
							</div>
						<?php } ?>
					</div>
					<?php if (!empty($name)) { ?>
						<a class="tg-btn" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
							<?php echo esc_attr($name); ?>
						</a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
