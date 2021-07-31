<?php
if (!defined('FW')){
    die('Forbidden');
}
/**
 * @var $atts
 */

$title 				= !empty( $atts['title'] ) ? $atts['title'] : '';
$description 		= !empty( $atts['description'] ) ? $atts['description'] : '';
$cities 			= !empty( $atts['city'] ) ? $atts['city'] : array();
$city_buttons 		= !empty( $atts['city_buttons'] ) ? $atts['city_buttons'] : array();

?>
<div class="sc-cities tg-haslayout tg-paddingzero">
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
		<?php if ( !empty( $cities ) ) { ?>
			<div class="tg-popularcities">					
			<?php 
				$terms = get_terms( array(
			    	'taxonomy' 		=> 'cities',
			    	'include' 		=> $cities,
			    	'hide_empty' 	=> 0
				) );

				if ( !empty( $terms ) ){ 							
					foreach ( $terms as $key => $value ) {
						$country_name = '';					 
						$get_cities_meta = fw_get_db_term_option( $value->term_id, 'countries' );
						if (!empty($get_cities_meta['country'][0])) {
							$country_id = $get_cities_meta['country'][0];
							$country_term = get_term($country_id, 'countries');
							$country_name = $country_term->slug;						    					  
						}

						$city_name = $value->slug;	
						$custom_url = "?country=".$country_name."&city=".$city_name;							
						$term_data = fw_get_db_term_option( $value->term_id, 'cities' );						
						$cat_image = !empty( $term_data['image']['url'] ) ? $term_data['image']['url'] : get_template_directory_uri().'/images/locations/city.jpg';
						$total_users	= listingo_get_total_users_under_taxanomy($city_name,'number','city');
					?>										
					<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
						<div class="tg-topcity">
							<figure class="tg-cityimg">									
								<img src="<?php echo esc_url( $cat_image ); ?>" alt="<?php esc_html_e('City Image', 'listingo'); ?>">									
								<figcaption>										
									<h3><a href="<?php echo esc_url( get_term_link( $value->term_id, 'cities' ) ); echo esc_attr( $custom_url  ); ?>"><?php echo esc_attr( $value->name ); ?></a></h3>
									<span><?php echo esc_attr( $total_users ); ?>&nbsp;<?php esc_html_e('Listings', 'listingo'); ?></span>										
								</figcaption>
							</figure>
						</div>
					</div>
				<?php } } ?>
			</div>
		<?php } ?>
		<?php 
		if ( !empty( $city_buttons ) ) {
			foreach ($city_buttons as $key => $value) {
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