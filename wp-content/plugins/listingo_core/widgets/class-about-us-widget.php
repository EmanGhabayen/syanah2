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
if (!class_exists('Service_AboutUs')) {

    class Service_AboutUs extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            parent::__construct(
                    'Service_AboutUs', // Base ID
                    esc_html__('About us | Listingo', 'listingo_core'), // Name
                    array( 'classname' => 'tg-footercolumn sp-service-about',
						'description' => esc_html__('Listingo about us widget', 'listingo_core'),
					) // Args
            );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args, $instance) { 
            // outputs the content of the widget
            extract($instance);            
            $about_us = isset($instance['about_us']) && !empty($instance['about_us']) ? $instance['about_us'] : '';
            $image_url = isset($instance['image_url']) && !empty($instance['image_url']) ? $instance['image_url'] : '';
            $site_url = isset($instance['site_url']) && !empty($instance['site_url']) ? $instance['site_url'] : '';
            $address = isset($instance['address']) && !empty($instance['address']) ? $instance['address'] : '';            
            $phone = isset($instance['phone']) && !empty($instance['phone']) ? $instance['phone'] : '';
			$fixedphone = isset($instance['fixedphone']) && !empty($instance['fixedphone']) ? $instance['fixedphone'] : '';
            $complaint = isset($instance['fax']) && !empty($instance['fax']) ? $instance['fax'] : '';            
            $email = isset($instance['email']) && !empty($instance['email']) ? $instance['email'] : '';            
			$facebook = isset($instance['facebook']) && !empty($instance['facebook']) ? $instance['facebook'] : '';
			$twitter = isset($instance['twitter']) && !empty($instance['twitter']) ? $instance['twitter'] : '';
			$linkedin = isset($instance['linkedin']) && !empty($instance['linkedin']) ? $instance['linkedin'] : '';
			$google = isset($instance['google']) && !empty($instance['google']) ? $instance['google'] : '';
            $rss = isset($instance['rss']) && !empty($instance['rss']) ? $instance['rss'] : '';
			
            echo ($args['before_widget']);
                        
            ?>
			
    			<?php if( isset( $image_url ) && !empty( $image_url ) ) {?>
    				<strong class="tg-logo">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php echo esc_url( $image_url ) ?>" alt="<?php esc_html_e('Logo','listingo_core');?>">
                        </a>
                    </strong>
    			<?php } ?>
                <?php if( isset( $about_us ) && ( !empty( $about_us ) || !empty( $site_url ) ) ) {?>
    				<div class="tg-description">
    					<p><?php  echo esc_attr($about_us); ?>
                            <?php if ( !empty( $site_url ) ) { ?>
                                <a href="<?php echo esc_url( $site_url ); ?>"><?php esc_html_e('more...', 'listingo_core'); ?></a>
                            <?php } ?>
                        </p>
    				</div>
    			<?php }?>
                <?php if ( !empty( $address ) || !empty( $phone ) || !empty( $fixedphone ) || !empty( $fax ) || !empty( $email ) ) { ?>
                    <ul class="tg-contactinfo">
                        <?php if ( !empty( $address ) ) { ?>
                            <li>
                                <i class="lnr lnr-location"></i>
                                <address><?php echo esc_attr( $address ); ?></address>
                            </li>
                        <?php } ?>
                        <?php if ( !empty( $phone ) ) { ?>
                            <li>
                                <i class="lnr lnr-phone-handset"></i>
                                <span><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_attr( $phone ); ?></a></span>
                            </li>
                        <?php } ?> 
                        <?php if ( !empty( $fixedphone ) ) { ?>
                            <li>
                                <i class="lnr lnr-phone"></i>
                                <span><a href="mailto:<?php echo esc_attr( $fixedphone ); ?>"><?php echo esc_attr( $fixedphone ); ?></a></span>
                            </li>
                        <?php } ?>                        
                        <?php if ( !empty( $email ) ) { ?>
                        <li>                            
                            <i class="lnr lnr-envelope"></i>
                            <span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></span>
                        </li>
                        <?php } ?>
                        <?php if ( !empty( $complaint ) ) { ?>
                            <li>
                                <i class="lnr lnr-construction"></i>            
                                    <span><a href="mailto:<?php echo esc_attr( $complaint ); ?>"><?php echo esc_attr( $complaint ); ?></a></span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php 
    			if( !empty( $facebook ) 
    				||
    				!empty( $twitter ) 
    				||
    				!empty( $linkedin ) 
    				||
    				!empty( $google )  
                    ||
                    !empty( $rss ) 
    			){?>
                <ul class="tg-socialicons">
                    <?php if( !empty( $facebook ) ) { ?>
                        <li class="tg-facebook"><a href="<?php echo esc_url( $facebook ); ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php } ?>
                    <?php if ( !empty( $twitter ) ) { ?>
                        <li class="tg-twitter"><a href="<?php echo esc_url( $twitter );?>"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>
                    <?php if ( !empty( $linkedin ) ) { ?>
                        <li class="tg-linkedin"><a href="<?php echo esc_url( $linkedin );?>"><i class="fa fa-linkedin"></i></a></li>
                    <?php } ?>
                    <?php if ( !empty( $google ) ) { ?>
                        <li class="tg-googleplus"><a href="<?php echo esc_url( $google );?>"><i class="fa fa-google-plus"></i></a></li>
                    <?php } ?>
                    <?php if ( !empty( $rss ) ) { ?>
                        <li class="tg-rss"><a href="<?php echo esc_url( $rss );?>"><i class="fa fa-rss"></i></a></li>
                    <?php } ?>
                </ul>
    			<?php }?>
            <?php
            echo ($args['after_widget']);
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
			$about_us = !empty($instance['about_us']) ? $instance['about_us'] : '';
            $image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
			$site_url = !empty($instance['site_url']) ? $instance['site_url'] : '';
            $address = !empty($instance['address']) ? $instance['address'] : '';
            $phone = !empty($instance['phone']) ? $instance['phone'] : '';
			$fixedphone = !empty($instance['fixedphone']) ? $instance['fixedphone'] : '';
            $fax = !empty($instance['fax']) ? $instance['fax'] : '';
            $email = !empty($instance['email']) ? $instance['email'] : '';
			$facebook = isset($instance['facebook']) && !empty($instance['facebook']) ? $instance['facebook'] : '';
			$twitter = isset($instance['twitter']) && !empty($instance['twitter']) ? $instance['twitter'] : '';
			$linkedin = isset($instance['linkedin']) && !empty($instance['linkedin']) ? $instance['linkedin'] : '';
			$google = isset($instance['google']) && !empty($instance['google']) ? $instance['google'] : '';
            $rss = isset($instance['rss']) && !empty($instance['rss']) ? $instance['rss'] : '';
            
			?>
            <p>
                <label for="<?php echo ( $this->get_field_id('image_url') ); ?>"><?php esc_html_e('Image URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('image_url')); ?>" name="<?php echo ( $this->get_field_name('image_url')); ?>" type="text" value="<?php echo esc_attr($image_url); ?>">
            </p>  
            <p>
                <label for="<?php echo ( $this->get_field_id('about_us') ); ?>"><?php esc_html_e('Description','listingo_core'); ?></label> 
                <textarea class="widefat" id="<?php echo ( $this->get_field_id('about_us')); ?>" name="<?php echo ( $this->get_field_name('about_us')); ?>"><?php echo esc_attr($about_us); ?></textarea>
            </p>           
            <p>
                <label for="<?php echo ( $this->get_field_id('site_url') ); ?>"><?php esc_html_e('Read More URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('site_url')); ?>" name="<?php echo ( $this->get_field_name('site_url')); ?>" type="text" value="<?php echo esc_attr($site_url); ?>">
            </p> 
            <p>
                <label for="<?php echo ( $this->get_field_id('address') ); ?>"><?php esc_html_e('Address:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('address')); ?>" name="<?php echo ( $this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>">
            </p> 
            <p>
                <label for="<?php echo ( $this->get_field_id('phone') ); ?>"><?php esc_html_e('Phone:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('phone')); ?>" name="<?php echo ( $this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>">
            </p> 
            <p>
                <label for="<?php echo ( $this->get_field_id('fixedphone') ); ?>"><?php esc_html_e('Second Phone:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('fixedphone')); ?>" name="<?php echo ( $this->get_field_name('fixedphone')); ?>" type="text" value="<?php echo esc_attr($fixedphone); ?>">
            </p>     
            <p>
                <label for="<?php echo ( $this->get_field_id('email') ); ?>"><?php esc_html_e('Email:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('email')); ?>" name="<?php echo ( $this->get_field_name('email')); ?>" type="email" value="<?php echo esc_attr($email); ?>">
            </p> 
              <p>
                <label for="<?php echo ( $this->get_field_id('fax') ); ?>"><?php esc_html_e('Complaint Email:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('fax')); ?>" name="<?php echo ( $this->get_field_name('fax')); ?>" type="text" value="<?php echo esc_attr($fax); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('facebook')); ?>" name="<?php echo ( $this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($facebook); ?>">
                <span><?php esc_html_e('Leave it empty to hide.','listingo_core'); ?></span>
            </p>  
            <p>
                <label for="<?php echo ( $this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('twitter')); ?>" name="<?php echo ( $this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($twitter); ?>">
                <span><?php esc_html_e('Leave it empty to hide.','listingo_core'); ?></span>
            </p>  
            <p>
                <label for="<?php echo ( $this->get_field_id('linkedin')); ?>"><?php esc_html_e('Linkedin URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('linkedin')); ?>" name="<?php echo ( $this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>">
                <span><?php esc_html_e('Leave it empty to hide.','listingo_core'); ?></span>
            </p>  
            <p>
                <label for="<?php echo ( $this->get_field_id('google')); ?>"><?php esc_html_e('Google Plus URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('google')); ?>" name="<?php echo ( $this->get_field_name('google')); ?>" type="text" value="<?php echo esc_attr($google); ?>">
                <span><?php esc_html_e('Leave it empty to hide.','listingo_core'); ?></span>
            </p>  
            <p>
                <label for="<?php echo ( $this->get_field_id('ss')); ?>"><?php esc_html_e('RSS URL:','listingo_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('rss')); ?>" name="<?php echo ( $this->get_field_name('rss')); ?>" type="text" value="<?php echo esc_attr($rss); ?>">
                <span><?php esc_html_e('Leave it empty to hide.','listingo_core'); ?></span>
            </p>        
            <?php
        }

        /**
         * Processing widget options on save
         *
         * @param array $new_instance The new options
         * @param array $old_instance The previous options
         */
        public function update($new_instance, $old_instance) {
            // processes widget options to be saved
            $instance = $old_instance;
            $instance['about_us'] = (!empty($new_instance['about_us']) ) ? ($new_instance['about_us']) : '';
            $instance['image_url'] = (!empty($new_instance['image_url']) ) ? ($new_instance['image_url']) : '';
            $instance['site_url'] = (!empty($new_instance['site_url']) ) ? ($new_instance['site_url']) : '';
            $instance['address'] = (!empty($new_instance['address']) ) ? ($new_instance['address']) : '';
            $instance['phone'] = (!empty($new_instance['phone']) ) ? ($new_instance['phone']) : '';
			$instance['fixedphone'] = (!empty($new_instance['fixedphone']) ) ? ($new_instance['fixedphone']) : '';
            $instance['fax'] = (!empty($new_instance['fax']) ) ? ($new_instance['fax']) : '';
            $instance['email'] = (!empty($new_instance['email']) ) ? ($new_instance['email']) : '';
			$instance['facebook'] = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
			$instance['twitter'] = (!empty($new_instance['twitter']) ) ? strip_tags($new_instance['twitter']) : '';
			$instance['linkedin'] = (!empty($new_instance['linkedin']) ) ? strip_tags($new_instance['linkedin']) : '';
			$instance['google'] = (!empty($new_instance['google']) ) ? strip_tags($new_instance['google']) : '';
            $instance['rss'] = (!empty($new_instance['rss']) ) ? strip_tags($new_instance['rss']) : '';
            return $instance;
        }

    }

}
//register widget
function listingo_register_service_about_widgets() {
	register_widget( 'Service_AboutUs' );
}
add_action( 'widgets_init', 'listingo_register_service_about_widgets' );
