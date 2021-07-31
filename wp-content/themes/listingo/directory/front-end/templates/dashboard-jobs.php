<?php
/**
 *
 * The template part for displaying the dashboard jobs.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user,
 $wp_roles,
 $userdata,
 $paged;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
    $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$get_username = listingo_get_username($url_identity);
$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
$show_posts = get_option('posts_per_page') ? get_option('posts_per_page') : '2';

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$order = 'DESC';
if (!empty($_GET['order'])) {
    $order = esc_attr($_GET['order']);
}

$sorting = 'ID';
if (!empty($_GET['sort'])) {
    $sorting = esc_attr($_GET['sort']);
}

$args = array('posts_per_page' => '-1',
    'post_type' => 'sp_jobs',
    'orderby' => 'ID',
    'post_status' => 'publish',
    'author' => $url_identity,
    'suppress_filters' => false
);

$query = new WP_Query($args);
$count_post = $query->post_count;

$args = array('posts_per_page' => $show_posts,
    'post_type' => 'sp_jobs',
    'orderby' => $sorting,
    'order' => $order,
    'post_status' => 'publish',
    'author' => $url_identity,
    'paged' => $paged,
    'suppress_filters' => false
);

$query = new WP_Query($args);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Manage Jobs', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','jobs');?></h2>
            </div>
            <div class="tg-btnaddservices">
                <a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $url_identity, '', 'add'); ?>"><?php esc_html_e('Add New Job', 'listingo'); ?></a>
            </div>
        </div>
        <?php if ($query->have_posts()) { ?>
            <div class="tg-sortfilters">
                <form class="form-sort-jobs" method="get" action="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $url_identity, '', 'listing'); ?>">
                    <div class="tg-sortfilter tg-sortby">
                        <div class="tg-select">
                            <select name="sort" class="sort_by">
                                <option value="ID" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'ID' ? 'selected' : ''; ?>><?php esc_html_e('Laest jobs at top', 'listingo'); ?></option>
                                <option value="title" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e('Order by title', 'listingo'); ?></option>
                                <option value="name" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'selected' : ''; ?>><?php esc_html_e('Order by job name', 'listingo'); ?></option>
                                <option value="date" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'selected' : ''; ?>><?php esc_html_e('Order by date', 'listingo'); ?></option>
                                <option value="rand" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'rand' ? 'selected' : ''; ?>><?php esc_html_e('Random order', 'listingo'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="tg-sortfilter tg-arrange">
                        <div class="tg-select">
                            <select name="order" class="order_by">
                                <option value="DESC" <?php echo isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e('DESC', 'listingo'); ?></option>
                                <option value="ASC" <?php echo isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e('ASC', 'listingo'); ?></option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="" value="jobs" name="ref">
                    <input type="hidden" class="" value="listing" name="mode">
                    <input type="hidden" class="" value="<?php echo intval($url_identity); ?>" name="identity">
                </form>
            </div>
            <table class="tg-tablejoblidting job-listing-wrap">
                <tbody>
                    <?php
                    $today = time();
                    $job_type = apply_filters('listingo_get_job_type', listingo_get_job_type());
                    while ($query->have_posts()) : $query->the_post();
                        global $post;
                        $type = fw_get_db_post_option($post->ID, 'job_type', true);
                        $salary = fw_get_db_post_option($post->ID, 'salary', true);
                        $category = fw_get_db_post_option($post->ID, 'category', true);
                        $expirydate = fw_get_db_post_option($post->ID, 'expirydate', true);
                        $expiry = esc_html__('Expired', 'listingo');
                        if (!empty($expirydate) && strtotime($expirydate) > $today) {
                            $expiry = date(get_option('time_format'), strtotime($expirydate));
                        }
                        ?>
                        <tr>
                            <td>
                                <figure class="tg-companylogo">
                                    <a class="tg-btnedite" href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $url_identity, '', 'edit', $post->ID); ?>"><i class="lnr lnr-pencil"></i></a>
                                    <a class="tg-btnedite btn-job-del" data-key="<?php echo intval($post->ID); ?>"><i class="lnr lnr-trash"></i></a>
                                </figure>
                                <div class="tg-contentbox"> 
                                    <?php if (!empty($job_type[$type])) { ?>
                                        <a class="tg-tag tg-featuredtag" href="javascript:;"><?php echo esc_attr($job_type[$type]); ?></a>
                                    <?php } ?>
                                    <div class="tg-title">
                                        <h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                    <span><?php esc_html_e('By', 'listingo'); ?>:&nbsp;<?php echo esc_attr($get_username); ?></span> 
                                </div>
                            </td>
                            <td><?php if (!empty($category[0])) { ?><span><?php echo get_the_title($category[0]); ?></span><?php } ?></td>
                            <td><span><?php echo esc_attr($expiry); ?></span></td>
                            <td><?php if (!empty($salary)) { ?><span><?php echo esc_attr($salary); ?></span><?php } ?></td>
                        </tr>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </tbody>
            </table>
            <?php
            if (!empty($count_post) && $count_post > $show_posts) {
                listingo_prepare_pagination($count_post, $show_posts);
            }
            ?>
        <?php }else{ ?>
        	<div class="tg-dashboardappointmentbox">
				<?php Listingo_Prepare_Notification::listingo_info(esc_html__('Information', 'listingo'), esc_html__('No jobs added.', 'listingo')); ?>
			</div>
		<?php }?>
    </div>
</div>