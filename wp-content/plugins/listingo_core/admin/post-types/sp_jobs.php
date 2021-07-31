<?php

/**
 * @package   Listingo Core
 * @author    Themographics
 * @link      http://themographics.com/
 * @version 1.0
 * @since 1.0
 */


	if (!class_exists('Listingo_Jobs')) {

		class Listingo_Jobs {

			/**
			 * @access  public
			 * @Init Hooks in Constructor
			 */
			public function __construct() {
				
				add_action('init', array(&$this, 'init_jobs'));
				
			}

			/**
			 * @Init Post Type
			 * @return {post}
			 */
			public function init_jobs() {
				if ( apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
					$this->prepare_post_type();
				}
			}

			/**
			 * @Prepare Post Type Category
			 * @return post type
			 */
			public function prepare_post_type() {
				$job_slug	= listingo_get_theme_settings('job_slug');
				$job_slug	=  !empty( $job_slug ) ? $job_slug : 'job';
				$labels = array(
					'name' => esc_html__('Jobs', 'listingo_core'),
					'all_items' => esc_html__('Jobs', 'listingo_core'),
					'singular_name' => esc_html__('Job', 'listingo_core'),
					'add_new' => esc_html__('Add Job', 'listingo_core'),
					'add_new_item' => esc_html__('Add New Job', 'listingo_core'),
					'edit' => esc_html__('Edit', 'listingo_core'),
					'edit_item' => esc_html__('Edit Job', 'listingo_core'),
					'new_item' => esc_html__('New Job', 'listingo_core'),
					'view' => esc_html__('View Job', 'listingo_core'),
					'view_item' => esc_html__('View Job', 'listingo_core'),
					'search_items' => esc_html__('Search Job', 'listingo_core'),
					'not_found' => esc_html__('No Job found', 'listingo_core'),
					'not_found_in_trash' => esc_html__('No Job found in trash', 'listingo_core'),
					'parent' => esc_html__('Parent Job', 'listingo_core'),
				);
				$args = array(
					'labels' => $labels,
					'description' => esc_html__('This is where you can add new Jobs.', 'listingo_core'),
					'public' => true,
					'supports' => array('title', 'editor'),
					'show_ui' => true,
					'capability_type' => 'post',
					'show_in_menu' => 'edit.php?post_type=sp_categories',
					'map_meta_cap' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'hierarchical' => true,
					'menu_position' => 10,
					'rewrite' => array('slug' => $job_slug, 'with_front' => true),
					'query_var' => true,
					'has_archive' => 'true',
				);
				
				register_post_type('sp_jobs', $args);
				
			}

		}

		new Listingo_Jobs();
	}