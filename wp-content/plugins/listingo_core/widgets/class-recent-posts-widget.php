<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-out-authors-widget
 *
 * @author ab
 */
 
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Listingo_LatestPosts')) {

    class Listingo_LatestPosts extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'listingo_recentposts' , // Base ID
                    esc_html__('Recent Posts | Listingo' , 'listingo_core') , // Name
                array (
                	'classname' => 'tg-burfats',
					'description' => esc_html__('Listingo Recent Posts' , 'listingo_core') , 
				) // Args
            );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args , $instance) {
            // outputs the content of the widget
            extract($instance);
			$number_of_posts = isset($instance['number_of_posts']) && !empty($instance['number_of_posts']) ? $instance['number_of_posts'] : -1;
			$categories = isset($instance['categories']) && !empty($instance['categories']) ? $instance['categories'] : array();
			$title = isset($instance['title']) && !empty($instance['title']) ? $instance['title'] : '';
			  
            $before	= ($args['before_widget']);
			$after	 = ($args['after_widget']);
			
			echo ($before);
			
			$query_args = array(
				'posts_per_page' 	=> $number_of_posts,
				'post_type' 		=> 'post',
				'order' 			=> 'DESC',
				'post_status' 		=> 'publish',
				'orderby' 			=> 'ID',
				'suppress_filters' 	=> false,
				'ignore_sticky_posts' => 1
			);
			
			if ( !empty($categories) ) {
                $slugs = array ();
                foreach ($categories as $key => $value) {
                    $term    = get_term($value , 'category');
                    $slugs[] = $term->slug;
                }

                $filterable             = $slugs;
                $tax_query['tax_query'] = array (
                    'relation' => 'AND' ,
                    array (
                        'taxonomy' => 'category' ,
                        'terms'    => $filterable ,
                        'field'    => 'slug' ,
                    ));
            }
			
			if ( !empty($tax_query) ) {
                $query_args = array_merge($query_args , $tax_query);
            }
			
			if (!empty($title) ) {
				echo ($args['before_title'] . apply_filters('widget_title', esc_attr($title)) . $args['after_title']);
			}
			
            $query = new WP_Query($query_args);
			if( $query->have_posts() ) {
			?>
            <ul>
                <?php
                while ($query->have_posts()) : $query->the_post();
                    global $post;
                    $user_ID    = get_the_author_meta('ID');
					$thumbnail = listingo_prepare_thumbnail($post->ID , 71 , 71);
                    
                    ?>
					<li>
						<?php if ( has_post_thumbnail() ) {?>
                        <div class="tg-videobox">
                            <div class="tg-videoholder">
                                    <img src="<?php echo esc_url($thumbnail); ?>"  alt="<?php echo sanitize_title( get_the_title() ); ?>">
                            </div>
                        </div>
                        <?php }?>
                        <div class="tg-videocontent">
                            <div class="tg-videotitle">
                                <h4><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_attr(get_the_title()); ?></a></h4>
                            </div>
                            <span><a href="<?php echo esc_url(get_author_posts_url($user_ID));?>"><?php echo get_the_author(); ?></a></span>
                        </div>
					</li>
                <?php 
				endwhile;
				wp_reset_postdata(); ?>
            </ul>
            <?php
			}
			echo ( $after );
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
            $db_categories           = !empty($instance['categories']) ? $instance['categories'] : array();
			$title           = !empty($instance['title']) ? $instance['title'] : esc_html__('Recent Posts' , 'listingo_core');
            $number_of_posts = !empty($instance['number_of_posts']) ? $instance['number_of_posts'] : 3;
			
			$categories	= listingo_get_posts_categories_walker();
            ?>
            
			<p>
                <label for="<?php echo ( $this->get_field_id('categories') ); ?>"><?php esc_html_e('Select categories','listingo_core'); ?></label> 
				<select multiple="multiple" name="<?php echo ( $this->get_field_name('categories') ); ?>[]" class="<?php echo ( $this->get_field_id('categories') ); ?>">
					<?php foreach( $categories as $key => $term ){?>
							<option value="<?php echo intval( $key );?>" <?php echo !empty( $db_categories ) && in_array($key,$db_categories) ? 'selected' : '';?>><?php echo esc_attr( $term );?></option>
					<?php }?>
				
				</select>
               
            </p>
			
			<p>
                <label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('number_of_posts') ); ?>"><?php esc_html_e('Number of Posts to show:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('number_of_posts') ); ?>" name="<?php echo ( $this->get_field_name('number_of_posts')); ?>" type="number" min="1" value="<?php echo esc_attr($number_of_posts); ?>">
            </p>
            <?php
        }

        /**
         * Processing widget options on save
         *
         * @param array $new_instance The new options
         * @param array $old_instance The previous options
         */
        public function update($new_instance , $old_instance) {
            // processes widget options to be saved
            $instance                    = $old_instance;
            $instance['categories']           = (!empty($new_instance['categories']) ) ? $new_instance['categories'] : array();
			$instance['title']           = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['number_of_posts'] = (!empty($new_instance['number_of_posts']) ) ? strip_tags($new_instance['number_of_posts']) : '';

            return $instance;
        }

    }

}

//register widget
function listingo_register_listingo_latestposts_widgets() {
	register_widget( 'Listingo_LatestPosts' );
}
add_action( 'widgets_init', 'listingo_register_listingo_latestposts_widgets' );
