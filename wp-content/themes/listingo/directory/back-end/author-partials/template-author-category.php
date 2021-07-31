<?php
/**
 *
 * Author Category Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;

if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	$category  = get_user_meta($user_identity, 'category', true);
	$provider_subcategory	= listingo_get_provider_subcategories($user_identity);
	$provider_subcategory	= !empty( $provider_subcategory ) ?  $provider_subcategory : array();
	$args = array('posts_per_page' => '-1',
			'post_type' 		=> 'sp_categories',
			'post_status' 		=> 'publish',
			'suppress_filters'  => false
		);
	$cust_query = get_posts($args);
	?>
	<div class="tg-dashboardbox tg-languages sp-dashboard-profile-form">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Provider Category', 'listingo'); ?></h2>
				</div>
				<div class="tg-languagesbox">
					<div class="tg-startendtime">
						<div class="form-group">
							<span class="tg-select">
								<select name="basics[category]" class="sp-caetgory-select" data-current="<?php echo esc_attr( $category );?>" data-current_sub='<?php echo json_encode( $provider_subcategory );?>'>
									<option value=""><?php esc_html_e('Category', 'listingo'); ?></option>
									<?php
										if (!empty($cust_query)) {
											$counter = 0;
											foreach ($cust_query as $key => $dir) {
												$selected = '';
												if ( intval( $dir->ID ) === intval( $category ) ) {
													$selected = 'selected';
												}

												echo '<option ' . $selected . ' data-id="' . $dir->ID . '" data-title="' . $dir->post_title . '"  value="' . $dir->ID . '">' . $dir->post_title . '</option>';
											}
										}
									?>

								</select>
							</span>
						</div>
						<div class="form-group">
							<span class="tg-select">
								<select name="sub_category[]" multiple class="sp-sub-category">
									<option value=""><?php esc_html_e('Select Sub Category', 'listingo'); ?></option>
									<?php 
										if( !empty( $category ) ) {
											$terms = get_the_terms($category, 'sub_category');

											if (!empty($terms)) {
												foreach ($terms as $pterm) {
													$selected = '';
													if( is_array( $provider_subcategory ) && in_array( $pterm->slug , $provider_subcategory ) ){
														$selected = 'selected';
													}
													echo '<option ' . $selected . ' value="' . $pterm->slug . '">' . $pterm->name . '</option>';
												}
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
	</div>
<?php }