<?php

if (!defined('FW')) {
    die('Forbidden');
}

class FW_Extension_Ads extends FW_Extension {

    /**
     * @internal
     */
    public function _init() {     
		add_action('init',array(&$this,'register_post_type'));
		add_filter('manage_sp_ads_posts_columns', array(&$this, 'directory_columns_add'),10,1);
		add_action('manage_sp_ads_posts_custom_column', array(&$this, 'directory_columns'),10, 1);
        add_filter('template_include', array(&$this, 'render_sp_ads_detail_page_view'));
    }


    /**
     * @Render ads detail page view
     * @return type
     */
    public function render_sp_ads_detail_page_view( $template ) {
        $post_types = array('sp_ads');
        $taxonomies = array('ad_tags', 'ad_category', 'ad_amenity');
        if (is_singular($post_types)) {
            $template = do_action('render_sp_display_detail_ads_view');            
        }
        if ( is_tax( $taxonomies ) ) {
            $template = do_action('render_sp_display_archive_view');            
        }
        return $template;
    }


    /**
     * @Render ads Listing
     * @return type
     */
    public function render_ad_listing() {
        return $this->render_view('listing');
    }
	
	/**
     * @Render favorite ads
     * @return type
     */
    public function render_favorite_ads() {
        return $this->render_view('favorites');
    }

    /**
     * @Render ads Add View
     * @return type
     */
    public function render_add_ads() {
        return $this->render_view('add');
    }

    /**
     * @Render ads Edit View
     * @return type
     */
    public function render_edit_ads() {
        return $this->render_view('edit');
    }
	
	/**
     * @Render ads Edit View
     * @return type
     */
    public function render_display_dashboard_ads() {
        return $this->render_view('ads');
    }

    /**
     * @Render ads detail page View
     * @return type
     */
    public function render_ad_detail_page() {
        return $this->render_view('single-ad');
    }
	
	/**
     * @Render ads search result
     * @return type
     */
    public function render_display_search_result() {
        return $this->render_view('ads-search');
    }
	
	/**
     * @Render ads provider detail page
     * @return type
     */
    public function render_display_profile_ads() {
        return $this->render_view('provider_detail');
    }

    /**
     * @Render ads provider detail page
     * @return type
     */
    public function render_display_profile_ads_detail_view() {
        return $this->render_view('ads_detail');
    }
	
    /**
     * @Render ads archive page
     * @return type
     */
    public function render_display_ads_archive_view() {
        return $this->render_view('ad-archive');
    }

	/**
     * @Render ads Edit View
     * @return type
     */
    public function render_list_ads() {
        return $this->render_view('grid');
    }

    /**
     * @access Private
     * @Register Post Type
     */
    public function register_post_type() {
		if( function_exists('listingo_get_theme_settings') ){
			$ad_slug	= listingo_get_theme_settings('ad_slug');
		}
		
		$ad_slug	=  !empty( $ad_slug ) ? $ad_slug : 'ad';
		
        register_post_type('sp_ads', array(
            'labels' => array(
                'name' => esc_html__('Ads', 'listingo'),
                'all_items' => esc_html__('Ads', 'listingo'),
                'singular_name' => esc_html__('Ad', 'listingo'),
                'add_new' => esc_html__('Create Ad', 'listingo'),
                'add_new_item' => esc_html__('Create New ad', 'listingo'),
                'edit' => esc_html__('Edit', 'listingo'),
                'edit_item' => esc_html__('Edit ad', 'listingo'),
                'new_item' => esc_html__('New ad', 'listingo'),
                'view' => esc_html__('View ad', 'listingo'),
                'view_item' => esc_html__('View ad', 'listingo'),
                'search_items' => esc_html__('Search ad', 'listingo'),
                'not_found' => esc_html__('No ad found', 'listingo'),
                'not_found_in_trash' => esc_html__('No ad found in trash', 'listingo'),
                'parent' => esc_html__('Parent ad', 'listingo'),
            ),
            'description' => esc_html__('This is where you can create new ads.', 'listingo'),
            'public' => true,
            'supports' => array('title', 'editor','thumbnail','author', 'comments'),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => $ad_slug, 'with_front' => true),
            'query_var' => true,
            'has_archive' => true
        ));
        	register_taxonomy('ad_tags', 'sp_ads', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Tags', 'listingo'),
                'singular_name' => esc_html__('Tag', 'listingo'),
                'search_items' => esc_html__('Search Tags', 'listingo'),
                'popular_items' => esc_html__('Popular Tags', 'listingo'),
                'all_items' => esc_html__('All Tags', 'listingo'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Tag', 'listingo'),
                'update_item' => esc_html__('Update Tag', 'listingo'),
                'add_new_item' => esc_html__('Add New Tag', 'listingo'),
                'new_item_name' => esc_html__('New Tag Name', 'listingo'),
                'separate_items_with_commas' => esc_html__('Separate tags with commas', 'listingo'),
                'add_or_remove_items' => esc_html__('Add or remove tags', 'listingo'),
                'choose_from_most_used' => esc_html__('Choose from the most used tags', 'listingo'),
                'menu_name' => esc_html__('Tags', 'listingo'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_tags'),
        ));

        //Register category
        register_taxonomy('ad_category', 'sp_ads', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Category', 'listingo'),
                'singular_name' => esc_html__('Category', 'listingo'),
                'search_items' => esc_html__('Search Categories', 'listingo'),
                'popular_items' => esc_html__('Popular Categories', 'listingo'),
                'all_items' => esc_html__('All Categories', 'listingo'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Category', 'listingo'),
                'update_item' => esc_html__('Update Category', 'listingo'),
                'add_new_item' => esc_html__('Add New Category', 'listingo'),
                'new_item_name' => esc_html__('New Category Name', 'listingo'),
                'separate_items_with_commas' => esc_html__('Separate Categories with commas', 'listingo'),
                'add_or_remove_items' => esc_html__('Add or remove Categories', 'listingo'),
                'choose_from_most_used' => esc_html__('Choose from the most used Categories', 'listingo'),
                'menu_name' => esc_html__('Categories', 'listingo'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_category'),
        ));

        //Register amenity
        register_taxonomy('ad_amenity', 'sp_ads', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Amenity', 'listingo'),
                'singular_name' => esc_html__('Amenity', 'listingo'),
                'search_items' => esc_html__('Search amenities', 'listingo'),
                'popular_items' => esc_html__('Popular amenities', 'listingo'),
                'all_items' => esc_html__('All amenities', 'listingo'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Amenity', 'listingo'),
                'update_item' => esc_html__('Update Amenity', 'listingo'),
                'add_new_item' => esc_html__('Add New Amenity', 'listingo'),
                'new_item_name' => esc_html__('New Amenity Name', 'listingo'),
                'separate_items_with_commas' => esc_html__('Separate amenities with commas', 'listingo'),
                'add_or_remove_items' => esc_html__('Add or remove amenities', 'listingo'),
                'choose_from_most_used' => esc_html__('Choose from the most used amenities', 'listingo'),
                'menu_name' => esc_html__('Amenities', 'listingo'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_amenity'),
        ));
		
    }
	
	/**
	 * @Prepare Columns
	 * @return {post}
	 */
	public function directory_columns_add($columns) {
		$columns['author'] 			= esc_html__('Author','listingo');
		return $columns;
	}

	/**
	 * @Get Columns
	 * @return {}
	 */
	public function directory_columns($name) {
		global $post;


		switch ($name) {
			case 'author':
				echo ( get_the_author );
			break;
		}
	}

}