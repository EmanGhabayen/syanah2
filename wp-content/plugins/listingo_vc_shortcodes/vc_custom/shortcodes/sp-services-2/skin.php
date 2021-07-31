<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Services Grid
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Services_Items_View_Two')) {

    class SC_VC_Skin_Services_Items_View_Two extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_services_item_two", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {
            extract(shortcode_atts(array(
                "sec_heading" => '',
                "services" => '',
                "color" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_services_item_two', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $services_grid = array();
            if (isset($services)) {
                $services_grid = vc_param_group_parse_atts($services);
            }


            ob_start();
            ?>
            <div class="sp-sc-services-v2 <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php
                if (!empty($sec_heading) || !empty($content)) {
                    ?>
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
                    <?php
                }               
                    $this->listingo_vc_shortcodes_services_grid_view_one($services_grid);
                ?>
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
                <div class="tg-servicesfacilities">
                    <div class="row">
                        <?php
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
                            $iconClass = isset(${'icon_' . $type}) ? ${'icon_' . $type} : '';                           
                            if ( !empty($service_title) || !empty($service_description) || !empty( $iconClass )) {
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 pull-left">
                                    <div class="tg-servicefacility">
                                        <span class="tg-servicefacilityicon" style="background: <?php echo!empty($color) ? esc_attr($color) : '#ccc'; ?>;">
                                            <?php                                           
                                                if (!empty($iconClass)) {
                                                    ?>
                                                    <i class="<?php echo esc_attr($iconClass); ?>"></i>
                                                    <?php
                                                }          
                                            ?>
                                        </span>
                                        <?php if (!empty($title)) { ?>
                                            <div class="tg-title">
                                                <h3>
                                                    <a href="<?php echo esc_attr($link_url); ?>" target="<?php echo esc_attr($target); ?>">
                                                        <?php echo esc_attr($title); ?>
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
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            echo ob_get_clean();
        }       

    }

    new SC_VC_Skin_Services_Items_View_Two();
}
