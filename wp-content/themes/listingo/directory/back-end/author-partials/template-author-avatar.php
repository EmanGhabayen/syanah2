<?php
/**
 *
 * Author avatar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
$profile_avatars = get_user_meta( $user_identity, 'profile_avatar', true );

?>
<div class="tg-dashboardbox tg-uploadphotos">
	<div class="sp-row">
		<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
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
						<a href="javascript:;" id="upload-profile-photo" class="tg-fileinput sp-upload-container">
							<i class="lnr lnr-cloud-upload"></i>
						</a> 
					</label>
					<div class="tg-gallery">
						<div class="tg-galleryimages sp-profile-photo" data-image_type="<?php echo isset($profile_avatars['image_type']) ? esc_attr($profile_avatars['image_type']) : esc_attr('profile_photo'); ?>">
							<?php
							if (!empty($profile_avatars['image_data'])) {
								$default = !empty($profile_avatars['default_image']) ? $profile_avatars['default_image'] : '';
								foreach ($profile_avatars['image_data'] as $key => $value) {
									$active = '';
									$default_image_id = '';
									if ($value['image_id'] == $default) {
										$active = 'active';
										$default_image_id	= $value['image_id'];
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
												<img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo !empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
												<figcaption>
													<i class="fa fa-check active-profile-photo"></i>
													<i class="fa fa-close del-profile-photo"></i>
												</figcaption>
												<input type="hidden" class="media_full" name="profile_avatar[image_type]" value="profile_photo">
												<input type="hidden" class="media_full" name="profile_avatar[default_image]" value="<?php echo esc_attr($default_image_id); ?>">
												<input type="hidden" class="media_full" name="profile_avatar[image_data][<?php echo intval($value['image_id']); ?>][full]" value="<?php echo esc_url($value['full']); ?>">
												<input type="hidden" class="media_thumb" name="profile_avatar[image_data][<?php echo intval($value['image_id']); ?>][thumb]" value="<?php echo esc_url($value['thumb']); ?>">
												<input type="hidden" class="media_banner" name="profile_avatar[image_data][<?php echo intval($value['image_id']); ?>][banner]" value="<?php echo esc_url($value['banner']); ?>">
												<input type="hidden" class="media_image_id" name="profile_avatar[image_data][<?php echo intval($value['image_id']); ?>][image_id]" value="<?php echo intval($value['image_id']); ?>">
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
	</div>
</div>
<script type="text/template" id="tmpl-load-profile-thumb">
    <div class="tg-galleryimg tg-galleryimg-item item-{{data.id}}" data-id="{{data.id}}">
		<figure>
			<img src="{{data.thumb}}">
			<figcaption>
				<i class="fa fa-check active-profile-photo"></i>
				<i class="fa fa-close del-profile-photo"></i>
			</figcaption>
			<input type="hidden" class="media_full" name="profile_avatar[image_type]" value="profile_photo">
			<input type="hidden" class="media_full" name="profile_avatar[default_image]" value="{{data.id}}">
			<input type="hidden" class="media_full" name="profile_avatar[image_data][{{data.id}}][full]" value="{{data.full}}">
			<input type="hidden" class="media_thumb" name="profile_avatar[image_data][{{data.id}}][thumb]" value="{{data.thumb}}">
			<input type="hidden" class="media_banner" name="profile_avatar[image_data][{{data.id}}][banner]" value="{{data.banner}}">
			<input type="hidden" class="media_image_id" name="profile_avatar[image_data][{{data.id}}][image_id]" value="{{data.id}}">		
		</figure>
    </div>
</script>