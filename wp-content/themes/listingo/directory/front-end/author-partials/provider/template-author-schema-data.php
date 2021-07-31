<?php
/**
 *
 * AuthorSchema Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */  
    $author_profile = $wp_query->get_queried_object();

    $list_services = array();
    if (!empty($author_profile->profile_services)) {
        $list_services = $author_profile->profile_services;
    }
    $author_url           = get_author_posts_url($author_profile->ID);
    $appointment_currency = get_user_meta($author_profile->ID, 'appointment_currency', true);
    $currencies           = listingo_get_current_currency();
    $currency_symbol      = !empty( $currencies['symbol'] ) ? $currencies['symbol'] : '$';
	
	$user_meta	=  array();
    $user_id    = $author_profile->ID;   
    $user_meta  = get_user_meta($user_id);

 	$address    = !empty( $author_profile->address ) ? $author_profile->address : '';
	$phone      = !empty( $author_profile->address ) ? $author_profile->phone : '';
    $email      = !empty( $author_profile->user_email ) ? $author_profile->user_email : '';
	$country    = !empty( $author_profile->address ) ? $author_profile->country : '';

    $latitude   = !empty( $author_profile->latitude ) ? $author_profile->latitude : '';
    $longitude  = !empty( $author_profile->longitude ) ? $author_profile->longitude : '';
	$city       = !empty( $author_profile->address ) ? $author_profile->city : '';
    $user_name  = listingo_get_username($author_profile->ID); 
    
    $list_gallery = array();
    if (!empty($author_profile->profile_gallery_photos)) {
        $list_gallery = $author_profile->profile_gallery_photos;
    }
    
    $review_data = get_user_meta($author_profile->ID, 'review_data', true);                 
    $ratings = !empty($review_data['sp_total_rating']) ? $review_data['sp_total_rating'] : 0;
    $average = !empty($review_data['sp_average_rating']) ? $review_data['sp_average_rating'] : 0;

    $client_description = '';
    $price = array();
    if ( !empty( $list_services ) ) {
        $counter = 1;
        foreach ($list_services as $key => $service) {            
            $price[] = !empty($service['price']) ? $service['price'] : 0;    
            $description = !empty($service['description']) ? $service['description'] : '';
            if ( !empty( $description ) ) {
                $client_description = $description;
            }            
        }
    }

    $min_price = !empty( $price ) ? min($price) : '0.0';  
    $max_price = !empty( $price ) ? max($price) : '0.0'; 

    //getting user logo
    $user_avatar = apply_filters(
        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $author_profile->ID), array('width' => 100, 'height' => 100) //size width,height
    );
   
    $listingo_user_product_data = array();
    $listingo_user_product_data['@context'] = "http://schema.org";
    $listingo_user_product_data['@type'] = "LocalBusiness";   
    $listingo_user_product_data['@id'] =  $author_url;    
    $listingo_user_product_data['contactPoint'] = array(           
        "@type" => "ContactPoint",
        "contactType" => "customer support",
        "telephone" => $phone,
        "email" => $email              
    );
    $listingo_user_product_data['address']      = $address;
    $listingo_user_product_data['description']  = $client_description;
    $listingo_user_product_data['name'] 		= $user_name;
    $listingo_user_product_data['legalName']    = $user_name;
    $listingo_user_product_data['logo']         = $user_avatar;
    $listingo_user_product_data['url']          =  $author_url;
    $listingo_user_product_data['telephone'] 	= $phone;
    $listingo_user_product_data['email']        = $email;
    $listingo_user_product_data['image'] 		= $user_avatar;
    $listingo_user_product_data['photo']        = $user_avatar;
    $listingo_user_product_data['priceRange']   = $currency_symbol.$min_price . ' - ' . $currency_symbol.$max_price;      
 
    if ( !empty( $list_gallery ) ) {
        $listingo_user_product_data['photos'] = array();
        foreach ($list_gallery['image_data'] as $key => $gallery) {           
            $full = !empty($gallery['full']) ? $gallery['full'] : ''; 
            $listingo_user_product_data['photos'][] = $full;     
        }
    }

    if ( !empty( $latitude ) && !empty( $longitude ) ) {

        $listingo_user_product_data['geo'] = array (
            "@type" => "GeoCoordinates",
             "latitude" => $latitude,
             "longitude" => $longitude,
        );
        $listingo_user_product_data['hasMap'] = "https://www.google.nl/maps/@".$latitude.",".$longitude;

    }

    if ( $ratings > 0 ){
		$average	= !empty( $average ) ? $average : '1';
		$ratings	= !empty( $ratings ) ? $ratings : '1';
        $listingo_user_product_data['aggregateRating'] = array(
            "@type" => "AggregateRating",
            "ratingValue" => $average,
            "reviewCount" => $ratings,
            "bestRating" => "5"
        );
    }

    do_action('print_schema_tags', $listingo_user_product_data);