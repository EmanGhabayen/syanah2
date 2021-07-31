<?php
/**
 * Visual Composer Configuration
 * Learn more: 
 * @package Pearl
 */

if (!function_exists('listingo_vc_shortcodes_load_vc_elements')) {
	add_action( 'plugins_loaded', 'listingo_vc_shortcodes_load_vc_elements' );
	function listingo_vc_shortcodes_load_vc_elements() {
		if (function_exists('vc_add_shortcode_param')) {
			//data info
			vc_add_shortcode_param('data_info_bar', 'vc_form_data_information');

			function vc_form_data_information($settings, $value) {
				return;
			}

			//VC Number
			vc_add_shortcode_param('vc_number', 'vc_form_number_field');

			function vc_form_number_field($settings, $value) {
				$max = !empty($settings['max']) ? $settings['max'] : 10000;
				$min = !empty($settings['min']) ? $settings['min'] : 1;

				return '<div class="vc_number_block">'
							. '<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' .
							esc_attr($settings['param_name']) . ' ' .
							esc_attr($settings['type']) . '_field" type="number" max="' . $max . '" min="' . $min . '" value="' . esc_attr($value) . '" />' .
						'</div>'; // This is html markup that will be outputted in content elements edit form
			}
		}
	}
}