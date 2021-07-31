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

$profile_avatars 	= get_user_meta($user_identity, 'profile_avatar', true);
$profile_banners 	= get_user_meta($user_identity, 'profile_banner_photos', true);
$provider_category	= listingo_get_provider_category($current_user->ID);
?>

<div class="tg-dashboardbox tg-uploadphotos">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Upload Photos', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','photos');?></h2>
	</div>
	<div class="tg-uploadbox">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
				<div class="tg-upload">
					<div class="tg-uploadhead">
						<span>
							<h3><?php esc_html_e('Upload Profile Photo/Logo', 'listingo'); ?></h3>
							<i class="fa fa-exclamation-circle"></i>
						</span>
						<i class="lnr lnr-upload"></i>
					</div>
					<div class="tg-box">
						<label class="tg-fileuploadlabel" for="tg-profilephoto">
							<div id="plupload-profile-container">
								<a href="javascript:;" id="upload-profile-photo" class="tg-fileinput sp-upload-container">
									<i class="lnr lnr-cloud-upload"></i>
									<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
								</a> 
							</div>
						</label>
						<div class="tg-gallery">
							<div class="tg-galleryimages sp-profile-photo" data-image_type="<?php echo isset($profile_avatars['image_type']) ? esc_attr($profile_avatars['image_type']) : esc_attr('profile_photo'); ?>">
								<?php
								if (!empty($profile_avatars['image_data'])) {
									$default = !empty($profile_avatars['default_image']) ? $profile_avatars['default_image'] : '';
									foreach ($profile_avatars['image_data'] as $key => $value) {
										$active = '';
										if ($value['image_id'] == $default) {
											$active = 'active';
										}

										$image_meta = '';
										if (!empty($value['image_id'])) {
											$image_meta = listingo_get_image_metadata($value['image_id']);
										}
										$image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
										$image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
										?>
										<div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['image_id']); ?> <?php echo esc_attr($active); ?>" data-id="<?php echo intval($value['image_id']); ?>">
											<figure>
												<?php if (!empty($value['thumb'])) { ?>
													<img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
													<figcaption>
														<i class="fa fa-check active-profile-photo"></i>
														<i class="fa fa-close del-profile-photo"></i>
													</figcaption>
												<?php } ?>
											</figure>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if (apply_filters('listingo_is_setting_enabled', $user_identity, 'subscription_profile_banner') === true) { ?>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
					<div class="tg-upload">
						<div class="tg-uploadhead">
							<span>
								<h3><?php esc_html_e('Upload Banner Photo', 'listingo'); ?></h3>
								<i class="fa fa-exclamation-circle"></i>
							</span>
							<i class="lnr lnr-upload"></i>
						</div>
						<div class="tg-box">
							<label class="tg-fileuploadlabel" for="tg-bannerphoto">
								<div id="plupload-banner-container">
									<a href="javascript:;" id="upload-profile-banner-photo" class="tg-fileinput sp-upload-container">
										<i class="lnr lnr-cloud-upload"></i>
										<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
									</a>
								</div> 
							</label>
							<div class="tg-gallery">
								<div class="tg-galleryimages sp-profile-banner-photos" data-image_type="profile_banner">
									<?php
									if (!empty($profile_banners['image_data'])) {
										$default = !empty($profile_banners['default_image']) ? $profile_banners['default_image'] : '';
										foreach ($profile_banners['image_data'] as $key => $value) {
											$active = '';
											if ($value['image_id'] == $default) {
												$active = 'active';
											}
											$image_meta = '';
											if (!empty($value['image_id'])) {
												$image_meta = listingo_get_image_metadata($value['image_id']);
											}
											$image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
											$image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
											?>
											<div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['image_id']); ?> <?php echo esc_attr($active); ?>" data-id="<?php echo intval($value['image_id']); ?>">
												<figure>
													<?php if (!empty($value['thumb'])) { ?>
														<img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
														<figcaption>
															<i class="fa fa-check active-profile-banner"></i>
															<i class="fa fa-close del-profile-banner-photo"></i>
														</figcaption>
													<?php } ?>
												</figure>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	
	<script type="text/template" id="tmpl-load-profile-thumb">
		<div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
			<figure>
				<img src="{{data.thumbnail}}">
				<figcaption>
					<i class="fa fa-check active-profile-photo"></i>
					<i class="fa fa-close del-profile-photo"></i>
				</figcaption>
			</figure>
		</div>
	</script>
	<script type="text/template" id="tmpl-load-profile-banenr-thumb">
		<div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
			<figure>
				<img src="{{data.thumbnail}}">
				<figcaption >
					<i class="fa fa-check active-profile-banner"></i>
					<i class="fa fa-close del-profile-banner-photo"></i>
				</figcaption>
			</figure>
		</div>
	</script>
</div>


