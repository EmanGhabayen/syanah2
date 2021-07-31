<?php
/**
 * @ Listingo Functions
 * @ return {}
 * @ Version 1.0.0
 */
if (!class_exists('Listingo_Profile_Menu')) {

    class Listingo_Profile_Menu {

        protected static $instance = null;

        public function __construct() {
            //Do something
        }

        /**
         * @Returns the *Singleton* instance of this class.
         * @return Singleton The *Singleton* instance.
         */
        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * @profile Menu
         * @Returns Menu Top
         */
        public static function listingo_profile_menu_top() {
            global $current_user, $wp_roles, $userdata, $post;

            ob_start();
            $username = listingo_get_username($current_user->ID);
            $avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $current_user->ID), array('width' => 100, 'height' => 100)
            );
			
			$sticky_header = '';
			if (function_exists('fw_get_db_settings_option')) {
				$sticky_header = fw_get_db_settings_option('sticky');
			}
			
			$menu_scroll	= 'spscroll-null';
			if( isset( $sticky_header ) && $sticky_header === 'enable' ){
				$menu_scroll	= 'tg-themescrollbar';
			}
			
            ?>
            <div class="tg-useradminbox sp-top-menu">
                <div class="tg-themedropdown tg-userdropdown">
                    <a href="javascript:;" id="tg-usermenu" class="tg-btndropdown">
                        <em><img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Profile Avatar', 'listingo'); ?>"></em>
                        <span><?php echo esc_attr($username); ?></span>
                    </a>
                    <div class="tg-dropdownmenu tg-usermenu" aria-labelledby="tg-usermenu">
                       	<div class="spv-menu-wrap <?php echo esc_attr( $menu_scroll );?>">
							<nav id="tg-dashboardnav" class="tg-dashboardnav ">
								<?php self::listingo_profile_menu('dashboard-menu-top'); ?>
							</nav>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            echo ob_get_clean();
        }

        /**
         * @profile Menu
         * @Returns Menu Top
         */
        public static function listingo_profile_menu_left() {
            global $current_user, $wp_roles, $userdata, $post;

            ob_start();
            ?>

            <?php self::listingo_do_process_userinfo(); ?>
            <div class="tg-widgetdashboard">
                <nav class="tg-dashboardnav">
                   	<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#db-navigation" aria-expanded="false">
							<span class="dbm-only"><?php esc_html_e('Menu', 'listingo'); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
                    <div id="db-navigation" class="collapse navbar-collapse tg-dashboardnav">
                    	<?php self::listingo_profile_menu('dashboard-menu-left'); ?>
					</div>
                </nav>
            </div>

            <?php
            echo ob_get_clean();
        }

        /** 	
         * @Profile Menu
         * @Returns Dashoboard Menu
         */
        public static function listingo_profile_menu($menu_type = "dashboard-menu-left") {
            global $current_user, $wp_roles, $userdata, $post;
			$reference 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
			$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
			$user_identity 	 = $current_user->ID;

			$url_identity = $user_identity;
			if (isset($_GET['identity']) && !empty($_GET['identity'])) {
				$url_identity = $_GET['identity'];
			}
			
			$menu_list 	= apply_filters('listingo_get_dashboard_menu','default');
            ob_start();
            ?>
            <ul class="<?php echo esc_attr($menu_type); ?>">
                <?php 
					if ($url_identity == $user_identity) {
						if( !empty( $menu_list ) ){
							foreach($menu_list as $key => $value){
								get_template_part('directory/front-end/dashboard-menu-templates/profile-menu', $key);
							}
						}
					} 
                ?>
            </ul>
            <?php
            echo ob_get_clean();
        }

        /**
         * @Generate Menu Link
         * @Returns 
         */
        public static function listingo_profile_menu_link($profile_page = '', $slug = '', $user_identity = '', $return = false, $mode = '', $id = '') {
            if ( empty( $profile_page ) ) {
                $permalink = home_url('/') . '?author=' . $user_identity;
            } else {
                $query_arg['ref'] = urlencode($slug);

                //mode
                if (!empty($mode)) {
                    $query_arg['mode'] = urlencode($mode);
                }
				
                //id for edit record
                if (!empty($id)) {
                    $query_arg['id'] = urlencode($id);
                }

                $query_arg['identity'] = urlencode($user_identity);

                $permalink = add_query_arg(
                        $query_arg, esc_url(get_permalink($profile_page)
                        )
                );
            }
			
            if ($return) {
                return esc_url_raw($permalink);
            } else {
                echo esc_url_raw($permalink);
            }
        }

        /**
         * @Generate Profile Avatar Image Link
         * @Returns HTML
         */
        public static function listingo_get_avatar() {
            global $current_user, $wp_roles, $userdata, $post;
			
            $user_identity = $current_user->ID;
			$profile_status = get_user_meta($user_identity, 'profile_status', true);
			$profile_status	=  !empty($profile_status) ? $profile_status : 'sphide';
			
            $dir_profile_page = '';
            if (function_exists('fw_get_db_settings_option')) {
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

            $profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
			
            $avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $user_identity), array('width' => 100, 'height' => 100)
            );
			
			$statuses	= listingo_get_status_list();
            ?>
            <figure class="sp-user-profile-img">
                <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Profile Avatar', 'listingo'); ?>">
                <a class="tg-btnedite sp-profile-edit" href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'settings', $user_identity); ?>">
                    <i class="lnr lnr-pencil"></i>
                </a>
                <?php if( !empty( $statuses ) ) {?>
					<div class="tg-themedropdown tg-userdropdown spprofile-statuswrap <?php echo esc_attr( $profile_status );?>"> 
					  <a href="javascript:;" class="spactive-status">
						<span class="<?php echo esc_attr( $profile_status );?>"></span>
					  </a>
					  <div class="tg-dropdownmenu tg-statusmenu" aria-labelledby="tg-usermenu">
						<nav class="tg-dashboardnav">
						  <ul class="dashboard-status">
							<?php foreach( $statuses as $key => $value ){?>
								<li class="status-current current-<?php echo esc_attr($key);?> <?php echo isset($key) && $key === $profile_status ? 'status-selected' : '';?>" data-key="<?php echo esc_attr($key);?>"><a href="javascript:;"><?php echo esc_attr($value['title']);?></a></li>
							<?php }?>
						  </ul>
						</nav>
					  </div>
					</div>
				<?php }?>

            </figure>
            <?php
        }

        /**
         * @Generate Profile Banner Image Link
         * @Returns HTML
         */
        public static function listingo_get_banner() {
            global $current_user, $wp_roles, $userdata, $post;

            $user_identity = $current_user->ID;

            $user_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $user_identity = $_GET['identity'];
            }

            $avatar = apply_filters(
                    'listingo_get_media_filter', listingo_get_user_banner(array('width' => 270, 'height' => 120), $user_identity), array('width' => 270, 'height' => 120)//size width,height
            );
            ?>
            <figure class="tg-profilebannerimg sp-profile-banner-img">
                <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Profile Banner', 'listingo'); ?>">
				<?php if (( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
					 || apply_filters('listingo_get_user_type', $user_identity) === 'professional' 
					 || apply_filters('listingo_get_user_type', $user_identity) === 'customer' 
					) && function_exists('fw_get_db_settings_option')
				) {?>
               	 	<a target="_blank" class="sp-view-profile" href="<?php echo esc_url(get_author_posts_url($user_identity));?>"><span class="lnr lnr-eye"></span></a>
                <?php }?>
            </figure>
            <?php
        }

        /**
         * @Generate Profile Information
         * @Returns HTML
         */
        public static function listingo_get_user_info() {
            global $current_user;


            $user_identity = $current_user->ID;

            $user_identity = $user_identity;
            if (isset($_GET['identity']) && !empty($_GET['identity'])) {
                $user_identity = $_GET['identity'];
            }
            $get_username = listingo_get_username($user_identity);
			
            $tag_line = get_user_meta($user_identity, 'tag_line', true);
			
			
			$dir_profile_page = '';
			$insight_page = '';
			if (function_exists('fw_get_db_settings_option')) {
				$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
				$insight_page = fw_get_db_settings_option('insight_page', $default_value = null);
			}

			$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
			
            ?>
            <div class="tg-admininfo">
                <?php if (!empty($get_username)) { ?>
                    <h3><?php echo esc_attr($get_username); ?></h3>
                <?php } ?>
                <?php if (apply_filters('listingo_do_check_user_type', $user_identity) === true) { ?>
                    <?php if (!empty($tag_line)) { ?>
                        <h4><?php echo esc_attr($tag_line); ?></h4>
                    <?php } ?>
                    <?php do_action('sp_get_rating_and_votes', $user_identity, 'echo'); ?>
                <?php } ?>
            </div>
            <?php if (( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
				 || apply_filters('listingo_get_user_type', $user_identity) === 'professional' 
				 || apply_filters('listingo_get_user_type', $user_identity) === 'customer' 
				) && function_exists('fw_get_db_settings_option')
			) {?>
				<a target="_blank" class="sp-view-profile-btn tg-btn" href="<?php echo esc_url(get_author_posts_url($user_identity));?>"><?php esc_html_e('View Profile', 'listingo'); ?></a>
			<?php }?>
            
            <?php if ( apply_filters('listingo_get_user_type', $user_identity) === 'customer' && function_exists('fw_get_db_settings_option')) {?>
           		<a target="_blank" class="sp-view-profile-btn sp-switchaccount" href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'switch_account', $user_identity); ?>"><?php esc_html_e('Switch Account', 'listingo'); ?></a>
            <?php }?>
            <?php
        }

        /**
         * @get user info
         * @return 
         */
        public static function listingo_do_process_userinfo() {
            global $current_user, $wp_roles, $userdata, $post;
            $reference = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : $reference = '';
            $user_identity = $current_user->ID;
            ?>
            <div class="tg-widgetprofile">
                <?php self::listingo_get_banner(); ?>
                <div class="tg-widgetcontent">
                    <?php self::listingo_get_avatar(); ?>
                    <?php self::listingo_get_user_info(); ?>
                </div>
            </div>
            <?php
        }

    }

    new Listingo_Profile_Menu();
}
