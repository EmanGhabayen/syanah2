<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */

$title 				= !empty( $atts['title'] ) ? $atts['title'] : '';
$description 		= !empty( $atts['description'] ) ? $atts['description'] : '';
$countries 			= !empty( $atts['countries'] ) ? $atts['countries'] : array();
$country_buttons 	= !empty( $atts['country_buttons'] ) ? $atts['country_buttons'] : array();

?>
<div class="sc-countries tg-haslayout">
	<div class="row">
		<?php if ( !empty( $title ) || !empty( $description ) ) { ?>
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
				<div class="tg-sectionhead">
					<?php if ( !empty( $title ) ) { ?>
						<div class="tg-sectiontitle">
							<h2><?php echo esc_attr( $title ); ?></h2>
						</div>
					<?php } ?>
					<?php if ( !empty( $description ) ) { ?>
						<div class="tg-description">
							<?php echo wpautop( do_shortcode( $description ) ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<?php if ( !empty( $countries ) ) { ?>
			<div class="tg-topcategories tg-topcategoriesvtwo">					
				<?php 
					$terms = get_terms( array(
				    	'taxonomy' => 'countries',
				    	'include' => $countries,
				    	'hide_empty' => 0
					) );
					
					if ( !empty( $terms ) ){ 							
					foreach ( $terms as $key => $value ) {
						$country_name = $value->slug;	
						$term_data = fw_get_db_term_option( $value->term_id, 'countries' );						
						$cat_image = !empty( $term_data['country_image']['url'] ) ? $term_data['country_image']['url'] : get_template_directory_uri().'/images/locations/country.jpg';
						$total_users	= listingo_get_total_users_under_taxanomy($country_name,'number','country');
					?>										
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="tg-category">
							<figure>									
								<img src="<?php echo esc_url( $cat_image ); ?>" alt="<?php esc_html_e('Country Image', 'listingo'); ?>">									
								<figcaption class="tg-automotive">
									<div class="tg-catagorycontent">
										<h3><a href="<?php echo esc_url( get_term_link( $value->term_id, 'countries' ) ); ?>"><?php echo esc_attr( $value->name ); ?></a></h3>
										<span><?php echo esc_attr( $total_users ); ?>&nbsp;<?php esc_html_e('Listings', 'listingo'); ?></span>
									</div>
								</figcaption>
							</figure>
						</div>
					</div>
				<?php } } ?>
			</div>
		<?php } ?>
		<?php 
		if ( !empty( $country_buttons ) ) {
			foreach ($country_buttons as $key => $value) {
			$btn_text = !empty( $value['button_text'] ) ? $value['button_text'] : '';
			$btn_link = !empty( $value['button_link'] ) ? $value['button_link'] : '#';
			if ( !empty( $btn_text ) ) {
		?>	
			<div class="tg-btnbox">
				<a class="tg-btn tg-btnviewall" href="<?php echo esc_attr( $btn_link ); ?>"><?php echo esc_attr( $btn_text ); ?></a>
			</div>
		<?php } } } ?>			
	</div>
</div>