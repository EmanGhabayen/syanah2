<?php

if (!defined('FW')) {
    die('Forbidden');
}

class FW_Extension_Articles extends FW_Extension {

    /**
     * @internal
     */
    public function _init() {
        add_action('init',array(&$this,'register_post_type'));
		add_filter('manage_sp_articles_posts_columns', array(&$this, 'directory_columns_add'),10,1);
		add_action('manage_sp_articles_posts_custom_column', array(&$this, 'directory_columns'),10, 1);
    }

    /**
     * @Render Articles Listing
     * @return type
     */
    public function render_article_listing() {
        return $this->render_view('listing');
    }

    /**
     * @Render Articles Add View
     * @return type
     */
    public function render_add_articles() {
        return $this->render_view('add');
    }

    /**
     * @Render Articles Edit View
     * @return type
     */
    public function render_edit_articles() {
        return $this->render_view('edit');
    }
	
	/**
     * @Render Articles Edit View
     * @return type
     */
    public function render_display_dashboard_articles() {
        return $this->render_view('articles');
    }
	
	/**
     * @Render Articles Edit View
     * @return type
     */
    public function render_list_articles() {
        return $this->render_view('grid');
    }

    /**
     * @access Private
     * @Register Post Type
     */
    public function register_post_type() {
		if( function_exists('listingo_get_theme_settings') ){
			$article_slug	= listingo_get_theme_settings('article_slug');
		}
		
		$article_slug	=  !empty( $article_slug ) ? $article_slug : 'article';
		
        register_post_type('sp_articles', array(
            'labels' => array(
                'name' => esc_html__('Articles', 'listingo'),
                'all_items' => esc_html__('Articles', 'listingo'),
                'singular_name' => esc_html__('Article', 'listingo'),
                'add_new' => esc_html__('Add Article', 'listingo'),
                'add_new_item' => esc_html__('Add New Article', 'listingo'),
                'edit' => esc_html__('Edit', 'listingo'),
                'edit_item' => esc_html__('Edit Article', 'listingo'),
                'new_item' => esc_html__('New Article', 'listingo'),
                'view' => esc_html__('View Article', 'listingo'),
                'view_item' => esc_html__('View Article', 'listingo'),
                'search_items' => esc_html__('Search Article', 'listingo'),
                'not_found' => esc_html__('No Article found', 'listingo'),
                'not_found_in_trash' => esc_html__('No Article found in trash', 'listingo'),
                'parent' => esc_html__('Parent Article', 'listingo'),
            ),
            'description' => esc_html__('This is where you can add new Articles.', 'listingo'),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail',"author"),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => $article_slug, 'with_front' => true),
            'query_var' => true,
            'has_archive' => true
        ));
        	register_taxonomy('article_tags', 'sp_articles', array(
            'hierarchical' => false,
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
            'rewrite' => array('slug' => 'article_tags'),
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
