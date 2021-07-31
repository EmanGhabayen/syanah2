<?php
/**
 * @Init Reviews Post Type
 * @return {post}
 */
if (!class_exists('SP_Reviews')) {

    class SP_Reviews {

        public function __construct() {
            global $pagenow;
            add_action('init', array(&$this, 'init_review'));
            add_action('add_meta_boxes', array(&$this, 'sp_reviews_add_meta_box'), 10, 1);
            add_filter('manage_sp_reviews_posts_columns', array(&$this, 'reviews_columns_add'));
            add_action('manage_sp_reviews_posts_custom_column', array(&$this, 'reviews_columns'), 10, 2);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_review() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type
         * @return {}
         */
        public function prepare_post_type() {
            $labels = array(
                'name' => esc_html__('Reviews', 'listingo_core'),
                'all_items' => esc_html__('Reviews', 'listingo_core'),
                'singular_name' => esc_html__('Review', 'listingo_core'),
                'add_new' => esc_html__('Add Review', 'listingo_core'),
                'add_new_item' => esc_html__('Add New Review', 'listingo_core'),
                'edit' => esc_html__('Edit', 'listingo_core'),
                'edit_item' => esc_html__('Edit Review', 'listingo_core'),
                'new_item' => esc_html__('New Review', 'listingo_core'),
                'view' => esc_html__('View Review', 'listingo_core'),
                'view_item' => esc_html__('View Review', 'listingo_core'),
                'search_items' => esc_html__('Search Review', 'listingo_core'),
                'not_found' => esc_html__('No Review found', 'listingo_core'),
                'not_found_in_trash' => esc_html__('No Review found in trash', 'listingo_core'),
                'parent' => esc_html__('Parent Review', 'listingo_core'),
            );
            $args = array(
                'labels' => $labels,
                'description' => esc_html__('', 'listingo_core'),
                'public' => true,
                'supports' => array('title', 'editor'),
                'show_ui' => true,
                'capability_type' => 'post',
                'show_in_nav_menus' => false,
                'map_meta_cap' => true,
                'publicly_queryable' => true,
                'show_in_menu' => 'edit.php?post_type=sp_categories',
                'exclude_from_search' => false,
                'hierarchical' => false,
                'menu_position' => 10,
                'rewrite' => array('slug' => 'reviews', 'with_front' => true),
                'query_var' => false,
                'has_archive' => false,
                'capabilities' => array('create_posts' => false), //Hide add New Button
            );
            register_post_type('sp_reviews', $args);
        }

        /**
         * @Init Meta Boxes
         * @return {post}
         */
        public function sp_reviews_add_meta_box($post_type) {
            if ($post_type == 'sp_reviews') {
                add_meta_box(
                        'sp_reviews_info', esc_html__('Review Info', 'listingo_core'), array(&$this, 'sp_reviews_meta_box_reviewinfo'), 'sp_reviews', 'side', 'high'
                );
            }
        }

        /**
         * @Init Save Meta Boxes
         * @return {post}
         */
        public function sp_reviews_save_meta_box() {
            global $post;
           
        }

        /**
         * @Init Review info
         * @return {post}
         */
        public function sp_reviews_meta_box_reviewinfo() {
            global $post;

            if (function_exists('fw_get_db_settings_option')) {
                $user_from_id = get_post_meta($post->ID, 'user_from', true);
                $user_to_id = get_post_meta($post->ID, 'user_to', true);
                $rating = get_post_meta($post->ID, 'user_rating', true);
                $user_from = listingo_get_username($user_from_id);
                $user_to = listingo_get_username($user_to_id);

            } else {

                $user_from = '';
                $user_to = '';
                $rating = 0;
            }
            ?>
            <ul class="review-info">
                <li>
                    <span class="push-left"><strong><?php esc_html_e('Rating:', 'listingo_core'); ?></strong></span>
                    <span class="push-right"><?php echo esc_attr($rating); ?>/<?php echo intval(5); ?></span>
                </li>
                <?php if (!empty($user_from)) { ?>
                    <li>
                        <span class="push-left"><strong><?php esc_html_e('Review By', 'listingo_core'); ?>:</strong></span>
                        <span class="push-right"><a href="<?php echo get_edit_user_link($user_from_id); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'listingo_core'); ?>"><?php echo esc_attr($user_from); ?></a></span>
                    </li>
                <?php } ?>
                <?php if (!empty($user_to)) { ?>
                    <li>
                        <span class="push-left"><strong><?php esc_html_e('Review To', 'listingo_core'); ?></strong></span>
                        <span class="push-right"><a href="<?php echo get_edit_user_link($user_to_id); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'listingo_core'); ?>"><?php echo esc_attr($user_to); ?></a></span>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function reviews_columns_add($columns) {
            $columns['user_from'] = esc_html__('User From', 'listingo_core');
            $columns['user_to'] = esc_html__('User To', 'listingo_core');
            $columns['rating'] = esc_html__('Average Rating', 'listingo_core');

            return $columns;
        }

        /**
         * @Get Columns
         * @return {}
         */
        public function reviews_columns($name) {
            global $post;

            $user_identity = '';
            $rating = '';

            if (function_exists('fw_get_db_settings_option')) {
                $user_from = get_post_meta($post->ID, 'user_from', true);
                $user_to = get_post_meta($post->ID, 'user_to', true);
                $rating = get_post_meta($post->ID, 'user_rating', true);
				
				$user_from = listingo_get_username($user_from);
                $user_to = listingo_get_username($user_to);
            }

            switch ($name) {
                case 'user_from':
                   if (!empty($user_from) ) {
                        echo esc_attr($user_from);
                    }
                    break;
                case 'user_to':
                    if (!empty($user_to) ) {
                        echo esc_attr($user_to);
                    }
                    break;
                case 'rating':
                    printf('%s', $rating);
                    break;
            }
        }

    }

    new SP_Reviews();
}