<?php
/**
 *
 * Search template, list view
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $wp_query, $total_users, $query_args, $limit;
get_header();

if (!empty($_GET['category'])) {
    $sp_category = listingo_get_page_by_slug($_GET['category'], 'sp_categories', 'id');
} else {
    $sp_category = '';
}

if (function_exists('fw_get_db_settings_option')) {
    $dir_map_marker_default = fw_get_db_settings_option('dir_map_marker');
    $search_page_map = fw_get_db_settings_option('search_page_map');
	
	$zip_search = fw_get_db_settings_option('zip_search');
	$misc_search = fw_get_db_settings_option('misc_search');
	$dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
	$language_search = fw_get_db_settings_option('language_search');
	$dir_radius = fw_get_db_settings_option('dir_radius');
	$dir_location = fw_get_db_settings_option('dir_location');
	$dir_keywords = fw_get_db_settings_option('dir_keywords');
} else {
    $dir_map_marker_default = '';
    $search_page_map = '';
	
	$dir_radius = '';
	$dir_location = '';
	$dir_keywords = '';
	$misc_search = '';
	$zip_search = '';
	$dir_search_insurance = '';
	$language_search = '';
}

//Set Full width if Search View Map option is disabled from theme settings.
$sp_listing_view_column = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left';
if(!empty($search_page_map) && $search_page_map === 'enable'){
	$sp_listing_view_column = 'col-xs-12 col-sm-7 col-md-8 col-lg-9 pull-left';
}

$width	= listingo_get_field_width();
//Search center point
$direction	= listingo_get_location_lat_long();

$active_view = 'list-default';
if (function_exists('fw_get_db_post_option')) {
    $active_view = fw_get_db_settings_option('dir_search_view');
}

if (!empty($_GET['view'])) {
    $active_view = esc_attr($_GET['view']);
}

?>

<div class="spv4-listing">
	<div class="tg-haslayout">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12  col-lg-12">
					<form class="sp-form-search" action="<?php echo listingo_get_search_page_uri();?>" method="get">
						<div class="tg-searchtitle">
							<h2><?php esc_html_e('Search Result', 'listingo'); ?></h2>
						</div>
						<div class="tg-sortfilters tg-searchheadform">
							<div class="tg-sortfilter tg-sortby">
								<?php do_action('listingo_get_sortby'); ?>
							</div>
							<div class="tg-sortfilter tg-arrange">
								<?php do_action('listingo_get_orderby'); ?>
							</div>
							<div class="tg-sortfilter tg-show">
								<?php do_action('listingo_get_showposts'); ?>
							</div>
							<div class="tg-btnsearcharea">
								<a class="tg-btnsearchvtwo switch-view <?php echo isset( $active_view ) && $active_view == 'grid-default' ? 'active-view' : '';?>" data-key="grid-default" href="javascript:;"><i class="fa fa-th"></i></a>
								<a class="tg-btnsearchvtwo switch-view <?php echo isset( $active_view ) && $active_view == 'list-default' ? 'active-view' : '';?>" data-key="list-default" href="javascript:;"><i class="fa fa-list"></i></a>
							</div>
						</div>
						<div class="tg-formsearchresult">
							<div class="tg-formtheme tg-formsearchvtwo">
								<fieldset>
									<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
										<div class="form-group tg-inputwithicon">
											<i class="lnr lnr-magnifier"></i>
											<?php do_action('listingo_get_search_keyword'); ?>
										</div>
									<?php } ?>
									<?php
									if (isset($geo_type) && $geo_type === 'countries') {
										do_action('listingo_get_countries_list');
									} else {
										if (!empty($dir_location) && $dir_location === 'enable') {?>
											<div class="form-group tg-inputwithicon">
												<i class="lnr lnr-map-marker"></i>
												<?php do_action('listingo_get_search_geolocation'); ?>
											</div>
										<?php } ?>
									<?php } ?>
									<div class="form-group tg-inputwithicon">
										<?php do_action('listingo_get_search_category'); ?>
									</div>
									<?php if (!empty($atts['sub_cats']) && $atts['sub_cats'] === 'yes') { ?>
										<div class="form-group tg-inputwithicon">
											<?php do_action('listingo_get_search_sub_category'); ?>
										</div>
									<?php } ?>
									<?php do_action('listingo_get_search_permalink_setting'); ?>
									<button class="tg-btnsearchvtwo" type="submit"><i class="lnr lnr-magnifier"></i></button>
								</fieldset>
							</div>
							<?php do_action('listingo_get_search_filtrs_v2'); ?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="tg-twocolumns" class="tg-twocolumns tg-twocolumnsresult">
		<div class="container">
			<div class="row">
				<div class="<?php echo esc_attr($sp_listing_view_column); ?>">
					<div class="row">
						<div class="sp-featured-providers-v2 tg-haslayout">
							<div class="tg-featuredproviders tg-listview">
								<div class="tg-featuredproviders">
								<?php
								$user_query = get_users($query_args);
								$sp_usersdata	=  array();
								$sp_userslist	=  array();
								$sp_userslist['status'] = 'none';
								$sp_userslist['lat']  = floatval ( $direction['lat'] );
								$sp_userslist['long'] = floatval ( $direction['long'] );

								if (!empty($user_query)) {
									$sp_userslist['status'] = 'found';

									if (!empty($sp_category)) {
										$title = get_the_title($sp_category);
										$postdata = get_post($sp_category);
										$slug = $postdata->post_name;
									} else {
										$title = '';
										$slug = '';
									}

									foreach ($user_query as $user) {
										$username = listingo_get_username($user->ID);
										$useremail = $user->user_email;
										$userphone = $user->phone;
										if( !empty( $user->user_email ) ){
											$email = explode('@', $user->user_email);
										}

										$category = get_user_meta($user->ID, 'category', true);
										if( function_exists('fw_get_db_post_option') ){
											$map_marker = fw_get_db_post_option($category, 'dir_map_marker', true);
										}
										$avatar = apply_filters(
												'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), array('width' => 92, 'height' => 92)
										);

										$sp_usersdata['latitude'] = $user->latitude;
										$sp_usersdata['longitude'] = $user->longitude;
										$sp_usersdata['username'] = $username;

										$infoBox = '';
										$infoBox .= '<div class="tg-infoBox">';
										$infoBox .= '<div class="tg-serviceprovider">';
										$infoBox .= '<figure class="tg-featuredimg"><img src="' . esc_url($avatar) . '" alt="' . $username . '"></figure>';
										$infoBox .= '<div class="tg-companycontent">';
										$infoBox .= listingo_result_tags($user->ID, 'return');
										$infoBox .= '<div class="tg-title">';
										$infoBox .= '<h3><a href="' . get_author_posts_url($user->ID) . '">' . $username . '</a></h3>';
										$infoBox .= '</div>';
										$infoBox .= listingo_get_total_rating_votes($user->ID, 'return');
										$infoBox .= '</div>';
										$infoBox .= '</div>';
										$infoBox .= '</div>';

										if (isset($map_marker['url']) && !empty($map_marker['url'])) {
											$sp_usersdata['icon'] = $map_marker['url'];
										} else {
											if (!empty($dir_map_marker_default['url'])) {
												$sp_usersdata['icon'] = $dir_map_marker_default['url'];
											} else {
												$sp_usersdata['icon'] = get_template_directory_uri() . '/images/map-marker.png';
											}
										}

										$sp_usersdata['html']['content'] = $infoBox;
										$sp_userslist['users_list'][] = $sp_usersdata;
									?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 tg-verticaltop">
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
									<?php if (!empty($total_users) && !empty($limit) && $total_users > $limit) { ?>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<?php listingo_prepare_pagination($total_users, $limit); ?>
										</div>
									<?php } ?>
									<?php if (isset($search_page_map) && $search_page_map === 'enable') { 
											$script	= "jQuery(document).ready(function ($) {listingo_init_map_script(".json_encode($sp_userslist)."); });";
											wp_add_inline_script('listingo_gmaps', $script,'after');
									} ?> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if(!empty($search_page_map) && $search_page_map === 'enable') { ?>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
						<aside id="tg-sidebarvtwo" class="tg-sidebarvtwo">
							<div class="tg-sidemap">
								<?php do_action('listingo_get_search_toggle_map','tg-mapvtwo',esc_html__('Full View', 'listingo')); ?>
							</div>
						</aside>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>