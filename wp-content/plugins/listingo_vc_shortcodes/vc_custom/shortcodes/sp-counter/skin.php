<?php
/**
 * @ Visual Composer Shortcode
 * @ Class Counter
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_Counter')) {

    class SC_VC_Skin_Counter extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_counter", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "sp_counters" => array(),
				"color" => '',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_counter', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes = array();
            $classes[] = $custom_classes;
            $classes[] = $css_class;
            
			$txtcolor	= !empty( $color ) ? 'style=color:'.$color : '';
			
            $counters = array();
            if (isset($sp_counters)) {
                $counters = vc_param_group_parse_atts($sp_counters);
            }

            ob_start();
            ?>
            <div class="sp-sc-counter tg-haslayout <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <?php if (!empty($counters)) { ?>
                    <div id="tg-counters-<?php echo esc_attr($flag); ?>" class="tg-counters">
                        <?php
                        foreach ($counters as $key => $counter) {
                            $counter_title = !empty($counter['counter_title']) ? $counter['counter_title'] : '0';
                            $counter_value_from = !empty($counter['counter_value_from']) ? $counter['counter_value_from'] : '0';
                            $counter_value_to = !empty($counter['counter_value_to']) ? $counter['counter_value_to'] : '0';
                            $counter_speed = !empty($counter['counter_speed']) ? $counter['counter_speed'] : '0';
                            $counter_interval = !empty($counter['counter_interval']) ? $counter['counter_interval'] : '0';
                            ?>
                            <div class="tg-countercontent">
                                <?php if (!empty($counter_value_from) || !empty($counter_value_to) && !empty($counter_interval) && !empty($counter_speed)) { ?>
                                    <h3 <?php echo esc_attr( $txtcolor );?> data-from="<?php echo intval($counter_value_from); ?>" data-to="<?php echo intval($counter_value_to); ?>" data-speed="<?php echo intval($counter_speed); ?>" data-refresh-interval="<?php echo intval($counter_interval); ?>"></h3>
                                <?php } ?>
                                <?php if (!empty($counter_title)) { ?>
                                    <h4 <?php echo esc_attr( $txtcolor );?>><?php echo esc_html($counter_title); ?></h4>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    $script = "jQuery('#tg-counters-" . esc_js($flag) . "').appear(function () {
                        jQuery('.tg-countercontent h3').countTo({
                         formatter: function (value, options) {
                          return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                         }
                        });
                    });";
                    wp_add_inline_script('listingo_callbacks', $script, 'after');
                    ?>
                <?php } ?>
            </div>
            <?php
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_Counter();
}
