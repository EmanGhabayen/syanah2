<?php
/**
 *
 * The template used for displaying default post style
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $current_user, $wp_query;
$user_id = $current_user->ID;
$user_info  = get_userdata( $user_id );
if ( $user_info !== false ){
    $user_email = $user_info->user_email;
    $user_cell  = $user_info->phone;
    $user_address  = $user_info->address;
    $user_name = listingo_get_username($user_info->ID); 

} else {  
    $user_email = '';
    $user_cell  = '';
    $user_address  = '';
    $user_name  = '';
}

$post_obj = $wp_query->get_queried_object();
do_action('sp_set_profile_views', $post_obj->ID, 'set_job_view');

get_header();

$apply_job = '';
if (function_exists('fw_get_db_settings_option')) {
	$apply_job = fw_get_db_settings_option('apply_job');
	$more_less = fw_get_db_settings_option('more_less');
}

if( isset( $apply_job ) && $apply_job === 'restrict' ){
	$auth_page	= listingo_get_login_registration_page_uri();
}
?>

<div class="tg-detailpage tg-jobdetail">
    <?php
    if (have_posts()) :
        
        while (have_posts()) : the_post();
            global $post;
            //Get job post metas
            $post_author = '';
            $career_level = '';
            $job_type = '';
            $experience = '';
            $salary = '';
            $qualification = '';
            $languages = '';
            $requirements = '';
            $benifits = '';
            $expiry_date = '';
            if (function_exists('fw_get_db_post_option')) {
				//career level
                $career_level = fw_get_db_post_option($post->ID, 'career_level', true);
                $list_career_levels = listingo_get_career_level();
                if (array_key_exists($career_level, $list_career_levels)) {
                    $career_level = $list_career_levels[$career_level];
                }
                
				//job type
				$job_type = fw_get_db_post_option($post->ID, 'job_type', true);
                $list_job_types = listingo_get_job_type();
                
				if (array_key_exists($job_type, $list_job_types)) {
                    $job_type = $list_job_types[$job_type];
                }
				
				//experience
                $experience = fw_get_db_post_option($post->ID, 'experience', true);
				$experience_list 		= listingo_get_experience_list();
				if (array_key_exists($experience, $experience_list)) {
                    $experience = $experience_list[$experience];
                }
				
                $salary = fw_get_db_post_option($post->ID, 'salary', true);
                $qualification = fw_get_db_post_option($post->ID, 'qualification', true);
                $languages = fw_get_db_post_option($post->ID, 'languages', true);
                $requirements = fw_get_db_post_option($post->ID, 'requirements', true);
                $benefits = fw_get_db_post_option($post->ID, 'benifits', true);
                $expiry_date = fw_get_db_post_option($post->ID, 'expirydate', true);
                $post_author = get_post_meta($post->ID, 'author', true);
                
				//Get Location Detail.
                $profile_address = fw_get_db_post_option($post->ID, 'address', true);
                $latitude = fw_get_db_post_option($post->ID, 'address_latitude', true);
                $longitude = fw_get_db_post_option($post->ID, 'address_longitude', true);
                $phone = fw_get_db_post_option($post->ID, 'phone', true);
                $fax = fw_get_db_post_option($post->ID, 'fax', true);
                $email = fw_get_db_post_option($post->ID, 'email', true);
                $user_url = fw_get_db_post_option($post->ID, 'url', true);
            }

            $avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $post_author), array('width' => 100, 'height' => 100)
            );
           
			$author_name = listingo_get_username($post_author);
            
			//Get the total job views.
            $job_views = apply_filters('sp_get_profile_views', $post->ID, 'set_job_view');
            $job_total_views = esc_html__('Total Views: ', 'listingo') . intval(0);
            if (!empty($job_views)) {
                $job_total_views = esc_html__('Total Views: ', 'listingo') . intval($job_views);
            }

            //Get user meta social links detail.
            $facebook = get_user_meta($post_author, 'facebook', true);
            $twitter = get_user_meta($post_author, 'twitter', true);
            $linkedin = get_user_meta($post_author, 'linkedin', true);
            $pinterest = get_user_meta($post_author, 'pinterest', true);
            $googleplus = get_user_meta($post_author, 'googleplus', true);
            $skype = get_user_meta($post_author, 'skype', true);
	
            ?>
            <div class="tg-detailpagehead">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="tg-detailpageheadcontent">
                                <?php if (!empty($post_author)) { ?>
                                    <div class="tg-companylogo">
                                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Job author avatar', 'listingo'); ?>">
                                    </div>
                                <?php } ?>
                                <div class="tg-companycontent">
                                    <?php if (!empty($job_type)) { ?>
                                        <ul class="tg-tags">
                                            <li><a class="tg-tag" href="javascript:;"><?php echo esc_attr($job_type); ?></a></li>
                                        </ul>
                                    <?php } ?>
                                    <div class="tg-title">
                                        <h1><?php echo get_the_title(); ?></h1>
                                        <span class="tg-jobpostedby"><?php esc_html_e('By: ', 'listingo'); ?>
                                            <a href="javascript:;"><?php echo esc_attr($author_name); ?></a>
                                        </span>
                                    </div>
                                </div>
                                <?php if( isset( $apply_job ) && $apply_job === 'restrict' ){?>
                                	<?php if (is_user_logged_in()) {?>
                                		<a class="tg-btn tg-apply-job-model" href="javascript:;"><?php esc_html_e('apply now', 'listingo'); ?></a>
                                	<?php }else{?>
                                		<a class="tg-btn" href="<?php echo esc_attr( $auth_page );?>?redirect=<?php the_permalink();?>"><?php esc_html_e('Login before apply', 'listingo'); ?></a>
                                	<?php }?>
                                <?php }else{?>
                                	<a class="tg-btn tg-apply-job-model" href="javascript:;"><?php esc_html_e('apply now', 'listingo'); ?></a>
                                <?php }?>
                            </div>
                            <ul class="tg-jobmatadata">
                                <li>
                                    <div class="tg-box tg-posteddate">
                                        <span class="tg-jobmataicon"><i class="lnr lnr-calendar-full"></i></span>
                                        <div class="tg-jobmatacontent">
                                            <strong><?php esc_html_e('Posted Date', 'listingo'); ?></strong>
                                            <span><?php echo date_i18n(get_option('date_format'), strtotime(get_the_date('Y-m-d'))); ?></span>
                                        </div>
                                    </div>
                                </li>
                                <?php if (!empty($job_total_views)) { ?>
                                    <li>
                                        <div class="tg-box tg-views">
                                            <span class="tg-jobmataicon"><i class="lnr lnr-eye"></i></span>
                                            <div class="tg-jobmatacontent">
                                                <strong><?php esc_html_e('Views', 'listingo'); ?></strong>
                                                <span><?php echo esc_attr($job_total_views); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($expiry_date)) { ?>
                                    <li>
                                        <div class="tg-box tg-expiredate">
                                            <span class="tg-jobmataicon"><i class="lnr lnr-warning"></i></span>
                                            <div class="tg-jobmatacontent">
                                                <strong><?php esc_html_e('Expire Date', 'listingo'); ?></strong>
                                                <span><?php echo date_i18n(get_option('date_format'), strtotime($expiry_date)); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tg-twocolumns" class="tg-twocolumns">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8 pull-left">
                            <div id="tg-content" class="tg-content">
                                <div class="tg-companyfeatures">
                                    <div class="tg-companyfeaturebox tg-introduction">
                                        <div class="tg-description">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                    <?php
										if( isset( $more_less ) && $more_less === 'yes' ){
											$script = "
												jQuery(document).ready(function(){
												var _readmore = jQuery('.tg-introduction .tg-description');
													_readmore.readmore({
															speed: 500,
															collapsedHeight: 140,
															moreLink: '<a class=\"tg-btntext\" href=\"#\">".esc_html__('more...','listingo')."</a>',
															lessLink: '<a class=\"tg-btntext\" href=\"#\">".esc_html__('less...','listingo')."</a>',
													});
												});";
											wp_add_inline_script('listingo_callbacks', $script, 'after');
										}
                                    ?>
                                    <div class="tg-companyfeaturebox tg-jobdetails">
                                        <div class="tg-companyfeaturetitle">
                                            <h3><?php esc_html_e('Job Details', 'listingo'); ?></h3>
                                        </div>
                                        <ul>
                                            <?php if (!empty($career_level)) { ?>
                                                <li>
                                                    <span><?php esc_html_e('Career Level:', 'listingo'); ?></span>
                                                    <span><?php echo esc_attr($career_level); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($experience)) { ?>
                                                <li>
                                                    <span><?php esc_html_e('Experience:', 'listingo'); ?></span>
                                                    <span><?php echo esc_attr($experience); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($salary)) { ?>
                                                <li>
                                                    <span><?php esc_html_e('Salary:', 'listingo'); ?></span>
                                                    <span><?php echo esc_attr($salary); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($job_type)) { ?>
                                                <li>
                                                    <span><?php esc_html_e('Job Type:', 'listingo'); ?></span>
                                                    <span><?php echo esc_attr($job_type); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($qualification)) { ?>
                                                <li>
                                                    <span><?php esc_html_e('Qualification:', 'listingo'); ?></span>
                                                    <span><?php echo esc_attr($qualification); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($languages)) {
                                                ?>
                                                <li>
                                                    <span><?php esc_html_e('Languages:', 'listingo'); ?></span>
                                                    <span>
                                                        <?php
															$langnames = array();
															foreach ($languages as $language) {
																$lang_term_data = get_term_by('id', $language, 'languages');
																$langnames[] = $lang_term_data->name;
															}
															echo implode(", ", $langnames);
                                                        ?>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <?php if (!empty($requirements)) { ?>
                                        <div class="tg-companyfeaturebox tg-jobrequirments">
                                            <div class="tg-companyfeaturetitle">
                                                <h3><?php esc_html_e('Job Requirements', 'listingo'); ?></h3>
                                            </div>
                                            <div class="tg-description">
                                                <?php echo wp_kses_post(wpautop(do_shortcode($requirements))); ?> 
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if (!empty($benefits)) {
                                        ?>
                                        <div class="tg-companyfeaturebox tg-benefitsallowances">
                                            <div class="tg-companyfeaturetitle">
                                                <h3><?php esc_html_e('Benefits / Allowances', 'listingo'); ?></h3>
                                            </div>
                                            <ul class="tg-themeliststyle tg-themeliststylecircletick">
                                                <?php foreach ($benefits as $benefit) { ?>
                                                    <li><?php echo esc_attr($benefit); ?></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 pull-right">
                            <aside id="tg-sidebar" class="tg-sidebar">
                                <div class="tg-widget tg-widgetlocationandcontactinfo">
                                    <?php if( !empty( $latitude ) && !empty( $longitude ) ){?>
										<div class="tg-mapbox">
											<div id="location-pickr-map"></div>
										</div>
										<?php
											$map_script = "jQuery(document).ready(function (e) {
												jQuery.listingo_init_map(" . esc_js($latitude) . "," . esc_js($longitude) . ");
											});";
											wp_add_inline_script('listingo_maps', $map_script, 'after');
										?>
                                    <?php }?>
                                    <div class="tg-contactinfobox">
                                        <ul class="tg-contactinfo">
                                            <?php if (!empty($profile_address)) { ?>
                                                <li>
                                                    <i class="lnr lnr-location"></i>
                                                    <address><?php echo esc_attr($profile_address); ?></address>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($phone)) { ?>
                                                <li>
                                                    <i class="lnr lnr-phone-handset"></i>
                                                    <span><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_attr($phone); ?></a></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($fax)) { ?>
                                                <li>
                                                    <i class="lnr lnr-printer"></i>
                                                    <span><?php echo esc_attr($fax); ?></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($email)) { ?>
                                                <li>
                                                    <i class="lnr lnr-envelope"></i>
                                                    <span><a href="mailto:<?php echo esc_attr($email); ?>?subject:<?php esc_html_e('Hello', 'listingo'); ?>"><?php echo esc_attr($email); ?></a></span>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($user_url)) { ?>
                                                <li>
                                                    <i class="lnr lnr-screen"></i>
                                                    <span><a href="<?php echo esc_url($user_url); ?>" target="_blank"><?php echo esc_attr($user_url); ?></a></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <?php
                                        if (!empty($facebook) ||
                                                !empty($twitter) ||
                                                !empty($linkedin) ||
                                                !empty($google_plus) ||
                                                !empty($skype) ||
                                                !empty($pinterest)) {
                                            ?>
                                            <ul class="tg-socialicons">
                                                <?php if (!empty($facebook)) { ?>
                                                    <li class="tg-facebook"><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li>
                                                <?php } ?>
                                                <?php if (!empty($twitter)) { ?>
                                                    <li class="tg-twitter"><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li>
                                                <?php } ?>
                                                <?php if (!empty($linkedin)) { ?>
                                                    <li class="tg-linkedin"><a href="<?php echo esc_url($linkedin); ?>"><i class="fa fa-linkedin"></i></a></li>
                                                <?php } ?>
                                                <?php if (!empty($google_plus)) { ?>
                                                    <li class="tg-googleplus"><a href="<?php echo esc_url($google_plus); ?>"><i class="fa fa-google-plus"></i></a></li>
                                                <?php } ?>
                                                <?php if (!empty($skype)) { ?>
                                                    <li class="tg-skype"><a href="<?php echo esc_url($skype); ?>"><i class="fa fa-skype"></i></a></li>
                                                <?php } ?>
                                                <?php if (!empty($pinterest)) { ?>
                                                    <li class="tg-pinterestp"><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        <?php if (!empty($profile_address)) { ?>
                                            <a class="tg-btn tg-btn-lg" href="http://maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($profile_address); ?>" target="_blank"><?php esc_html_e('Get Directions', 'listingo'); ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="tg-widget tg-widgetshare">
                                    <div class="tg-widgettitle">
                                        <h3><?php esc_html_e('Share this job', 'listingo'); ?></h3>
                                    </div>
                                    <div class="tg-widgetcontent">
                                        <?php listingo_prepare_social_sharing('false', '', 'false', '', $avatar); ?>
                                    </div>
                                </div>
                                <!--Get related job posts-->
                                <?php sp_get_related_job_posts(); ?>
                                <!--///-->
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer();?>
<?php if( isset( $apply_job ) && $apply_job === 'free' || is_user_logged_in() ){?>
<div class="modal fade tg-appointmentrejectmodal sp-apply-job-modal" tabindex="-1" >
    <div class="modal-dialog tg-modaldialog" role="document">
        <div class="modal-content tg-modalcontent">
            <div class="tg-modalhead">
                <h2><?php esc_html_e('Apply Now', 'listingo'); ?></h2>
            </div>            
            <form class="tg-themeform tg-formamanagejobs tg-job-application-form">
                <fieldset>                   
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="text" value="<?php echo esc_attr( $user_name ); ?>" name="apply[name]" class="form-control" placeholder="<?php esc_html_e('Name', 'listingo'); ?>">                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="text" id="tg-date-birth" value="" calss="tg-date-birth form-control" name="apply[dob]" placeholder="<?php esc_html_e('Date of Birth', 'listingo'); ?>">                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="email" value="<?php echo esc_attr( $user_email ); ?>" name="apply[email]" class="form-control" placeholder="<?php esc_html_e('Email', 'listingo'); ?>">                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="text" value="<?php echo esc_attr( $user_cell ); ?>" name="apply[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="text" value="" name="apply[education]" class="form-control" placeholder="<?php esc_html_e('Education', 'listingo'); ?>">                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <span class="tg-select">
                                    <select name="apply[status]">
                                        <option value="employed"><?php esc_html_e('Employed', 'listingo'); ?></option>
                                        <option value="unemployed"><?php esc_html_e('Un-Employed', 'listingo'); ?></option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <input type="text" value="<?php echo esc_attr( $user_address ); ?>" name="apply[address]" class="form-control" placeholder="<?php esc_html_e('Address', 'listingo'); ?>">                                
                            </div>
                        </div>                       
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                            <div class="form-group">
                                <textarea name="apply[description]" placeholder="<?php esc_html_e('Provide further details about yourself','listingo'); ?> "></textarea>
                            </div>
                        </div>                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
                            <div class="form-group">
                                <?php wp_nonce_field('sp_dashboard_contact_form', 'security'); ?>
                                <input type="hidden" name="apply[job]" value="<?php echo esc_attr( $post->ID ); ?>">
                                <button type= "button" class="tg-btn tg-apply-job" href="javascript:;"><?php esc_html_e('apply now', 'listingo'); ?></button>
                            </div>
                        </div>                         
                    </div>
                </fieldset>
            </form>           
        </div>
    </div>
</div>
<?php }?>