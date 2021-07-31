<?php

if (!defined('FW')) {
    die('Forbidden');
}

/**
 * Enqueue Script on frontend
 * Check if this is not admin
 */
if (!is_admin()) {

    $fw_ext_instance = fw()->extensions->get('ads');

    wp_register_script(
        'fw_ext_ads_callback', $fw_ext_instance->get_declared_URI('/static/js/fw_ext_ads_callbacks.js'), array('jquery','listingo_callbacks'), '1.0', true
    );
	
    wp_register_script(
        'listingo_ad_gmaps', $fw_ext_instance->get_declared_URI('/static/js/maps/ad_gmaps.js'), array('jquery', 'jquery-googleapis','markerclusterer','listingo_infobox','oms','sticky-kit','listingo_callbacks'), '1.0', true
    );
	
	if (is_singular()) {

		$_post = get_post();
		if ($_post != null) {
			if ($_post && 
				( 
					preg_match('/sp_recent_ads/', $_post->post_content)
					||
					preg_match('/listingo_vc_recent_ads/', $_post->post_content)
				)
			) {
				wp_enqueue_script('fw_ext_ads_callback');
			}
		}
	}
	
	if(is_page_template('directory/dashboard.php') 
	   || is_page_template('directory/provider-ads.php') 
	   || is_author() 
	   || is_singular( array( 'sp_ads' ) ) ) {      
		wp_enqueue_script('fw_ext_ads_callback');
	}

    if( is_tax( array( 'ad_category', 'ad_tags', 'ad_amenity' ) )  
        || is_page_template('directory/ads-search.php')
    ) {      
        wp_enqueue_script('listingo_ad_gmaps'); 
        wp_enqueue_script('fw_ext_ads_callback');
    }     

}