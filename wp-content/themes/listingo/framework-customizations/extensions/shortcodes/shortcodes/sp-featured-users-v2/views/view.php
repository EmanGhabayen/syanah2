<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */

$today 		= time();
if (isset($atts['get_mehtod']['gadget']) && $atts['get_mehtod']['gadget'] === 'by_users' && !empty($atts['get_mehtod']['by_users']['users'])) {
    $users_list = !empty($atts['get_mehtod']['by_users']['users']) ? $atts['get_mehtod']['by_users']['users'] : array();
} else {
    $cat_sepration  = array();
    $cat_sepration  = $atts['get_mehtod']['by_cats']['categories'];
}


$show_users	 = !empty( $atts['show_posts'] ) ? $atts['show_posts'] : 8;
$order		 = !empty( $atts['order'] ) ? $atts['order'] : 'DESC';
$btn		 = !empty( $atts['btn'] ) ? $atts['btn'] : '';
$limit  	 = (int) $show_users;
$uniq_flag 	 = fw_unique_increment();

$query_args	= array(
					'role__in' => array('professional', 'business'),
					'order'    => $order,
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

$meta_query_args	= array();
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
    'compare' 	=> '='
);

if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

//By Categories
if( !empty( $meta_category ) ) {
	$query_relations = array( 'relation' => 'OR',);
	$meta_query_args	= array_merge( $query_relations, $meta_category );
	$query_args['meta_query'][] = $meta_query_args;
}

//Featured
$expiry_args = array(
					'key'     => 'subscription_featured_expiry',
					'value'   => 0,
					'type'    => 'numeric',
					'compare' => '>'
				);
$query_args['meta_query'][] = $expiry_args;

$query_args['meta_key']	   = 'subscription_featured_expiry';
$query_args['orderby']	   = 'meta_value';

$offset = 0;

$query_args['number'] 		= $limit;
$query_args['offset'] 		= $offset;

//By users
if( !empty( $users_list ) ) {
	$query_args['include']	= $users_list;
}
?>
<div class="sp-featured-providers-v2 tg-haslayout spv4-listing ">
	<div class="tg-featuredproviders tg-listview">
		<div class="row">
			<?php if (!empty($atts['heading']) || !empty($atts['sub_heading'])) { ?>
				<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
					<div class="tg-sectionheadvtwo">
						<div class="tg-sectiontitle">
							<?php if (!empty($atts['heading'])) { ?><span><?php echo esc_attr($atts['heading']); ?></span><?php } ?>
							<?php if (!empty($atts['sub_heading'])) { ?><h2><?php echo esc_attr($atts['sub_heading']); ?></h2><?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="tg-featuredproviders">
				 <?php
					$user_query = new WP_User_Query($query_args);
					if (!empty($user_query->results)) {

						foreach ($user_query->results as $user) {
							$username = listingo_get_username($user->ID);
							$useremail = $user->user_email;
							$userphone = $user->phone;
							$email = explode('@', $user->user_email);

							$category = get_user_meta($user->ID, 'category', true);
							$map_marker = fw_get_db_post_option($category, 'dir_map_marker', true);
							$avatar = apply_filters(
									'listingo_get_media_filter', 
									listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), 
									array('width' => 92, 'height' => 92)
							);
							?>
							<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
								<div class="tg-featuredad">
									<?php do_action('listingo_result_avatar_v2', $user->ID,'',array('width' => 275, 'height' => 152)); ?>
									<div class="tg-featuredetails">
										<?php do_action('listingo_result_tags_v2', $user->ID); ?>
										<div class="tg-title">
											<h2><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h2>
										</div>
										<?php do_action('sp_get_rating_and_votes', $user->ID); ?>
									</div>
									<ul class="tg-phonelike">
										<?php do_action('listingo_get_user_meta','phone',$user);?>
										<?php do_action('listingo_add_to_wishlist', $user->ID); ?>
									</ul>
								</div>
							</div>
						<?php
						}
					} else{?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Sorry!', 'listingo'), esc_html__('Nothing found.', 'listingo')); ?>
						</div>
					<?php }?>
				<?php if (!empty( $btn ) && $btn === 'yes' ) { ?>
					<div class="tg-btnboxvtwo">
						<a class="tg-btn tg-btnvtwo" href="<?php echo listingo_get_search_page_uri(); ?>"><?php echo esc_html__('View all', 'listingo');?></a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
