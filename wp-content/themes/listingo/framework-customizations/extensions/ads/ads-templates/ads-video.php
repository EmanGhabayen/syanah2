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
 * Get post data
 */
global $post;
$videos = array();
if (function_exists('fw_get_db_post_option')) {
    $videos = fw_get_db_post_option($post->ID, 'videos', true);        
} 
if ( !empty( $videos[0] ) ) { ?>
    <div class="tg-sectionpaddingvtwo tg-videos tg-videosvtwo">
        <div class="tg-sectiontitlevthree text-left">
            <h2><?php esc_html_e('Audio/Video', 'listingo'); ?></h2>
        </div>
        <ul>
            <?php 
			foreach ($videos as $key => $media) {
				if( !empty( $media ) ){?>
                <li class="tg-verticaltop">
                    <div class="tg-videobox">
                        <?php
                        $media_url  = parse_url($media);
                        $height 	= 208;
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