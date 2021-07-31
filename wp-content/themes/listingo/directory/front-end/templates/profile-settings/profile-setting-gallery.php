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

$user_identity 		= $current_user->ID;
$url_identity 		= $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$profile_gallery 	= get_user_meta($user_identity, 'profile_gallery_photos', true);
$provider_category	= listingo_get_provider_category($current_user->ID);

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'gallery') === true ){?>
<div class="tg-dashboardbox tg-imggallery">
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
							<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
						</a>
					</div> 
				</label>
				<div class="tg-gallery sp-profile-gallery-photos" data-image_type="<?php echo isset($profile_gallery['image_type']) ? esc_attr($profile_gallery['image_type']) : esc_attr('profile_gallery'); ?>">
					<div class="tg-galleryimages">
						<?php
						if (!empty($profile_gallery['image_data'])) {
							foreach ($profile_gallery['image_data'] as $key => $value) {

								$image_meta = '';
								if (!empty($value['image_id'])) {
									$image_meta = listingo_get_image_metadata($value['image_id']);
								}
								$image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
								$image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
								
								$meta_title = !empty($value['title']) ? $value['title'] : '';
								$meta_link  = !empty($value['link']) ? $value['link'] : '';
								
								?>
								<div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['image_id']); ?>" data-id="<?php echo intval($value['image_id']); ?>">
									<?php if (!empty($value['thumb'])) { ?>
										<figure>
											<img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
											<figcaption>
												<a href="javascript:;" data-toggle="modal" data-target=".tg-categoryModal-<?php echo intval($value['image_id']); ?>"><i class="fa fa-pencil edit-gallery-photo"></i></a>
												<i class="fa fa-close del-profile-gallery-photo"></i>
											</figcaption>
										</figure>
										<div class="modal fade tg-modalmanageteam tg-categoryModal-<?php echo intval($value['image_id']); ?>" tabindex="-1">
											<div class="modal-dialog tg-modaldialog" role="document">
												<div class="modal-content tg-modalcontent">
													<div class="tg-modalhead">
														<h2><?php esc_html_e('Update Meta Data', 'listingo'); ?></h2>
													</div>
													<div class="tg-modalbody">
														<fieldset>
															<div class="form-group">
																<input type="text" value="<?php echo esc_attr( $meta_title );?>"  name="title" class="form-control meta-title" placeholder="<?php esc_html_e('Add title', 'listingo'); ?>">
															</div>
															<div class="form-group">
																<input type="text" value="<?php echo esc_attr( $meta_link );?>" name="link" class="form-control meta-link" placeholder="<?php esc_html_e('Add link', 'listingo'); ?>">
															</div>
														</fieldset>
													</div>
													<div class="tg-modalfoot">
														<a href="javascript:;" data-id="<?php echo intval($value['image_id']); ?>" class="tg-btn update-gallery-meta" type="submit"><?php esc_html_e('Update', 'listingo'); ?></a>
													</div>
												</div>
											</div>
										</div>
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
	<script type="text/template" id="tmpl-load-profile-gallery-thumb">
		<div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
		<figure>
			<img src="{{data.thumbnail}}">
			<figcaption>
				<a href="javascript:;" data-toggle="modal" data-target=".tg-categoryModal-{{data.attachment_id}}"><i class="fa fa-pencil edit-gallery-photo"></i></a>
				<i class="fa fa-close del-profile-gallery-photo"></i>
			</figcaption>
			<div class="modal fade tg-modalmanageteam tg-categoryModal-{{data.attachment_id}}" tabindex="-1">
				<div class="modal-dialog tg-modaldialog" role="document">
					<div class="modal-content tg-modalcontent">
						<div class="tg-modalhead">
							<h2><?php esc_html_e('Update Meta Data', 'listingo'); ?></h2>
						</div>
						<div class="tg-modalbody">
							<fieldset>
								<div class="form-group">
									<input type="text" value=""  name="title" class="form-control meta-title" placeholder="<?php esc_html_e('Add title', 'listingo'); ?>">
								</div>
								<div class="form-group">
									<input type="text" value="" name="link" class="form-control meta-link" placeholder="<?php esc_html_e('Add link', 'listingo'); ?>">
								</div>
							</fieldset>
						</div>
						<div class="tg-modalfoot">
							<a href="javascript:;" data-id="{{data.attachment_id}}" class="tg-btn update-gallery-meta" type="submit"><?php esc_html_e('Update', 'listingo'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</figure>
		</div>
	</script>
	
</div>
<?php }?>
