<?php
/**
 *
 * Author Brochures Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
$profile_brochure = get_user_meta($user_identity, 'profile_brochure', true);
$provider_category	= listingo_get_provider_category($user_identity);

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'brochures') === true ){?>
	<div class="tg-dashboardbox tg-brochureupload">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Brochure', 'listingo'); ?></h2>
				</div>
				<div class="tg-brochureuploadbox">
					<div class="tg-upload">
						<div class="tg-uploadhead">
							<span>
								<h3><?php esc_html_e('Upload Brochure', 'listingo'); ?></h3>
								<i class="fa fa-exclamation-circle"></i>
							</span>
							<i class="lnr lnr-upload"></i>
						</div>
						<div class="tg-box">
							<label class="tg-fileuploadlabel" for="tg-photogallery">
								<div id="plupload-brochure-container">
									<a href="javascript:;" id="upload-brochure" class="tg-fileinput sp-upload-container">
										<i class="lnr lnr-cloud-upload"></i>
									</a> 
								</div>
							</label>
							<div class="tg-brochure">
								<ul class="tg-tagdashboardlist sp-profile-brochure" data-file_type="<?php echo isset($profile_brochure['file_type']) ? esc_attr($profile_brochure['file_type']) : esc_attr('profile_brochure'); ?>">
									<?php
									if (!empty($profile_brochure['file_data'])) {
										$default = !empty($profile_brochure['default_file']) ? $profile_brochure['default_file'] : '';
										foreach ($profile_brochure['file_data'] as $key => $value) {
											$default_file_id	= '';
											if ( isset( $value['default_file'] ) && $value['default_file'] == $default) {
												$active = 'active';
												$default_file_id	= $value['default_file'];
											}
											?>
											<?php if (!empty($value['file_title'])) { ?>
												<li class="brochure-item brochure-thumb-item item-<?php echo intval($value['file_id']); ?>" data-brochure_id="<?php echo intval($value['file_id']); ?>">
													<span class="tg-tagdashboard">
														<i class="fa fa-close delete_brochure_file"></i>
														<em><?php echo esc_attr($value['file_title']); ?></em>
													</span>
													<i class="<?php echo esc_attr($value['file_icon']); ?> file_icon"></i>
													<input type="hidden" name="profile_brochure[file_type]" value="profile_brochure">
													<input type="hidden" class="default_file" name="profile_brochure[default_file]" value="<?php echo esc_attr($default_file_id); ?>">
													<input type="hidden" class="file_type" name="profile_brochure[file_data][<?php echo esc_attr($value['file_id']); ?>][file_type]" value="<?php echo esc_attr($value['file_type']); ?>">
													<input type="hidden" class="file_icon" name="profile_brochure[file_data][<?php echo esc_attr($value['file_id']); ?>][file_icon]" value="<?php echo esc_attr($value['file_icon']); ?>">
													<input type="hidden" class="file_title" name="profile_brochure[file_data][<?php echo esc_attr($value['file_id']); ?>][file_title]" value="<?php echo esc_attr($value['file_title']); ?>">
													<input type="hidden" class="file_abspath" name="profile_brochure[file_data][<?php echo esc_attr($value['file_id']); ?>][file_abspath]" value="<?php echo esc_attr($value['file_abspath']); ?>">
													<input type="hidden" class="file_relpath" name="profile_brochure[file_data][<?php echo esc_attr($value['file_id']); ?>][file_relpath]" value="<?php echo esc_attr($value['file_relpath']); ?>">
													<input type="hidden" class="file_id" name="profile_brochure[file_data][<?php echo intval($value['file_id']); ?>][file_id]" value="<?php echo intval($value['file_id']); ?>">
												</li>
											<?php } ?>
											<?php
										}
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-profile-brochure">
		<li class="brochure-item brochure-thumb-item">
			<span class="tg-tagdashboard">
				<i class="fa fa-close delete_brochure_file"></i>
				<em>{{data.file_title}}</em>
			</span>
			<i class="{{data.file_icon}} file_icon"></i>
			<input type="hidden" name="profile_brochure[file_type]" value="profile_brochure">
			<input type="hidden" class="default_file" name="profile_brochure[default_file]" value="{{data.id}}">
			<input type="hidden" class="file_type" name="profile_brochure[file_data][{{data.id}}][file_type]" value="{{data.file_type}}">
			<input type="hidden" class="file_icon" name="profile_brochure[file_data][{{data.id}}][file_icon]" value="{{data.file_icon}}">
			<input type="hidden" class="file_title" name="profile_brochure[file_data][{{data.id}}][file_title]" value="{{data.file_title}}">
			<input type="hidden" class="file_abspath" name="profile_brochure[file_data][{{data.id}}][file_abspath]" value="{{data.file_abspath}}">
			<input type="hidden" class="file_relpath" name="profile_brochure[file_data][{{data.id}}][file_relpath]" value="{{data.file_relpath}}">
			<input type="hidden" class="media_id" name="profile_brochure[file_data][{{data.id}}][file_id]" value="{{data.id}}">
		</li>
	</script>
	<?php }
}
