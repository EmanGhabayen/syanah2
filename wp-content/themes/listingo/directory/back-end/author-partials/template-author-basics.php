<?php
/**
 *
 * Author basics Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$professional_statements = get_user_meta($user_identity, 'professional_statements', true);
	?>
	
	<div class="tg-dashboardbox tg-introduction">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Introduction', 'listingo'); ?></h2>
				</div>
				<div class="tg-introductionbox">
					<p><strong><?php esc_html_e('It will be shown in user detail page below user short description.', 'listingo'); ?></strong></p>
					<?php
					$professional_statements = !empty($professional_statements) ? $professional_statements : '';
					$settings = array('media_buttons' => false,'quicktags' => true);
					wp_editor($professional_statements, 'professional_statements', $settings);
					?>
				</div>
			</div>
		</div>
	</div>
<?php }?>

<?php 
if ( $profileuser->roles[0] === 'professional' ){
	$gender = get_user_meta($user_identity, 'gender', true);

	if( apply_filters('listingo_dev_manage_fields','true','gender') === 'true' ){?>
		<div class="tg-dashboardbox tg-introduction">
			<div class="sp-row">
				<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
					<div class="tg-dashboardtitle">
						<h2><?php esc_html_e('Gender', 'listingo'); ?></h2>
					</div>
					<div class="tg-languagesbox">
						<span class="tg-select">
							<select name="basics[gender]">
								<option value=""><?php esc_html_e('Gender', 'listingo'); ?></option>
								<option value="male" <?php echo isset($gender) && $gender === 'male' ? 'selected' : '';?>><?php esc_html_e('Male', 'listingo'); ?></option>
								<option value="female" <?php echo isset($gender) && $gender === 'female' ? 'selected' : '';?>><?php esc_html_e('Female', 'listingo'); ?></option>
							</select>
						</span>
					</div>
				</div>
			</div>
		</div>
<?php }} ?>