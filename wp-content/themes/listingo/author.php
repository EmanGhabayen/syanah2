<?php
/**
 *
 * Author Page
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
$author_profile = $wp_query->get_queried_object();

/* Get Category type */
$category_type 		= $author_profile->category;
$provider_category  = listingo_get_provider_category($author_profile->ID);
$db_privacy 		= listingo_get_privacy_settings($author_profile->ID);
$style_settings		= listingo_get_provider_page_style($author_profile->ID);
$profile_section 	= apply_filters('listingo_get_profile_sections',$author_profile->ID,'content');
$profile_v4_section = apply_filters('listingo_get_profile_v4_sections',$author_profile->ID);
$customer_sections  = apply_filters('listingo_get_customer_profile_sections',$author_profile->ID);
/* Check if reviews enable from category settings then include the template. */

$enable_reviews = '';
if (function_exists('fw_get_db_settings_option')) {
    $enable_reviews = fw_get_db_post_option($category_type, 'enable_reviews', true);
}

/* ==================Set The Profile Views==================== */
do_action('sp_set_profile_views', $author_profile->ID, 'set_profile_view');

$start_wrapper	= '';
$end_wrapper	= '';

$viewClass	= 'tg-serviceproviderdetailvone';
if( isset( $style_settings ) && $style_settings === 'view_2' ){
	$viewClass	= 'tg-serviceproviderdetailvtwo';
	$start_wrapper	= '<div class="tg-listdetailcontent">';
	$end_wrapper	= '</div>';
} else if( isset( $style_settings ) && $style_settings === 'view_3' ){
	$viewClass	= 'tg-listinglistdetail sp-detail-bannerv3';
}

get_header();

if (( apply_filters('listingo_get_user_type', $author_profile->ID) === 'business' 
	 || apply_filters('listingo_get_user_type', $author_profile->ID) === 'professional' 
	) && function_exists('fw_get_db_settings_option')
) {
	if( isset( $style_settings ) && $style_settings === 'view_4' ){ ?>
		 <div class="sp-provider-detail providers-v4">
			<?php			
				foreach( $profile_v4_section as $key => $value  ){
					get_template_part('directory/front-end/author-partials/provider/v4/template-author', $key);
				}
			?>
		</div>
		<?php 
			//appointment model
			if (isset($db_privacy['profile_appointment']) && $db_privacy['profile_appointment'] === 'on') {
				get_template_part('directory/front-end/author-partials/provider/template-author-appointment', 'model');
			}

			//Including Schema template    
			get_template_part('directory/front-end/author-partials/provider/template-author-schema', 'data');  

			
	} else{
		?>
		<div class="tg-serviceprovider tg-detailpage tg-serviceproviderdetail sp-default-layout <?php echo esc_attr( $viewClass );?>">
			<?php echo (  $start_wrapper );?>
			<?php 
				if( isset( $style_settings ) && $style_settings === 'view_2' ){
					get_template_part('directory/front-end/author-partials/provider/template-author', 'header_v2');
				}else if( isset( $style_settings ) && $style_settings === 'view_3' ){
					get_template_part('directory/front-end/author-partials/provider/template-author', 'header_v3');
				}else{
					get_template_part('directory/front-end/author-partials/provider/template-author', 'header');
					get_template_part('directory/front-end/author-partials/provider/template-author-views', 'bar');
				}
			?>
			<div id="tg-twocolumns" class="tg-twocolumns">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
							<div id="tg-content" class="tg-content">
								<div class="tg-companyfeatures">
								   <?php get_template_part('directory/front-end/author-partials/provider/template-author', 'banner'); ?>
								   <?php 								 
										foreach( $profile_section as $key => $value  ){
											get_template_part('directory/front-end/author-partials/provider/template-author', $key);
										}
									?>
								</div>
							</div>
						</div>
						<?php get_template_part('directory/front-end/author-partials/provider/template-author', 'sidebar'); ?>
					</div>
				</div>
			</div>
			<?php echo (  $end_wrapper );?>
		</div>
		<?php
		if (isset($db_privacy['profile_appointment']) && $db_privacy['profile_appointment'] === 'on') {
			get_template_part('directory/front-end/author-partials/provider/template-author-appointment', 'model');
		}

		//Including Schema template    
		get_template_part('directory/front-end/author-partials/provider/template-author-schema', 'data');    
	}

} else if ( apply_filters('listingo_get_user_type', $author_profile->ID) === 'customer' ){?>
	<div class="tg-serviceprovider tg-detailpage tg-serviceproviderdetail tg-serviceproviderdetailvtwo customer-dashboard">
        <div class="tg-listdetailcontent">
			<?php get_template_part('directory/front-end/author-partials/customer/template-author', 'header_v2');?>
			<div id="tg-twocolumns" class="tg-twocolumns">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8 pull-left">
							<div id="tg-content" class="tg-content">
								<div class="tg-companyfeatures">
							   	   <?php if (is_active_sidebar('user-page-top')) {?>
									  <div class="tg-advertisement">
										<?php dynamic_sidebar('user-page-top'); ?>
									  </div>
								   <?php }?>
								   <?php
										foreach( $customer_sections['content'] as $key => $value ){
											$template	= !empty( $value['key'] ) ? $value['key'] : 'default';
											get_template_part('directory/front-end/author-partials/customer/template-author', $template);
										}
									?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right">
							<aside id="tg-sidebar" class="tg-sidebar">
								<?php 
									foreach( $customer_sections['sidebar'] as $key => $value ){
										$template	= !empty( $value['key'] ) ? $value['key'] : 'default';
										get_template_part('directory/front-end/author-partials/customer/template-author-sidebar',$template); 
									}															  
								?>
							</aside>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
<?php
}else {
    get_template_part('content', 'author');
}

get_footer();

get_template_part('directory/front-end/author-partials/provider/template-author-facbook-customer', 'chat');
get_template_part('directory/front-end/author-partials/provider/template-author-add', 'templates');
do_action('am_chat_modal',$author_profile->ID);
