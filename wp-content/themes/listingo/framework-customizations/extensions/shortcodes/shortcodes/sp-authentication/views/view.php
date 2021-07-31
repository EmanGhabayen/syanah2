<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */

$uniq_flag = fw_unique_increment();

?>
<div class="sp-auth tg-haslayout">
	<?php
		if( isset( $atts['auth']['gadget'] ) && $atts['auth']['gadget'] === 'login' ){
			$title	= !empty( $atts['auth']['login']['title'] ) ? $atts['auth']['login']['title'] : '';
			echo do_shortcode('[listingo_authentication_signin title="'.$title.'" single="true"]');
		} else if( isset( $atts['auth']['gadget'] ) && $atts['auth']['gadget'] === 'register' ){
			$title	= !empty( $atts['auth']['register']['title'] ) ? $atts['auth']['register']['title'] : '';
			echo do_shortcode('[listingo_authentication_signup title="'.$title.'" single="true"]');
		} else {
			$login_title			= !empty( $atts['auth']['both']['login'] ) ? $atts['auth']['both']['login'] : '';
			$register_title			= !empty( $atts['auth']['both']['register'] ) ? $atts['auth']['both']['register'] : '';
			echo do_shortcode('[listingo_authentication login_title="'.$login_title.'" register_title="'.$register_title.'"]');
		}
	?>
</div>