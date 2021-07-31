<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/themographics/portfolio
 * @since      1.0.0
 *
 * @package    Docdirect
 * @subpackage Docdirect/admin
 */
/**
 * @init            Blink Admin Menu init
 * @package         Tailors Online
 * @subpackage      listingo_core/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if (!function_exists('listingo_core_admin_menu')) {
    add_action('admin_menu', 'listingo_core_admin_menu');

    function listingo_core_admin_menu() {
        $url = admin_url();
        add_submenu_page('edit.php?post_type=sp_categories', 
						 esc_html__('Settings', 'listingo_core'), 
						 esc_html__('Settings', 'listingo_core'), 
						 'manage_options', 
						 'listingo_settings', 
						 'listingo_admin_page'
        );
		
    }

}


/**
 * @init            Settings Admin Page
 * @package         Docdirect
 * @subpackage      docdirect/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if (!function_exists('listingo_admin_page')) {

    function listingo_admin_page() {
		$job		= listingo_get_theme_settings('jobs');
		$job_slug	= listingo_get_theme_settings('job_slug');
		$apt_slug	= listingo_get_theme_settings('apt_slug');
		$category_slug	= listingo_get_theme_settings('category_slug');
		$sub_category_slug	= listingo_get_theme_settings('sub_category_slug');
		$country_slug	= listingo_get_theme_settings('country_slug');
		$city_slug	= listingo_get_theme_settings('city_slug');
		$language_slug	= listingo_get_theme_settings('language_slug');
		$amenity_slug	= listingo_get_theme_settings('amenity_slug');
		$insurance_slug	= listingo_get_theme_settings('insurance_slug');
		
		$article_slug	= listingo_get_theme_settings('article_slug');
		$question_slug	= listingo_get_theme_settings('question_slug');

		$menu_list 	= apply_filters('listingo_get_dashboard_menu','default');
        $protocol = is_ssl() ? 'https' : 'http';
        ob_start();
		
        ?>
        <div id="tg-main" class="tg-main tg-addnew">
            <div class="wrap">
                <div id="tg-tab1s" class="tg-tabs">
					<ul class="tg-tabsnav">
						<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] === 'welcome' ? 'tg-active' : ''; ?>">
							<a href="<?php echo cus_prepare_final_url('welcome','settings'); ?>">
								<?php esc_html_e("What's New?", 'listingo_core'); ?>
							</a>
						</li> 
						<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] === 'settings'? 'tg-active' : ''; ?>">
							<a href="<?php echo cus_prepare_final_url('settings','settings'); ?>">
								<?php esc_html_e('Settings', 'listingo_core'); ?>
							</a>
						</li>
						<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] === 'menu'? 'tg-active' : ''; ?>">
							<a href="<?php echo cus_prepare_final_url('menu','settings'); ?>">
								<?php esc_html_e('Dashboard Menu', 'listingo_core'); ?>
							</a>
						</li>
					</ul>
                    <div class="tg-tabscontent">
                        <div id="tg-main" class="tg-main tg-features settings-main-wrap">
                            <div class="tg-featureswelcomebox">
                                <figure><img src="<?php echo ListingoGlobalSettings::get_plugin_url(); ?>/admin/settings/welcome/logo.jpg" alt="<?php esc_html_e('logo', 'listingo_core'); ?>"></figure>
                                <div class="tg-welcomecontent">
                                    <h3><?php esc_html_e('Welcome To Listingo', 'listingo_core'); ?></h3>
                                    <div class="tg-description">
                                        <p><?php esc_html_e('Listingo is a purpose built Directory WordPress theme. It is designed in a way that it could be used as a engineers directory, lawyer directory, handyman directory, business services directory, veterinary directory, listingo directory, business and service finder directory, business listing or as a directory for other professionals as it has a lot of features a directory website may need (and many more!).  ', 'listingo_core'); ?></p>
                                        <p><?php esc_html_e('The current template has been designed with a directory for healthcare establishments in mind. The inner pages are carefully designed to provide all the essential information any directory business would need.', 'listingo_core'); ?></p>

                                    </div>
                                </div>
                            </div>
						    <div class="tg-featurescontent">
                                <div class="tg-twocolumns">
								<?php
									if( isset( $_GET['tab'] ) && $_GET['tab'] === 'menu' ){
										?>
										<div class="settings-wrap">
											<div class="tg-boxarea">
												<div id="tabone">
													<div class="tg-titlebox">
														<h3><?php esc_html_e('Dashboard Menu Settings', 'listingo_core'); ?></h3>
													</div>
													<p><?php esc_html_e('All possible menu items are given below. You can sort them according to your need.', 'listingo_core'); ?></p>
													<?php esc_html_e('Developer Note : If any developer want to include new menu item in providers dashboard please reset this menu after including item in array.', 'listingo_core'); ?></p>
													<div class="spv-reset-menu"><a href="javascript:;" class="button button-primary sp-reset-menu"><?php esc_html_e('Reset Menu', 'listingo_core'); ?></a></div>
													<form method="post" class="save-settings-form">
														<div class="tg-sortcontentitems sp-item-sortable">
															<div class="tg-profilewidget tg-peaoplereviews">
																<div class="tg-box sp-content-sort">
																	<?php 
																	if( !empty( $menu_list ) ){
																		foreach($menu_list as $key => $value){?>
																			<div class="tg-timebox">
																				<i class="lnr lnr-move"></i>
																				<input type="hidden" name="menu[<?php echo esc_attr( $key ); ?>][key]" value="<?php echo esc_attr( $key ); ?>">
																				<input type="hidden" name="menu[<?php echo esc_attr( $key ); ?>][title]" value="<?php echo esc_attr( $value['title'] ); ?>">
																				<span><?php echo esc_attr( $value['title'] ); ?></span>
																			</div>
																	<?php }}?>
																</div>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<?php }else if( isset( $_GET['tab'] ) && $_GET['tab'] === 'settings' ){?>
										<div class="settings-wrap">
											<div class="tg-boxarea">
												<div id="tabone">
													<div class="tg-titlebox">
														<h3><?php esc_html_e('General Options', 'listingo_core'); ?></h3>
													</div>
													<form method="post" class="save-settings-form">
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will hide jobs from front-end and back-end.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Enable jobs?', 'listingo_core'); ?></span>
															<div class="tg-iosstylcheckbox">
																<input type="hidden" name="settings[jobs]" value="no">
																<input class="dashboard-privacy" value="yes" <?php checked($job, 'yes', true); ?> type="checkbox" id="data-jobs" name="settings[jobs]">
																<label for="data-jobs" data-disable="<?php esc_html_e('Disable', 'listingo_core'); ?>" data-enable="<?php esc_html_e('Enable', 'listingo_core'); ?>"></label>
															</div>
														</div>
														<?php if( isset( $job ) && $job ===  'yes' ){?>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Job page slug?', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[job_slug]" class="form-control" value="<?php echo esc_attr( $job_slug );?>">
																</div>
															</div>
														</div>
														<?php }?>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Articles page slug?', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[article_slug]" class="form-control" value="<?php echo esc_attr( $article_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Questions page slug?', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[question_slug]" class="form-control" value="<?php echo esc_attr( $question_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Appointment page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[apt_slug]" class="form-control" value="<?php echo esc_attr( $apt_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Category page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[category_slug]" class="form-control" value="<?php echo esc_attr( $category_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Sub category page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[sub_category_slug]" class="form-control" value="<?php echo esc_attr( $sub_category_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Country page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[country_slug]" class="form-control" value="<?php echo esc_attr( $country_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('City page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[city_slug]" class="form-control" value="<?php echo esc_attr( $city_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Language page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[language_slug]" class="form-control" value="<?php echo esc_attr( $language_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Amenity page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[amenity_slug]" class="form-control" value="<?php echo esc_attr( $amenity_slug );?>">
																</div>
															</div>
														</div>
														<div class="tg-privacysetting">
															<span class="tg-tooltipbox">
																<i>?</i>
																<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'listingo_core'); ?></span>
															</span>
															<span><?php esc_html_e('Insurance page slug', 'listingo_core'); ?></span>
															<div class="sp-input-setting">
																<div class="form-group">
																	<input type="text" name="settings[insurance_slug]" class="form-control" value="<?php echo esc_attr( $insurance_slug );?>">
																</div>
															</div>
														</div>
														<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary save-data-settings" value="<?php esc_html_e('Save Changes', 'listingo_core'); ?>"></p>
													</form>
												</div>
											</div>
										</div>
										<?php }else{?>
										<div class="tg-content">
											<div class="tg-boxarea">
												<div class="tg-title">
													<h3><?php esc_html_e('Minimum System Requirements', 'listingo_core'); ?></h3>
												</div>
												<div class="tg-contentbox">
													<ul class="tg-liststyle tg-dotliststyle tg-twocolumnslist">
														<li>PHP version should be  7.0 or above 7.0 </li>
														<li>PHP Zip extension Should</li>
														<li>max_execution_time = 300</li>
														<li>max_input_time = 300</li>
														<li>memory_limit = 300</li>
														<li>post_max_size = 100M</li>
														<li>upload_max_filesize = 100M</li>
													</ul>
												</div>
											</div>
										</div>
										<aside class="tg-sidebar">
											<div class="tg-widgetbox tg-widgetboxquicklinks">
												<div class="tg-title">
													<h3><?php esc_html_e('Video Tutorial', 'listingo_core'); ?></h3>
												</div>
												<figure>
													<div style="position:relative;height:0;padding-bottom:56.25%">
														<iframe src="https://www.youtube.com/embed/rynUvzHH7Fo?rel=0" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe>

													</div>
												</figure>
											</div>
											<div class="tg-widgetbox tg-widgetboxquicklinks">
												<div class="tg-title">
													<h3><?php esc_html_e('Quick Links', 'listingo_core'); ?></h3>
												</div>
												<ul>
													<li><a target="_blank" href="https://themographics.ticksy.com/article/11916"><?php esc_html_e('How to translate theme', 'listingo_core'); ?></a></li>
													<li><a target="_blank" href="https://themographics.ticksy.com/article/11918/"><?php esc_html_e('How to make login/registration page', 'listingo_core'); ?></a></li>
													<li><a target="_blank" href="https://themographics.ticksy.com/article/11919/"><?php esc_html_e('How to Update Theme, When New Update release', 'listingo_core'); ?></a></li>
												</ul>
												<a class="tg-btn" target="_blank" href="https://themographics.ticksy.com/"><?php esc_html_e('Get a quick help', 'listingo_core'); ?></a>
											</div>
										</aside>
								<?php }?>	
                                </div>
                                <div class="tg-socialandcopyright">
                                    <span class="tg-copyright"><?php echo date('Y'); ?>&nbsp;<?php esc_html_e('All Rights Reserved', 'listingo_core'); ?> &copy; <a target="_blank"  href="https://themeforest.net/user/themographics/"><?php esc_html_e('Themographics', 'listingo_core'); ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }
}
