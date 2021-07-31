<?php
/**
 * @Google connect
 * @return 
 */
class Google_Connect {

    private $clientId 		= '';
    private $clientSecret 	= '';
    private $app_name 		= '';
	private $redirectURL 	= '';

    public function __construct() {
        add_action('do_google_connect', array(&$this, 'do_google_connect'));
		add_action('wp_ajax_listingo_google_connect', array(&$this, 'get_login_url'));
		add_action('wp_ajax_nopriv_listingo_google_connect', array(&$this, 'get_login_url'));
    }
	
	/**
     * init api credentials
     *
     * @link https://codex.wordpress.org/Function_Reference/get_users
     * @return bool|void
     */
    private function initApi() {
		if (function_exists('fw_get_db_settings_option')) {
			$this->clientId = fw_get_db_settings_option('client_id', $default_value = null);
			$this->clientSecret = fw_get_db_settings_option('client_secret', $default_value = null);
			$this->app_name = fw_get_db_settings_option('app_name', $default_value = esc_html__('Google Connect', 'listingo_core'));
		}

		$this->redirectURL 	= listingo_new_social_login_url('googlelogin');
		
		$client = new Google_Client();
		$client->setApplicationName($this->app_name);
		// Visit https://code.google.com/apis/console?api=plus to generate your
		$client->setClientId($this->clientId);
		$client->setClientSecret($this->clientSecret);
		$client->setRedirectUri($this->redirectURL);
		
        return $client;
    }
	
	/**
     * get google connect
     *
     * @link https://codex.wordpress.org/Function_Reference/get_users
     * @return bool|void
     */
    public function do_google_connect() {
		$redirectURL = listingo_new_social_login_url( 'googlelogin' );

		$client = $this->initApi();
		$oauth2 = new Google_Oauth2Service( $client );

		if ( isset( $_GET[ 'code' ] ) ) {
			//set_site_transient( listingo_get_uniqid().'_google_r', $_GET['redirect'], 3600);
			$client->authenticate( $_GET[ 'code' ] );
			$access_token = $client->getAccessToken();
			set_site_transient( listingo_get_uniqid() . '_sp_google_connect', $access_token, 3600 );
			header( 'Location: ' . filter_var( listingo_new_social_login_url( 'googlelogin' ), FILTER_SANITIZE_URL ) );
			exit;
		}

		$access_token = get_site_transient( listingo_get_uniqid() . '_sp_google_connect' );

		if ( $access_token !== false ) {
			$client->setAccessToken( $access_token );
		}

		if ( $client->getAccessToken() ) {
			$user = $oauth2->userinfo->get();
			set_site_transient( listingo_get_uniqid() . '_sp_google_connect', $client->getAccessToken(), 3600 );
			$email = filter_var( $user[ 'email' ], FILTER_SANITIZE_EMAIL );

			if ( !is_user_logged_in() ) {
				$ID = email_exists( $email );
				if ( $ID == false ) { // Real register
					do_action('listingo_create_social_users','google',$user);
				} else if ( $ID ) { // Login
					do_action('listingo_do_social_login',$ID);
				}
			}
		}
    }
	
	/**
     * get login URL
     *
     * @link https://codex.wordpress.org/Function_Reference/get_users
     * @return bool|void
     */
	public function get_login_url() {
		if( function_exists('listingo_is_demo_site') ) { 
			listingo_is_demo_site() ;
		}; //if demo site then prevent
		
		// Set the Redirect URL:
		$client = $this->initApi();
		$oauth2 = new Google_Oauth2Service($client);
		$authUrl = $client->createAuthUrl();

		$json['type'] 	 		= 'success';
		$json['authUrl']    	= $authUrl;
		$json['message'] 		= esc_html__('Please wait while you are redirecting to google+ for authorizations.', 'listingo_core');
		echo json_encode($json);
		die();
	}
}
new Google_Connect();
