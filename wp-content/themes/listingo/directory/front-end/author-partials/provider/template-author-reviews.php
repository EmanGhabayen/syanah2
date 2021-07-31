<?php
/**
 *
 * Author List Reviews Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $paged;

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$show_posts = 4;

//Get User Queried Object Data
$author_profile = $wp_query->get_queried_object();

//Get The Category Type
$category_type = $author_profile->category;

/* Get the total wait time. */
$total_time = listingo_get_reviews_evaluation($category_type, 'total_wait_time');
/* Get the rating headings */
$rating_titles = listingo_get_reviews_evaluation($category_type, 'leave_rating');

/**
 * @Prepare Reviews Data
 * @Get Total Reviews
 * @Get Reviews Loop Data
 */
$meta_query_args = array('relation' => 'AND');
$meta_query_args[] = array(
    'key' => 'user_to',
    'value' => $author_profile->ID,
    'compare' => '=',
    'type' => 'NUMERIC'
);

$query_args = array('posts_per_page' => -1,
    'post_type' => 'sp_reviews',
    'post_status' => 'publish',
    'order' => 'ASC'
);

$query_args['meta_query'] = $meta_query_args;

$query = new WP_Query($query_args);

$total_reviews = $query->post_count;

$total_reviews_text = esc_html__('Reviews', 'listingo');
$review_heading = sprintf("%u %s", $total_reviews, $total_reviews_text);

$query_args1 = array(
    'posts_per_page' => $show_posts,
    'post_type' => 'sp_reviews',
    'paged' => $paged,
    'order' => 'ASC',
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

$query_args1['meta_query'] = $meta_query_args;
$review_query = new WP_Query($query_args1);
?>
<div class="tg-companyfeaturebox tg-reviews">
    <div class="tg-companyfeaturetitle">
        <h3><?php echo esc_attr($review_heading); ?></h3>
    </div>
    <div class="tg-feedbacks review-wrap">
        <?php
        if ($review_query->have_posts()) {

            while ($review_query->have_posts()) {
                $review_query->the_post();
                global $post;
                $post_author = $post->post_author;
                $reviewer_name = listingo_get_username($post_author);
				$review_wait_time = get_post_meta($post->ID, 'review_wait_time', true);
				$category_type = get_post_meta($post->ID, 'category_type', true);
				$total_time = listingo_get_reviews_evaluation($category_type, 'total_wait_time');
				
                /**
                 * Count user total rating
                 * with individual rating plus.
                 */
                $count_indivi_rating = 0;
                if (!empty($rating_titles)) {
                    foreach ($rating_titles as $key => $value) {
                        $indivi_rating = get_post_meta($post->ID, $key, true);
						if( !empty( $indivi_rating )){
							$count_indivi_rating += $indivi_rating;
						}  
                    }
                }
				
				if( $count_indivi_rating > 0 ){
					 $total_ratings = ($count_indivi_rating / listingo_count_items($rating_titles)) * intval(20);
				} else{
					$total_ratings = 0;
				}
 
                $review_date = get_the_date('Y-m-d h:i:s');
                $avatar = apply_filters(
                        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $post_author), array('width' => 100, 'height' => 100)
                );
				
				$review_time	= '';
				if( !empty( $total_time[$review_wait_time] ) ){
					$review_time	= '<li class="wait-time-wrap"><span class="sp-review-time">'.esc_html__('Wait Time', 'listingo').'</span><span class="sp-review-val">'.esc_attr($total_time[$review_wait_time]).'</span></li>';
				}
				
				if( ( apply_filters('listingo_get_user_type', $post_author) === 'business' 
						  || apply_filters('listingo_get_user_type', $post_author) === 'professional' )
						  && function_exists('fw_get_db_settings_option') 
				) {
					$author_url	= get_author_posts_url($post_author);
				} else{
					$author_url	= 'javascript:;';
				}
                ?>
                <div class="tg-feedback" style="display:block;">
                    <figure>
                        <a href="<?php echo esc_attr($author_url); ?>">
                            <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Reviewer', 'listingo'); ?>">
                        </a>
                    </figure>
                    <div class="tg-feedbackcontent">
                        <div class="tg-feedbackbox">
                            <div class="tg-contenthead">
                                <div class="tg-leftbox">
                                    <div class="tg-name">
                                        <h4><a href="javascript:;"><?php echo get_the_title(); ?></a></h4>
                                    </div>
                                    <ul class="tg-matadata">
                                        <li> <a href="<?php echo esc_attr($author_url); ?>"><?php echo esc_attr($reviewer_name); ?></a></li>
                                        <li>
                                            <a href="javascript:;">
                                               <?php printf( _x( '%s Ago', '%s = human-readable time difference', 'listingo' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tg-overallratingbox">
                                    <span class="tg-stars">
                                        <span style="width:<?php echo esc_attr($total_ratings); ?>%;"></span>
                                    </span>
                                    <div class="tg-overallratingarea">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <?php if (!empty($rating_titles)) { ?>
                                            <div class="tg-overallrating">
                                                <?php if (!empty($rating_titles)) { ?>
                                                    <ul class="tg-servicesrating">
                                                       <?php echo force_balance_tags( $review_time );?>
                                                        <?php
                                                        foreach ($rating_titles as $key => $rating) {
                                                            $individual_rating = get_post_meta($post->ID, $key, true);
															$indivi_rating_total = 0;
															if( !empty( $individual_rating )){
                                                            	$indivi_rating_total = ($individual_rating / intval(5)) * intval(100);
															}
                                                            ?>
                                                            <li>
                                                                <span class="tg-stars">
                                                                    <span style="width:<?php echo esc_attr($indivi_rating_total); ?>%;"></span>
                                                                </span>
                                                                <em><?php echo esc_attr($rating); ?></em>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                            <div class="tg-description">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } wp_reset_postdata(); ?>
            <?php
        } else {
            Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('No Reviews Found.', 'listingo'));
        }
        ?>
    </div>

    <?php if (( isset($total_reviews) && isset($show_posts) ) && $total_reviews > $show_posts) { ?>
        <div class="tg-btnarea">
            <div class="loadmore-ads"><a data-id="<?php echo esc_attr( $author_profile->ID );?>" class="loadmore-reviews" href="javascript:;"><?php esc_html_e('Load More', 'listingo');?></a></div>
        </div>
    <?php } ?>
</div>