<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$provider_category		= listingo_get_provider_category($url_identity);
$provider_subcategory	= listingo_get_provider_subcategories($url_identity);
if( !empty( $provider_category ) ){?>
	<div class="tg-dashboardbox tg-basicinformation">
		<div class="tg-dashboardtitle">
			<h2><?php esc_html_e('Select Categories', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','categories');?></h2>
		</div>
		<div class="tg-amenitiesfeaturesbox">
			<div class="row">
			 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
			 		<div class="form-group">
						<span class="tg-select">
							<select name="sub_categories[]" multiple class="sp-sub-categories">
								<option value=""><?php esc_html_e('Select sub categories', 'listingo'); ?></option>
								<?php
									$terms = get_the_terms($provider_category, 'sub_category');
									if (!empty($terms)) {
										foreach ($terms as $pterm) {
											$selected = '';
											if( is_array( $provider_subcategory ) && in_array( $pterm->slug , $provider_subcategory ) ){
												$selected = 'selected';
											}
											echo '<option ' . $selected . ' value="' . $pterm->slug . '">' . $pterm->name . '</option>';
										}
									}
								?>
							</select>
						</span>
					</div>
			 	</div>
			</div>
		</div>
	</div>
<?php }