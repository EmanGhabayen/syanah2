<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Section Heading
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Listingo_Newsletter_V2')) {

    class SC_VC_Skin_Listingo_Newsletter_V2 extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_newsletter_v2", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "form_heading" => '',
                "form_subheading" => '',
                "form_image" => '',
                "frm_btn_txt" => '',
				"color" => '#333',
                "username" => 'yes',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_newsletter_v2', $args);
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
			
			$bordercolor	= !empty( $color ) ? $color : 'rgba(255,255,255,0.50)';
			$txtcolor	= !empty( $color ) ? 'style=color:'.$color : '';
			
            $thumb_meta = array();
            $thumbnail = '';
            if (!empty($form_image)) {
                $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($form_image);
                $thumbnail = $this->listingo_vc_shortcodes_get_image_source($form_image, 0, 0);
                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $thumb_meta['title'];
            }
            $form_btn_text = !empty($frm_btn_txt) ? $frm_btn_txt : 'Signup Now';
            ob_start();
            ?>
            <div class="sp-sc-newsletter <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div class="row">
                    <?php
                    if (!empty($form_heading) || !empty($form_subheading) || !empty($form_img)) {?>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                            <div class="tg-newslttercontent">
                                <?php if (!empty($thumbnail)) { ?>
                                    <span class="tg-envelopicon"><img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>"></span>
                                <?php } ?>
                                <?php if (!empty($form_heading) || !empty($form_subheading)) { ?> 
                                    <div class="tg-healthtips" style="border-left: 1px solid <?php echo esc_attr( $bordercolor );?>">
                                        <?php if (!empty($form_subheading)) { ?>
                                            <span <?php echo esc_attr( $txtcolor );?>><?php echo esc_attr($form_subheading); ?></span>
                                        <?php } ?>
                                        <?php if (!empty($form_heading)) { ?>
                                            <h3 <?php echo esc_attr( $txtcolor );?>><?php echo esc_attr($form_heading); ?></h3>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
                        <form class="tg-formtheme tg-formnewsletter signup-newletter">
                            <fieldset>
                                <div class="form-group tg-newslettergroup tg-inputwithicon">
                                    <i class="lnr lnr-envelope"></i>
                                    <input type="email" name="email" class="form-control" placeholder="<?php esc_html_e('Enter Your Email', 'listingo_vc_shortcodes'); ?>">
                                </div>
                                <button type="submit" class="tg-btn subscribe_me"><?php echo esc_attr($form_btn_text); ?></button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>            
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Listingo_Newsletter_V2();
}
