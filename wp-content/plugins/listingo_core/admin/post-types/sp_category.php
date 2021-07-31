<?php

/**
 * @package   Listingo Core
 * @author    Themographics
 * @link      http://themographics.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Listingo_Category')) {

    class Listingo_Category {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_directory_type'));
            add_action('created_cities', array(&$this, 'save_country_meta'), 10, 1);
            add_action('edited_cities', array(&$this, 'update_country_meta'), 10, 1);
            add_filter("manage_edit-countries_columns", array(&$this, 'add_countries_column'));
            add_filter("manage_edit-cities_columns", array(&$this, 'add_cities_column'));
            add_filter("manage_edit-languages_columns", array(&$this, 'add_languages_column'));
            add_filter("manage_edit-amenities_columns", array(&$this, 'add_amenities_column'));
            add_filter('manage_cities_custom_column', array(&$this, 'add_cities_column_content'), 10, 3);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_directory_type() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {
			$category_slug	= listingo_get_theme_settings('category_slug');
			$sub_category_slug	= listingo_get_theme_settings('sub_category_slug');
			$country_slug	= listingo_get_theme_settings('country_slug');
			$city_slug	= listingo_get_theme_settings('city_slug');
			$language_slug	= listingo_get_theme_settings('language_slug');
			$amenity_slug	= listingo_get_theme_settings('amenity_slug');
			$insurance_slug	= listingo_get_theme_settings('insurance_slug');
			
			$category_slug		=  !empty( $category_slug ) ? $category_slug : 'provider-category';
			$sub_category_slug	=  !empty( $sub_category_slug ) ? $sub_category_slug : 'sub_category';
			$country_slug		=  !empty( $country_slug ) ? $country_slug : 'country';
			$city_slug			=  !empty( $city_slug ) ? $city_slug : 'city';
			$amenity_slug		=  !empty( $amenity_slug ) ? $amenity_slug : 'amenity';
			$language_slug		=  !empty( $language_slug ) ? $language_slug : 'language';
			$insurance_slug		=  !empty( $insurance_slug ) ? $insurance_slug : 'insurance';

            $labels = array(
                'name' => esc_html__('Provider Types( Categories )', 'listingo_core'),
                'all_items' => esc_html__('Provider Types ( Categories )', 'listingo_core'),
                'singular_name' => esc_html__('Provider Type', 'listingo_core'),
                'add_new' => esc_html__('Add Provider Type', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Provider Type', 'listingo_core'),
                'edit' => esc_html__('Edit', 'listingo_core'),
                'edit_item' => esc_html__('Edit Provider Type', 'listingo_core'),
                'new_item' => esc_html__('New Provider Type', 'listingo_core'),
                'view' => esc_html__('View Provider Type', 'listingo_core'),
                'view_item' => esc_html__('View Provider Type', 'listingo_core'),
                'search_items' => esc_html__('Search Provider Type', 'listingo_core'),
                'not_found' => esc_html__('No Provider Type found', 'listingo_core'),
                'not_found_in_trash' => esc_html__('No Provider Type found in trash', 'listingo_core'),
                'parent' => esc_html__('Parent Provider Types ( Categories )', 'listingo_core'),
            );
            $args = array(
                'labels' => $labels,
                'description' => esc_html__('This is where you can add new Provider Types ', 'listingo_core'),
                'public' => true,
                'supports' => array('title'),
                'show_ui' => true,
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'hierarchical' => false,
                'menu_position' => 10,
                'rewrite' => array('slug' => $category_slug, 'with_front' => true),
                'query_var' => false,
                'has_archive' => 'false',
            );
            register_post_type('sp_categories', $args);

            //Sub Category Taxonomy Labels
            $sub_cat_labels = array(
                'name' => esc_html__('Sub Categories', 'listingo_core'),
                'singular_name' => esc_html__('Sub Category','listingo_core'),
                'search_items' => esc_html__('Search Sub Category', 'listingo_core'),
                'all_items' => esc_html__('All Sub Category', 'listingo_core'),
                'parent_item' => esc_html__('Parent Sub Category', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent Sub Category:', 'listingo_core'),
                'edit_item' => esc_html__('Edit Sub Category', 'listingo_core'),
                'update_item' => esc_html__('Update Sub Category', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Sub Category', 'listingo_core'),
                'new_item_name' => esc_html__('New Sub Category Name', 'listingo_core'),
                'menu_name' => esc_html__('Sub Categories', 'listingo_core'),
            );
            //Sub Category Taxonomy Args
            $sub_cat_args = array(
                'hierarchical' => true,
                'labels' => $sub_cat_labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $sub_category_slug),
            );


            //Countries Taxonomy Labels
            $country_labels = array(
                'name' => esc_html__('Countries','listingo_core'),
                'singular_name' => esc_html__('Country', 'listingo_core'),
                'search_items' => esc_html__('Search Country', 'listingo_core'),
                'all_items' => esc_html__('All Country', 'listingo_core'),
                'parent_item' => esc_html__('Parent Country', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent Country:', 'listingo_core'),
                'edit_item' => esc_html__('Edit Country', 'listingo_core'),
                'update_item' => esc_html__('Update Country', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Country', 'listingo_core'),
                'new_item_name' => esc_html__('New Country Name', 'listingo_core'),
                'menu_name' => esc_html__('Countries', 'listingo_core'),
            );
            //Countries Taxonomy Args
            $country_args = array(
                'hierarchical' => false,
                'parent_item' => null,
                'parent_item_colon' => null,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'labels' => $country_labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $country_slug),
            );

            //Cities Taxonomy Labels
            $cities_labels = array(
                'name' => esc_html__('Cities','listingo_core'),
                'singular_name' => esc_html__('City', 'listingo_core'),
                'search_items' => esc_html__('Search City', 'listingo_core'),
                'all_items' => esc_html__('All City', 'listingo_core'),
                'parent_item' => esc_html__('Parent City', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent City:', 'listingo_core'),
                'edit_item' => esc_html__('Edit City', 'listingo_core'),
                'update_item' => esc_html__('Update City', 'listingo_core'),
                'add_new_item' => esc_html__('Add New City', 'listingo_core'),
                'new_item_name' => esc_html__('New City Name', 'listingo_core'),
                'menu_name' => esc_html__('Cities', 'listingo_core'),
            );

            //Cities Taxonomy Args
            $cities_args = array(
                'hierarchical' => false,
                'parent_item' => null,
                'parent_item_colon' => null,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'labels' => $cities_labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $city_slug),
            );

            //Languages Taxonomy Labels
            $languages_labels = array(
                'name' => esc_html__('Languages', 'listingo_core'),
                'singular_name' => esc_html__('Language','listingo_core'),
                'search_items' => esc_html__('Search Language', 'listingo_core'),
                'all_items' => esc_html__('All Language', 'listingo_core'),
                'parent_item' => esc_html__('Parent Language', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent Language:', 'listingo_core'),
                'edit_item' => esc_html__('Edit Language', 'listingo_core'),
                'update_item' => esc_html__('Update Language', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Language', 'listingo_core'),
                'new_item_name' => esc_html__('New Language Name', 'listingo_core'),
                'menu_name' => esc_html__('Languages', 'listingo_core'),
            );

            //Languages Taxonomy Args
            $languages_args = array(
                'hierarchical' => false,
                'parent_item' => null,
                'parent_item_colon' => null,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'labels' => $languages_labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $language_slug),
            );

            //Amenities Taxonomy Labels
            $amenities_labels = array(
                'name' => esc_html__('Amenities', 'listingo_core'),
                'singular_name' => esc_html__('Amenity','listingo_core'),
                'search_items' => esc_html__('Search Amenity', 'listingo_core'),
                'all_items' => esc_html__('All Amenity', 'listingo_core'),
                'parent_item' => esc_html__('Parent Amenity', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent Amenity:', 'listingo_core'),
                'edit_item' => esc_html__('Edit Amenity', 'listingo_core'),
                'update_item' => esc_html__('Update Amenity', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Amenity', 'listingo_core'),
                'new_item_name' => esc_html__('New Amenity Name', 'listingo_core'),
                'menu_name' => esc_html__('Amenities', 'listingo_core'),
            );

            //Amenities Taxonomy Args
            $amenities_args = array(
                'hierarchical' => true,
                'parent_item' => null,
                'parent_item_colon' => null,
                'show_in_quick_edit' => false,
                'labels' => $amenities_labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $amenity_slug),
            );

            //insurance
            $insurance_labels = array(
                'name' => esc_html__('Insurance', 'listingo_core'),
                'singular_name' => esc_html__('Insurance','listingo_core'),
                'search_items' => esc_html__('Search Insurance', 'listingo_core'),
                'all_items' => esc_html__('All Insurance', 'listingo_core'),
                'parent_item' => esc_html__('Parent Insurance', 'listingo_core'),
                'parent_item_colon' => esc_html__('Parent Insurance:', 'listingo_core'),
                'edit_item' => esc_html__('Edit Insurance', 'listingo_core'),
                'update_item' => esc_html__('Update Insurance', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Insurance', 'listingo_core'),
                'new_item_name' => esc_html__('New Insurance Name', 'listingo_core'),
                'menu_name' => esc_html__('Insurance', 'listingo_core'),
            );

            $insurance_args = array(
                //'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
                'labels' => $insurance_labels,
                'show_ui' => true,
                'show_admin_column' => false,
				'meta_box_cb' => false,
				'show_in_quick_edit' => false,
                'query_var' => true,
                'rewrite' => array('slug' => $insurance_slug),
            );



            //Regirster Sub Category Taxonomy
            register_taxonomy('sub_category', array('sp_categories'), $sub_cat_args);
            //Regirster Countries Taxonomy
            register_taxonomy('countries', array('sp_categories'), $country_args);
            //Register Cities Taxonomy
            register_taxonomy('cities', array('sp_categories'), $cities_args);
            //Regirster Languages Taxonomy
            register_taxonomy('languages', array('sp_categories'), $languages_args);
            //Regirster Amenities Taxonomy
            register_taxonomy('amenities', array('sp_categories'), $amenities_args);
            //Regirster insurance Taxonomy
            register_taxonomy('insurance', array('sp_categories'), $insurance_args);
        }

        /**
         * @Countries Column
         * @return {}
         */
        public function add_countries_column($columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => esc_html__('Name', 'listingo_core'),
                'slug' => esc_html__('Slug', 'listingo_core')
            );
            return $new_columns;
        }

        /**
         * @Langugaes Column
         * @return {}
         */
        public function add_languages_column($columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => esc_html__('Name', 'listingo_core'),
                'slug' => esc_html__('Slug', 'listingo_core')
            );
            return $new_columns;
        }

        /**
         * @Amenities Column
         * @return {}
         */
        public function add_amenities_column($columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => esc_html__('Name', 'listingo_core'),
                'slug' => esc_html__('Slug', 'listingo_core')
            );
            return $new_columns;
        }

        /**
         * @Cities Column
         * @return {}
         */
        public function add_cities_column($columns) {
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => esc_html__('Name', 'listingo_core'),
                'countries_list' => esc_html__('Country', 'listingo_core'),
                'slug' => esc_html__('Slug', 'listingo_core')
            );
            return $new_columns;
        }

        /**
         * @Cities Column show
         * @return {}
         */
        public function add_cities_column_content($content, $column_name, $term_id) {


            if ($column_name !== 'countries_list') {
                return $content;
            }

            $get_cities_meta = array();
            $country_term = array();
            if (function_exists('fw_get_db_term_option')) {
                $get_cities_meta = fw_get_db_term_option($term_id, 'cities');
                if (!empty($get_cities_meta['country'][0])) {
                    $country_id = $get_cities_meta['country'][0];
                    $country_term = get_term($country_id, 'countries');
                }
            }

            if (!empty($country_term)) {
                $country_name = $country_term->name;
            }

            if (!empty($country_name)) {
                $content .= $country_name;
            }

            return $content;
        }

        /**
         * @Country Save
         * @return {}
         */
        public function save_country_meta($term_id) {
            if (!empty($_POST['fw_options']['country'])) {
                $country_id = $_POST['fw_options']['country'];
                $term_data = get_term_by('id', $country_id, 'countries');
                if (!empty($term_data->slug)) {
                    add_term_meta($term_id, 'country', $term_data->slug, true);
                }
            }
        }

        /**
         * @Country update
         * @return {}
         */
        public function update_country_meta($term_id) {
            if (!empty($_POST['fw_options']['country'])) {
                $country_id = $_POST['fw_options']['country'];
                $term_data = get_term_by('id', $country_id, 'countries');
                if (!empty($term_data->slug)) {
                    update_term_meta($term_id, 'country', $term_data->slug);
                }
            }
        }

    }

    new Listingo_Category();
}


