<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
	global $post;
	$social = array();
	$social_links = apply_filters('listingo_get_social_media_icons_list',array());
	$address = '';
	$phone = '';
	$fax = '';
	$email = '';
	$website = '';
	$longitude = '';
	$latitude = '';

	if (function_exists('fw_get_db_post_option')) {		
		$address = fw_get_db_post_option($post->ID, 'address', true);
		$phone = fw_get_db_post_option($post->ID, 'phone', true);
		$fax = fw_get_db_post_option($post->ID, 'fax', true);
		$email = fw_get_db_post_option($post->ID, 'email', true);
		$website = fw_get_db_post_option($post->ID, 'website', true);
		$longitude = fw_get_db_post_option($post->ID, 'longitude', true);
		$latitude = fw_get_db_post_option($post->ID, 'latitude', true);
		$dir_map_marker = fw_get_db_settings_option('dir_map_marker');
    	$dir_map_marker = !empty($dir_map_marker['url']) ? $dir_map_marker['url'] : '';
		
	}

	if (empty($dir_map_marker)) {
		$dir_map_marker = get_template_directory_uri() . '/images/map-marker.png';
	}

	if( !empty( $social_links ) ) {
		foreach ($social_links as $key => $value) {
			if (function_exists('fw_get_db_post_option')) {
				$social_data = fw_get_db_post_option($post->ID, $key);
				$social[$key] = $social_data;		
			}
		}
	}
	$social_exist = '';
	if( !empty( $social ) ) {
		foreach ($social as $key => $value) {
			if( !empty( $value) ){
				$social_exist = 'exist';
				break;
			}
		}
	}

	if( !empty( $address ) || !empty( $social[0] ) ) {	
	
		$sp_usersdata = array();
		$adinfo['adinfo']	=  array();

		$sp_usersdata['marker'] 	= $dir_map_marker;
		$sp_usersdata['longitude'] 	= $longitude;
		$sp_usersdata['latitude'] 	= $latitude;
		$sp_usersdata['address'] 	= $address;
		$adinfo['adinfo'][]  = $sp_usersdata;
?>
<div class="tg-widget tg-widgetvtwo">
	<?php if( !empty( $address ) ){?>		
		<div id="tg-locationmapvtwo" class="tg-locationmapvtwo"></div>
		<?php
			$script = "jQuery(document).ready(function () {listingo_init_ad_map_script(" . json_encode($adinfo) . ");});";
			wp_add_inline_script('listingo_gmaps', $script, 'after');
		?>
    <?php }?>
	<div class="tg-contactinfoboxvtwo">
		<?php 
			if( !empty( $address ) 
				|| !empty( $phone ) 
				|| !empty( $fax ) 
				|| !empty( $email ) 
				|| !empty( $website ) ) { ?>
		<ul class="tg-contactinfo">
			<?php if( !empty( $address ) ) { ?>
				<li>
					<i class="lnr lnr-location"></i>
					<address><?php echo esc_attr( $address ); ?></address>
				</li>
			<?php } ?>
			<?php if( !empty( $phone ) ) { ?>
				<li>
					<i class="lnr lnr-phone-handset"></i>
					<span><?php echo esc_attr( $phone ); ?></span>
				</li>
			<?php } ?>
			<?php if( !empty( $fax ) ) { ?>
				<li>
					<i class="lnr lnr-printer"></i>
					<span><?php echo esc_attr( $fax ); ?></span>
				</li>
			<?php } ?>
			<?php if( !empty( $email ) ) { ?>
				<li>
					<i class="lnr lnr-envelope"></i>
					<span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></span>
				</li>
			<?php } ?>
			<?php if( !empty( $website ) ) { ?>	
				<li>
					<i class="lnr lnr-screen"></i>
					<span>
					<a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_attr( $website ); ?></a></span>
				</li>
			<?php } ?>
		</ul>
		<?php } ?>
		<?php if( !empty( $social )  && !empty( $social_exist ) ) { ?>
			<div class="tg-socialiconsbox">
				<span class="tg-getsocial"><i class="lnr lnr-sync"></i>&nbsp;<?php esc_html_e('Get Social', 'listingo'); ?></span>
				<ul class="tg-socialicons tg-socialiconssilmple">
					<?php
					foreach ( $social as $key => $value ) { 
					if( !empty( $value ) ) {
						if( $value == 'googleplus'){
							$value = 'google-plus';
						}
					 ?>							
					<li class="tg-<?php echo esc_attr( $key ); ?>"><a href="<?php echo esc_attr( $value ); ?>"><i class="fa fa-<?php echo esc_attr( $key ); ?>"></i></a>
					</li>
				<?php } } ?>	
				</ul>
			</div>
		<?php } ?>
	</div>
</div>
<?php } 