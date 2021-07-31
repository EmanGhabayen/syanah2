<?php
/**
 *
 * Author Company Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$profile_v4_section = apply_filters('listingo_get_profile_v4_sections',$author_profile->ID);
$db_privacy 			= listingo_get_privacy_settings($author_profile->ID);
$category_type = $author_profile->category;

$final_menu	= array();
$final_menu_part	= array();
foreach( $profile_v4_section as $key => $menu ){
	if( isset( $menu['menu'] ) && $menu['menu'] === 'yes' ){
		if( $key === 'company' ){
			if (!empty($author_profile->professional_statements)) {
				$is_include	= 'yes';
			}

			if (!empty($author_profile->description)) {
				$is_include	= 'yes';
			}

			if( !empty( $is_include ) && $is_include === 'yes'){
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'language' ){
			if (!empty($author_profile->profile_languages)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'contact-info' ){
			if (!empty($author_profile->user_url)) {
				$is_include	= 'yes';
			} else if (!empty($author_profile->phone)) { 
				$is_include	= 'yes';
			} else if (!empty($author_profile->user_email)) { 
				$is_include	= 'yes';
			} else if (!empty($author_profile->fax)) { 
				$is_include	= 'yes';
			}

			if( !empty( $is_include ) && $is_include === 'yes'){
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}

		} else if( $key === 'experience' ){
			if (!empty($author_profile->experience)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'awards' ){
			if (!empty($author_profile->awards)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'qualification' ){
			if (!empty($author_profile->qualification)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'amenity' ){
			if (!empty($author_profile->profile_amenities)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'services' ){
			if (!empty($author_profile->profile_services)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'teams' ){
			if (!empty($author_profile->teams_data)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'businesshours-contactform' ){
			if (!empty($author_profile->business_hours)) {
				$is_include	= 'yes';
			}

			if (isset($db_privacy['profile_contact']) && $db_privacy['profile_contact'] === 'on') {
				$is_include	= 'yes';
			}

			if( !empty( $is_include ) && $is_include === 'yes'){
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		}else if( $key === 'brochures' ){
			if (!empty($author_profile->profile_brochure)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'insurance' ){
			if (!empty($author_profile->profile_insurance)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'gallery' ){
			if (!empty($author_profile->profile_gallery_photos)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		} else if( $key === 'videos' ){
			if (!empty($author_profile->audio_video_urls)) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		}  else if( $key === 'articles' ){
			if (!empty(listingo_get_total_articles_by_user($author_profile->ID))) {
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		}  else if( $key === 'more-info-tabs' ){
			$enable_reviews = '';
			if (function_exists('fw_get_db_settings_option')) {
				$enable_reviews = fw_get_db_post_option($category_type, 'enable_reviews', true);
			}

			if (!empty($enable_reviews) && $enable_reviews['gadget'] === 'enable') {
				$is_include	= 'yes';
			}

			if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')
				 && apply_filters('listingo_is_feature_allowed', $category_type, 'qa') === true
				 && fw_ext('questionsanswers')
				 ) {
				$is_include	= 'yes';
			}

			if( !empty( $is_include ) && $is_include === 'yes'){
				if( count( $final_menu ) > 4 ){
					$final_menu_part[]	= $menu;
				}else{
					$final_menu[] = $menu;
				}
			}
		}
	}
}
?>
<section class="tg-haslayout spv-menu">
	<div class="tg-innernavbar tg-haslayout">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="tg-innernavbarholder">
						<nav id="tg-nav" class="tg-nav">
							<div id="tg-navigation" class="tg-navigation">
								<ul>
									<?php 
									if( !empty( $final_menu ) ){
										$menucounter	= 0;
										foreach( $final_menu as $key => $value ){
											$menucounter++;
											?>
											<li><a href="#section-<?php echo esc_attr( $value['key'] );?>"><?php echo esc_attr( $value['title'] );?></a></li>
									<?php }}?>
									<?php if( !empty( $final_menu_part ) ){?>
										<li>
											<div class="tg-themedropdown tg-userdropdown">
												<a class="tg-btnsearchvtwo" href="javascript:;"><i class="fa fa-bars"></i></a>
												<div class="tg-dropdownmenu tg-statusmenu" aria-labelledby="tg-usermenu">
													<nav class="tg-dashboardnav">
													  <ul class="dashboard-status">
														<?php
														$menucounter	= 0;
														foreach( $final_menu_part as $key => $value ){
															$menucounter++;
															?>
															<li><a href="#section-<?php echo esc_attr( $value['key'] );?>"><?php echo esc_attr( $value['title'] );?></a></li>
														<?php }?>
													  </ul>
													</nav>
												</div>
											</div>
										</li>
									<?php }?>
								</ul>
							</div>
						</nav>
					</div>	
				</div>
			</div>
		</div>
	</div>
</section>
