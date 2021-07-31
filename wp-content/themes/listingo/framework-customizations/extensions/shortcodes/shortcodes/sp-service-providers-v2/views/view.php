<?php
if (!defined('FW'))
    die('Forbidden');

global $paged;

$per_page = intval(8);
if (!empty($atts['show_posts'])) {
    $per_page = $atts['show_posts'];
}

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$limit = (int) $per_page;

$meta_query_args = array();
$query_args = array(
    'role__in' => array('professional', 'business'),
    'order' => 'DESC',
    'orderby' => 'ID',
);

//Verify user
$meta_query_args[] = array(
    'key' => 'verify_user',
    'value' => 'on',
    'compare' => '='
);
//active users filter
$meta_query_args[] = array(
    'key' => 'activation_status',
    'value' => 'active',
    'compare' => '='
);

if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

if (!empty($atts['show_pagination']) && $atts['show_pagination'] === 'yes') {
    $offset = ($paged - 1) * $limit;
} else {
    $offset = 0;
}

$query_args['number'] = $limit;
$query_args['offset'] = $offset;

$user_query = new WP_User_Query($query_args);
$total_users = $user_query->total_users;
?>
<div class="sp-sc-latest sp-featured-providers-v2 tg-haslayout spv4-listing">
   <div class="tg-featuredproviders tg-listview">
		<?php if (!empty($atts['heading']) || !empty($atts['sub_heading'])) { ?>
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
				<div class="tg-sectionheadvtwo">
					<div class="tg-sectiontitle">
						<?php if (!empty($atts['heading'])) { ?><span><?php echo esc_attr($atts['heading']); ?></span><?php } ?>
						<?php if (!empty($atts['sub_heading'])) { ?><h2><?php echo esc_attr($atts['sub_heading']); ?></h2><?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="tg-featuredproviders">
			<div class="row">
				<?php
				if (!empty($user_query->results)) {
					foreach ($user_query->results as $user) {
						$username = listingo_get_username($user->ID);
						$category = get_user_meta($user->ID, 'category', true);
						$avatar = apply_filters(
								'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 92, 'height' => 92), $user->ID), array('width' => 92, 'height' => 92)
						);
						?>
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
							<div class="tg-featuredad">
								<?php do_action('listingo_result_avatar_v2', $user->ID, '', array('width' => 275, 'height' => 152)); ?>
								<div class="tg-featuredetails">
									<?php do_action('listingo_result_tags_v2', $user->ID); ?>
									<div class="tg-title">
										<h2><a href="<?php echo esc_url(get_author_posts_url($user->ID)); ?>"><?php echo esc_attr($username); ?></a></h2>
									</div>
									<?php do_action('sp_get_rating_and_votes', $user->ID); ?>
								</div>
								<ul class="tg-phonelike">
									<?php do_action('listingo_get_user_meta', 'phone', $user); ?>
									<?php do_action('listingo_add_to_wishlist', $user->ID); ?>
								</ul>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php if (!empty($total_users) && !empty($limit) && $total_users > $limit && isset($atts['show_pagination']) && $atts['show_pagination'] == 'yes') { ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php listingo_prepare_pagination($total_users, $limit); ?>
			</div>
		<?php } ?>
	</div>
</div>