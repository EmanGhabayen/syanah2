<?php
/**
 * @ Visual Composer Shortcode
 * @ Class SP Google Map
 * @ return {HTML}
 * @ Autor: Themographics
 */
if (!class_exists('SC_VC_Skin_SP_Google_Map')) {

    class SC_VC_Skin_SP_Google_Map extends SC_VC_Core {

        public function __construct() {
            add_shortcode("listingo_vc_sp_google_map", array(
                &$this,
                "shortCodeCallBack"));
        }

        /**
         * @ Front end Init
         * @ return {HTML}
         */
        public function shortCodeCallBack($args, $content = '') {

            extract(shortcode_atts(array(
                "map_height" => intval(300),
                "latitude" => '51.5074',
                "longitude" => '0.1278',
                "map_zoom" => intval(16),
                "map_type" => 'ROADMAP',
                "map_styles" => 'view_1',
                "map_info" => '',
                "info_box_width" => '250',
                "info_box_height" => '150',
                "marker" => '',
                "map_controls" => 'false',
                "map_dragable" => 'true',
                "scroll" => 'false',
                "custom_id" => '',
                "custom_classes" => '',
                "css" => '',
                            ), $args));

            $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'listingo_vc_sp_google_map', $args);

            $flag = $this->listingo_vc_shortcodes_unique_increment();
            $classes[] = $custom_classes;
            $classes[] = $css_class;

            $image_meta = array();
            $marker_image = get_template_directory_uri() . '/images/marker.png';
            if (!empty($marker)) {
                $marker_image = $this->listingo_vc_shortcodes_get_image_source($marker, 0, 0);
            }
            if ($map_type == 'ROADMAP') {
                $map_type_id = 'google.maps.MapTypeId.ROADMAP';
            } else if ($map_type == 'SATELLITE') {
                $map_type_id = 'google.maps.MapTypeId.SATELLITE';
            } else if ($map_type == 'HYBRID') {
                $map_type_id = 'google.maps.MapTypeId.HYBRID';
            } else if ($map_type == 'TERRAIN') {
                $map_type_id = 'google.maps.MapTypeId.TERRAIN';
            } else {
                $map_type_id = 'google.maps.MapTypeId.ROADMAP';
            }

            $uni_flag = $this->listingo_vc_shortcodes_unique_increment();
            $map_content = '';
            if(!empty($map_info)){
                $map_content = preg_replace( "/\r|\n/", "", $map_info );
            }
            
            ob_start();
            ?>
            <div class="sp-sc-map <?php $this->listingo_vc_shortcodes_prepare_custom_classes($classes); ?>" <?php $this->listingo_vc_shortcodes_prepare_custom_id($custom_id); ?>>
                <div id="tg-location-map-<?php echo esc_attr($uni_flag); ?>" style="height:<?php echo esc_attr($map_height); ?>px" class="tg-location-map tg-haslayout"></div>
            </div>
            <?php
            $scripts = "
			function initialize() {
				var myLatlng = new google.maps.LatLng(" . esc_js($latitude) . ", " . esc_js($longitude) . ");
				var mapOptions = {
					zoom: " . esc_js($map_zoom) . ",
					scrollwheel: " . esc_js($scroll) . ",
					draggable: " . esc_js($map_dragable) . ",
					streetViewControl: false,
					center: myLatlng,
					mapTypeId: " . esc_js($map_type_id) . ",
					disableDefaultUI: " . esc_js($map_controls) . ",
				}


				var map = new google.maps.Map(document.getElementById('tg-location-map-" . esc_attr($uni_flag) . "'), mapOptions);

				var styles = listingo_get_map_styles('" . esc_js($map_styles) . "');
				if (styles != '') {
					var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
					map.mapTypes.set('map_style', styledMap);
					map.setMapTypeId('map_style');
				}
				var infowindow = new google.maps.InfoWindow({
					content: '{$map_content}',
					maxWidth: '" . esc_js($info_box_width) . "',
					maxHeight: '" . esc_js($info_box_height) . "',
				});

				var marker = new google.maps.Marker({
					position: myLatlng,
					map: map,
					title: '',
					icon: '" . esc_js($marker_image) . "',
					shadow: ''
				});

				if (infowindow.content != '') {
					infowindow.open(map, marker);
					map.panBy(1, -60);
					google.maps.event.addListener(marker, 'click', function (event) {
						infowindow.open(map, marker);
					});
				}

			}

			jQuery(document).ready(function (e) {
				google.maps.event.addDomListener(window, 'load', initialize);
			}); ";

            wp_add_inline_script('listingo_callbacks', $scripts, 'after');
            return ob_get_clean();
        }

    }

    new SC_VC_Skin_SP_Google_Map();
}
