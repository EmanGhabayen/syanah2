<?php
/**
 *
 * Author Videos/Audios Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();

/**
 * Get The Dashboard Videos/Audios
 */
$list_videos = array();
if (!empty($author_profile->audio_video_urls)) {
    $list_videos = $author_profile->audio_video_urls;
}

if (!empty($list_videos[0])) { ?>
    <div class="tg-companyfeaturebox tg-videos" id="section-videos">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Audio/Video', 'listingo'); ?></h3>
        </div>
        <ul>
            <?php 
			foreach ($list_videos as $key => $media) {
				if( !empty( $media ) ){?>
                <li>
                    <div class="tg-videobox">
                        <?php
                        $media_url  = parse_url($media);
                        $height 	= 210;
                        $width 		= 370;

                        $url = parse_url($media);
                        if ( isset( $url['host'] ) && $url['host'] == $_SERVER["SERVER_NAME"]) {
                            echo '<div class="sp-videos-frame">';
                            echo do_shortcode('[video width="' . intval($width) . '" height="' . intval($height) . '" src="' . esc_url($media) . '"][/video]');
                            echo '</div>';
                        } else {

                            if ( isset( $url['host'] ) && ( $url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com' ) ) {
                                echo '<div class="sp-videos-frame">';
                                $content_exp = explode("/", $media);
                                $content_vimo = array_pop($content_exp);
                                echo '<iframe width="' . intval($width) . '" height="' . intval($height) . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
></iframe>';
                                echo '</div>';
                            } elseif ( isset( $url['host'] ) && $url['host'] == 'soundcloud.com') {
                                $video = wp_oembed_get($media, array('height' => intval($height)));
                                $search = array('webkitallowfullscreen', 'mozallowfullscreen', 'frameborder="no"', 'scrolling="no"');
                                echo '<div class="audio">';
                                $video = str_replace($search, '', $video);
                                echo str_replace('&', '&amp;', $video);
                                echo '</div>';
                            } else {
                                echo '<div class="sp-videos-frame">';
                                echo do_shortcode('[video width="' . intval($width) . '" height="' . intval($height) . '" src="' . esc_url($media) . '"][/video]');
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </li>
            <?php }} ?>
        </ul>
    </div>
<?php } ?>