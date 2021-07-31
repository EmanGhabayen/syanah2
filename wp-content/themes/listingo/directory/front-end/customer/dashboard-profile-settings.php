<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity  = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$profile_avatars = get_user_meta($user_identity, 'profile_avatar', true);
$profile_latitude = get_user_meta($user_identity, 'latitude', true);
$profile_longitude = get_user_meta($user_identity, 'longitude', true);
$profile_country = get_user_meta($user_identity, 'country', true);
$profile_city = get_user_meta($user_identity, 'city', true);
$profile_address = get_user_meta($user_identity, 'address', true);
$profile_gender = get_user_meta($user_identity, 'gender', true);

if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$profile_latitude = !empty($profile_latitude) ? $profile_latitude : $dir_longitude;
$profile_longitude = !empty($profile_longitude) ? $profile_longitude : $dir_latitude;
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboardprofilesetting">
        <form class="tg-themeform sp-dashboard-profile-form">
            <fieldset>
                <div class="tg-dashboardbox tg-uploadphotos">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Upload Photos', 'listingo'); ?></h2>
                    </div>
                    <div class="tg-uploadbox">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
                                <div class="tg-upload">
                                    <div class="tg-uploadhead">
                                        <span>
                                            <h3><?php esc_html_e('Upload Profile Photo/Logo', 'listingo'); ?></h3>
                                            <i class="fa fa-exclamation-circle"></i>
                                        </span>
                                        <i class="lnr lnr-upload"></i>
                                    </div>
                                    <div class="tg-box">
                                        <label class="tg-fileuploadlabel" for="tg-profilephoto">
                                            <div id="plupload-profile-container">
                                            	<a href="javascript:;" id="upload-profile-photo" class="tg-fileinput sp-upload-container">
													<i class="lnr lnr-cloud-upload"></i>
													<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
												</a> 
                                            </div>
                                        </label>
                                        <div class="tg-gallery">
                                            <div class="tg-galleryimages sp-profile-photo" data-image_type="<?php echo isset($profile_avatars['image_type']) ? esc_attr($profile_avatars['image_type']) : esc_attr('profile_photo'); ?>">
                                                <?php
                                                if (!empty($profile_avatars['image_data'])) {
                                                    $default = !empty($profile_avatars['default_image']) ? $profile_avatars['default_image'] : '';
                                                    foreach ($profile_avatars['image_data'] as $key => $value) {
                                                        $active = '';
                                                        if ($value['image_id'] == $default) {
                                                            $active = 'active';
                                                        }

                                                        $image_meta = '';
                                                        if (!empty($value['image_id'])) {
                                                            $image_meta = listingo_get_image_metadata($value['image_id']);
                                                        }
                                                        $image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
                                                        $image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
                                                        ?>
                                                        <div class="tg-galleryimg tg-galleryimg-item item-<?php echo intval($value['image_id']); ?> <?php echo esc_attr($active); ?>" data-id="<?php echo intval($value['image_id']); ?>">
                                                            <figure>
                                                                <?php if (!empty($value['thumb'])) { ?>
                                                                    <img src="<?php echo esc_url($value['thumb']); ?>" alt="<?php echo!empty($image_alt) ? esc_attr($image_alt) : esc_attr($image_title); ?>">
                                                                    <figcaption>
                                                                        <i class="fa fa-check active-profile-photo"></i>
                                                                        <i class="fa fa-close del-profile-photo"></i>
                                                                    </figcaption>
                                                                <?php } ?>
                                                            </figure>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tg-dashboardbox tg-basicinformation">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Basic Infomartion', 'listingo'); ?></h2>
                    </div>
                    <div class="tg-basicinformationbox">
                        <div class="row">
                            <?php if( apply_filters('listingo_dev_manage_fields','true','first_name') === 'true' ){?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
									<div class="form-group">
										<input type="text" class="form-control" name="basics[first_name]" value="<?php echo get_user_meta($user_identity, 'first_name', true); ?>" placeholder="<?php esc_html_e('First Name', 'listingo'); ?>">
									</div>
								</div>
                            <?php }?>
                            <?php if( apply_filters('listingo_dev_manage_fields','true','last_name') === 'true' ){?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
									<div class="form-group">
										<input type="text" class="form-control" name="basics[last_name]" value="<?php echo get_user_meta($user_identity, 'last_name', true); ?>" placeholder="<?php esc_html_e('Last Name', 'listingo'); ?>">
									</div>
								</div>
                            <?php }?>
                            <?php if( apply_filters('listingo_dev_manage_fields','true','gender') === 'true' ){?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
									<div class="form-group">
										<span class="tg-select">
											<select name="basics[gender]">
												<option value=""><?php esc_html_e('Gender', 'listingo'); ?></option>
												<option value="male" <?php selected( $profile_gender, 'male',true); ?>><?php esc_html_e('Male', 'listingo'); ?></option>
												<option value="female" <?php selected( $profile_gender, 'female', true); ?>><?php esc_html_e('Female', 'listingo'); ?></option>
											</select>
										</span>
									</div>
								</div>
                            <?php }?>
                            <?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
									<div class="form-group">
										<input type="text" class="form-control" name="basics[phone]" value="<?php echo get_user_meta($user_identity, 'phone', true); ?>" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
									</div>
								</div>
                            <?php }?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="basics[fax]" value="<?php echo get_user_meta($user_identity, 'fax', true); ?>" placeholder="<?php esc_html_e('Fax', 'listingo'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 pull-left">
                                <div class="form-group">
                                    <textarea class="form-control basic-short-desc" name="basics[description]" placeholder="<?php esc_attr_e('Short description', 'listingo'); ?>"><?php echo get_user_meta($user_identity, 'description', true); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!---------------------------------------------------
                * Profile Location
                ---------------------------------------------------->
                <div class="tg-dashboardbox tg-location">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Location', 'listingo'); ?></h2>
                    </div>
                    <div class="tg-locationbox">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
                                <div class="form-group">
                                    <span class="tg-select">
                                        <select name="basics[country]" class="sp-country-select">
                                            <option value=""><?php esc_html_e('Choose Country', 'listingo'); ?></option>
                                            <?php $countries = listingo_get_term_options($profile_country, 'countries'); ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
                                <div class="form-group">
                                    <span class="tg-select">
                                        <select name="basics[city]" class="sp-city-select">
                                            <option value=""><?php esc_html_e('Choose City', 'listingo'); ?></option>
                                            <?php
                                            if (!empty($profile_country)) {
                                                $country = sanitize_text_field($profile_country);
                                                $args = array(
                                                    'hide_empty' => false,
                                                    'meta_key' => 'country',
                                                    'meta_value' => $country
                                                );
                                                $terms = get_terms('cities', $args);
                                                if (!empty($terms)) {
                                                    foreach ($terms as $key => $term) {
                                                        $selected = '';
                                                        if ($profile_city === $term->slug) {
                                                            $selected = 'selected';
                                                        }
                                                        echo '<option ' . esc_attr($selected) . ' value="' . esc_attr($term->slug) . '">' . esc_attr($term->name) . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                <div class="form-group locate-me-wrap">
                                    <input type="text" value="<?php echo esc_attr($profile_address); ?>" name="basics[address]" class="form-control" id="location-address" />
                                    <a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'listingo'); ?>"></a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                <div class="form-group">
                                    <input type="text" value="<?php echo esc_attr($profile_longitude); ?>" name="basics[longitude]" class="form-control" id="location-longitude" />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                                <div class="form-group">
                                    <input type="text" value="<?php echo esc_attr($profile_latitude); ?>" name="basics[latitude]" class="form-control" id="location-latitude" />
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
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

                <div id="tg-updateall" class="tg-updateall">
                    <div class="tg-holder">
                        <?php wp_nonce_field('sp_profile_settings_nonce', 'profile-settings-update'); ?>
                        <span class="tg-note"><?php esc_html_e('Click update now to update the latest added details.', 'listingo'); ?></span>
                        <a class="tg-btn update-profile-dashboard" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<!----------------------------------------------------
* Underscore Templates
----------------------------------------------------->
<script type="text/template" id="tmpl-load-profile-thumb">
    <div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
    <figure>
    <img src="{{data.thumbnail}}">
    <figcaption>
    <i class="fa fa-check active-profile-photo"></i>
    <i class="fa fa-close del-profile-photo"></i>
    </figcaption>
    </figure>
    </div>
</script>
<script type="text/template" id="tmpl-load-profile-banenr-thumb">
    <div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
    <figure>
    <img src="{{data.thumbnail}}">
    <figcaption >
    <i class="fa fa-check active-profile-banner"></i>
    <i class="fa fa-close del-profile-banner-photo"></i>
    </figcaption>
    </figure>
    </div>
</script>
<script type="text/template" id="tmpl-load-profile-gallery-thumb">
    <div class="tg-galleryimg tg-galleryimg-item item-{{data.attachment_id}}" data-id="{{data.attachment_id}}">
    <figure>
    <img src="{{data.thumbnail}}">
    <figcaption><i class="fa fa-close del-profile-gallery-photo"></i></figcaption>
    </figure>
    </div>
</script>
<script type="text/template" id="tmpl-load-profile-brochure">
    <li class="brochure-item brochure-thumb-item item-{{data.attachment_id}}" data-brochure_id="{{data.attachment_id}}">
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_brochure_file"></i>
    <em>{{data.file_title}}</em>
    </span>
    <i class="{{data.file_icon}} file_icon"></i>
    </li>
</script>
<script type="text/template" id="tmpl-load-profile-languages">
    <li data-language-key="{{data.lang_val}}">
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_profile_lang"></i>
    <em>{{data.lang_val}}</em>
    </span>
    <input type="hidden" name="languages[]" value="{{data.lang_key}}">
    </li>
</script>
<script type="text/template" id="tmpl-load-profile-amenities">
    <li data-amenities-key="{{data.ameni_val}}">
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_profile_amenity"></i>
    <em>{{data.ameni_val}}</em>
    </span>
    <input type="hidden" name="amenities[]" value="{{data.ameni_key}}">
    </li>
</script>
<script type="text/template" id="tmpl-load-profile-insurance">
    <li data-insurance-key="{{data.insurance_value}}">
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_profile_insurance"></i>
    <em>{{data.insurance_value}}</em>
    </span>
    <input type="hidden" name="insurance[]" value="{{data.insurance_key}}">
    </li>
</script>
<script type="text/template" id="tmpl-load-media-links">
    <div class="tg-startendtime">
    <div class="form-group">
    <div class="tg-inpuicon">
    <i class="lnr lnr-film-play"></i>
    <input type="text" name="videos[]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'listingo'); ?>">
    </div>
    </div>
    <button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
    </div>
</script>
<script type="text/template" id="tmpl-load-awards">
    <div class="tg-certificatesaward awards-parent-wrap-{{data+1}}" data-count-awards="{{data}}">
    <div class="tg-imgandtitle">
    <figure class="sp-award-photo-thumb"><a href="javascript:;"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/award.jpg'); ?>"></a></figure>
    <h3><a class="sp-awards-title" href="javascript:;"><?php esc_html_e('Certification &amp; Awards Title', 'listingo'); ?></a></h3>
    </div>
    <div class="tg-btntimeedit">
    <button type="button" class="tg-btnedite edit_awards"><i class="lnr lnr-pencil "></i></button>
    <button type="button" class="tg-btndel delete_awards"><i class="lnr lnr-trash "></i></button>
    </div>
    <div class="sp-awards-edit-collapse tg-haslayout elm-display-none">
    <div class="tg-themeform tg-formcertificatesawards">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <div class="form-group">
    <div class="tg-imggallerybox">
    <div class="tg-upload">
    <div class="tg-uploadhead">
    <span>
    <h3><?php esc_html_e('Upload Awards &amp; Certification Photo', 'listingo'); ?></h3>
    <i class="fa fa-exclamation-circle"></i>
    </span>
    <i class="lnr lnr-upload"></i>
    </div>
    <div class="tg-box">
    <label class="tg-fileuploadlabel" for="tg-photogallery">
		<div id="plupload-award-container-{{data+1}}">
			<a href="javascript:;" id="upload-award-photo-{{data+1}}" class="tg-fileinput sp-upload-container">
				<i class="lnr lnr-cloud-upload"></i>
				<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
			</a> 
		</div>
    </label>
    <div class="tg-gallery sp-awards-photo">
    <div class="tg-galleryimages">
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control sp-awards-title-input" name="awards[{{data}}][title]" placeholder="<?php esc_html_e('Certificates / Awards Title', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control awards_date" name="awards[{{data}}][date]" placeholder="<?php esc_html_e('Date', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <textarea class="form-control" name="awards[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
    </div>
    </div>
    </div>
    </div>

</script>
<script type="text/template" id="tmpl-load-experience">
    <div class="tg-experience tg-certificatesaward" data-count-experinces="{{data}}">
    <div class="tg-imgandtitle">
    <h3><a class="sp-job-title" href="javascript:;"><?php esc_html_e('Enter Your Experience Name', 'listingo'); ?></a></h3>

    </div>
    <div class="tg-btntimeedit">
    <button type="button" class="tg-btnedite edit_experience"><i class="lnr lnr-pencil"></i></button>
    <button type="button" class="tg-btndel delete_experience"><i class="lnr lnr-trash"></i></button>
    </div>
    <div class="sp-experience-edit-collapse tg-haslayout elm-display-none">
    <div class="tg-themeform tg-formexperience">
    <input class="tg-checkbox" type="checkbox" name="experience[{{data}}][current]">
    <label><?php esc_html_e('Current Job: ','listingo'); ?></label>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control sp-job-title-input" name="experience[{{data}}][title]" placeholder="<?php esc_html_e('Job Title', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control sp-job-company-input" name="experience[{{data}}][company]" placeholder="<?php esc_html_e('Company Name', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control start_date" name="experience[{{data}}][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control end_date" name="experience[{{data}}][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <textarea class="form-control" name="experience[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
    </div>
    </div>
    </div>
    </div>
</script>
<script type="text/template" id="tmpl-load-qualification">
    <div class="tg-qualification tg-certificatesaward" data-count-qualification="{{data}}">
    <div class="tg-imgandtitle">
    <h3><a class="sp-degree-title" href="javascript:;"><?php esc_html_e('Enter Your Degree Name', 'listingo'); ?></a></h3>
    </div>
    <div class="tg-btntimeedit">
    <button type="button" class="tg-btnedite edit_qualification"><i class="lnr lnr-pencil"></i></button>
    <button type="button" class="tg-btndel delete_qualification"><i class="lnr lnr-trash"></i></button>
    </div>
    <div class="sp-qualification-edit-collapse tg-haslayout elm-display-none">
    <div class="tg-themeform tg-formqualification">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control sp-degree-title-input" name="qualification[{{data}}][title]" placeholder="<?php esc_html_e('Degree Name', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control sp-job-institute-input" name="qualification[{{data}}][institute]" placeholder="<?php esc_html_e('Institute Name', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control start_date" name="qualification[{{data}}][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
    <div class="form-group">
    <input type="text" class="form-control end_date" name="qualification[{{data}}][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>">
    </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
    <textarea class="form-control" name="qualification[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
    </div>
    </div>
    </div>
    </div>
</script>
<script type="text/template" id="tmpl-load-profile-award-thumb">
    <div class="tg-galleryimg tg-galleryimg-item item-{{data.response.attachment_id}}" data-id="{{data.response.attachment_id}}">
    <figure>
    <img src="{{data.response.thumbnail}}">
    <figcaption><i class="fa fa-close del-profile-award-photo"></i></figcaption>
    <input type="hidden" value="{{data.response.attachment_id}}" name="awards[{{data.count}}][attachment_id]">
    <input type="hidden" value="{{data.response.thumbnail}}" name="awards[{{data.count}}][thumbnail_url]">
    <input type="hidden" value="{{data.response.banner}}" name="awards[{{data.count}}][banner_url]">
    <input type="hidden" value="{{data.response.full}}" name="awards[{{data.count}}][full_url]">
    </figure>
    </div>
</script>