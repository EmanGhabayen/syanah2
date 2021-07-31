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

$profile_videos = get_user_meta($user_identity, 'audio_video_urls', true);
$provider_category	= listingo_get_provider_category($current_user->ID);

if (empty($profile_videos)) {
    $profile_videos = array(
        0 => ''
    );
}

if( apply_filters('listingo_is_feature_allowed', $provider_category, 'videos') === true ){?>
<div class="tg-dashboardbox tg-videogallery">
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
							<div class="tg-inpuicon">
								<i class="lnr lnr-film-play"></i>
								<input type="text" value="<?php echo esc_url($media); ?>" name="videos[]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
							</div>
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
</div>

<?php }
