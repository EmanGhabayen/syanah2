<?php
/**
 *
 * Class used as base to create theme header
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
if (!class_exists('Listingo_Prepare_Headers')) {

    class Listingo_Prepare_Headers {

        function __construct() {
            add_action('listingo_do_process_headers', array(&$this, 'listingo_do_process_headers'));
            add_action('listingo_prepare_headers', array(&$this, 'listingo_prepare_header'));
            add_action('listingo_systemloader', array(&$this, 'listingo_systemloader'));
            add_action('listingo_app_available', array(&$this, 'listingo_app_available'));
        }

        /**
         * @system app available
         * @return {}
         * @author themographics
         */
        public function listingo_app_available() {
            ob_start();
            if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com') { ?>
                <a target="_blank" class="tg-appavailable" href="https://codecanyon.net/item/listingo-service-providers-business-finder-android-native-app/21435746">
                    <img class="bubbleicon" src="<?php echo get_template_directory_uri(); ?>/images/bubble.png" alt="">
                    <img class="android-logo" src="<?php echo get_template_directory_uri(); ?>/images/android-logo.png" alt="">
                </a>
                <?php
                echo ob_get_clean();
            }
        }

        /**
         * @system loader
         * @return {}
         * @author themographics
         */
        public function listingo_systemloader() {
            $preloader = '';
            if (function_exists('fw_get_db_settings_option')) {
                $preloader = fw_get_db_settings_option('preloader', $default_value = null);
                $maintenance = fw_get_db_settings_option('maintenance');
            }

            if (isset($maintenance) && $maintenance === 'disable') {
                if (isset($preloader['gadget']) && $preloader['gadget'] === 'enable') {
                    if (isset($preloader['enable']['preloader']['gadget']) && $preloader['enable']['preloader']['gadget'] === 'default') {
                        ?>
                        <div class="preloader-outer">
                            <div class="pin"></div>
                            <div class="pulse"></div>
                        </div>
                        <?php
                    } elseif (isset($preloader['enable']['preloader']['gadget']) && $preloader['enable']['preloader']['gadget'] === 'custom' && !empty($preloader['enable']['preloader']['custom']['loader']['url'])
                    ) {
                        ?>
                        <div class="preloader-outer">
                            <div class="preloader-inner">
                                <img width="100" src="<?php echo esc_url($preloader['enable']['preloader']['custom']['loader']['url']); ?>" alt="<?php esc_html_e('loader', 'listingo'); ?>" />
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }

        /**
         * @Prepare headers
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_headers() {
            global $current_user;

            $loaderDisbale = '';
            if (function_exists('fw_get_db_settings_option')) {
                $header_type = fw_get_db_settings_option('header_type');
                $maintenance = fw_get_db_settings_option('maintenance');
            } else {
                $maintenance = '';
            }

            $post_name = listingo_get_post_name();

            if (( isset($maintenance) && $maintenance == 'enable' && !is_user_logged_in() ) || $post_name === "coming-soon"
            ) {
                $loaderDisbale = 'elm-display-none';
            }

            //get_template_part('template-parts/template', 'comingsoon');

            //demo ready
			if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com') {
				if (isset($post_name) && ( $post_name === "header-v2" || $post_name === "home-v5" )) {
					$header_type['gadget'] = 'header_v2';
				} else if (isset($post_name) && ( $post_name === "home-page-7" )) {
					$header_type['gadget'] = 'header_v3';
				} else if (isset($post_name) && ( $post_name === "home-page-8" )) {
					$header_type['gadget'] = 'header_v4';
				} else if (isset($post_name) && ( $post_name === "home-page-5" )) {
					$header_type['gadget'] = 'header_v5';
				} else if (isset($post_name) && ( $post_name === "home-v2" )) {
					$header_type['gadget'] = 'header_v1';
				}
			}


            if (isset($header_type['gadget']) && $header_type['gadget'] === 'header_v2') {
                $this->listingo_do_process_header_v2();
            } elseif (isset($header_type['gadget']) && $header_type['gadget'] === 'header_v3') {
                $this->listingo_do_process_header_v3();
            } elseif (isset($header_type['gadget']) && $header_type['gadget'] === 'header_v4') {
                $this->listingo_do_process_header_v4();
            } elseif (isset($header_type['gadget']) && $header_type['gadget'] === 'header_v5') {
                $this->listingo_do_process_header_v5();
            } else {
                $this->listingo_do_process_header_v1();
            } 
        }

        /**
         * @Prepare header v1
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_header_v1() {
            global $current_user;
            $user_identity = $current_user->ID;
            $url_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $url_identity = $_GET['identity'];
            }

            $login_register = '';
            if (function_exists('fw_get_db_settings_option')) {
                $enable_job = fw_get_db_settings_option('enable_job');
                $header_type = fw_get_db_settings_option('header_type');
                $main_logo = fw_get_db_settings_option('main_logo');
                $login_register = fw_get_db_settings_option('enable_login_register');
            } else {
                $enable_job = '';
                $header_type = '';
                $main_logo = '';
            }

            if (!empty($main_logo['url'])) {
                $logo = $main_logo['url'];
            } else {
                $logo = get_template_directory_uri() . '/images/logo.png';
            }

            $protocol = is_ssl() ? 'https' : 'http';

            $signup_page = '';

            if (!empty($login_register) && $login_register['gadget'] === 'enable') {
                $signup_page = $login_register['enable']['login_reg_page'];
            }

            $signup_page_slug = '';
            $dir_profile_page = '';

            if (!empty($signup_page[0])) {
                $signup_page_slug = listingo_get_slug($signup_page[0]);
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $add_job_link = home_url('/' . esc_attr($signup_page_slug) . '/', $protocol);


            if (is_user_logged_in()) {
                $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
                $add_job_link = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $user_identity, true, 'listing');
            }
            ?>
            <header id="tg-header" class="tg-header tg-haslayout sp-header-v1">
                <?php
                if (!empty($header_type['header_v1']['enable_top_strip']['gadget']) && $header_type['header_v1']['enable_top_strip']['gadget'] === 'enable') {
                    $this->listingo_prepare_top_strip();
                }
                ?>
                <div id="tg-fixednav" class="tg-navigationarea tg-fixednav">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <?php $this->listingo_prepare_logo($logo); ?>
                                <div class="tg-rightarea">
                                    <nav id="tg-nav" class="tg-nav">
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'listingo'); ?></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>
                                        <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                            <?php Listingo_Prepare_Headers::listingo_prepare_navigation('primary-menu', '', 'tg-navigationlist', '0'); ?>
                                        </div>
                                    </nav>
                                    <?php
										if (apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
											if (!empty($enable_job) && $enable_job === 'enable') {
												?>
												<a class="tg-btn" href="<?php echo esc_url($add_job_link); ?>"><?php esc_html_e('Post A New Job', 'listingo'); ?></a>
												<?php
											}
										}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }

        /**
         * @Prepare header v2
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_header_v2() {
            global $current_user;
            $user_identity = $current_user->ID;
            $url_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $url_identity = $_GET['identity'];
            }

            $login_register = '';
            if (function_exists('fw_get_db_settings_option')) {
                $enable_job = fw_get_db_settings_option('enable_job');
                $header_type = fw_get_db_settings_option('header_type');
                $main_logo = fw_get_db_settings_option('main_logo');
                $login_register = fw_get_db_settings_option('enable_login_register');
            } else {
                $enable_job = '';
                $header_type = '';
                $main_logo = '';
            }

            if (!empty($main_logo['url'])) {
                $logo = $main_logo['url'];
            } else {
                $logo = get_template_directory_uri() . '/images/logo.png';
            }

            $post_name = listingo_get_post_name();

            if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com' && $post_name === "home-3") {
                $logo = get_template_directory_uri() . '/images/logo2.png';
            }

            $protocol = is_ssl() ? 'https' : 'http';

            $signup_page = '';

            if (!empty($login_register) && $login_register['gadget'] === 'enable') {
                $signup_page = $login_register['enable']['login_reg_page'];
            }

            $signup_page_slug = '';
            $dir_profile_page = '';

            if (!empty($signup_page[0])) {
                $signup_page_slug = listingo_get_slug($signup_page[0]);
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $add_job_link = home_url('/' . esc_attr($signup_page_slug) . '/', $protocol);

            if (is_user_logged_in()) {
                $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
                $add_job_link = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $user_identity, true, 'listing');
            }
            ?>
            <header id="tg-header" class="tg-header tg-haslayout sp-header-v2">
                <div id="tg-fixednav" class="tg-navigationarea tg-fixednav">
                    <div class="fullwidth-header tg-haslayout">
                        <?php $this->listingo_prepare_logo($logo); ?>
                        <div class="tg-rightarea">
                            <nav id="tg-nav" class="tg-nav">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                        <span class="sr-only"><?php esc_html_e('Toggle navigation', 'listingo'); ?></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                    <?php Listingo_Prepare_Headers::listingo_prepare_navigation('primary-menu', '', 'tg-navigationlist', '0'); ?>
                                </div>
                            </nav>
                            <?php $this->listingo_prepare_registration('v2'); ?>
                            <?php
                            if (apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
                                if (!empty($enable_job) && $enable_job === 'enable') {
                                    ?>
                                    <a class="tg-btn tg-btnpostanewjob" href="<?php echo esc_url($add_job_link); ?>"><?php esc_html_e('Post a job', 'listingo'); ?></a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>	
                </div>
            </header>
            <?php
        }

        /**
         * @Prepare header v3
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_header_v3() {
            global $current_user;
            $user_identity = $current_user->ID;
            $url_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $url_identity = $_GET['identity'];
            }

            $login_register = '';
            if (function_exists('fw_get_db_settings_option')) {
                $enable_job = fw_get_db_settings_option('enable_job');
                $header_type = fw_get_db_settings_option('header_type');
                $main_logo = fw_get_db_settings_option('main_logo');
                $login_register = fw_get_db_settings_option('enable_login_register');
            } else {
                $enable_job = '';
                $header_type = '';
                $main_logo = '';
            }

            if (!empty($main_logo['url'])) {
                $logo = $main_logo['url'];
            } else {
                $logo = get_template_directory_uri() . '/images/logo.png';
            }

            $protocol = is_ssl() ? 'https' : 'http';

            $signup_page = '';

            if (!empty($login_register) && $login_register['gadget'] === 'enable') {
                $signup_page = $login_register['enable']['login_reg_page'];
            }

            $signup_page_slug = '';
            $dir_profile_page = '';

            if (!empty($signup_page[0])) {
                $signup_page_slug = listingo_get_slug($signup_page[0]);
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $add_job_link = home_url('/' . esc_attr($signup_page_slug) . '/', $protocol);


            if (is_user_logged_in()) {
                $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
                $add_job_link = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $user_identity, true, 'listing');
            }

            $contact_address = !empty($header_type['header_v3']['contact_address']) ? $header_type['header_v3']['contact_address'] : '';
            $contact_phone = !empty($header_type['header_v3']['contact_phone']) ? $header_type['header_v3']['contact_phone'] : '';
            $contact_email = !empty($header_type['header_v3']['contact_email']) ? $header_type['header_v3']['contact_email'] : '';
            ?>                    
            <header id="tg-header" class="tg-header tg-headervtwo tg-haslayout sp-header-v3">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="tg-logoarea">
                                <?php $this->listingo_prepare_logo($logo); ?>
                                <div class="tg-rightbox">
                                    <?php if (!empty($contact_address) || !empty($contact_phone) || !empty($contact_email)) { ?>
                                        <ul class="tg-contactbar">
                                            <?php if (!empty($contact_address)) { ?>
                                                <li>
                                                    <i class="lnr lnr-map-marker"></i>
                                                    <div class="tg-contentbox">
                                                        <address><?php echo force_balance_tags($contact_address); ?></address>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            <?php if (!empty($contact_phone) || !empty($contact_email)) { ?>
                                                <li>
                                                    <i class="lnr lnr-phone-handset"></i>
                                                    <div class="tg-contentbox">
                                                        <?php if (!empty($contact_phone)) { ?>
                                                            <span><a href="tel:<?php echo esc_attr($contact_phone); ?>"><?php echo esc_attr($contact_phone); ?></a></span>
                                                        <?php } ?>
                                                        <?php if (!empty($contact_email)) { ?>
                                                            <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_attr($contact_email); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>                                     
                                    <?php $this->listingo_prepare_registration('v3'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div id="tg-fixednav" class="tg-navigationarea tg-navresponsive">
                                <nav id="tg-nav" class="tg-nav">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                            <span class="sr-only"><?php esc_html_e('Toggle navigation', 'listingo'); ?></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                        <?php Listingo_Prepare_Headers::listingo_prepare_navigation('primary-menu', '', 'tg-navigationlist', '0'); ?>
                                    </div>
                                </nav>
                                <?php
                                if (apply_filters('listingo_get_theme_settings', 'jobs') == 'yes') {
                                    if (!empty($enable_job) && $enable_job === 'enable') {
                                        ?>
                                        <a class="tg-btnpostanewjob" href="<?php echo esc_url($add_job_link); ?>"><?php esc_html_e('Post A New Job', 'listingo'); ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }

        //Header version four testing
        /**
         * @Prepare header v4
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_header_v4() {
            global $current_user;
            $user_identity = $current_user->ID;
            $url_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $url_identity = $_GET['identity'];
            }

            $login_register = '';
            if (function_exists('fw_get_db_settings_option')) {
                $enable_job = fw_get_db_settings_option('enable_job');
                $header_type = fw_get_db_settings_option('header_type');
                $main_logo = fw_get_db_settings_option('main_logo');
                $login_register = fw_get_db_settings_option('enable_login_register');
            } else {
                $enable_job = '';
                $header_type = '';
                $main_logo = '';
            }

            if (!empty($main_logo['url'])) {
                $logo = $main_logo['url'];
            } else {
                $logo = get_template_directory_uri() . '/images/logo.png';
            }

            $protocol = is_ssl() ? 'https' : 'http';

            $signup_page = '';

            if (!empty($login_register) && $login_register['gadget'] === 'enable') {
                $signup_page = $login_register['enable']['login_reg_page'];
            }

            $signup_page_slug = '';
            $dir_profile_page = '';

            if (!empty($signup_page[0])) {
                $signup_page_slug = listingo_get_slug($signup_page[0]);
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $add_job_link = home_url('/' . esc_attr($signup_page_slug) . '/', $protocol);


            if (is_user_logged_in()) {
                $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
                $add_job_link = Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'jobs', $user_identity, true, 'listing');
            }

            $social_icons = !empty($header_type['header_v4']['social_icons']) ? $header_type['header_v4']['social_icons'] : '';
            ?>                         
            <header id="tg-header" class="tg-header tg-headervthree tg-haslayout sp-header-v4">
                <div id="tg-fixednav" class="tg-logoarea">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="tg-leftbox">
                                    <?php if (!empty($enable_job) && $enable_job === 'enable') { ?>
                                        <a class="tg-btnpostanewjob" href="<?php echo esc_url($add_job_link); ?>"><?php esc_html_e('Post A New Job', 'listingo'); ?></a>
                                    <?php } ?>
                                    <?php if (!empty($social_icons)) { ?>
                                        <ul class="tg-socialicons">
                                            <?php
                                            foreach ($social_icons as $key => $value) {
                                                $social_name = !empty($value['social_name']) ? $value['social_name'] : '';
                                                $social_class = !empty($value['social_icons_list']) ? $value['social_icons_list'] : '';
                                                $social_link = !empty($value['social_url']) ? $value['social_url'] : '#';
                                                $social_main_class = '';
                                                if (!empty($social_class)) {
                                                    $social_main_class = substr($social_class, 6);
                                                }
                                                if (!empty($social_class)) {
                                                    ?>
                                                    <li class="tg-<?php echo esc_attr($social_main_class); ?>"><a href="<?php echo esc_attr($social_link); ?>"><i class="<?php echo esc_attr($social_class); ?>"></i></a></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                                <?php $this->listingo_prepare_registration('v4'); ?>
                                <?php $this->listingo_prepare_logo($logo); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tg-navigationarea tg-navresponsive">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <nav id="tg-nav" class="tg-nav">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                            <span class="sr-only"><?php esc_html_e('Toggle navigation', 'listingo'); ?></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                        <?php Listingo_Prepare_Headers::listingo_prepare_navigation('primary-menu', '', 'tg-navigationlist', '0'); ?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }

        //Header version four testing ends 

        /**
         * @Prepare header v5
         * @return {}
         * @author themographics
         */
        public function listingo_do_process_header_v5() {
            $login_register = '';
            if (function_exists('fw_get_db_settings_option')) {
                $enable_job = fw_get_db_settings_option('enable_job');
                $header_type = fw_get_db_settings_option('header_type');
                $main_logo = fw_get_db_settings_option('main_logo');
                $login_register = fw_get_db_settings_option('enable_login_register');
                $dir_search_page = fw_get_db_settings_option('dir_search_page');
                $zip_search = fw_get_db_settings_option('zip_search');
                $misc_search = fw_get_db_settings_option('misc_search');
                $dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
                $language_search = fw_get_db_settings_option('language_search');
                $country_cities = fw_get_db_settings_option('country_cities');
                $dir_radius = fw_get_db_settings_option('dir_radius');
                $dir_location = fw_get_db_settings_option('dir_location');
                $dir_keywords = fw_get_db_settings_option('dir_keywords');
            } else {
                $enable_job = '';
                $header_type = '';
                $main_logo = '';
                $dir_search_page = '';
                $dir_radius = '';
                $dir_location = '';
                $dir_keywords = '';
                $misc_search = '';
                $zip_search = '';
                $dir_search_insurance = '';
                $language_search = '';
                $country_cities = '';
            }

            if (!empty($main_logo['url'])) {
                $logo = $main_logo['url'];
            } else {
                $logo = get_template_directory_uri() . '/images/logo-new.png';
            }

            $protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_script('listingo_maps');
            ?>                         
            <header id="tg-header" class="tg-header tg-headervfour spv-header-five tg-haslayout">
                <div class="container-fluid" id="tg-fixednav">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="tg-logoarea">
                                <?php $this->listingo_prepare_logo($logo); ?>
                                <div class="tg-rightarea">
                                    <div class="tg-navigationarea tg-navigationareavtwo">
                                        <nav id="tg-nav" class="tg-nav">
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                                    <span class="sr-only"><?php esc_html_e('Toggle navigation', 'listingo'); ?></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                                <?php Listingo_Prepare_Headers::listingo_prepare_navigation('primary-menu', '', 'tg-navigationlist', '0'); ?>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <?php if( !empty($header_type['header_v5']['search_form']) && $header_type['header_v5']['search_form'] === 'enable' ){?>
                                <form class="tg-formtheme tg-formsearchvtwo spv-header-search-form" action="<?php echo listingo_get_search_page_uri(); ?>" method="get">  
                                    <fieldset>
                                        <?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
                                            <div class="form-group tg-inputwithicon">
                                                <i class="lnr lnr-magnifier"></i>
                                                <?php do_action('listingo_get_search_keyword'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if (isset($geo_type) && $geo_type === 'countries') {
                                            do_action('listingo_get_countries_list');
                                        } else {
                                            if (!empty($dir_location) && $dir_location === 'enable') {?>
                                                <div class="form-group tg-inputwithicon">
                                                    <i class="lnr lnr-map-marker"></i>
                                                    <?php do_action('listingo_get_header_search_geolocation'); ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="form-group tg-inputwithicon">
                                            <?php do_action('listingo_get_search_category'); ?>
                                        </div>
                                        <?php if (!empty($atts['sub_cats']) && $atts['sub_cats'] === 'yes') { ?>
                                            <div class="form-group tg-inputwithicon">
                                                <?php do_action('listingo_get_search_sub_category'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php do_action('listingo_get_search_permalink_setting'); ?>
                                        <button class="tg-btnsearchvtwo" type="submit"><i class="lnr lnr-magnifier"></i></button>
                                    </fieldset>
                                </form>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->listingo_prepare_registration(); ?>
            </header>
            <?php
        }

        /**
         * @Prepare top strip
         * @return {}
         * @author themographics
         */
        public function listingo_prepare_top_strip() {
            if (function_exists('fw_get_db_settings_option')) {
                $header_type = fw_get_db_settings_option('header_type');
                $enable_login_register = fw_get_db_settings_option('enable_login_register');
            } else {
                $header_type = '';
                $enable_login_register = '';
            }

            $top_strip = !empty($header_type['header_v1']['enable_top_strip']['enable']) ? $header_type['header_v1']['enable_top_strip']['enable'] : array();

            $bg_color = '';
            $contact_info = array();
            if (!empty($top_strip['topstrip_color'])) {
                $bg_color = 'style=background:' . $top_strip['topstrip_color'] . ';';
            }

            if (!empty($top_strip['contact_info'])) {
                $contact_info = $top_strip['contact_info'];
            }
            ?>
            <div class="tg-topbar tg-haslayout" <?php echo ( $bg_color ); ?>>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <?php if (!empty($contact_info)) { ?>
                                <ul class="tg-addressinfo">
                                    <?php
                                    do_action('enqueue_unyson_icon_css');
                                    foreach ($contact_info as $key => $contact) {
                                        $contact_label = $contact['contact_label'];
                                        $contact_icon = $contact['contact_icon'];
                                        $contact_type = !empty($contact['type']) ? $contact['type'] : '';
                                        if (!empty($contact_label)) {
                                            if (isset($contact_type) && $contact_type === 'email') {
                                                $data_link = 'mailto:' . esc_attr($contact_label);
                                            } elseif (isset($contact_type) && $contact_type === 'phone') {
                                                $data_link = 'tel:' . esc_attr($contact_label);
                                            } else {
                                                $data_link = 'javascript:;';
                                            }
                                            ?>
                                            <li>
                                                <?php if (!empty($contact_icon)) { ?>
                                                    <i class="<?php echo esc_attr($contact_icon['icon-class']); ?>"></i>
                                                <?php } ?>
                                                <?php if (!empty($contact_label)) { ?>
                                                    <a href="<?php echo esc_attr($data_link); ?>"><?php echo esc_attr($contact_label); ?></a>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <?php $this->listingo_prepare_registration(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * @Prepare Logo
         * @return {}
         * @author themographics
         */
        public function listingo_prepare_logo($logo = '') {
            global $post, $woocommerce;

            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

            //demo ready
            $post_name = listingo_get_post_name();
            if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'themographics.com') {
                if (isset($post_name) && $post_name === 'home-page-8') {
                    $logo = get_template_directory_uri() . '/images/logo_blue_header.png';
                } else if (isset($post_name) && $post_name === 'home-page-7') {
                    $logo = get_template_directory_uri() . '/images/logo_green_header.png';
                }
            }

            ob_start();
            ?>
            <strong class="tg-logo"> 
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (!empty($logo)) { ?>
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($blogname); ?>">
                        <?php
                    } else {
                        echo esc_attr($blogname);
                    }
                    ?>
                </a> 
            </strong>
            <?php
            echo ob_get_clean();
        }

        /**
         * @Registration and Login
         * @return {}
         */
        public function listingo_prepare_registration($header_type = '') {
            global $current_user, $wp_roles, $userdata, $post;

            $login_register = '';
            $login_reg_link = '#';
            if (function_exists('fw_get_db_settings_option')) {
                $login_register = fw_get_db_settings_option('enable_login_register');
            }

            if (!empty($login_register['enable']['login_reg_page'])) {
                $login_reg_link = $login_register['enable']['login_reg_page'];
            }

            ob_start();
            ?>
            <?php if (!empty($login_register) && $login_register['gadget'] === 'enable') { ?>
                <div class="tg-adminbox header-type-<?php echo esc_attr($header_type); ?>">
                    <?php
                    if (is_user_logged_in()) {
                        Listingo_Profile_Menu::listingo_profile_menu_top();
                    } else {
                        if (!empty($login_reg_link)) {?>
                            <div class="tg-loginregister">
                                <a class="tg-btnlogin" href="<?php echo esc_url(get_permalink((int) $login_reg_link[0])); ?>"><i class="lnr lnr-user"></i><?php esc_html_e('Join Now', 'listingo'); ?></a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            <?php } ?>
            <?php
            echo ob_get_clean();
        }

        /**
         * @Main Navigation
         * @return {}
         */
        public static function listingo_prepare_navigation($location = '', $id = 'menus', $class = '', $depth = '0') {

            if (has_nav_menu($location)) {
                $defaults = array(
                    'theme_location' => "$location",
                    'menu' => '',
                    'container' => 'ul',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => "$class",
                    'menu_id' => "$id",
                    'echo' => false,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' => "$depth",
                );
                echo do_shortcode(wp_nav_menu($defaults));
            } else {
                $defaults = array(
                    'theme_location' => "$location",
                    'menu' => '',
                    'container' => 'ul',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => "$class",
                    'menu_id' => "$id",
                    'echo' => false,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth' => "$depth",
                );
                echo do_shortcode(wp_nav_menu($defaults));
            }
        }

    }

    new Listingo_Prepare_Headers();
}