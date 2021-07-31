<?php 
/**
 *
 * The template used for displaying ad amenities
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */

global $post;
$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
$amenities = wp_get_post_terms( $post->ID, 'ad_amenity', $args ); 
if( !empty( $amenities ) ) { ?>
	<div class="tg-sectionpaddingvtwo tg-amenities tg-amenitiesvtwo">
		<div class="tg-sectiontitlevthree text-left">
			<h2><?php esc_html_e('Amenities and Features', 'listingo'); ?></h2>
		</div>
		<ul>
			<?php 
				foreach ($amenities as $key => $value) {
					if (function_exists('fw_get_db_term_option')) {
						$amenity_meta = fw_get_db_term_option($value->term_id, 'ad_amenity');	
					}

					if ( isset($amenity_meta['amenities_icon']['type']) 
						&& $amenity_meta['amenities_icon']['type'] === 'icon-font'
						&& !empty($amenity_meta['amenities_icon']['icon-class'])
					   ) {
						do_action('enqueue_unyson_icon_css');
						 $amenity_icon = $amenity_meta['amenities_icon']['icon-class'];
						?>
						<li class="tg-activated">
							<?php if (!empty($amenity_icon)) { ?>
								<i class="<?php echo esc_attr($amenity_icon); ?>"></i>
							<?php } ?>
							<span><?php echo esc_attr( $value->name ); ?></span>
						</li>
						<?php
					} else if (isset($amenity_meta['amenities_icon']['type']) 
					   && $amenity_meta['amenities_icon']['type'] === 'custom-upload'
					   && !empty($amenity_meta['amenities_icon']['url'])
					 ) {
					?>
						<li class="tg-activated">
							<img src="<?php echo esc_url($amenity_meta['amenities_icon']['url']); ?>" alt="<?php esc_html_e('category', 'listingo'); ?>">
							<span><?php echo esc_attr( $value->name ); ?></span>
						</li>
					<?php
					} elseif( !empty( $value->name ) ){
						?>
						<li class="tg-activated">
							<span><?php echo esc_attr( $value->name ); ?></span>
						</li>
						<?php
					}
				} ?>										
		</ul>
	</div>
<?php } ?>