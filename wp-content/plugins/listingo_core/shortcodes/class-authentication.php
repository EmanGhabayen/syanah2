<?php
/**
 * File Type : Authentication
 */
if (!class_exists('SC_Listingo_Authentication')) {

    class SC_Listingo_Authentication {

        /**
         * Construct Shortcode
         */
        public function __construct() {
            add_shortcode('listingo_authentication', array(&$this, 'shortCodeCallBack'));
			add_shortcode('listingo_authentication_signup', array(&$this, 'listingo_authentication_signup'));
			add_shortcode('listingo_authentication_signin', array(&$this, 'listingo_authentication_signin'));
            add_shortcode('user_lostpassword', array(&$this, 'listingo_user_lostpassword'));
        }

        /**
         * Return Authentication Result
         */
        public function shortCodeCallBack($atts) {
			global $current_user, $wp_roles;
			
			$atts = shortcode_atts( array(
						'login_title' 		=> '',
						'register_title' 	=> '',
					), $atts, 'listingo_authentication' );
			
			ob_start();
			
			$login_title	= !empty($atts['login_title']) ? $atts['login_title'] : '';
			$register_title	= !empty($atts['register_title']) ? $atts['register_title'] : '';
			
			$enable_resgistration = '';
			$enable_login = '';
			$captcha_settings = '';
			$terms_link = '';
			$site_key = '';
			$login_reg_link = '';
			$signup_page_slug = '';
			$protocol = is_ssl() ? 'https' : 'http';

			if (function_exists('fw_get_db_settings_option')) {
				$captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
				$login_register = fw_get_db_settings_option('enable_login_register');
				$site_key = fw_get_db_settings_option('site_key');
				$enable_google_connect 	 = fw_get_db_settings_option('enable_google_connect', $default_value = null);
				$enable_facebook_connect = fw_get_db_settings_option('enable_facebook_connect', $default_value = null);
			}

			if (!empty($login_register) && $login_register['gadget'] === 'enable') {
				$terms_link = !empty( $login_register['enable']['terms_link'] ) ? $login_register['enable']['terms_link'] : '';
				$terms_link	= !empty( $terms_link ) ? get_the_permalink($terms_link[0]) : '';
			}
			
			if (!empty($login_register['enable']['login_reg_page'])) {
                $login_reg_link = $login_register['enable']['login_reg_page'];
            }

			if(!empty( $login_reg_link[0] )){
				$signup_page_slug = esc_url(get_permalink((int) $login_reg_link[0]));
			}
			
			$enable_registration = !empty( $login_register['enable']['registration'] ) ? $login_register['enable']['registration'] : 'enable';
			$enable_login = !empty( $login_register['enable']['login'] ) ? $login_register['enable']['login'] : 'enable';
			
			$redirect	= !empty( $_GET['redirect'] ) ? esc_url( $_GET['redirect'] ) : '';
			
			if (!is_user_logged_in()) {
				if ( !empty($login_register) && $login_register['gadget'] === 'enable' ) {
			?>
			<div class="tg-content">
				<div class="tg-themeform tg-formlogin-register">
					<?php if ( !empty($enable_registration) && $enable_registration === 'enable' ) {?>
						<?php echo do_shortcode('[listingo_authentication_signup title="'.$register_title.'" single="false"]');?>
					<?php }?>
					<?php if ( !empty($enable_login) && $enable_login === 'enable' ) {?>
						<?php echo do_shortcode('[listingo_authentication_signin title="'.$login_title.'" single="false"]');?>
					<?php }?>
				</div>
			</div>
			<?php
				}else{
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
						<div class="doc-myaccount-content">
							<p><?php esc_html_e('Login and registration is disabled by administrator.','listingo_core');?></p>
						</div>
					 </div>
					<?php
				}
			}else{
				$this->listingo_loggedin_view();
			}
			echo ob_get_clean();
        }
		
		/**
         * Signup Form
         */
        public function listingo_loggedin_view() {
			global $current_user;
			$username = listingo_get_username($current_user->ID);
			$avatar = apply_filters(
					'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $current_user->ID), array('width' => 100, 'height' => 100)
			);
			$dir_profile_page = '';
			if (function_exists('fw_get_db_settings_option')) {
				$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
			}
			$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
			?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
				<div class="doc-myaccount-content">
					<p><?php esc_html_e('Hello','listingo_core');?> <strong><?php echo esc_attr( $username );?></strong> (<?php esc_html_e('not','listingo_core');?> <?php echo esc_attr( $username );?>? <a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e('Sign out','listingo_core');?></a>)</p>
					<p><?php esc_html_e('You can view your dashboard here','listingo_core');?>&nbsp;<a href="<?php Listingo_Profile_Menu::listingo_profile_menu_link($profile_page, 'dashboard', $current_user->ID); ?>"><?php esc_html_e('View','listingo_core');?></a></p>
				</div>
			 </div>
			<?php
		}
		
		/**
         * Signup Form
         */
        public function listingo_authentication_signup($atts) {
			$captcha_settings = '';
			if (function_exists('fw_get_db_settings_option')) {
				$login_register = fw_get_db_settings_option('enable_login_register');
				$captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
			}

			ob_start();
			
			if (!is_user_logged_in()) {
				if ( !empty($login_register) && $login_register['gadget'] === 'enable' ) {
					$atts = shortcode_atts( array(
						'title' 	=> '',
						'single' 	=> 'false'
					), $atts, 'listingo_authentication_signup' );

					$terms_link = '';
					$protocol = is_ssl() ? 'https' : 'http';

					if (function_exists('fw_get_db_settings_option')) {
						$login_register = fw_get_db_settings_option('enable_login_register');
					}

					if (!empty($login_register) && $login_register['gadget'] === 'enable') {
						$terms_link = !empty( $login_register['enable']['terms_link'] ) ? $login_register['enable']['terms_link'] : '';
						$terms_link	= !empty( $terms_link ) ? get_the_permalink($terms_link[0]) : '';
					}

					$redirect	= !empty( $_GET['redirect'] ) ? esc_url( $_GET['redirect'] ) : '';
					$getClasses	= apply_filters('listingo_get_formwrapper',$atts['single'],'signup');
				?>
				<div class="<?php echo esc_attr( $getClasses );?>">
					<div class="tg-registerarea tg-haslayout">
						<?php if( !empty( $atts['title'] ) ){?>
							<div class="tg-loginarea">
								<div class="tg-bordertitle">
									<h3><?php echo esc_attr($atts['title']); ?></h3>
								</div>
							</div>
						<?php }?>
						<fieldset>
							<ul class="tg-tabnav" role="tablist">
								<li role="presentation" class="active">
									<a href="#regularuser" data-toggle="tab">
										<span class="lnr lnr-user"></span>
										<div class="tg-navcontent">
											<h3><?php esc_html_e('Regular Single User', 'listingo_core'); ?></h3>
											<span><?php esc_html_e('Register As Service Seeker', 'listingo_core'); ?></span>
										</div>
									</a>
								</li>
								<li role="presentation">
									<a href="#company" data-toggle="tab">
										<span class="lnr lnr-briefcase"></span>
										<div class="tg-navcontent">
											<h3><?php esc_html_e('Company / Professional', 'listingo_core'); ?></h3>
											<span><?php esc_html_e('Register As Service Provider', 'listingo_core'); ?></span>
										</div>
									</a>
								</li>
							</ul>	
							<div class="tg-themetabcontent tab-content">
								<div class="tab-pane active fade in" id="regularuser">
									<form action="#" method="post" class="seeker-register do-registration-form">
										<div class="form-group">
											<div class="tg-registeras">
												<span><?php esc_html_e('Already have an account? Please login', 'listingo_core'); ?></span>
											</div>
										</div>
										<div class="form-group">
											<input type="text" name="register[username]" class="form-control" placeholder="<?php esc_html_e('User Name, eg alex', 'listingo_core'); ?>">
										</div>
										<?php if( apply_filters('listingo_dev_manage_fields','true','user_nicename') === 'true' ){?>
										<div class="form-group">
											<input type="text" name="register[user_nicename]" class="form-control" placeholder="<?php esc_html_e('Nicename eg : alex', 'listingo_core'); ?>">
											<?php do_action('listingo_get_tooltip','element','nicename');?>
										</div>
										<?php }?>
										<?php if( apply_filters('listingo_dev_manage_fields','true','first_name') === 'true' ){?>
											<div class="form-group">
												<input type="text" name="register[first_name]" class="form-control" placeholder="<?php esc_html_e('First Name', 'listingo_core'); ?>">
											</div>
										<?php }?>
										<?php if( apply_filters('listingo_dev_manage_fields','true','last_name') === 'true' ){?>
											<div class="form-group">
												<input type="text" name="register[last_name]" class="form-control" placeholder="<?php esc_html_e('Last Name', 'listingo_core'); ?>">
											</div>
										<?php }?>
										<?php if( apply_filters('listingo_dev_manage_fields','true','gender') === 'true' ){?>
											<div class="form-group">
												<span class="tg-select">
													<select name="register[gender]">
														<option value=""><?php esc_html_e('Gender', 'listingo_core'); ?></option>
														<option value="male"><?php esc_html_e('Male', 'listingo_core'); ?></option>
														<option value="female"><?php esc_html_e('Female', 'listingo_core'); ?></option>
													</select>
												</span>
											</div>
										<?php }?>
										<?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
											<div class="form-group">
												<input type="text" name="register[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo_core'); ?>">
												<?php do_action('listingo_get_tooltip','element','phone');?>
											</div>
										<?php }?>
										<div class="form-group">
											<input type="email" name="register[email]" class="form-control" placeholder="<?php esc_html_e('Email', 'listingo_core'); ?>">
										</div>
										<div class="form-group">
											<input type="password" name="register[password]" class="form-control" placeholder="<?php esc_html_e('Password', 'listingo_core'); ?>">
										</div>
										<div class="form-group">
											<input type="password" name="register[confirm_password]" class="form-control" placeholder="<?php esc_html_e('Retype Password', 'listingo_core'); ?>">
										</div>
										<?php do_action('listingo_registration_customer_extra_fields');?> 
										<div class="form-group term-group">
											<?php 
											if( isset( $captcha_settings ) 
													&& $captcha_settings === 'enable' 
												) {
											?>
												<div class="domain-captcha">
													<div id="recaptcha_signup"></div>
												</div>
											<?php }?>
											<div class="tg-checkbox">
												<input name="terms"  type="hidden" value="0"  />
												<input name="terms" type="checkbox" id="terms">
												<label for="terms">
													<?php if (!empty($terms_link)) { ?>
														<?php esc_html_e('I have read the', 'listingo_core'); ?>&nbsp;<a target="_blank" href="<?php echo esc_url($terms_link); ?>"><?php esc_html_e('Terms & Conditions', 'listingo_core'); ?></a>&nbsp;<?php esc_html_e('and accept them', 'listingo_core'); ?>
													<?php } else { ?>
														<?php esc_html_e('I agree with the terms and conditions and accept them', 'listingo_core'); ?>
													<?php } ?>

												</label>
												
												<input type="hidden" name="register[account]" value="seeker">
												<?php wp_nonce_field('register_seeker_request', 'register_seeker_request'); ?>
												<button class="tg-btn do-regiter-me" type="submit"><?php esc_html_e('Register Now', 'listingo_core'); ?></button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane fade in" id="company">
									<form action="#" method="post" class="do-registration-form">
										<div class="form-group">
											<div class="tg-registeras">
												<span><?php esc_html_e('Register As', 'listingo_core'); ?>:</span>
												<div class="tg-radio">
													<input type="radio" class="register_type" value="business" id="business" name="register[type]" checked>
													<label for="business"><?php esc_html_e('Business', 'listingo_core'); ?></label>
												</div>
												<div class="tg-radio">
													<input type="radio" class="register_type" value="professional" id="professional" name="register[type]">
													<label for="professional"><?php esc_html_e('professional', 'listingo_core'); ?></label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<span class="tg-select">
												<select name="register[category]" class="sp-category">
													<option value=""><?php esc_html_e('Select Category', 'listingo_core'); ?></option>
													<?php listingo_get_categories('', 'sp_categories'); ?>
												</select>
											</span>
										</div>
										<?php if( apply_filters('listingo_dev_manage_fields','true','sub_category') === 'true' ){?>
											<div class="form-group">
												<span class="tg-select">
													<select name="register[sub_category][]" data-placeholder="<?php esc_html_e('Sub category', 'listingo_core'); ?>"  multiple class="sp-sub-category sp-register-ms">
														<option value=""><?php esc_html_e('Select Sub Category', 'listingo_core'); ?></option>
													</select>
												</span>
											</div>
										<?php }?>
										<div class="form-group">
											<input type="text" name="register[username]" class="form-control" placeholder="<?php esc_html_e('User Name, eg alex', 'listingo_core'); ?>">
										</div>
										<?php if( apply_filters('listingo_dev_manage_fields','true','user_nicename') === 'true' ){?>
										<div class="form-group">
											<input type="text" name="register[user_nicename]" class="form-control" placeholder="<?php esc_html_e('Nicename eg : alex', 'listingo_core'); ?>">
											<?php do_action('listingo_get_tooltip','element','nicename');?>
										</div>
										<?php }?>
										<div class="by-category-fields">
											<div class="form-group">
												<input type="text" name="register[company_name]" class="form-control" placeholder="<?php esc_html_e('Company Name', 'listingo_core'); ?>">
											</div>
											<?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
												<div class="form-group">
													<input type="text" name="register[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo_core'); ?>">
													<?php do_action('listingo_get_tooltip','element','phone');?>
												</div>
											<?php }?>
										</div>
										
										<div class="form-group">
											<input type="email" name="register[email]" class="form-control" placeholder="<?php esc_html_e('Email', 'listingo_core'); ?>">
										</div>
										<div class="form-group">
											<input type="password" name="register[password]" class="form-control" placeholder="<?php esc_html_e('Password', 'listingo_core'); ?>">
										</div>
										<div class="form-group">
											<input type="password" name="register[confirm_password]" class="form-control" placeholder="<?php esc_html_e('Retype Password', 'listingo_core'); ?>">
										</div>
										<!--For Professionals : professional, for Companies : company, for both : both -->
										<?php do_action('listingo_registration_extra_fields','both');?>
										<div class="form-group term-group">
											<?php 
											if( isset( $captcha_settings ) 
													&& $captcha_settings === 'enable' 
												) {
											?>
												<div class="domain-captcha">
													<div id="recaptcha_signup_provider"></div>
												</div>
											<?php }?>
											<div class="tg-checkbox">
												<input name="terms"  type="hidden" value="0"  />
												<input name="terms" type="checkbox" id="provider_terms">
												<label for="provider_terms">
													<?php if (!empty($terms_link)) { ?>
														<?php esc_html_e('I have read the', 'listingo_core'); ?>&nbsp;<a target="_blank" href="<?php echo esc_url($terms_link); ?>"><?php esc_html_e('Terms & Conditions', 'listingo_core'); ?></a>&nbsp;<?php esc_html_e('and accept them', 'listingo_core'); ?>
													<?php } else { ?>
														<?php esc_html_e('I agree with the terms and conditions and accept them', 'listingo_core'); ?>
													<?php } ?>

												</label>
												<input type="hidden" name="register[account]" value="provider">
												<?php wp_nonce_field('register_provider_request', 'register_provider_request'); ?>
												<button class="tg-btn do-regiter-me" type="submit"><?php esc_html_e('Register Now', 'listingo_core'); ?></button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<script type="text/template" id="tmpl-load-business">
					<?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
						<div class="form-group">
							<input type="text" name="register[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo_core'); ?>">
						</div>
					<?php }?>
					<div class="form-group">
						<input type="text" name="register[company_name]" class="form-control" placeholder="<?php esc_html_e('Company Name', 'listingo_core'); ?>">
					</div>
				</script>
				<script type="text/template" id="tmpl-load-indvidual">
					<?php if( apply_filters('listingo_dev_manage_fields','true','first_name') === 'true' ){?>
						<div class="form-group">
							<input type="text" name="register[first_name]" class="form-control" placeholder="<?php esc_html_e('First Name', 'listingo_core'); ?>">
						</div>
					<?php }?>
					<?php if( apply_filters('listingo_dev_manage_fields','true','last_name') === 'true' ){?>
						<div class="form-group">
							<input type="text" name="register[last_name]" class="form-control" placeholder="<?php esc_html_e('Last Name', 'listingo_core'); ?>">
						</div>
					<?php }?>
					<?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
						<div class="form-group">
							<input type="text" name="register[phone]" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo_core'); ?>">
						</div>
					<?php }?>
					<?php if( apply_filters('listingo_dev_manage_fields','true','gender') === 'true' ){?>
						<div class="form-group">
							<span class="tg-select">
								<select name="register[gender]">
									<option value=""><?php esc_html_e('Gender', 'listingo_core'); ?></option>
									<option value="male"><?php esc_html_e('Male', 'listingo_core'); ?></option>
									<option value="female"><?php esc_html_e('Female', 'listingo_core'); ?></option>
								</select>
							</span>
						</div>
					<?php }?>
				</script>
				<?php
					
				}else{
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
						<div class="doc-myaccount-content">
							<p><?php esc_html_e('Login and registration is disabled by administrator.','listingo_core');?></p>
						</div>
					 </div>
					<?php
				}
			}else{
				$this->listingo_loggedin_view();
			}
			
			return ob_get_clean();
		}
		
		/**
         * Signin form
         */
        public function listingo_authentication_signin($atts) {
			if (function_exists('fw_get_db_settings_option')) {
				$login_register = fw_get_db_settings_option('enable_login_register');
			}
			
			ob_start();
			
			if (!is_user_logged_in()) {
				if ( !empty($login_register) && $login_register['gadget'] === 'enable' ) {
					$atts = shortcode_atts( array(
						'title' 	=> '',
						'single' 	=> 'true'
					), $atts, 'listingo_authentication_signin' );

					if (function_exists('fw_get_db_settings_option')) {
						$captcha_settings 		 = fw_get_db_settings_option('captcha_settings', $default_value = null);
						$enable_google_connect 	 = fw_get_db_settings_option('enable_google_connect', $default_value = null);
						$enable_facebook_connect = fw_get_db_settings_option('enable_facebook_connect', $default_value = null);
					}

					$redirect	= !empty( $_GET['redirect'] ) ? esc_url( $_GET['redirect'] ) : '';

					$getClasses	= apply_filters('listingo_get_formwrapper',$atts['single'],'signin');
					
				?>
				<div class="<?php echo esc_attr( $getClasses );?>">
					<div class="tg-loginarea">
						<?php if( !empty( $atts['title'] ) ){?>
							<div class="tg-bordertitle">
								<h3><?php echo esc_attr( $atts['title'] );?></h3>
							</div>
						<?php }?>
						<fieldset>
							<form action="#" method="post" class="do-login-form">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="<?php esc_html_e('Email or username', 'listingo_core'); ?>">
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="<?php esc_html_e('Password', 'listingo_core'); ?>">
								</div>
								<div class="form-group">
									<div class="tg-checkbox">
										<input type="checkbox" name="rememberme" class="form-control" id="remember">
										<label for="remember">
											<?php esc_html_e('Remember Me', 'listingo_core'); ?>
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<?php if (isset($captcha_settings) && $captcha_settings === 'enable') {?>
										<div class="domain-captcha">
											<div id="recaptcha_signin"></div>
										</div>
									<?php } ?>
									<?php wp_nonce_field('login_request', 'login_request'); ?>
									<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect );?>"> 
									<button class="tg-btn tg-btn-lg do-login-button" type="submit"><?php esc_html_e('Login Now', 'listingo_core'); ?></button>
								</div>
								<a class="tg-btnforgotpass sp-forgot-password" href="javascript:;"><?php esc_html_e('Forgot your password?', 'listingo_core'); ?></a>
								<?php 
								if (  ( isset($enable_google_connect) && $enable_google_connect === 'enable' ) 
								   || ( isset($enable_facebook_connect) && $enable_facebook_connect === 'enable' ) 
								) {?>
								<ul class="tg-sociallogingsignup" style="margin-top: 30px;">
									<?php if (  isset($enable_google_connect) && $enable_google_connect === 'enable' ) {?>
										<li class="tg-googleplus">
											<a href="javascript:;" class="sp-googl-connect">
												<i class="fa fa-google-plus"></i>
												<span><?php esc_html_e('Signin/Signup with', 'listingo_core'); ?> <strong><?php esc_html_e('Google', 'listingo_core'); ?></strong></span>
											</a>
										</li>
									<?php }?>
									<?php if (  isset($enable_facebook_connect) && $enable_facebook_connect === 'enable' ) {?>
										<li class="tg-facebook">
											<a href="javascript:;" class="sp-fb-connect">
												<i class="fa fa-facebook"></i>
												<span><?php esc_html_e('Sign/Signup in with', 'listingo_core'); ?> <strong><?php esc_html_e('Facebook', 'listingo_core'); ?></strong></span>
											</a>
										</li>
									<?php }?>
								</ul>
								<?php }?>
							</form>
						</fieldset>
					</div>
				</div>
				<?php
				}else{
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
						<div class="doc-myaccount-content">
							<p><?php esc_html_e('Login and registration is disabled by administrator.','listingo_core');?></p>
						</div>
					 </div>
					<?php
				}
			}else{
				$this->listingo_loggedin_view();
			}
			
			return ob_get_clean();
		}
		
        /**
         * Lost Password Form
         */
        public function listingo_user_lostpassword() {
            $captcha_settings = '';
            if (function_exists('fw_get_db_settings_option')) {
                $captcha_settings = fw_get_db_settings_option('captcha_settings', $default_value = null);
            }
            ?>
            <div class="modal fade tg-modalmanageteam sp-user-lp-model" tabindex="-1" role="dialog">
                <div class="modal-dialog tg-modaldialog">
                    <div class="modal-content tg-modalcontent">
                        <div class="panel-lostps">
                            <form class="tg-form-modal tg-form-signup do-forgot-form">
                                <div class="form-group">
                                    <div class="tg-modalhead">
                                        <h2><?php esc_html_e('Forgot Password', 'listingo_core'); ?></h2>
                                    </div>
                                    <p><?php esc_html_e('Forgot your password? Enter the email address for your account to reset your password.', 'listingo_core'); ?></p>
                                    <div class="forgot-fields">
                                        <div class="form-group">
                                            <input type="email" name="psemail" class="form-control psemail" placeholder="<?php esc_html_e('Email Address*', 'listingo_core'); ?>">
                                            <input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
                                        </div>
                                    </div>
                                    <?php if (isset($captcha_settings) && $captcha_settings === 'enable') { ?>
                                        <div class="domain-captcha">
                                            <div id="recaptcha_forgot"></div>
                                        </div>
                                    <?php } ?>
                                    <button class="tg-btn tg-btn-lg  do-lp-button" type="button"><?php esc_html_e('Submit', 'listingo_core'); ?></button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    new SC_Listingo_Authentication();
}