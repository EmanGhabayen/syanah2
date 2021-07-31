<?php
/**
 *
 * The template part to add new jobs.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user;

$user_identity = $current_user->ID;
$profile_latitude = '';
$profile_longitude = '';
$job_limit = 0;
if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
	$job_limit 	  = fw_get_db_settings_option('job_limit');
    $profile_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $profile_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
	
	$profile_longitude	= !empty( $current_user->longitude ) ? $current_user->longitude : $profile_longitude;
	$profile_latitude	= !empty( $current_user->latitude ) ? $current_user->latitude : $profile_latitude;
	
}

$job_limit = !empty( $job_limit ) ? $job_limit  : 0;

$career_level 		= apply_filters('listingo_get_career_levels', listingo_get_career_level());
$job_type 			= apply_filters('listingo_get_job_type', listingo_get_job_type());
$experience_years 	= apply_filters('listingo_get_experience_years', 20);
$remaining_jobs 	= listingo_get_subscription_meta('subscription_jobs', $user_identity);
$remaining_jobs		= !empty( $remaining_jobs ) ? $remaining_jobs : 0; 
$remaining_jobs 	= $remaining_jobs + $job_limit; //total in package and one free
$content 			= esc_html__('Job detail will be here', 'listingo');
$settings 			= array('media_buttons' => false,'quicktags' => true);

$args = array('posts_per_page' => '-1',
    'post_type' 		=> 'sp_jobs',
    'orderby' 			=> 'ID',
    'post_status' 		=> 'publish',
    'author' 			=> $user_identity,
    'suppress_filters'  => false
);
$query = new WP_Query($args);
$posted_jobs = $query->post_count;
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboardbox tg-businesshours">
        <div class="tg-dashboardtitle">
            <h2><?php esc_html_e('Post A Job', 'listingo'); ?></h2>
        </div>
        <?php if (isset($remaining_jobs) && $remaining_jobs > $posted_jobs) { ?>
            <div class="tg-servicesmodal tg-categoryModal">
                <div class="tg-modalcontent">
                    <form class="tg-themeform tg-formamanagejobs sp-dashboard-profile-form">
                        <fieldset>
                            <h2><?php esc_html_e('Job Description', 'listingo'); ?></h2>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                    <div class="form-group">
                                        <input type="text" name="job[title]" class="form-control" placeholder="<?php esc_html_e('Job Title', 'listingo'); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                    <div class="form-group tg-iconinput">
                                        <i class="lnr lnr-calendar-full"></i>
                                        <input type="text" name="job[expirydate]" class="form-control expirydate" placeholder="<?php esc_html_e('Expire Date', 'listingo'); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                    <div class="form-group">
                                        <?php wp_editor($content, 'job_detail', $settings); ?> 
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
                                                <?php listingo_get_categories('', 'sp_categories'); ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                    <div class="form-group">
                                        <span class="tg-select">
                                            <select name="job[sub_category]" class="sp-sub-category">
                                                <option value=""><?php esc_html_e('Select Sub Category', 'listingo'); ?></option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                    <div class="form-group tg-inputborder">
                                        <div class="tg-select tg-career">
                                            <select name="job[career_level]">
                                                <option value=""><?php esc_html_e('Choose career level', 'listingo'); ?></option>
                                                <?php foreach ($career_level as $key => $value) { ?>
                                                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
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
                                                <?php for ($i = 1; $i <= $experience_years; $i++) { ?>
                                                    <option value="<?php echo intval($i); ?>-year"><?php echo intval($i); ?> - <?php esc_html_e('Year', 'listingo'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                    <div class="form-group tg-inputborder">
                                        <input type="text" name="job[salary]" class="form-control" placeholder="<?php esc_html_e('Add salary/cost', 'listingo'); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                    <div class="form-group tg-inputborder">
                                        <div class="tg-select tg-jobtype">
                                            <select name="job[job_type]">
                                                <option value=""><?php esc_html_e('Job Type', 'listingo'); ?></option>
                                                <?php foreach ($job_type as $key => $value) { ?>
                                                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left tg-columnpadding">
                                    <div class="form-group tg-inputborder">
                                        <input type="text" name="job[qualification]" class="form-control" placeholder="<?php esc_html_e('What minimum qualification is required?', 'listingo'); ?>">
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
                                                        <?php $languages = listingo_get_term_options('', 'languages'); ?>
                                                    </select>
                                                </span>
                                                <button class="tg-btn add_profie_language" type="button"><?php esc_html_e('Add Now', 'listingo'); ?></button>
                                            </div>
                                            <ul class="tg-tagdashboardlist sp-languages-wrap">

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
                                        <?php wp_editor($content, 'job_requirements', $settings); ?> 
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
                                                <input type="text" value="<?php echo esc_attr( $current_user->phone );?>" name="location[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                            <div class="form-group">
                                                <input type="text" value="<?php echo esc_attr( $current_user->fax );?>" name="location[fax]" class="form-control" placeholder="<?php esc_html_e('Fax', 'listingo'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                            <div class="form-group">
                                                <input type="email" value="<?php echo esc_attr( $current_user->user_email );?>" name="location[email]" class="form-control" placeholder="<?php esc_html_e('Email', 'listingo'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                                            <div class="form-group">
                                                <input type="text" value="<?php echo esc_attr( $current_user->user_url );?>" name="location[url]" class="form-control" placeholder="<?php esc_html_e('URL', 'listingo'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                            <div class="form-group locate-me-wrap">
                                                <input type="text"  value="<?php echo esc_attr( $current_user->address );?>" name="location[address]" class="form-control" id="location-address" />
                                                <a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                            <div class="form-group">
                                                <input type="text" value="<?php echo esc_attr($profile_longitude); ?>" placeholder="<?php esc_html_e('Longitude', 'listingo'); ?>" name="location[longitude]" class="form-control" id="location-longitude" />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                            <div class="form-group">
                                                <input type="text" placeholder="<?php esc_html_e('Latitude', 'listingo'); ?>" value="<?php echo esc_attr($profile_latitude); ?>" name="location[latitude]" class="form-control" id="location-latitude" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <div id="location-pickr-map"></div>
                                            </div>
                                        </div>
                                        <?php
											$script = "jQuery(document).ready(function (e) {
												jQuery.listingo_init_map(" . esc_js($profile_latitude) . "," . esc_js($profile_longitude) . ");
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
                                    <span class="tg-note"><?php esc_html_e('Click to', 'listingo'); ?> <strong> <?php esc_html_e('Add Now Button', 'listingo'); ?> </strong> <?php esc_html_e('to add the job.', 'listingo'); ?></span>
                                    <?php wp_nonce_field('listingo_job_nounce', 'listingo_job_nounce'); ?>
                                    <a class="tg-btn process-job" data-type="add" href="javascript:;"><?php esc_html_e('Add Job', 'listingo'); ?></a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="tg-dashboardappointmentbox">
                <?php Listingo_Prepare_Notification::listingo_info(esc_html__('Oops', 'listingo'), esc_html__('Please upgrade your package to add jobs.', 'listingo')); ?>
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