<?php if (!defined('FW')) die('Forbidden'); 

$title	= !empty( $atts['title'] ) ? $atts['title'] : '';
$images = !empty( $atts['images'] ) ? $atts['images'] : array();
 
?>

<div class="sp-photo-gallery tg-companyfeaturebox tg-gallery tg-haslayout">
	<?php if (!empty($atts['provider_heading']) || !empty($atts['provider_description'])) { ?>
		<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
			<div class="tg-sectionhead">
				<?php if (!empty($atts['provider_heading'])) { ?>
					<div class="tg-sectiontitle">
						<h2><?php echo esc_attr($atts['provider_heading']); ?></h2>
					</div>
				<?php } ?>
				<?php if (!empty($atts['provider_description'])) { ?>
					<div class="tg-description">
						<?php echo wp_kses_post(wpautop(do_shortcode($atts['provider_description']))); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
	<?php if ( !empty( $images ) ) { ?>
		<ul>
			<?php 
				foreach ( $images as $image ) {
					$url   		= esc_url( $image['url']);
					$alt_text 	= get_the_title( $image['attachment_id'] );
					$height 	= 150;
					$width  	= 150;
					$thumbnail 	= listingo_prepare_image_source( $image['attachment_id'], $width, $height );
			?>
			<li>
				<div class="tg-galleryimgbox">
					<figure>
						<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>">
						<a class="tg-btngallery" href="<?php echo esc_url( $url ); ?>" data-rel="prettyPhoto[gallery]" rel="prettyPhoto[gallery]">
							<i class="lnr lnr-magnifier"></i>
						</a>
					</figure>
				</div>
			</li>				
			<?php } ?>
		</ul>
	<?php } ?>
</div>