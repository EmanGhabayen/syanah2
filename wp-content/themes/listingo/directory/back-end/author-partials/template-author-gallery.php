<?php
/**
 *
 * Gallery
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;
	$profile_languages  = array();
	$profile_gallery    = get_user_meta($user_identity, 'profile_gallery_photos', true);
	$provider_category	= listingo_get_provider_category($user_identity);

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'gallery') === true ){?>
	<div class="tg-dashboardbox tg-imggallery">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Gallery', 'listingo'); ?></h2>
				</div>
				<div class="tg-imggallerybox">
					<div class="tg-upload">
						<div class="tg-uploadhead">
							<span>
								<h3><?php esc_html_e('Upload Photo Gallery', 'listingo'); ?></h3>
								<i class="fa fa-exclamation-circle"></i>
							</span>
							<i class="lnr lnr-upload"></i>
						</div>
						<div class="tg-box">
							<label class="tg-fileuploadlabel" for="tg-photogallery">
								<div id="plupload-gallery-container">
									<a href="javascript:;" id="upload-gallery-photos" class="tg-fileinput sp-upload-container">
										<i class="lnr lnr-cloud-upload"></i>
									</a>
								</div> 
							</label>
							<div class="tg-gallery sp-profile-gallery-photos" data-user_id="<?php echo esc_attr( $profileuser->ID );?>" data-image_type="<?php echo isset($profile_gallery['image_type']) ? esc_attr($profile_gallery['image_type']) : esc_attr('profile_gallery'); ?>">
								<div class="tg-galleryimages">
									<?php
									if (!empty($profile_gallery['image_data'])) {
										$default = !empty($profile_gallery['default_image']) ? $profile_gallery['default_image'] : '';
										foreach ($profile_gallery['image_data'] as $key => $value) {

											$image_meta = '';
											$default_image_id	= '';
											$active = '';

											if ($value['image_id'] == $default) {
												$active = 'active';
												$default_image_id	= $value['image_id'];
											}

											if (!empty($value['image_id'])) {
												$image_meta = listingo_get_image_metadata($value['image_id']);
											}

											$image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
											$image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
											?>
											<div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['image_id']); ?> <?php echo esc_attr($active); ?>" data-id="<?php echo intval($value['image_id']); ?>">
												<?php if (!empty($value['thumb'])) { ?>
													<figure>
														<img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
														<figcaption><i class="fa fa-close del-profile-gallery-photo"></i></figcaption>
														<input type="hidden" class="media_full" name="profile_gallery_photos[image_type]" value="profile_gallery">
														<input type="hidden" class="media_full" name="profile_gallery_photos[default_image]" value="<?php echo esc_attr($default_image_id); ?>">
														<input type="hidden" class="media_full" name="profile_gallery_photos[image_data][<?php echo intval($value['image_id']); ?>][full]" value="<?php echo esc_url($value['full']); ?>">
														<input type="hidden" class="media_thumb" name="profile_gallery_photos[image_data][<?php echo intval($value['image_id']); ?>][thumb]" value="<?php echo esc_url($value['thumb']); ?>">
														<input type="hidden" class="media_banner" name="profile_gallery_photos[image_data][<?php echo intval($value['image_id']); ?>][banner]" value="<?php echo esc_url($value['banner']); ?>">
														<input type="hidden" class="media_image_id" name="profile_gallery_photos[image_data][<?php echo intval($value['image_id']); ?>][image_id]" value="<?php echo intval($value['image_id']); ?>">
													</figure>
												<?php } ?>
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
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-gallery-thumb">
		<div class="tg-galleryimg tg-galleryimg-item">
			<figure>
				<img src="{{data.thumb}}">
				<figcaption><i class="fa fa-close del-profile-gallery-photo"></i></figcaption>
				<input type="hidden" class="media_full" name="profile_gallery_photos[image_type]" value="profile_photo">
				<input type="hidden" class="media_full" name="profile_gallery_photos[default_image]" value="{{data.id}}">
				<input type="hidden" class="media_full" name="profile_gallery_photos[image_data][{{data.id}}][full]" value="{{data.full}}">
				<input type="hidden" class="media_thumb" name="profile_gallery_photos[image_data][{{data.id}}][thumb]" value="{{data.thumb}}">
				<input type="hidden" class="media_banner" name="profile_gallery_photos[image_data][{{data.id}}][banner]" value="{{data.banner}}">
				<input type="hidden" class="media_image_id" name="profile_gallery_photos[image_data][{{data.id}}][image_id]" value="{{data.id}}">
			</figure>
		</div>
	</script>
	<?php }
}
