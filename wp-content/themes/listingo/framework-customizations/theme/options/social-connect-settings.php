<?php

if (!defined('FW')) {
    die('Forbidden');
}



if( function_exists('listingo_new_social_login_url') ){
	$redirect_google_url	= listingo_new_social_login_url('googlelogin');
	$redirect_facebook_url	= listingo_new_social_login_url('facebooklogin');
}else{
	$redirect_google_url	= site_url('wp-login.php') . '?googlelogin=1';
	$redirect_facebook_url	= site_url('wp-login.php') . '?facebooklogin=1';
}
	
$options = array (
    'connect_settings' => array (
        'type'    => 'tab' ,
        'title'   => esc_html__('Social Connect' , 'listingo') ,
        'options' => array (
			'google' => array(
                'title' => esc_html__('Google', 'listingo'),
                'type' => 'tab',
                'options' => array(
					'enable_google_connect' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'desc' => esc_html__('Enable google connect/login?', 'listingo'),
                        'label' => esc_html__('Google connect?', 'listingo'),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disbale', 'listingo'),
                        ),
                    ),
					'google_settings' => array(
                        'type' => 'html',
                        'html' => esc_html__('Google Settings', 'listingo'),
                        'label' => esc_html__('Settings', 'listingo'),
						'desc' => wp_kses( __( 'Add you system to google domain <a href="https://www.google.com/accounts/ManageDomains" target="_blank">Add your domain to Google system!</a> and then create your own API key <a href="https://code.google.com/apis/console" target="_blank">You have to create and API access</a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
                    ),
					'redirect_url' => array(
                        'type' => 'html',
						'html' 	=> $redirect_google_url,
                        'label' => esc_html__('Authorized redirect URIs', 'listingo'),
                        'desc'  => wp_kses( __( 'Copy above link and add in your google project as Authorized redirect URIs. For more detail you can also read this article : <a href="https://themographics.ticksy.com/article/12616/" target="_blank">Check Settings</a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
                    ),
					'client_id' => array(
                        'type' => 'text',
                        'label' => esc_html__('Client ID', 'listingo'),
                        'desc' => esc_html__('Add client ID here.', 'listingo'),
                    ),
					'client_secret' => array(
                        'type' => 'text',
                        'label' => esc_html__('Client secret', 'listingo'),
                        'desc' => esc_html__('Add client secret here.', 'listingo'),
                    ),
					'app_name' => array(
                        'type' => 'text',
						'value' => esc_html__('Google Connect', 'listingo'),
                        'label' => esc_html__('Application name', 'listingo'),
                        'desc' => esc_html__('Add application name here.', 'listingo'),
                    ),
	
					'g_prefix' => array(
                        'type' => 'text',
						'value' => esc_html__('google-', 'listingo'),
                        'label' => esc_html__('User prefix (optional)', 'listingo'),
                        'desc' => esc_html__('Add prefix for new registered user before name. This will be used before username. like http://www.yoursite.com/provider-category/google-abc', 'listingo'),
                    ),
                )
            ),
            'facebook' => array(
                'title'   => esc_html__( 'Facebook', 'listingo' ),
                'type'    => 'tab',
                'options' => array(
					'enable_facebook_connect' => array(
                        'type' => 'switch',
                        'value' => 'disable',
                        'desc' => esc_html__('Enable facebook connect/login?', 'listingo'),
                        'label' => esc_html__('Facebook connect?', 'listingo'),
                        'right-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'listingo'),
                        ),
                        'left-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disbale', 'listingo'),
                        ),
                    ),
					'facebook_settings' => array(
                        'type' => 'html',
                        'html' => esc_html__('Facebook Settings', 'listingo'),
                        'label' => esc_html__('Settings', 'listingo'),
						'desc' => wp_kses( __( 'Register your app and get APP ID and APP Secret <a href="https://developers.facebook.com/docs/apps/register" target="_blank">Create APP</a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
                    ),
					'redirect_url' => array(
                        'type' => 'html',
						'html' 	=> $redirect_facebook_url,
                        'label' => esc_html__('Authorized redirect URIs', 'listingo'),
                        'desc'  => wp_kses( __( 'Copy this link and add in your facebook APP as Valid OAuth redirect URIs. For more detail you can also read this article : <a href="https://themographics.ticksy.com/article/12616/" target="_blank">Check Settings</a>', 'listingo' ),array(
																		'a' => array(
																			'href' => array(),
																			'title' => array()
																		),
																		'br' => array(),
																		'em' => array(),
																		'strong' => array(),
																	)),
                    ),
                    'app_id' => array(
                        'type' => 'text',
                        'label' => esc_html__('APP ID', 'listingo'),
                        'desc' => esc_html__('Add your APP ID here.', 'listingo'),
                    ),
                    'app_secret' => array(
                        'type' => 'text',
                        'label' => esc_html__('APP Secret', 'listingo'),
                        'desc' => esc_html__('Add your APP secret here.', 'listingo'),
                    ),
	
					'fb_prefix' => array(
                        'type' => 'text',
						'value' => esc_html__('facebook-', 'listingo'),
                        'label' => esc_html__('User prefix (optional)', 'listingo'),
                        'desc' => esc_html__('Add prefix for new registered user before name. This will be used before username. like http://www.yoursite.com/provider-category/facebook-abc', 'listingo'),
                    ),
                )
             ),
        )
    )
);
