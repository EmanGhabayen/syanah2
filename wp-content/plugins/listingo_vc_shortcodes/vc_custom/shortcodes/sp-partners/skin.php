<?php
/**
 * @ Visual Composer Shortcode
 * @ Class OurPartners
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_OurPartners')) {

    class SC_VC_Skin_OurPartners extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_OurPartners", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "sec_title" => '',
                "partners" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));


            $partners_data = array();
            if (isset($partners)) {
                $partners_data = vc_param_group_parse_atts($partners);
            }

            $list_view = '';
            if (isset($partner_style) && $partner_style === 'list_view') {
                $list_view = 'partner_list_view';
            }

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_OurPartners', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
            $classes[] = $list_view;

            ob_start();
            ?>
            <div class="sc-our-partners <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($sec_title) || !empty($content)) { ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-push-2 col-lg-8">
                        <div class="tg-sectionhead">
                            <?php if (!empty($sec_title)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($sec_title); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo do_shortcode($content); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php
                    $this->listingo_vc_shortcodes_prepare_partner_grid_view($partners_data);
                ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * Partners Grid View
         */
		public function listingo_vc_shortcodes_prepare_partner_grid_view($partners_data) {
			ob_start();
			if (!empty($partners_data)) {
				?>
                <div class="tg-brands">
                    <?php
                    foreach ($partners_data as $key => $partner) {
                        extract($partner);

                        $image_meta = array();
                        $banner_logo = '';
                        
                        if (!empty($logo)) {
                            $image_meta = $this->listingo_vc_shortcodes_get_image_metadata($logo);
                            $banner_logo = $this->listingo_vc_shortcodes_get_image_source($logo, 0, 0);
                        }
                        ($banner_logo);
                        $image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
                        $image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';

                        $link = '';
                        if (!empty($partner_link)) {
                            $link = vc_build_link($partner_link);
                        }
                        $title = !empty($link['title']) ? $link['title'] : '';
                        $target = !empty($link['target']) ? $link['target'] : '_self';
                        $link_url = !empty($link['url']) ? $link['url'] : '#';
                        if (!empty($banner_logo)) {
                            ?>
                            <div class="tg-brand">
                                <figure>
                                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($target); ?>">
                                        <img src="<?php echo esc_url($banner_logo); ?>" alt="<?php echo esc_attr($company_name); ?>">
                                    </a>
                                </figure>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
				<?php
			}//endif
			echo ob_get_clean();
		}     

    }

    new SC_VC_Skin_OurPartners();
}
