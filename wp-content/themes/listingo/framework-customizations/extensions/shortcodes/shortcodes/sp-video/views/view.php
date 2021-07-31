<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$video_link = !empty($atts['video_link']) ? $atts['video_link'] : '';
$video_width = !empty($atts['video_width']) ? $atts['video_width'] : '';
$video_height = !empty($atts['video_height']) ? $atts['video_height'] : '';
?>

<div class="sp-sc-video">
    <?php
    $url = parse_url($video_link);
    $height = $video_height;
    $width  = $video_width;
    if ( isset( $url['host'] ) && $url['host'] == $_SERVER["SERVER_NAME"]) {
        echo do_shortcode('[video width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_attr( $video_link ) . '"][/video]');
    } else {
        if (isset( $url['host'] ) &&  ( $url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com' )) {

            $content_exp = explode("/", $video_link);
            $content_vimo = array_pop($content_exp);
            echo '<iframe width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="https://player.vimeo.com/video/' . esc_attr( $content_vimo ) . '" 
></iframe>';
        } elseif ( isset( $url['host'] ) &&  $url['host'] == 'soundcloud.com') {
            $height = $video_height;
            $width = $video_width;
            $video = wp_oembed_get($video_link, array(
                'height' => intval( $height ),
                'width' => intval( $width ) ));
            $search = array(
                'webkitallowfullscreen',
                'mozallowfullscreen',
                'frameborder="0"');
            echo str_replace($search, '', $video);
        } else {

            $content = str_replace(array(
                'watch?v=',
                'http://www.dailymotion.com/'), array(
                'embed/',
                '//www.dailymotion.com/embed/'), $video_link);
            echo '<iframe width="' . intval( $width ) . '" height="' . intval( $height ) . '" src="' . esc_attr( $content ) . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
    }
    ?>
</div>
