<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Services Grid
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Services_Items_View')) {

    class SC_VC_Skin_Services_Items_View extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_services_item", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "services_view" => '',
                "sec_heading" => '',
                "services" => '',
                "color" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_services_item', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $services_grid = array();
            if (isset($services)) {
                $services_grid = vc_param_group_parse_atts($services);
            }


            ob_start();
            ?>
            <div class="sp-sc-services <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php  if (!empty($sec_heading) || !empty($content)) {?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-push-2 col-lg-8">
                        <div class="tg-sectionhead">
                            <?php if (!empty($sec_heading)) { ?>
                                <div class="tg-sectiontitle">
                                    <h2><?php echo esc_attr($sec_heading); ?></h2>
                                </div>
                            <?php } ?>
                            <?php if (!empty($content)) { ?>
                                <div class="tg-description">
                                    <?php echo do_shortcode($content); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }?>               
                    <?php $this->listingo_vc_shortcodes_services_grid_view_one($services_grid);?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * @ Grid View One
         * @ return {HTML}
         */
        public function listingo_vc_shortcodes_services_grid_view_one($services_grid) {
            ob_start();
            if (!empty($services_grid)) {
                ?>
                <div class="tg-advantagies">
                    <div class="row">
                        <?php
                        $count = 1;
                        foreach ($services_grid as $key => $service) {
                            extract($service);                            
                            
                            $link = '';
                            if (!empty($service_link)) {
                                $link = vc_build_link($service_link);
                            }
							
                            $title = !empty($link['title']) ? $link['title'] : '';
                            $target = !empty($link['target']) ? $link['target'] : '_self';
                            $link_url = !empty($link['url']) ? $link['url'] : '#';
                            if ('listingovsicon' !== $type) {
                                vc_icon_element_fonts_enqueue($type);
                            }
                            $defaultIconClass = '';
                            $thumb_meta = array();
                            $thumbnail = '';
                            if ( $icon_image == 'image' ) {                               
                                if (!empty($image)) {
                                    $thumb_meta = $this->listingo_vc_shortcodes_get_image_metadata($image);
                                    $thumbnail = $this->listingo_vc_shortcodes_get_image_source($image, 0, 0);
                                }
                                $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : '';
                                $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : '';
                            } else {
                                $iconClass = isset(${'icon_' . $type}) ? ${'icon_' . $type} : '';
                            }
                            
                            if ( !empty($service_title) || !empty($service_description) ) {
                                ?>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
                                    <div class="tg-advantage tg-advantageplan">
                                        <span class="tg-advantageicon">
                                            <?php 
                                            if (!empty($show_count) && $show_count === 'yes') { 
                                                $count_color = !empty( $color ) ? $color : '';
                                            ?>
                                                <i class="tg-badge" style="background: <?php echo esc_attr($count_color); ?>;"><?php echo intval($count); ?></i>
                                            <?php } ?>
                                            <?php  
                                                if ( $icon_image == 'icon' ) {                                                                             
                                                    if (!empty($iconClass)) {
                                                        ?>
                                                        <em><i class="<?php echo esc_attr($iconClass); ?>"></i></em>
                                                        <?php
                                                    }
                                                } else {
                                                    if (!empty($thumbnail)) {
                                                        ?>
                                                        <em><img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>"></em>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </span>
                                        <?php if (!empty($service_title)) { ?>
                                            <div class="tg-title">
                                                <h3>
                                                    <a href="<?php echo esc_attr($link_url); ?>" target="<?php echo esc_attr($target); ?>">
                                                        <?php echo esc_attr($service_title); ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($service_description)) { ?>
                                            <div class="tg-description">
                                                <?php echo wp_kses_post(wpautop(do_shortcode($service_description))); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            echo ob_get_clean();
        }       

    }

    new SC_VC_Skin_Services_Items_View();
}
