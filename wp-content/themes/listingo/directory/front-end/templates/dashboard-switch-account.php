<?php
/**
 *
 * The template part for displaying the dashboard services.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user, $wp_roles, $userdata, $post;
$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

?>
<div class="tg-dashboard tg-dashboardmanageservices switch-account">
	<div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8">
		<div id="tg-content" class="tg-content">
			<div class="tg-loginviasocial">
				<div class="tg-sectionhead">
					<div class="tg-sectiontitle">
						<h2><?php esc_html_e('You are nearly there!', 'listingo'); ?></h2>
					</div>
					<div class="tg-description">
						<p><?php esc_html_e('Please select the options below to complete the account switch process.', 'listingo'); ?></p>
					</div>
				</div>
				<div class="tg-themeform tg-formlogin-register tg-formlogin-facebook">
					<fieldset>
						<ul class="tg-tabnav" role="tablist">
							<li role="presentation" class="active">
								<a href="#company" data-toggle="tab">
									<span class="lnr lnr-briefcase"></span>
									<div class="tg-navcontent">
										<h3><?php esc_html_e('Company / Professional', 'listingo'); ?></h3>
										<span><?php esc_html_e('Register As Service Provider', 'listingo'); ?></span>
									</div>
								</a>
							</li>
						</ul>	
						<div class="tg-themetabcontent tab-content">
							<div class="tab-pane active fade in tg-companyregister" id="company">
								<form action="#" method="post" class="do-complete-form">
									<div class="tg-description">
										<p><?php esc_html_e('Please select role, either you want to register as "Business or Professional" then select category and sub category under which you want to register yourself.', 'listingo'); ?></p>
									</div>
									<div class="form-group">
										<div class="tg-registeras">
											<span><?php esc_html_e('Register As', 'listingo'); ?>:</span>
											<div class="tg-radio">
												<input type="radio" class="register_type" value="business" id="business" name="register[type]" checked>
												<label for="business"><?php esc_html_e('Business', 'listingo'); ?></label>
											</div>
											<div class="tg-radio">
												<input type="radio" class="register_type" value="professional" id="professional" name="register[type]">
												<label for="professional"><?php esc_html_e('professional', 'listingo'); ?></label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<span class="tg-select">
											<select name="register[category]" class="sp-category">
												<option value=""><?php esc_html_e('Select Category', 'listingo'); ?></option>
												<?php listingo_get_categories('', 'sp_categories'); ?>
											</select>
										</span>
									</div>
									<?php if( apply_filters('listingo_dev_manage_fields','true','sub_category') === 'true' ){?>
									<div class="form-group">
										<span class="tg-select">
											<select name="register[sub_category][]" multiple class="sp-sub-category sp-register-ms">
												<option value=""><?php esc_html_e('Select Sub Category', 'listingo'); ?></option>
											</select>
										</span>
									</div>
									<?php }?>
									<div class="form-group term-group">
											<input type="hidden" name="register[account]" value="provider">
											<?php wp_nonce_field('register_provider_request', 'register_provider_request'); ?>
											<button class="tg-btn do-complete-profile" type="submit"><?php esc_html_e('Get Started', 'listingo'); ?></button>
										</div>
									</div>
								</form>
							</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</div>