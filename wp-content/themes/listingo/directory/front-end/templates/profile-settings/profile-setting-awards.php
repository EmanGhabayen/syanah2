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

$provider_category	= listingo_get_provider_category($current_user->ID);
$profile_awards 	= get_user_meta($user_identity, 'awards', true);
$date_format		= listingo_get_calendar_format();

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'awards') === true ){?>
<div class="tg-dashboardbox tg-certificatesawards">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Certificates and Awards', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','awards');?></h2>
		<a class="tg-btnaddnew add-profile-awards" href="javascript:;"><?php esc_html_e('+ add new', 'listingo'); ?></a>
	</div>
	<div class="tg-certificatesawardsbox profile-awards-wrap">
		<?php if (!empty($profile_awards)) { ?>
			<?php
			$counter_awards = 0;
			foreach ($profile_awards as $key => $value) {

				$width = 40;
				$height = 40;
				
				$awards_thumb = '';
				$image_meta = '';
				$default_thumb = esc_url(get_template_directory_uri() . '/images/award.jpg');
				
				if (!empty($value['attachment_id'])) {
					$image_meta   = listingo_get_image_metadata($value['attachment_id']);
					$awards_thumb = listingo_prepare_image_source($value['attachment_id'], intval($width), intval($height));
				}
				
				$awards_thumb	=  !empty( $awards_thumb ) ? $awards_thumb : $default_thumb;

				$image_alt 		= !empty($image_meta['alt']) ? $image_meta['alt'] : '';
				$image_title 	= !empty($image_meta['title']) ? $image_meta['title'] : '';
				$award_title 	= !empty($value['title']) ? $value['title'] : '';
				$award_date 	= !empty($value['date']) ? date($date_format, $value['date']) : '';
				
				$award_description = !empty($value['description']) ? $value['description'] : '';

				$inlinescript	= "jQuery(document).ready(function () {
						var sp_upload_nonce = scripts_vars.sp_upload_nonce;
						var sp_upload_awards = scripts_vars.sp_upload_awards;
						var data_size_in_kb = scripts_vars.data_size_in_kb;
						var uploaderArguments = {
							browse_button: 'upload-award-photo-".esc_attr($counter_awards)."', // this can be an id of a DOM element or the DOM element itself
							file_data_name: 'sp_image_uploader',
							container: 'plupload-award-container-".esc_attr($counter_awards)."',
							drop_element: 'upload-award-photo-".esc_attr($counter_awards)."',
							multipart_params: {
								'type': 'profile_award',
							},
							multi_selection: false,
							url: scripts_vars.ajaxurl + '?action=listingo_image_uploader&nonce=' + sp_upload_nonce,
							filters: {
								mime_types: [
									{title: sp_upload_awards, extensions: 'jpg,jpeg,gif,png'}
								],
								max_file_size: data_size_in_kb,
								max_file_count: 1,
								prevent_duplicates: false
							}
						};

						var AwardUploader = new plupload.Uploader(uploaderArguments);
						AwardUploader.init();

						//bind
						AwardUploader.bind('FilesAdded', function (up, files) {
							var awardThumb = '';
							plupload.each(files, function (file) {
								awardThumb += '<div class=\"tg-galleryimg gallery-item gallery-thumb-item\" id=\"thumb-' + file.id + '\"></div>';
							});

							jQuery('.awards-parent-wrap-".esc_attr($counter_awards)." .sp-awards-photo .tg-galleryimages').html(awardThumb);
							up.refresh();
							AwardUploader.start();
						});

						//bind
						AwardUploader.bind('UploadProgress', function (up, file) {
							jQuery('.gallery-thumb-item').addClass('tg-uploading');
							jQuery('#thumb-' + file.id).append('<figure class=\"user-avatar\"><span class=\"tg-loader\"><i class=\"fa fa-spinner\"></i></span><span class=\"tg-uploadingbar\"><span class=\"tg-uploadingbar-percentage\" style=\"width:' + file.percent + 'px;\"></span></span></figure>');
							listingo_uploader_progressbar(file.percent,'add');
						});


						//Error
						AwardUploader.bind('Error', function (up, err) {
							jQuery.sticky(err.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
						});


						//display data
						AwardUploader.bind('FileUploaded', function (up, file, ajax_response) {

							var response = $.parseJSON(ajax_response.response);

							if ( response.type === 'success' ) {
								var load_award_thumb = wp.template('load-profile-award-thumb');
								var counter = '".esc_attr($counter_awards)."';
								var data = {count: counter, response: response};
								var load_award_thumb = load_award_thumb(data);
								jQuery('#thumb-' + file.id).html(load_award_thumb);
								jQuery('.awards-parent-wrap-".esc_attr($counter_awards)." .sp-award-photo-thumb').find('img').attr('src', response.banner);
							} else {
								jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000});
							}
							
							listingo_uploader_progressbar('','remove');
						});

						//Delete Award Image
						jQuery(document).on('click', '.sp-awards-photo .del-profile-award-photo', function (e) {
							e.preventDefault();
							var _this = jQuery(this);
							_this.parents('.tg-galleryimg').remove();
						});

					});";

					wp_add_inline_script('listingo_user_dashboard', $inlinescript,'after');
				?>

				<div class="tg-certificatesaward awards-parent-wrap-<?php echo esc_attr($counter_awards); ?>" data-count-awards="<?php echo intval($counter_awards); ?>">
					<div class="tg-imgandtitle">
						<figure class="sp-award-photo-thumb">
							<a href="javascript:;">
								<img src="<?php echo esc_url($awards_thumb); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
							</a>
						</figure>
						<h3>
							<a class="sp-awards-title" href="javascript:;"><?php echo esc_attr($value['title']); ?></a>
						</h3>
					</div>
					<div class="tg-btntimeedit">
						<button type="button" class="tg-btnedite edit_awards"><i class="lnr lnr-pencil "></i></button>
						<button type="button" class="tg-btndel delete_awards"><i class="lnr lnr-trash "></i></button>
					</div>
					<div class="sp-awards-edit-collapse tg-haslayout elm-display-none">
						<div class="tg-themeform tg-formcertificatesawards">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
								<div class="form-group">
									<div class="tg-imggallerybox">
										<div class="tg-upload">
											<div class="tg-uploadhead">
												<span>
													<h3><?php esc_html_e('Upload Awards &amp; Certification Photo', 'listingo'); ?></h3>
													<i class="fa fa-exclamation-circle"></i>
												</span>
												<i class="lnr lnr-upload"></i>
											</div>
											<div class="tg-box">
												<label class="tg-fileuploadlabel" for="tg-photogallery">										 
													<div id="plupload-award-container-<?php echo esc_attr($counter_awards); ?>">
														<a href="javascript:;" id="upload-award-photo-<?php echo esc_attr($counter_awards); ?>" class="tg-fileinput sp-upload-container">
															<i class="lnr lnr-cloud-upload"></i>
															<span><?php echo esc_html_e('Upload Awards &amp; Certification Photo', 'listingo'); ?></span>
														</a>
													</div>
												</label>
												<div class="tg-gallery sp-awards-photo">
													<div class="tg-galleryimages">
														<div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['attachment_id']); ?>" data-id="<?php echo intval($value['attachment_id']); ?>">
															<figure>
																<img src="<?php echo esc_url($value['thumbnail_url']); ?>">
																<figcaption><i class="fa fa-close del-profile-award-photo"></i></figcaption>
																<input type="hidden" value="<?php echo intval($value['attachment_id']); ?>" name="awards[<?php echo intval($counter_awards); ?>][attachment_id]">
																<input type="hidden" value="<?php echo esc_url($value['thumbnail_url']); ?>" name="awards[<?php echo intval($counter_awards); ?>][thumbnail_url]">
																<input type="hidden" value="<?php echo esc_url($value['banner_url']); ?>" name="awards[<?php echo intval($counter_awards); ?>][banner_url]">
																<input type="hidden" value="<?php echo esc_url($value['full_url']); ?>" name="awards[<?php echo intval($counter_awards); ?>][full_url]">
															</figure>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
								<div class="form-group">
									<input type="text" class="form-control sp-awards-title-input" name="awards[<?php echo intval($counter_awards); ?>][title]" placeholder="<?php esc_html_e('Certificates / Awards Title', 'listingo'); ?>" value="<?php echo esc_attr($award_title); ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
								<div class="form-group">
									<input readonly type="text" class="form-control awards_date" name="awards[<?php echo intval($counter_awards); ?>][date]" placeholder="<?php esc_html_e('Date', 'listingo'); ?>" value="<?php echo esc_attr($award_date); ?>">
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
								<textarea class="form-control" name="awards[<?php echo intval($counter_awards); ?>][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"><?php echo esc_textarea($award_description); ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<?php
				$counter_awards++;
			}
			?>
		<?php } ?>
	</div>
	<script type="text/template" id="tmpl-load-awards">
		<div class="tg-certificatesaward awards-parent-wrap-{{data+1}}" data-count-awards="{{data}}">
		<div class="tg-imgandtitle">
		<figure class="sp-award-photo-thumb"><a href="javascript:;"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/award.jpg'); ?>"></a></figure>
		<h3><a class="sp-awards-title" href="javascript:;"><?php esc_html_e('Certification and Awards Title', 'listingo'); ?></a></h3>
		</div>
		<div class="tg-btntimeedit">
		<button type="button" class="tg-btnedite edit_awards"><i class="lnr lnr-pencil "></i></button>
		<button type="button" class="tg-btndel delete_awards"><i class="lnr lnr-trash "></i></button>
		</div>
		<div class="sp-awards-edit-collapse tg-haslayout elm-display-none">
		<div class="tg-themeform tg-formcertificatesawards">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
		<div class="form-group">
		<div class="tg-imggallerybox">
		<div class="tg-upload">
		<div class="tg-uploadhead">
		<span>
		<h3><?php esc_html_e('Upload Awards and Certification Photo', 'listingo'); ?></h3>
		<i class="fa fa-exclamation-circle"></i>
		</span>
		<i class="lnr lnr-upload"></i>
		</div>
		<div class="tg-box">
		<label class="tg-fileuploadlabel" for="tg-photogallery">
			<div id="plupload-award-container-{{data+1}}">
				<a href="javascript:;" id="upload-award-photo-{{data+1}}" class="tg-fileinput sp-upload-container">
					<i class="lnr lnr-cloud-upload"></i>
					<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
				</a> 
			</div>
		</label>
		<div class="tg-gallery sp-awards-photo">
		<div class="tg-galleryimages">
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
		<div class="form-group">
		<input type="text" class="form-control sp-awards-title-input" name="awards[{{data}}][title]" placeholder="<?php esc_html_e('Certificates / Awards Title', 'listingo'); ?>">
		</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
		<div class="form-group">
		<input type="text" class="form-control awards_date" name="awards[{{data}}][date]" placeholder="<?php esc_html_e('Date', 'listingo'); ?>">
		</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
		<textarea class="form-control" name="awards[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
		</div>
		</div>
		</div>
		</div>

	</script>
	<script type="text/template" id="tmpl-load-profile-award-thumb">
		<div class="tg-galleryimg tg-galleryimg-item item-{{data.response.attachment_id}}" data-id="{{data.response.attachment_id}}">
		<figure>
		<img src="{{data.response.thumbnail}}">
		<figcaption><i class="fa fa-close del-profile-award-photo"></i></figcaption>
		<input type="hidden" value="{{data.response.attachment_id}}" name="awards[{{data.count}}][attachment_id]">
		<input type="hidden" value="{{data.response.thumbnail}}" name="awards[{{data.count}}][thumbnail_url]">
		<input type="hidden" value="{{data.response.banner}}" name="awards[{{data.count}}][banner_url]">
		<input type="hidden" value="{{data.response.full}}" name="awards[{{data.count}}][full_url]">
		</figure>
		</div>
	</script>
</div>
<?php }