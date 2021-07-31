<?php
/**
 *
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $query_args, $showposts, $wp_query;
$per_page = get_option('posts_per_page');;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$json = array();
$meta_query_args	= array();
$tax_query_args		= array();
$tax_category_query_args	= array();
$tax_amenity_query_args		= array();
$tax_tag_query_args			= array();

//search filters
$s 				= !empty($_GET['keyword']) ? sanitize_text_field( $_GET['keyword'] ) : '';
$category 		= !empty($_GET['category']) ? $_GET['category'] : '';
$sort_by 		= !empty($_GET['sortby']) ? $_GET['sortby'] : '';
$price_type		= !empty($_GET['price_type']) ? $_GET['price_type'] : '';
$showposts 		= !empty($_GET['showposts']) ? $_GET['showposts'] : $per_page;
$s_amenities	= !empty( $_GET['amenities'] ) ? $_GET['amenities'] : array();
$s_tags			= !empty( $_GET['tags'] ) ? $_GET['tags'] : array();

//Order
$order = 'DESC';
if (!empty($_GET['orderby'])) {
    $order = esc_attr($_GET['orderby']);
}

//price type 
if( !empty( $price_type ) ){
	$meta_query_args[] = array(
		'key' 		=> 'pricing_type',
		'value' 	=> $price_type,
		'compare' 	=> '='
	);
}


//Category seearch
if (is_tax('ad_category') && empty( $category )) {    
    $cat = $wp_query->get_queried_object();
    if (!empty($cat->slug)) {
        $category = $cat->slug;         
    }
} 

if( !empty( $category ) ){
    $tax_category_query_args[] = array(
        'taxonomy'  => 'ad_category',
        'field'     => 'slug',
        'terms'     => $category,
    );
}
 
//Amenity seearch
if (is_tax('ad_amenity') && empty( $s_amenities )) {    
    $amenity = $wp_query->get_queried_object();
    if (!empty($amenity->slug)) {
        $s_amenities = array($amenity->slug);          
    }
}

if( !empty( $s_amenities ) ){
    $tax_amenity_query_args[] = array(
        'taxonomy'  => 'ad_amenity',
        'field'     => 'slug',
        'terms'     => $s_amenities,
    );
}

//Tag search
if (is_tax('ad_tags') && empty( $s_tags )) {    
    $adtags = $wp_query->get_queried_object();
    if (!empty($adtags->slug)) {
        $s_tags = array($adtags->slug);                
    }
}

if( !empty( $s_tags ) ){
    $tax_tag_query_args[] = array(
        'taxonomy'  => 'ad_tags',
        'field'     => 'slug',
        'terms'     => $s_tags,
    );
}

$query_args = array(
    'posts_per_page'        => $showposts,
    'post_type'             => 'sp_ads',
    'paged'                 => $paged,
    'orderby'               => $sort_by,
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1
);

$query_args['meta_key'] = '_featured_timestamp';
$query_args['orderby']	 = array( 
	'meta_value' 	=> 'DESC', 
	'ID'      		=> 'DESC',
); 


//meta query
if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

//tax query
if (!empty($tax_amenity_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_amenity_query_args = array_merge($query_relation, $tax_amenity_query_args);
    $tax_query_args [] = $tax_amenity_query_args;
}

if (!empty($tax_tag_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_tag_query_args = array_merge($query_relation, $tax_tag_query_args);
    $tax_query_args[] = $tax_tag_query_args;
}

if (!empty($tax_category_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_category_query_args = array_merge($query_relation, $tax_category_query_args);
    $tax_query_args[] = $tax_category_query_args;
}

if (!empty($tax_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $tax_query_args = array_merge($query_relation, $tax_query_args);
    $query_args['tax_query'] = $tax_query_args;
}

if (!empty($_GET['keyword'])) {
    $query_args['s'] = $s;
}

get_template_part('framework-customizations/extensions/ads/views/search-ads', 'grid');
