<?php
/**
 *
 * Author Awards Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$profile_awards = get_user_meta($user_identity, 'awards', true);
	$provider_category	= listingo_get_provider_category($user_identity);
	$date_format		= listingo_get_calendar_format();

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'awards') === true ){?>
	<div class="tg-dashboardbox tg-certificatesawards">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Certificates and Awards', 'listingo'); ?></h2>
					<a class="tg-btnaddnew add-profile-awards" href="javascript:;"><?php esc_html_e('+ add new', 'listingo'); ?></a>
				</div>
				<div class="tg-certificatesawardsbox profile-awards-wrap">
					<?php if (!empty($profile_awards)) { ?>
						<?php
						$counter_awards = 0;
						foreach ($profile_awards as $key => $value) {

							$width = 40;
							$height = 40;

							$image_meta = '';
							$awards_thumb = apply_filters(
									'listingo_get_media_filter', '', array('width' => 40, 'height' => 40) //size width,height
							);

							if (!empty($value['attachment_id'])) {
								$image_meta = listingo_get_image_metadata($value['attachment_id']);
								$awards_thumb = listingo_prepare_image_source($value['attachment_id'], intval($width), intval($height));
							}

							$image_alt 		= !empty($image_meta['alt']) ? $image_meta['alt'] : '';
							$image_title 	= !empty($image_meta['title']) ? $image_meta['title'] : '';
							$award_title 		= !empty($value['title']) ? $value['title'] : '';
							$award_date 		= !empty($value['date']) ? date($date_format, $value['date']) : '';
							$award_description  = !empty($value['description']) ? $value['description'] : '';
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
									<button type="button" class="tg-btnedite edit_awards"><i class="lnr lnr-pencil"></i></button>
									<button type="button" class="tg-btndel delete_awards"><i class="lnr lnr-trash"></i></button>
								</div>
								<div class="sp-awards-edit-collapse tg-haslayout elm-display-none">
									<div class="tg-themeform tg-formcertificatesawards">
										<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
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
																<a href="javascript:;" class="tg-fileinput upload-award-photo">
																	<i class="lnr lnr-cloud-upload"></i>
																	<span><?php echo esc_html_e('Upload Awards &amp; Certification Photo', 'listingo'); ?></span>
																</a> 
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
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input type="text" class="form-control sp-awards-title-input" name="awards[<?php echo intval($counter_awards); ?>][title]" placeholder="<?php esc_html_e('Certificates / Awards Title', 'listingo'); ?>" value="<?php echo esc_attr($award_title); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input readonly type="text" class="form-control awards_date" name="awards[<?php echo intval($counter_awards); ?>][date]" placeholder="<?php esc_html_e('Date', 'listingo'); ?>" value="<?php echo esc_attr($award_date); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
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
			</div>
		</div>
	</div>

	<script type="text/template" id="tmpl-load-awards">
		<div class="tg-certificatesaward awards-parent-wrap-{{data}}" data-count-awards="{{data}}">
			<div class="tg-imgandtitle">
				<figure class="sp-award-photo-thumb">
					<a href="javascript:;"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/award.jpg'); ?>"></a>
				</figure>
				<h3><a class="sp-awards-title" href="javascript:;"><?php esc_html_e('Certification and Awards Title', 'listingo'); ?></a></h3>
			</div>
			<div class="tg-btntimeedit">
				<button type="button" class="tg-btnedite edit_awards"><i class="lnr lnr-pencil "></i></button>
				<button type="button" class="tg-btndel delete_awards"><i class="lnr lnr-trash "></i></button>
			</div>
			<div class="sp-awards-edit-collapse tg-haslayout elm-display-none">
				<div class="tg-themeform tg-formcertificatesawards">
					<div class="sp-row">
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
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
												<a href="javascript:;" class="tg-fileinput upload-award-photo">
													<i class="lnr lnr-cloud-upload"></i>
												</a>
												<input type="hidden" class="award_hidden_id" value="" name="awards[{{data}}][attachment_id]">
												<input type="hidden" class="award_hidden_thumb" value="" name="awards[{{data}}][thumbnail_url]">
												<input type="hidden" class="award_hidden_banner" value="" name="awards[{{data}}][banner_url]">
												<input type="hidden" class="award_hidden_full" value="" name="awards[{{data}}][full_url]">
											</label>
											<div class="tg-gallery sp-awards-photo">
												<div class="tg-galleryimages"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control sp-awards-title-input" name="awards[{{data}}][title]" placeholder="<?php esc_html_e('Certificates / Awards Title', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control awards_date" name="awards[{{data}}][date]" placeholder="<?php esc_html_e('Date', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<textarea class="form-control" name="awards[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="tmpl-load-profile-award-thumb">
		<div class="tg-galleryimg tg-galleryimg-item">
			<figure>
				<img src="{{data.thumb}}">
				<figcaption><i class="fa fa-close del-profile-award-photo"></i></figcaption>
			</figure>
		</div>
	</script>
<?php }
}