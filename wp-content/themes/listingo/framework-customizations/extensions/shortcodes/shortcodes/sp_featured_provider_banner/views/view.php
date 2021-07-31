<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */


$today = time();
$cat_sepration = !empty($atts['cats']) ? $atts['cats']: '';
$show_users	= !empty( $atts['show_users'] ) ? $atts['show_users'] : 10;
$order		 = !empty( $atts['order'] ) ? $atts['order'] : 'DESC';
$uniq_flag = fw_unique_increment();

$query_args	= array(
					'role__in' => array('professional', 'business'),
					'order'  => $order,
					'number' => $show_users 
				 );

if( !empty( $cat_sepration ) ) {
	foreach( $cat_sepration as $key => $value ){
		$meta_category[] = array(
						'key'     => 'category',
						'value'   => $value,
						'compare' => '='
					);
	}
	
}

//Verify user
$meta_query_args[] = array(
    'key' 		=> 'verify_user',
    'value' 	=> 'on',
    'compare'   => '='
);
//active users filter
$meta_query_args[] = array(
    'key' 		=> 'activation_status',
    'value' 	=> 'active',
    'compare'   => '='
);

$expiry_args = array(
					'key'     => 'subscription_featured_expiry',
					'value'   => 0,
					'type'    => 'numeric',
					'compare' => '>'
				);
$query_args['meta_query'][] = $expiry_args;

$query_args['meta_key']	   = 'subscription_featured_expiry';
$query_args['orderby']	   = 'meta_value';

if( !empty( $meta_query_args ) ) {
	$query_relation = array('relation' => 'AND',);
	$meta_query_args	= array_merge( $query_relation,$meta_query_args );
	$query_args['meta_query'] = $meta_query_args;
}

//By Categories
if( !empty( $meta_category ) ) {
	$query_relations = array( 'relation' => 'OR',);
	$meta_query_args	= array_merge( $query_relations, $meta_category );
	$query_args['meta_query'][] = $meta_query_args;
}
?>
<div class="sp-featured-provider-banner tg-haslayout">
   <div class="tg-featuredprofiles">
	  <h1>
	  	<span><?php esc_html_e('Featured','listingo');?></span>
	  	<span><?php esc_html_e('Providers','listingo');?></span>
	  </h1>
	  <div id="tg-featuredprofileslider" class="tg-featuredprofileslider owl-carousel">
		<?php 
		$user_query = new WP_User_Query($query_args);
		if (!empty($user_query->results)) {
			$sp_userslist	=  array();
			$sp_userslist['status'] = 'found';

			if (!empty($sp_category)) {
				$title = get_the_title($sp_category);
				$postdata = get_post($sp_category);
				$slug = $postdata->post_name;
			} else {
				$title = '';
				$slug = '';
			}

			foreach ($user_query->results as $user) {
				$username = listingo_get_username($user->ID);
				$avatar = apply_filters(
						'listingo_get_media_filter', 
						listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), 
						array('width' => 92, 'height' => 92)
				);
				
				$user_banner = apply_filters(
						'listingo_get_media_filter', 
						listingo_get_user_banner(array('width' => 1920, 'height' => 380), $user->ID), 
						array('width' => 1920, 'height' => 380) //size width,
				);
				?>
				<div class="item tg-profile tg-featuredprofile">
				  <figure style="background-image:url(<?php echo esc_url( $user_banner );?>);">
					<figcaption>
					  <div class="tg-featuredprofilecontent">
						<div class="tg-contentbox">
						  <div class="tg-companylogo"><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Profile Avatar', 'listingo'); ?>"></a></div>
						  <div class="tg-companycontent">
							<?php do_action('listingo_result_tags', $user->ID); ?>
							<div class="tg-title">
							  <h3><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h3>
							</div>
							<?php do_action('sp_get_rating_and_votes', $user->ID); ?>
						  </div>
						</div>
						<a class="tg-btn" href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php esc_html_e('View Profile', 'listingo'); ?></a> </div>
					</figcaption>
				  </figure>
				</div>
		<?php }}?>
	   </div>
	   <?php
	   $script = "
			jQuery(document).ready(function(){
				jQuery('#tg-featuredprofileslider').owlCarousel({
					items:1,
					nav:true,
					loop:true,
					autoplay:false,
					rtl: ".listingo_owl_rtl_check().",
					smartSpeed:450,
					navClass: ['tg-btnprev', 'tg-btnnext'],
					animateOut: 'fadeOut',
					animateIn: 'fadeIn',
					navContainerClass: 'tg-featuredprofilesbtns',
					navText: [
								'<span><em>prev</em><i class=\"fa fa-angle-left\"></i></span>',
								'<span><i class=\"fa fa-angle-right\"></i><em>next</em></span>',
							],
				});
			});";
	   wp_add_inline_script('owl.carousel', $script, 'after');
			
	   ?>
	</div>
</div>