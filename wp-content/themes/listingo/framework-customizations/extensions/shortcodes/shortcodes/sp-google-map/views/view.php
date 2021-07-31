<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 * Get the Map shortcode attributes
 */
$title = !empty($atts['map']) ? $atts['map'] : '';
$zoom = !empty($atts['map_zoom']) ? $atts['map_zoom'] : 16;
$map_height = !empty($atts['map_height']) ? $atts['map_height'] : '300';
$marker = !empty($atts['marker']['url']) ? $atts['marker']['url'] : get_template_directory_uri() . '/images/marker.png';
$latitude = !empty($atts['latitude']) ? $atts['latitude'] : '51.5074';
$longitude = !empty($atts['longitude']) ? $atts['longitude'] : '0.1278';
$map_type = !empty($atts['map_type']) ? $atts['map_type'] : 'ROADMAP';
$map_info = !empty($atts['map_info']) ? $atts['map_info'] : '';
$info_box_width = !empty($atts['info_box_width']) ? $atts['info_box_width'] : '250';
$info_box_height = !empty($atts['info_box_height']) ? $atts['info_box_height'] : '150';
$map_controls = !empty($atts['map_controls']) ? $atts['map_controls'] : 'false';
$map_dragable = !empty($atts['map_dragable']) ? $atts['map_dragable'] : 'true';
$scroll = !empty($atts['scroll']) ? $atts['scroll'] : 'false';
$map_styles = !empty($atts['map_styles']) ? $atts['map_styles'] : 'view_1';


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

$map_content = '';
if(!empty($map_info)){
	$map_content = preg_replace( "/\r|\n/", "", $map_info );
}

$uni_flag = fw_unique_increment();
?>
<div class="sp-sc-map">
    <div id="tg-location-map-<?php echo esc_attr($uni_flag); ?>" style="height:<?php echo esc_attr($map_height); ?>px" class="tg-location-map tg-haslayout"></div>
</div>
<?php
    $scripts	= "
		function initialize() {
			var myLatlng = new google.maps.LatLng(".esc_js($latitude).", ".esc_js($longitude).");
			var mapOptions = {
				zoom: ".esc_js($zoom).",
				scrollwheel: ".esc_js($scroll).",
				draggable: ".esc_js($map_dragable).",
				streetViewControl: false,
				center: myLatlng,
				mapTypeId: ".esc_js($map_type_id).",
				disableDefaultUI: ".esc_js($map_controls).",
			}


			var map = new google.maps.Map(document.getElementById('tg-location-map-".esc_attr($uni_flag)."'), mapOptions);

			var styles = listingo_get_map_styles('". esc_js($map_styles)."');
			if (styles != '') {
				var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
				map.mapTypes.set('map_style', styledMap);
				map.setMapTypeId('map_style');
			}
			var infowindow = new google.maps.InfoWindow({
				content: '{$map_content}',
				maxWidth: '".esc_js($info_box_width)."',
				maxHeight: '".esc_js($info_box_height)."',
			});

			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: '',
				icon: '".esc_js($marker)."',
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
	