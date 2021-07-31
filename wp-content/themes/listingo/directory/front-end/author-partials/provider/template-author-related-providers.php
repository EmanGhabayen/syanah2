<?php
/**
 *
 * Author Related Providers Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $current_user;
//Get User Queried Object Data
$author_profile = $wp_query->get_queried_object();

//Get The Category Type
$category = $author_profile->category;

$meta_query_args = array('relation' => 'AND');
$meta_query_args[] = array(
    'key' => 'category',
    'value' => $category,
    'compare' => '=',
    'type' => 'NUMERIC'
);

$args = array(
    'role__in' => array('professional', 'business'),
    'exclude' => array($current_user->ID, $author_profile->ID),
    'order' => 'ASC',
    'number' => 5,
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

$args['meta_query'] = $meta_query_args;
$author_query = new WP_User_Query($args);
$author_data = $author_query->get_results();

if (!empty($author_data)) {
    ?>
    <div class="tg-widget tg-widgetrelatedposts" id="section-related">
        <div class="tg-widgettitle">
            <h3><?php esc_html_e('Related Providers', 'listingo'); ?></h3>
        </div>
        <div class="tg-widgetcontent">
            <ul>
                <?php
                foreach ($author_data as $providers) {
                    $author_id = $providers->ID;
                    $company_name = listingo_get_username($author_id);
                    $author_avatar = apply_filters(
                            'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 70, 'height' => 70), $author_id), array('width' => 100, 'height' => 100) //size width,height
                    );
                    ?>
                    <li>
                        <div class="tg-serviceprovidercontent">
                            <?php if (!empty($author_avatar)) { ?>
                                <div class="tg-companylogo">
                                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php esc_html_e('Related', 'listingo'); ?>">
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="tg-companycontent">
                                <?php if (!empty($company_name)) { ?>
                                    <div class="tg-title">
                                        <h3>
                                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                                <?php echo esc_attr($company_name); ?>
                                            </a>
                                        </h3>
                                    </div>
                                <?php } ?>
                                <?php do_action('sp_get_rating_and_votes', $author_id, 'echo'); ?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
