<?php
/**
 *
 * Author Audio/Video Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;

	$profile_videos 	= get_user_meta($user_identity, 'audio_video_urls', true);
	$provider_category	= listingo_get_provider_category($user_identity);
	if (empty($profile_videos)) {
		$profile_videos = array(
			0 => ''
		);
	}
	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'videos') === true ){?>
	<div class="tg-dashboardbox tg-videogallery">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Audio/Video', 'listingo'); ?></h2>
				</div>
				<div class="tg-videogallerybox">
					<div class="video-slot-wrap">
						<?php
						if (!empty($profile_videos)) {
							$video_count = 0;
							foreach ($profile_videos as $key => $media) {
								$video_count++;
								?>
								<div class="tg-startendtime">
									<div class="form-group">
										<i class="lnr lnr-film-play"></i>
										<input type="text" value="<?php echo esc_url($media); ?>" name="videos[]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
									</div>
									<?php if ($video_count === 1) { ?>
										<button type="button" class="tg-addtimeslot add-new-videoslot">+</button>
									<?php } else { ?>
										<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
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
	<script type="text/template" id="tmpl-load-media-links">
		<div class="tg-startendtime">
			<div class="form-group">
				<div class="tg-inpuicon">
					<i class="lnr lnr-film-play"></i>
					<input type="text" name="videos[]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
				</div>
			</div>
			<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
		</div>
	</script>
	<?php }
}