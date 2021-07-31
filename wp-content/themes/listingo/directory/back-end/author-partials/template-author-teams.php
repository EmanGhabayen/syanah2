<?php
/**
 *
 * Author Teams Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $profileuser;

if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$author_profile = $wp_query->get_queried_object();
	
	if (!empty($author_profile->teams_data)) {
    $limit = get_option('posts_per_page');

    if (empty($paged))
        $paged = 1;
		$offset = ($paged - 1) * $limit;
		$teams = $author_profile->teams_data;
		$teams = !empty($teams) && is_array($teams) ? $teams : array();

    ?>
    <div class="tg-companyfeaturebox tg-ourteam">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Our Team', 'listingo'); ?></h3>
        </div>

        <ul class="tg-teammembers">

            <?php
            $total_users = listingo_count_items($teams); //Total Users              
            $query_args = array(
                'role__in' => array('professional', 'business'),
                'order' => 'DESC',
                'orderby' => 'ID',
                'include' => $teams
            );

			$team_query = new WP_User_Query($query_args);
			if (!empty($team_query->results)) {
                foreach ($team_query->results as $user) {
					
                    $user_link = get_author_posts_url($user->ID);
                    $avatar = apply_filters(
                            'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 60, 'height' => 60), $user->ID), array('width' => 60, 'height' => 60) //size width,height
                    );
                    $username = listingo_get_username($user->ID);
                    ?>
                    <li class="tg-verticaltop" data-id="<?php echo esc_attr($user->ID); ?>" id="team-<?php echo esc_attr($user->ID); ?>">
                        <div class="tg-teammember">
                            <?php if (!empty($avatar)) { ?>
                                <figure>
                                    <a href="<?php echo esc_url($user_link); ?>">
                                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Team Member', 'listingo'); ?>">
                                    </a>
                                </figure>
                            <?php } ?>
                            <div class="tg-memberinfo">
                                <?php if (!empty($username)) { ?>
                                    <h5>
                                        <a href="<?php echo esc_url($user_link); ?>"><?php echo esc_attr($username); ?></a>
                                    </h5>
                                    <a href="<?php echo esc_url($user_link); ?>"><?php esc_html_e('View Full Profile', 'listingo'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
<?php }
}