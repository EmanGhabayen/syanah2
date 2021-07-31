<?php

/**
 *
 * Template Name: Job Search
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $total_posts, $query_args, $showposts;
$per_page = intval(10);
if (!empty($_GET['showposts'])) {
    $per_page = $_GET['showposts'];
}


$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$json = array();
$meta_query_args	= array();

//search filters
$sub_category 	= !empty($_GET['sub_categories']) ? $_GET['sub_categories'] : '';
$category 		= !empty($_GET['category']) ? $_GET['category'] : '';
$job_type 		= !empty($_GET['job_type']) ? $_GET['job_type'] : '';
$experience 	= !empty($_GET['experience']) ? $_GET['experience'] : '';
$languages 		= !empty($_GET['languages']) ? $_GET['languages'] : '';
$sort_by 		= !empty($_GET['sortby']) ? $_GET['sortby'] : 'ID';
$showposts 		= !empty($_GET['showposts']) ? $_GET['showposts'] : -1;

//Order
$order = 'DESC';
if (!empty($_GET['orderby'])) {
    $order = esc_attr($_GET['orderby']);
}

//Category Type Search
if (!empty($category)) {
    $meta_query_args[] = array(
        'key' 		=> 'category',
        'value' 	=> $category,
        'compare' 	=> '=',
    );
}
//Sub category Type Search
if (!empty($sub_category) && !empty($sub_category[0]) && is_array($sub_category)) {
    $query_relation = array('relation' => 'OR',);
    $sub_category_args = array();
    foreach ($sub_category as $key => $value) {
        $sub_category_args[] = array(
            'key' => 'sub_category',
            'value' => $value,
            'compare' => '='
        );
    }

    $meta_query_args[] = array_merge($query_relation, $sub_category_args);
}

//Job Type Search
if (!empty($job_type) && !empty($job_type[0]) && is_array($job_type)) {
    $query_relation = array('relation' => 'OR',);
    $job_type_args = array();
    foreach ($job_type as $key => $value) {
        $job_type_args[] = array(
            'key' 		=> 'job_type',
            'value' 	=> $value,
            'compare' 	=> '='
        );
    }

    $meta_query_args[] = array_merge($query_relation, $job_type_args);
}

//Experience Type Search
if (!empty($experience) && !empty($experience[0]) && is_array($experience)) {
    $query_relation = array('relation' => 'OR',);
    $experience_args = array();
    foreach ($experience as $key => $value) {
        $experience_args[] = array(
            'key' => 'experience',
            'value' => $value,
            'compare' => '='
        );
    }

    $meta_query_args[] = array_merge($query_relation, $experience_args);
}

//Experience Type Search
if (!empty($experience) && !empty($experience[0]) && is_array($experience)) {
    $query_relation = array('relation' => 'OR',);
    $experience_args = array();
    foreach ($experience as $key => $value) {
        $experience_args[] = array(
            'key' => 'experience',
            'value' => $value,
            'compare' => '='
        );
    }

    $meta_query_args[] = array_merge($query_relation, $experience_args);
}


//Language Search;
if (!empty($languages) && !empty($languages[0]) && is_array($languages)) {
    $query_relation = array('relation' => 'OR',);
    $language_args = array();
    foreach ($languages as $key => $value) {
        $language_args[] = array(
            'key' => 'languages',
            'value' => serialize(strval($value)),
            'compare' => 'LIKE'
        );
    }

    $meta_query_args[] = array_merge($query_relation, $language_args);
}

$query_args = array(
    'posts_per_page' => "-1",
    'post_type' => 'sp_jobs',
    'order' => $order,
    'orderby' => $sort_by,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

if (!empty($_GET['keyword'])) {
    $s = sanitize_text_field($_GET['keyword']);
    $query_args['s'] = $s;
}

$total_query = new WP_Query($query_args);
$total_posts = $total_query->post_count;

$query_args = array(
    'posts_per_page' => $showposts,
    'post_type' => 'sp_jobs',
    'paged' => $paged,
    'order' => $order,
    'orderby' => $sort_by,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);


if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}
if (!empty($_GET['keyword'])) {
    $s = sanitize_text_field($_GET['keyword']);
    $query_args['s'] = $s;
}


get_template_part('directory/front-end/jobs/job', 'listing');
