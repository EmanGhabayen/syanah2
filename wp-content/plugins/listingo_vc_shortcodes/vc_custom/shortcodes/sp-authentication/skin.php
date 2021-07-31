<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Services Grid
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Authentication')) {

    class SC_VC_Skin_Authentication extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_auth", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "form_type" => 'both',
                "login_title" => '',
                "register_title" => '',
				"both_login_title" => '',
                "both_register_title" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_auth', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            ob_start();
            ?>
            <div class="sp-sc-services-v2 <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
				<?php
					if( isset( $form_type ) && $form_type === 'login' ){
						$title	= !empty( $login_title ) ? $login_title : '';
						echo do_shortcode('[listingo_authentication_signin title="'.$title.'" single="true"]');
					} else if( isset( $form_type ) && $form_type === 'register' ){
						$title	= !empty( $register_title ) ? $register_title : '';
						echo do_shortcode('[listingo_authentication_signup title="'.$title.'" single="true"]');
					} else {
						$login_title			= !empty( $both_login_title ) ? $both_login_title : '';
						$register_title			= !empty( $both_register_title ) ? $both_register_title : '';
						echo do_shortcode('[listingo_authentication login_title="'.$login_title.'" register_title="'.$register_title.'"]');
					}
				?>
            </div>
            <?php
            return ob_get_clean();
        }
    }

    new SC_VC_Skin_Authentication();
}
