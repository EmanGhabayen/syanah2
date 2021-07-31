<?php
/**
 *
 * The template part for displaying the dashboard favourite.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

global $current_user,$paged;

$limit = get_option('posts_per_page');
$wishlist    = get_user_meta($current_user->ID,'wishlist', true);
$wishlist    = !empty($wishlist) && is_array( $wishlist ) ? $wishlist : array();

$total_users = listingo_count_items($wishlist); //Total Users

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$offset = ($paged - 1) * $limit;

$query_args	= array(
				'role__in' => array('professional', 'business'),
				'order' => 'DESC',
				'orderby' => 'ID',
				'include' => $wishlist
			 );

$query_args['number']	= $limit;
$query_args['offset']	= $offset;

$user_query  = new WP_User_Query($query_args);	
				  
if( apply_filters('listingo_is_favorite_allowed',$current_user->ID) === true ){?>
<div id="tg-content" class="tg-content">
  <div class="tg-dashboard">
    <div class="tg-themeform">
        <div class="tg-dashboardbox tg-dashboardfavoritelisting">
          <div class="tg-dashboardtitle">
            <h2><?php esc_html_e('Favorite Listings', 'listingo'); ?></h2>
            <?php if ( ! empty( $wishlist ) ) {?>
            	<button class="tg-btnaddservices remove-wishlist" data-type="all" data-wl_id="none"><?php esc_html_e('Delete All', 'listingo'); ?></button>
            <?php }?>
          </div>
          <div class="tg-dashboardappointmentbox">
          <?php 
			  if ( ! empty( $wishlist ) ) {
				if ( ! empty( $user_query->results ) ) {
				  foreach ( $user_query->results as $user ) {
					  $username = listingo_get_username($user->ID);
					  $directory_type	= $user->directory_type;
					  $avatar = apply_filters(
								'listingo_get_media_filter', 
						  		 listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), 
						  		 array('width' => 92, 'height' => 92)
						);
					   ?>
						<div class="tg-dashboardappointment" id="wishlist-<?php echo intval($user->ID);?>">
						  <div class="tg-servicetitle">
						    <figure> <a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>" class="list-avatar"><img src="<?php echo esc_url( $avatar );?>" alt="<?php echo esc_attr( $directories_array['name'] );?>"></a></figure>
							<div class="tg-clientcontent">
							  <h2><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h2>
							  <?php do_action('sp_get_rating_and_votes', $user->ID); ?>
							</div>
						  </div>
						  <div class="tg-btntimeedit">
							<button class="tg-btndel remove-wishlist"  data-type="single" data-wl_id="<?php echo intval($user->ID); ?>"><i class="lnr lnr-trash"></i></button>
						  </div>
						</div>
					 <?php }
					}
				} else {
					Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('No favorite provider.', 'listingo'));
				}
			?>
          </div>
          <?php if (!empty($total_users) && !empty($limit) && $total_users > $limit) { ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php listingo_prepare_pagination($total_users, $limit); ?>
			</div>
		  <?php } ?>
        </div>
    </div>
  </div>
</div>
<?php 
}