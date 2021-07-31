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

$profile_brochure = get_user_meta($user_identity, 'profile_brochure', true);
$provider_category	= listingo_get_provider_category($current_user->ID);

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'brochures') === true ){?>
<div class="tg-dashboardbox tg-brochureupload">
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
							<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
						</a>
					</div>
				</label>
				<div class="tg-brochure">
					<ul class="tg-tagdashboardlist sp-profile-brochure" data-file_type="<?php echo isset($profile_brochure['file_type']) ? esc_attr($profile_brochure['file_type']) : esc_attr('profile_brochure'); ?>">
						<?php
						if (!empty($profile_brochure['file_data'])) {
							foreach ($profile_brochure['file_data'] as $key => $value) {
								?>
								<?php if (!empty($value['file_title'])) { ?>
									<li class="brochure-item brochure-thumb-item item-<?php echo intval($value['file_id']); ?>" data-brochure_id="<?php echo intval($value['file_id']); ?>">
										<span class="tg-tagdashboard">
											<i class="fa fa-close delete_brochure_file"></i>
											<em><?php echo esc_attr($value['file_title']); ?></em>
										</span>
										<i class="<?php echo esc_attr($value['file_icon']); ?> file_icon"></i>
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
	<script type="text/template" id="tmpl-load-profile-brochure">
		<li class="brochure-item brochure-thumb-item item-{{data.attachment_id}}" data-brochure_id="{{data.attachment_id}}">
		<span class="tg-tagdashboard">
		<i class="fa fa-close delete_brochure_file"></i>
		<em>{{data.file_title}}</em>
		</span>
		<i class="{{data.file_icon}} file_icon"></i>
		</li>
	</script>
</div>
<?php }