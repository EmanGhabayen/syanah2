<?php
/**
 *
 * The template part to edit job.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user,
 $wp_roles,
 $userdata;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$career_level 		= apply_filters('listingo_get_career_levels', listingo_get_career_level());
$job_type 			= apply_filters('listingo_get_job_type', listingo_get_job_type());
$experience_years 	= apply_filters('listingo_get_experience_years', 20);

$content = esc_html__('Job detail will be here', 'listingo');
$settings = array('media_buttons' => false,'quicktags' => true);
$edit_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
$post_author = get_post_field('post_author', $edit_id);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboardbox tg-businesshours">
        <?php
        if (intval($url_identity) === intval($post_author)) {
            $args = array('posts_per_page' => '-1',
                'post_type' => 'sp_jobs',
                'orderby' => 'ID',
                'post_status' => 'publish',
                'post__in' => array($edit_id),
                'suppress_filters' => false
            );

            $query = new WP_Query($args);

            while ($query->have_posts()) : $query->the_post();
                global $post;
                $type = fw_get_db_post_option($post->ID, 'job_type', true);
                $salary = fw_get_db_post_option($post->ID, 'salary', true);
                $category = fw_get_db_post_option($post->ID, 'category', true);
                $sub_category = fw_get_db_post_option($post->ID, 'sub_category', true);
                $expirydate = fw_get_db_post_option($post->ID, 'expirydate', true);
                $career = fw_get_db_post_option($post->ID, 'career_level', true);
                $experience = fw_get_db_post_option($post->ID, 'experience', true);
                $type = fw_get_db_post_option($post->ID, 'job_type', true);
                $qualification = fw_get_db_post_option($post->ID, 'qualification', true);
                $job_requirements = fw_get_db_post_option($post->ID, 'requirements', true);
                $languages = fw_get_db_post_option($post->ID, 'languages', true);
                $benifits = fw_get_db_post_option($post->ID, 'benifits', true);

                $profile_address = fw_get_db_post_option($post->ID, 'address', true);
                $latitude = fw_get_db_post_option($post->ID, 'address_latitude', true);
                $longitude = fw_get_db_post_option($post->ID, 'address_longitude', true);
                $phone = fw_get_db_post_option($post->ID, 'phone', true);
                $fax = fw_get_db_post_option($post->ID, 'fax', true);
                $email = fw_get_db_post_option($post->ID, 'email', true);
                $user_url = fw_get_db_post_option($post->ID, 'url', true);

                $category = !empty($category[0]) ? $category[0] : '';
                $sub_category = !empty($sub_category[0]) ? $sub_category[0] : '';
                ?>
                <div class="tg-dashboardtitle">
                    <h2><?php esc_html_e('Edit Job', 'listingo'); ?></h2>
                </div>
                <div class="tg-servicesmodal tg-categoryModal"
                     <div class="tg-modalcontent">
                        <form class="tg-themeform tg-formamanagejobs sp-dashboard-profile-form">
                            <fieldset>
                                <h2><?php esc_html_e('Job Description', 'listingo'); ?></h2>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                        <div class="form-group">
                                            <input type="text" value="<?php the_title(); ?>" name="job[title]" class="form-control" placeholder="<?php esc_html_e('Job Title', 'listingo'); ?>">
                                            <input type="hidden" name="current" value="<?php echo intval($post->ID); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                        <div class="form-group tg-iconinput">
                                            <i class="lnr lnr-calendar-full"></i>
                                            <input type="text" value="<?php echo esc_attr($expirydate); ?>" name="job[expirydate]" class="form-control expirydate" placeholder="<?php esc_html_e('Expire Date', 'listingo'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                        <div class="form-group">
                                            <?php wp_editor(get_the_content(), 'job_detail', $settings); ?> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h2><?php esc_html_e('Job Detail', 'listingo'); ?></h2>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group">
                                            <span class="tg-select">
                                                <select name="job[category]" class="sp-category">
                                                    <option value=""><?php esc_html_e('Select Category', 'listingo'); ?></option>
                                                    <?php listingo_get_categories($category, 'sp_categories'); ?>
                                                </select>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group">
                                            <span class="tg-select">
                                                <select name="job[sub_category]" class="sp-sub-category">
                                                    <option value=""><?php esc_html_e('Select sub category', 'listingo'); ?></option>
                                                    <?php
                                                    $terms = get_the_terms($category, 'sub_category');
                                                    if (!empty($terms)) {
                                                        foreach ($terms as $pterm) {
                                                            $selected = intval($pterm->term_id) === intval($sub_category) ? 'selected' : '';
                                                            echo '<option ' . $selected . ' value="' . $pterm->slug . '">' . $pterm->name . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group tg-inputborder">
                                            <div class="tg-select tg-career">
                                                <select name="job[career_level]">
                                                    <option value=""><?php esc_html_e('Choose career level', 'listingo'); ?></option>
                                                    <?php
                                                    foreach ($career_level as $key => $value) {
                                                        $selected = $key === $career ? 'selected' : '';
                                                        ?>
                                                        <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group tg-inputborder">
                                            <div class="tg-select tg-experience">
                                                <select name="job[experience]">
                                                    <option value="fresh"><?php esc_html_e('Fresh', 'listingo'); ?></option>
                                                    <?php
                                                    for ($i = 1; $i <= $experience_years; $i++) {
                                                        $selected = intval($i) . '-year' === $experience ? 'selected' : '';
                                                        ?>
                                                        <option <?php echo esc_attr($selected); ?> value="<?php echo intval($i); ?>-year"><?php echo intval($i); ?> - <?php esc_html_e('Year', 'listingo'); ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group tg-inputborder">
                                            <input type="text" value="<?php echo esc_attr($salary); ?>" name="job[salary]" class="form-control" placeholder="<?php esc_html_e('Add salary/cost', 'listingo'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group tg-inputborder">
                                            <div class="tg-select tg-jobtype">
                                                <select name="job[job_type]">
                                                    <option value=""><?php esc_html_e('Job Type', 'listingo'); ?></option>
                                                    <?php
                                                    foreach ($job_type as $key => $value) {
                                                        $selected = $key === $type ? 'selected' : '';
                                                        ?>
                                                        <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                        <div class="form-group tg-inputborder">
                                            <input type="text" value="<?php echo esc_attr($qualification); ?>" name="job[qualification]" class="form-control" placeholder="<?php esc_html_e('What minimum qualification is required?', 'listingo'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left tg-columnpadding">
                                        <div class="tg-dashboardbox tg-languages">
                                            <h2><?php esc_html_e('Languages', 'listingo'); ?></h2>
                                            <div class="tg-languagesbox">
                                                <div class="form-group">
                                                    <span class="tg-select">
                                                        <select name="languages_data" class="sp-language-select">
                                                            <option value=""><?php esc_html_e('Select Language', 'listingo'); ?></option>
                                                            <?php listingo_get_term_options('', 'languages'); ?>
                                                        </select>
                                                    </span>
                                                    <button class="tg-btn add_profie_language" type="button"><?php esc_html_e('Add Now', 'listingo'); ?></button>
                                                </div>
                                                <ul class="tg-tagdashboardlist sp-languages-wrap">
                                                    <?php
                                                    if (!empty($languages)) {
                                                        foreach ($languages as $key => $value) {
                                                            $language = get_term_by('term_id', $value, 'languages');
                                                            if (!empty($language->term_id)) {
                                                                ?>
                                                                <li data-language-key="punjabi">
                                                                    <span class="tg-tagdashboard">
                                                                        <i class="fa fa-close delete_profile_lang"></i>
                                                                        <em><?php echo esc_attr($language->name); ?></em>
                                                                    </span>
                                                                    <input type="hidden" name="languages[]" value="<?php echo esc_attr($language->slug); ?>">
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h2><?php esc_html_e('Job Requirement', 'listingo'); ?></h2>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-right">
                                        <div class="form-group">
                                            <?php wp_editor($job_requirements, 'job_requirements', $settings); ?> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h2><?php esc_html_e('Benefits / Allowances', 'listingo'); ?></h2>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-right">
                                        <div class="tg-addallowances">
                                            <div class="tg-addallowance">
                                                <div class="form-group">
                                                    <input type="text" name="allowances" class="form-control input-feature" placeholder="<?php esc_html_e('Benefits / Allowances', 'listingo'); ?>">
                                                    <a class="tg-btn add-features" href="javascript:;"><?php esc_html_e('Add Now', 'listingo'); ?></a>
                                                </div>
                                                <ul class="tg-tagdashboardlist sp-feature-wrap">
                                                    <?php
                                                    if (!empty($benifits)) {
                                                        foreach ($benifits as $key => $value) {
                                                            ?>
                                                            <li>
                                                                <span class="tg-tagdashboard">
                                                                    <i class="fa fa-close delete_benifit"></i>
                                                                    <em><?php echo esc_attr($value); ?></em>
                                                                </span>
                                                                <input type="hidden" name="benifits[]" value="<?php echo esc_attr($value); ?>">
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="tg-dashboardbox tg-location">
                                    <div class="tg-dashboardtitle">
                                        <h2><?php esc_html_e('Location', 'listingo'); ?></h2>
                                    </div>
                                    <div class="tg-locationbox">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                                <div class="form-group">
                                                    <input type="text" name="location[phone]" value="<?php echo esc_attr($phone); ?>" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                                <div class="form-group">
                                                    <input type="text" name="location[fax]" value="<?php echo esc_attr($fax); ?>" class="form-control" placeholder="<?php esc_html_e('Fax', 'listingo'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                                <div class="form-group">
                                                    <input type="email" name="location[email]" value="<?php echo esc_attr($email); ?>" class="form-control" placeholder="<?php esc_html_e('Email', 'listingo'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                                <div class="form-group">
                                                    <input type="text" name="location[url]" value="<?php echo esc_attr($user_url); ?>" class="form-control" placeholder="<?php esc_html_e('URL', 'listingo'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                                <div class="form-group locate-me-wrap">
                                                    <input type="text" value="<?php echo esc_attr($profile_address); ?>" name="location[address]" class="form-control" id="location-address" />
                                                    <a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                                <div class="form-group">
                                                    <input type="text" value="<?php echo esc_attr($longitude); ?>" placeholder="<?php esc_html_e('Longitude', 'listingo'); ?>" name="location[longitude]" class="form-control" id="location-longitude" />
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                                <div class="form-group">
                                                    <input type="text" placeholder="<?php esc_html_e('Latitude', 'listingo'); ?>" value="<?php echo esc_attr($latitude); ?>" name="location[latitude]" class="form-control" id="location-latitude" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
                                                <div class="form-group">
                                                    <div id="location-pickr-map"></div>
                                                </div>
                                            </div>
                                            <?php
                                            $script = "jQuery(document).ready(function (e) {
                                                jQuery.listingo_init_map(" . esc_js($latitude) . "," . esc_js($longitude) . ");
                                            });";
                                            wp_add_inline_script('listingo_maps', $script, 'after');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div id="tg-updateall" class="tg-updateall">
                                    <div class="tg-holder">
                                        <span class="tg-note"><?php esc_html_e('Click to','listingo'); ?> <strong> <?php esc_html_e('Update job button', 'listingo'); ?> </strong> <?php esc_html_e('to add the job.','listingo'); ?></span>
                                        <?php wp_nonce_field('listingo_job_nounce', 'listingo_job_nounce'); ?>
                                        <a class="tg-btn process-job" data-type="update" href="javascript:;"><?php esc_html_e('Update Job', 'listingo'); ?></a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        } else {
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-right">
                <?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('You have not any privilege to view this page.', 'listingo')); ?>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/template" id="tmpl-load-profile-languages">
    <li data-language-key="{{data.lang_key}}">
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_profile_lang"></i>
    <em>{{data.lang_val}}</em>
    </span>
    <input type="hidden" name="languages[]" value="{{data.lang_key}}">
    </li>
</script>
<script type="text/template" id="tmpl-load-job-features">
    <li>
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_benifit"></i>
    <em>{{data}}</em>
    </span>
    <input type="hidden" name="benifits[]" value="{{data}}">
    </li>
</script>