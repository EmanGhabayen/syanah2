<?php

/**
 *
 * Template Name: Search Page
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $wp_query, $total_users, $query_args, $limit;
$google_key = '';
if( function_exists('fw_get_db_settings_option') ){
	$dir_search_pagination = fw_get_db_settings_option('dir_search_pagination');
	$google_key = fw_get_db_settings_option('google_key');
}

if (!empty($_GET['showposts'])) {
    $per_page = $_GET['showposts'];
} else {
    $per_page = !empty($dir_search_pagination) ? $dir_search_pagination : get_option('posts_per_page');
}

$limit = (int) $per_page;

$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var


if( is_tax( 'sub_category' )  
   || is_tax( 'countries' ) 
   || is_tax( 'cities' ) 
   || is_tax( 'languages' ) 
   || is_tax( 'amenities' ) 
   || is_tax( 'insurance' )
){
	if(!empty( $_GET['current_page'] )){
		$pg_paged    = $_GET['current_page'];
	}
}
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$offset = ($paged - 1) * $limit;

$json = array();
$directories = array();
$meta_query_args = array();

if (!empty($_GET['category'])) {
    $category = listingo_get_page_by_slug($_GET['category'], 'sp_categories', 'id');
} else {
    if (is_singular('sp_categories')) {
        $category = $wp_query->get_queried_object_id();
    } else {
        $category = '';
    }
}

//search filters

$location = !empty($_GET['geo']) ? esc_attr($_GET['geo']) : '';
$keyword = !empty($_GET['keyword']) ? esc_attr($_GET['keyword']) : '';
$appointments = !empty($_GET['appointment']) ? esc_attr($_GET['appointment']) : '';
$ratings = !empty($_GET['ratings']) ? esc_attr($_GET['ratings']) : '';
$sort_by = !empty($_GET['sortby']) ? esc_attr($_GET['sortby']) : '';
$photos = !empty($_GET['photo']) ? $_GET['photo'] : '';
$zip = !empty($_GET['zip']) ? esc_attr($_GET['zip']) : '';
$gender = !empty($_GET['gender']) ? esc_attr($_GET['gender']) : '';
$user_type = !empty($_GET['user_type']) ? esc_attr($_GET['user_type']) : '';

//Category seearch
if (is_tax('sub_category') && empty( $category )) {
    $sub_cat = $wp_query->get_queried_object();
    if (!empty($sub_cat->slug)) {
        $sub_category = array($sub_cat->slug);
    }
} else {
    $sub_category = !empty($_GET['sub_categories']) ? $_GET['sub_categories'] : '';
}

//Country search
if (!empty($_GET['country'])) {
    $country = !empty($_GET['country']) ? esc_attr($_GET['country']) : '';
} else {
    if (is_tax('countries')) {
        $sub_cat = $wp_query->get_queried_object();
        if (!empty($sub_cat->slug)) {
            $country = $sub_cat->slug;
        }
    } else {
        $country = '';
    }
}

//city search
if (!empty($_GET['city'])) {
    $city = !empty($_GET['city']) ? esc_attr($_GET['city']) : '';
} else {
    if (is_tax('cities')) {
        $sub_cat = $wp_query->get_queried_object();
        if (!empty($sub_cat->slug)) {
            $city = $sub_cat->slug;
        }
    } else {
        $city = '';
    }
}

//insurance search
if (!empty($_GET['insurance'])) {
    $insurance = !empty($_GET['insurance']) ? $_GET['insurance'] : '';
} else {
    if (is_tax('insurance')) {
        $sub_cat = $wp_query->get_queried_object();
        if (!empty($sub_cat->slug)) {
            $insurance = array($sub_cat->slug);
        }
    } else {
        $insurance = '';
    }
}

//languages search
if (!empty($_GET['languages'])) {
    $languages = !empty($_GET['languages']) ? $_GET['languages'] : '';
} else {
    if (is_tax('languages')) {
        $sub_cat = $wp_query->get_queried_object();
        if (!empty($sub_cat->slug)) {
            $languages = array($sub_cat->slug);
        }
    } else {
        $languages = '';
    }
}

//Order
$order = 'DESC';
if (!empty($_GET['orderby'])) {
    $order = esc_attr($_GET['orderby']);
}

if( !empty( $sort_by ) ){
	if( $sort_by === 'recent' ){
		$sort_by = 'ID';
	}
}

if(!empty($user_type) && in_array($user_type,array('professional', 'business'))){
	$query_args = array(
		'role__in' => array($user_type),
		'order' => $order,
		'orderby' => $sort_by,
	);
} else{
	$query_args = array(
		'role__in' => array('professional', 'business'),
		'order' => $order,
		'orderby' => $sort_by,
	);
}

//Search By likes
if ( $sort_by === 'likes') {
    $query_args['order'] = $order;
    $query_args['orderby'] = 'meta_value_num';

    $query_relation = array('relation' => 'OR',);
    $likes_args = array();
    $likes_args[] = array(
        'key' => 'likes_count',
        'compare' => 'EXISTS'
    );

    $meta_query_args[] = array_merge($query_relation, $likes_args);
}


//Search By Keywords
if (!empty($_GET['keyword'])) {
    $s = sanitize_text_field($_GET['keyword']);
    //$query_args['search'] = $s;
    $search_args = array(
        'search' => '*' . esc_attr($s) . '*',
        'search_columns' => array(
            'ID',
            'display_name',
            'user_login',
            'user_nicename',
            'user_email',
            'user_url',
        )
    );
	
	//$query_args	= array_merge($query_args,$search_args);
    $meta_keyword = array('relation' => 'OR',);
    $meta_keyword[] = array(
        'key' => 'first_name',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'last_name',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'nickname',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'username',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'full_name',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'company_name',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'description',
        'value' => $s,
        'compare' => 'LIKE',
    );

    $meta_keyword[] = array(
        'key' => 'professional_statements',
        'value' => $s,
        'compare' => 'LIKE',
    );
	
	$meta_keyword[] = array(
        'key' => 'tag_line',
        'value' => $s,
        'compare' => 'LIKE',
    );
	
	$meta_keyword[] = array(
        'key' => 'profile_services',
        'value' => $s,
        'compare' => 'LIKE',
    );
	
	$meta_keyword[] = array(
        'key' => 'spcategory_search',
        'value' => $s,
        'compare' => 'LIKE',
    );
	
	$meta_keyword[] = array(
        'key' => 'spsubcategory_search',
        'value' => $s,
        'compare' => 'LIKE',
    );
	
    if (!empty($meta_keyword)) {
        $meta_query_args[] = array_merge($meta_keyword, $meta_query_args);
    }
}

//Category Type Search
if (!empty($category)) {
    $meta_query_args[] = array(
        'key' => 'category',
        'value' => $category,
        'compare' => '=',
    );
}
//Sub category Type Search
if (!empty($sub_category) && !empty($sub_category[0]) && is_array($sub_category)) {
	
	$query_relation = array('relation' => 'OR',);
    $sub_category_args = array();
    foreach ($sub_category as $key => $value) {
        $sub_category_args[] = array(
            'key' 		=> 'sub_category',
            'value' 	=> strval($value),
            'compare' 	=> 'LIKE'
        );
    }

    $meta_query_args[] = array_merge($query_relation, $sub_category_args);
}


//Cities
if (!empty($country)) {
    $meta_query_args[] = array(
        'key' => 'country',
        'value' => $country,
        'compare' => '=',
    );
}

//Cities
if (!empty($city)) {
    $meta_query_args[] = array(
        'key' => 'city',
        'value' => $city,
        'compare' => '=',
    );
}

//Photos search
if (!empty($photos) && $photos === 'true') {
    $meta_query_args[] = array(
        'key' => 'profile_photo',
        'value' => 'on',
        'compare' => '='
    );

    $meta_query_args[] = array(
        'key' => 'profile_avatar',
        'value' => '',
        'compare' => '!='
    );
	
	$meta_query_args[] = array(
        'key' => 'profile_avatar',
        'value' => 'a:0:{}',
        'compare' => '!='
    );
}

//online appointments Search
if (!empty($appointments) && $appointments === 'true') {
    $meta_query_args[] = array(
        'key' => 'profile_appointment',
        'value' => 'on',
        'compare' => '='
    );
}

//Zip Search
if (!empty($zip)) {
    $meta_query_args[] = array(
        'key' => 'zip',
        'value' => $zip,
        'compare' => '='
    );
}

//gender Search
if (!empty($gender)) {
    $meta_query_args[] = array(
        'key' => 'gender',
        'value' => $gender,
        'compare' => '='
    );
}

//Language Search;
if (!empty($languages) && !empty($languages[0]) && is_array($languages)) {
    $query_relation = array('relation' => 'OR',);
    $language_args = array();
    foreach ($languages as $key => $value) {
        $language_args[] = array(
            'key' => 'profile_languages',
            'value' => serialize(strval($value)),
            'compare' => 'LIKE'
        );
    }

    $meta_query_args[] = array_merge($query_relation, $language_args);
}
//Insurance
if (!empty($insurance) && !empty($insurance[0]) && is_array($insurance)) {
    $query_relation = array('relation' => 'OR',);
    $insurance_args = array();
    foreach ($insurance as $key => $value) {
        $insurance_args[] = array(
            'key' => 'profile_insurance',
            'value' => serialize(strval($value)),
            'compare' => 'LIKE'
        );
    }

    $meta_query_args[] = array_merge($query_relation, $insurance_args);
}

//Speciality Search;
if (!empty($speciality) && !empty($speciality[0]) && is_array($speciality)) {
    $query_relation = array('relation' => 'OR',);
    $speciality_args = array();
    foreach ($speciality as $key => $value) {
        $speciality_args[] = array(
            'key' => $value,
            'value' => $value,
            'compare' => '='
        );
    }

    $meta_query_args[] = array_merge($query_relation, $speciality_args);
}

//Verify user
$meta_query_args[] = array(
    'key' => 'verify_user',
    'value' => 'on',
    'compare' => '='
);
//active users filter
$meta_query_args[] = array(
    'key' => 'activation_status',
    'value' => 'active',
    'compare' => '='
);

$query_args['meta_key'] = 'subscription_featured_expiry';
$query_args['orderby']	 = array( 
	'meta_value' 	=> 'DESC', 
	'ID'      		=> 'DESC',
); 

if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

//Radius Search
if ( !empty($_GET['geo']) ) {

    $Latitude = '';
    $Longitude = '';
    $prepAddr = '';
    $minLat = '';
    $maxLat = '';
    $minLong = '';
    $maxLong = '';
	
	$address = sanitize_text_field($_GET['geo']);
    $prepAddr = str_replace(' ', '+', $address);
	

    if (isset($_GET['geo_distance']) && !empty($_GET['geo_distance'])) {
        $radius = $_GET['geo_distance'];
    } else {
        $radius = 300;
    }

    //Distance in miles or kilometers
    if (function_exists('fw_get_db_settings_option')) {
        $dir_distance_type = fw_get_db_settings_option('dir_distance_type');
    } else {
        $dir_distance_type = 'mi';
    }

    if ($dir_distance_type === 'km') {
        $radius = $radius * 0.621371;
    }
	
	$Latitude	= isset( $_GET['lat'] ) ? esc_attr( $_GET['lat'] ) : '';
	$Longitude	= isset( $_GET['long'] ) ? esc_attr( $_GET['long'] ) : '';
	
	if( !empty( $Latitude ) && !empty( $Longitude ) ){
		$Latitude	 = $Latitude;
		$Longitude   = $Longitude;

	} else{
		$args = array(
			'timeout'     => 15,
			'headers' => array('Accept-Encoding' => ''),
			'sslverify' => false
		);

		$url	    = 'https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key='.$google_key;;
		$response   = wp_remote_get( $url, $args );
		$geocode	= wp_remote_retrieve_body($response);

		$output	  = json_decode($geocode);

		if( isset( $output->results ) && !empty( $output->results ) ) {
			$Latitude	 = $output->results[0]->geometry->location->lat;
			$Longitude   = $output->results[0]->geometry->location->lng;
		}
	}
	
	if( !empty( $Latitude ) && !empty( $Longitude ) ){
		$zcdRadius = new RadiusCheck($Latitude, $Longitude, $radius);
		$minLat = $zcdRadius->MinLatitude();
		$maxLat = $zcdRadius->MaxLatitude();
		$minLong = $zcdRadius->MinLongitude();
		$maxLong = $zcdRadius->MaxLongitude();

		$meta_query_args = array(
			'relation' => 'AND',
			array(
				'key' 		=> 'latitude',
				'value' 	=> array($minLat, $maxLat),
				'compare' 	=> 'BETWEEN',
				'type' 		=> 'DECIMAL(20,10)',
			),
			array(
				'key' 		=> 'longitude',
				'value' 	=> array($minLong, $maxLong),
				'compare' 	=> 'BETWEEN',
				'type' 		=> 'DECIMAL(20,10)',
			)
		);

		if (isset($query_args['meta_query']) && !empty($query_args['meta_query'])) {
			$meta_query = array_merge($meta_query_args, $query_args['meta_query']);
		} else {
			$meta_query = $meta_query_args;
		}

		$query_args['meta_query'] = $meta_query;
	}
}

$query_args	= apply_filters('listingo_apply_extra_search_filters',$query_args);
//Count total users for pagination
$total_query = new WP_User_Query($query_args);
$total_users = $total_query->total_users;
$query_args['number'] = $limit;
$query_args['offset'] = $offset;

$default_view = 'list';
if (function_exists('fw_get_db_post_option')) {
    $default_view = fw_get_db_settings_option('dir_search_view');
}

if (!empty($_GET['view'])) {
    $default_view = esc_attr($_GET['view']);
}

if (isset($default_view) && $default_view === 'grid') {
    get_template_part('directory/front-end/search-templates/search', 'grid');
} else if (isset($default_view) && $default_view === 'grid-left') {
    get_template_part('directory/front-end/search-templates/search', 'grid-left');
} else if (isset($default_view) && $default_view === 'list-left') {
    get_template_part('directory/front-end/search-templates/search', 'list-left');
} else if (isset($default_view) && $default_view === 'list-default') {
    get_template_part('directory/front-end/search-templates/search', 'list-default');
} else if (isset($default_view) && $default_view === 'grid-default') {
    get_template_part('directory/front-end/search-templates/search', 'grid-default');
} else {
    get_template_part('directory/front-end/search-templates/search', 'list');
}