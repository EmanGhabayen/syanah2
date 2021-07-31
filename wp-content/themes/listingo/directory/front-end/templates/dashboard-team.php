<?php
/**
 *
 * The template part for displaying the dashboard team.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $current_user;
get_header();
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboardmanageteams">
        <form class="tg-themeform">
            <fieldset>
                <div class="tg-dashboardbox tg-manageteam tg-ourteam">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Manage Team', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','teams');?></h2>
                        <span><?php esc_html_e('Not in List?', 'listingo'); ?> <a href="javascript:;" data-toggle="modal" data-target=".tg-categoryModal"><?php esc_html_e('Send Invitation Now', 'listingo'); ?></a></span> </div>
                    <div class="tg-manageteambox">
                        <div class="form-group search-input-wrap">
                            <input type="search" name="searchmember" class="form-control get_users_list" placeholder="<?php esc_html_e('Search member via email id or username', 'listingo'); ?>">
                        </div>
                        <ul class="tg-teammembers tg-teammembers-wrap">
                            <?php
                            $limit = 30;
                            if (empty($paged))
                                $paged = 1;
                            $offset = ($paged - 1) * $limit;
                            $teams = get_user_meta($current_user->ID, 'teams_data', true);
                            $teams = !empty($teams) && is_array($teams) ? $teams : array();

                            $total_users = listingo_count_items($teams); //Total Users


                            $query_args = array(
                                'role__in' => array('professional', 'business'),
                                'order' => 'DESC',
                                'orderby' => 'ID',
                                'include' => $teams
                            );

                            $query_args['number'] = $limit;
                            $query_args['offset'] = $offset;

                            $user_query = new WP_User_Query($query_args);
                            if (!empty($teams)) {
                                if (!empty($user_query->results)) {
                                    foreach ($user_query->results as $user) {

                                        $user_link = get_author_posts_url($user->ID);
                                        $username = listingo_get_username($user->ID);
                                        $user_email = $user->user_email;
                                        $avatar = apply_filters(
                                                'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $user->ID), array('width' => 100, 'height' => 100)
                                        );
                                        ?>
                                        <li data-id="<?php echo esc_attr($user->ID); ?>" id="team-<?php echo esc_attr($user->ID); ?>">
                                            <div class="tg-teammember">
                                                <a class="tg-btndel remove-team-member" href="javascript:;"><i class="fa fa-close"></i></a>
                                                <figure><a href="<?php echo esc_url($user_link); ?>"><img width="60" height="60" src="<?php echo esc_url($avatar); ?>"></a></figure>
                                                <div class="tg-memberinfo">
                                                    <h5><a href="<?php echo esc_url($user_link); ?>"><?php echo esc_attr($username); ?></a></h5>
                                                    <a href="<?php echo esc_url($user_link); ?>"><?php esc_html_e('View Full Profile', 'listingo'); ?></a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class="no-team-item"><div class="tg-list"><p><?php esc_html_e('No team members, Add your teams now.', 'listingo'); ?></p></div></li>
                                <?php } ?>
                            <?php } else { ?>
                                <li class="no-team-item"><div class="tg-list"><p><?php esc_html_e('No team members, Add your teams now.', 'listingo'); ?></p></div></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="modal fade tg-modalmanageteam tg-categoryModal" tabindex="-1">
    <div class="modal-dialog tg-modaldialog" role="document">
        <div class="modal-content tg-modalcontent">
            <div class="tg-modalhead">
                <h2><?php esc_html_e('Invite New User', 'listingo'); ?></h2>
            </div>
            <div class="tg-modalbody">
                <form class="tg-themeform user-invitation-form">
                    <fieldset>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="<?php esc_html_e('Add email address', 'listingo'); ?>">
                        </div>
                        <textarea name="message" placeholder="<?php esc_html_e('Invitation message', 'listingo'); ?>"></textarea>
                    </fieldset>
                </form>
            </div>
            <div class="tg-modalfoot">
                <a href="javascript:;" class="tg-btn invite-users" type="submit"><?php esc_html_e('Invite Now', 'listingo'); ?></a>
            </div>
        </div>
    </div>
</div>

