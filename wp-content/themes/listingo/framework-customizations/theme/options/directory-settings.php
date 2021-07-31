<?php

if (!defined('FW')) {
    die('Forbidden');
}
$dynamic_social_icons_data = array();
$social_links = apply_filters('listingo_get_social_media_icons_list',array());
if( !empty( $social_links ) ){
	foreach( $social_links as $key => $social ){
		$title		= !empty( $social['title'] ) ? $social['title'] : '';
		$dynamic_social_icons_data['tip_'.$key] = array(
							'type' => 'addable-box',
							'label' => $title,
							'desc' => esc_html__('Add tooltip for social icon in profile settings.', 'listingo'),
							'box-options' => array(
								'title' => array('type' => 'text'),
								'content' => array('type' => 'textarea'),
							),
							'template' => '{{- content }}', // box title
							'limit' => 1, // limit the number of boxes that can be added
						);

	}
}
$options = array(
    'directory' => array(
        'title' => esc_html__('Directory Settings', 'listingo'),
        'type' => 'tab',
        'options' => array(
            'general-settings' => array(
                'title' => esc_html__('General Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'general' => array(
                        'title' => esc_html__('General Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'general-group' => array(
                                'type' => 'group',
                                'options' => array(
									'dir_ads_uri' => array(
                                        'label' => esc_html__('Provider Ads Page', 'listingo'),
                                        'type' => 'multi-select',
                                        'population' => 'posts',
                                        'source' => 'page',
                                        'desc' => esc_html__('Please search and select providers ads listing page. This page will display providers all ads on a page if Unyson Ads extension would be installed and active.', 'listingo'),
                                        'limit' => 1
                                    ),
									'dir_adssearch_uri' => array(
                                        'label' => esc_html__('Ads search result page', 'listingo'),
                                        'type' => 'multi-select',
                                        'population' => 'posts',
                                        'source' => 'page',
                                        'desc' => esc_html__('Please select page for ads search result template. This page will display ads search result on a page if Unyson Ads extension would be installed and active.', 'listingo'),
                                        'limit' => 1
									),
									'private_chat'     => array(
										'label' => esc_html__( 'Private Chat', 'listingo' ),
										'type'  => 'select',
										'value' => 'no',
										'desc' => wp_kses( __( 'Please select only one of the following options.<br/> 
																1) In "Hide all over the site" No one users will be able to use the private chat<br/>
																2) In "Paid for providers only" Only providers have to pay to use the chat. Customers will be able to use free of cost<br/>
																3) In "Paid for all type of the users", In this option both customers and providers will be able to use chat free of cost.', 'listingo' ),array(
																				'a' => array(
																					'href' => array(),
																					'title' => array()
																				),
																				'br' => array(),
																				'em' => array(),
																				'strong' => array(),
																			)),
										'choices'	=> array(
											'no'	=> esc_html__('Hide all over the site', 'listingo'),
											'paid_providers'    => esc_html__('Paid for providers only', 'listingo'),
											'paid_all'   		=> esc_html__('Paid for all type of the users', 'listingo'),
											'free_all'   		=> esc_html__('Free for all types of the users', 'listingo'),
											
										)
									),
									'hide_dashboard'     => array(
										'label' => esc_html__( 'Show Packages?', 'listingo' ),
										'type'  => 'select',
										'value' => 'no',
										'desc' => esc_html__('Show packages page when new user get registered or user package get expired', 'listingo'),
										'choices'	=> array(
											'yes'   => esc_html__('Yes', 'listingo'),
											'no'	=> esc_html__('No', 'listingo')
										)
									),
									'sphide_map'     => array(
										'label' => esc_html__( 'Hide Map?', 'listingo' ),
										'type'  => 'select',
										'value' => 'no',
										'desc' => esc_html__('Hide map on profile detail page.', 'listingo'),
										'choices'	=> array(
											'yes'   => esc_html__('Yes', 'listingo'),
											'no'	=> esc_html__('No', 'listingo')
										)
									),
									'remove_qr'     => array(
										'label' => esc_html__( 'QR Code?', 'listingo' ),
										'type'  => 'select',
										'value' => 'no',
										'desc' => esc_html__('Hide QR code from all other the site?', 'listingo'),
										'choices'	=> array(
											'yes'   => esc_html__('Yes', 'listingo'),
											'no'	=> esc_html__('No', 'listingo')
										)
									),
									'exclude_auth'     => array(
										'label' => esc_html__( 'Exclude OTP?', 'listingo' ),
										'type'  => 'select',
										'value' => 'no',
										'desc' => esc_html__('Exlude OTP( one time password ) by email from booking process', 'listingo'),
										'choices'	=> array(
											'yes'   => esc_html__('Yes', 'listingo'),
											'no'	=> esc_html__('No', 'listingo')
										)
									),
									'verify_user'     => array(
										'label' => esc_html__( 'Verify User', 'listingo' ),
										'type'  => 'select',
										'value' => 'none',
										'desc' => esc_html__('Verify user before publicly available. Note: If you select "Need to verify, after registration" then user will not be shown until user will be verified by site owner. If you select "Verify by email" then user will get an email for verification. After clicking link user will be published and available at the website.', 'listingo'),
										'choices'	=> array(
											'verified'  => esc_html__('Verify by email', 'listingo'),
											'none'	=> esc_html__('Need to verify, after registeration', 'listingo')
										)
									),
									'page_design'     => array(
										'label' => esc_html__( 'Provider page design?', 'listingo' ),
										'type'  => 'select',
										'value' => 'view_1',
										'desc' => esc_html__('Select default provider page design.', 'listingo'),
										'choices'	=> array(
											'view_1'  => esc_html__('View 1', 'listingo'),
											'view_2'  => esc_html__('View 2', 'listingo'),
											'view_3'  => esc_html__('View 3', 'listingo'),
											'view_4'  => esc_html__('View 4', 'listingo')
										)
									),
									'show_category'     => array(
										'label' => esc_html__( 'Show category?', 'listingo' ),
										'type'  => 'select',
										'value' => 'none',
										'desc' => esc_html__('Show category on listings. Either you want to show parent category or sub category on listings.', 'listingo'),
										'choices'	=> array(
											'parent'  => esc_html__('Parent Category', 'listingo'),
											'child'	=> esc_html__('Sub Category', 'listingo')
										)
									),
									'apply_job' => array(
                                        'label' => esc_html__('Apply Job Settings', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Select apply job options for visitors. Either visitor should login/register before apply a job or free users can aslo apply.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
										'value' => 'free',
                                        'choices' => array(
                                            'restrict' => esc_html__('Restrict users to login/register before apply', 'listingo'),
                                            'free' => esc_html__('Accept job applications without login/registration', 'listingo'),
                                        )
                                    ),
									'sm_success'     => array(
										'label' => esc_html__( 'Sticky Messages position?', 'listingo' ),
										'type'  => 'select',
										'value' => 'top-right',
										'desc' => esc_html__('Please select sticky messages poistion.', 'listingo'),
										'choices'	=> array(
											'top-left'  => esc_html__('Top Left', 'listingo'),
											'top-right'  => esc_html__('Top Right', 'listingo'),
											'bottom-left'  => esc_html__('Bottom Left', 'listingo'),
											'bottom-right'	=> esc_html__('Bottom Right', 'listingo'),
											'center-center'	=> esc_html__('Middle Center', 'listingo')
										)
									),
                                    'dir_hide_providers' => array(
                                        'label' => esc_html__('Hide related providers?', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Hide related prividers on provider detail page.', 'listingo'),
                                        'choices' => array(
                                            'no' => esc_html__('No', 'listingo'),
                                            'yes' => esc_html__('Yes', 'listingo'),
                                        )
                                    ),
									'approve_articles'     => array(
										'label' => esc_html__( 'Article Approval', 'listingo' ),
										'type'  => 'select',
										'value' => 'auto',
										'desc' => esc_html__('Select either articles should publish or needs admin approval to publish.', 'listingo'),
										'help' => esc_html__('This will work only when article extension will be activated. Please go to Unyson > Articles > Activate', 'listingo'),
										'choices'	=> array(
											'auto'  => 'Auto Approve',
											'need_approval'	=> 'Needs to approve by admin',
										)
									),
									'approve_ads'     => array(
										'label' => esc_html__( 'Ads Approval', 'listingo' ),
										'type'  => 'select',
										'value' => 'auto',
										'desc' => esc_html__('Select either ad should publish or needs admin approval to publish.', 'listingo'),
										'help' => esc_html__('This will work only when ads extension will be activated. Please go to Unyson > Ads > Activate', 'listingo'),
										'choices'	=> array(
											'auto'  => 'Auto Approve',
											'need_approval'	=> 'Needs to approve by admin',
										)
									),
                                    'dir_review_status' => array(
                                        'label' => esc_html__('Review Status', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Please select review status when it post.', 'listingo'),
                                        'help' => esc_html__('If you want to publish review then select status as Publish, otherwise select Pending to make it draft( Only admin ) can approve it.', 'listingo'),
                                        'choices' => array(
                                            'pending' => esc_html__('Pending', 'listingo'),
                                            'publish' => esc_html__('Publish', 'listingo'),
                                        )
                                    ),
                                    'default_avatar' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Default avatar?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Add default user avatar. Minimum dimenstions should be 370x270', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    'default_banner' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Default banner?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Add default user banner. Minimum dimenstions should be 1920x500', 'listingo'),
                                        'images_only' => true,
                                    ),
									'calendar_format'    => array(
										'label' => esc_html__( 'Calender Date Format', 'listingo' ),
										'type'  => 'select',
										'value'  => 'Y-m-d',
										'desc' => esc_html__('Select your calender date format.', 'listingo'),
										'choices'	=> array(
											'Y-m-d'	  => 'Y-m-d',
											'd-m-Y'	  => 'd-m-Y',
										)
									),
									'calendar_locale'    => array(
										'label' => esc_html__( 'Calender Language', 'listingo' ),
										'type'  => 'text',
										'value'  => '',
										'desc' => wp_kses( __( 'Add 639-1 code. It will be two digit code like "en" for english. Leave it empty to use deualt. Click here to get code <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="_blank"> Get Code </a>', 'listingo' ),array(
																						'a' => array(
																							'href' => array(),
																							'title' => array()
																						),
																						'br' => array(),
																						'em' => array(),
																						'strong' => array(),
																					)),
									),
									'more_less'     => array(
										'label' => esc_html__( 'More content', 'listingo' ),
										'type'  => 'select',
										'value' => 'yes',
										'desc' => esc_html__('Show more or less content option in provider detail and job detail.', 'listingo'),
										'choices'	=> array(
											'no'  => esc_html__('No', 'listingo'),
											'yes'  => esc_html__('Yes', 'listingo'),
										)
									),
									'infoformat'     => array(
										'label' => esc_html__( 'Contact information format?', 'listingo' ),
										'type'  => 'select',
										'value' => 'full',
										'desc' => esc_html__('Show email and phone number in full format or with XXX', 'listingo'),
										'choices'	=> array(
											'full'  => esc_html__('Ful Format', 'listingo'),
											'hidden'  => esc_html__('In XXX Format', 'listingo'),
										)
									),
									'show_info_for'     => array(
										'label' => esc_html__( 'Contact information visibility?', 'listingo' ),
										'type'  => 'select',
										'value' => 'all',
										'desc'  => esc_html__('Show email and phone number for logged in or non logged in users. If loggedin users is selected then system will ask to register or login first and then system will show contact informations', 'listingo'),
										'choices'				=> array(
											'all'  				=> esc_html__('Show for all types', 'listingo'),
											'registered_only'   => esc_html__('Show only for loggedin users', 'listingo'),
										)
									),
									'rating_visibility'     => array(
										'label' => esc_html__( 'Rating visibility?', 'listingo' ),
										'type'  => 'select',
										'value' => 'all',
										'desc'  => esc_html__('Show rating and votes for logged in or non logged in users. If loggedin users is selected then system will not show anything until user get loggedin or register.', 'listingo'),
										'choices'				=> array(
											'all'  				=> esc_html__('Show for all types', 'listingo'),
											'registered_only'   => esc_html__('Show only for loggedin users', 'listingo'),
										)
									),
                                )
                            ),
                        )
                    ),
					'packages-box' => array(
                        'title' => esc_html__('Features Access Setting', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'packages-group' => array(
                                'type' => 'group',
                                'options' => array(
									'job_limit' => array(
                                        'type' => 'slider',
                                        'value' => 0,
                                        'properties' => array(
                                            'min' => 0,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Job Limit?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Select default job limit for each user. This limit will be added to provider purchased package. eg if package have 5 job and default limit is 3 then total jobs limit will be 5 + 3 = 8', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    'ad_limit' => array(
                                        'type' => 'slider',
                                        'value' => 0,
                                        'properties' => array(
                                            'min' => 0,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Ad Limit?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Select default ad limit for each user. This limit will be added to provider purchased package. eg if package have 5 ads and default limit is 3 then total ads limit will be 5 + 3 = 8. Please note : Unyson Ads extension should be installed and active.', 'listingo'),
                                        'images_only' => true,
                                    ),
									'article_limit' => array(
                                        'type' => 'slider',
                                        'value' => 0,
                                        'properties' => array(
                                            'min' => 0,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Articles Limit?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Select default article limit for each user. This limit will be added to provider purchased package. eg if package have 5 article and default limit is 3 then total articles limit will be 5 + 3 = 8', 'listingo'),
                                        'images_only' => true,
                                    ),
									'sp_gallery_photos' => array(
                                        'type' => 'slider',
                                        'value' => 5,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Number of gallery photos?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Select default gallery photos in providers dashboard.  Providers can upgrade package to increase limit.', 'listingo'),
                                        'images_only' => true,
                                    ),
									'sp_videos' => array(
                                        'type' => 'slider',
                                        'value' => 5,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Number of videos?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Add number of video links in providers dashboard. Providers can upgrade package to increase limit.', 'listingo'),
                                        'images_only' => true,
                                    ),
									'sp_photos_limit' => array(
                                        'type' => 'slider',
                                        'value' => 5,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Number of profile photos?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Add number of profile in providers dashboard. Providers can upgrade package to increase limit.', 'listingo'),
                                        'images_only' => true,
                                    ),
									'sp_banners_limit' => array(
                                        'type' => 'slider',
                                        'value' => 5,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Number of profile banners?', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Add number of profile banners in providers dashboard. Providers can upgrade package to increase limit.', 'listingo'),
                                        'images_only' => true,
                                    ),
									'sp_system_access' => array(
										'type'         => 'multi-picker',
										'label'        => false,
										'desc'         => false,
										'picker'       => array(
											'gadget' => array(
												'type' => 'select',
												'value' => 'paid',
												'label' => esc_html__('System Access type?', 'listingo'),
												'desc' => wp_kses( __( 'Please select only one of the following options.<br/> 
																		1) In "Paid listings" users will get specific features depending on the package they would purchase. <br/>
																		2) In "free listings" all features would be free of cost throughout. <br/>
																		3) In last option, "listings are free for specific number of users", users can also define how many users will get free subscription throughout their registration period and would be free of cost .<br/> After a set amount of users have registered for free, system will ask the new users to buy a package to get features specified in the package they would select.', 'listingo' ),array(
																						'a' => array(
																							'href' => array(),
																							'title' => array()
																						),
																						'br' => array(),
																						'em' => array(),
																						'strong' => array(),
																					)),
												'choices' => array(
													'paid' => esc_html__('Paid Listings', 'listingo'),
													'free' => esc_html__('Free listings', 'listingo'),
													'specific' => esc_html__('Listings are free for specific number of users.', 'listingo'),
												),
											)
										),
										'choices'      => array(
											'paid'  => array(
												'sp_contact_information'     => array(
													'label' => esc_html__( 'Contact informations', 'listingo' ),
													'type'  => 'select',
													'value' => 'no',
													'desc' => esc_html__('Include contact informations in packages. If it is enabled then users have to buy a package to show contact informations like phone number and email address.', 'listingo'),
													'choices'	=> array(
														'no'  	=> esc_html__("Exclude from packages( Free )", 'listingo'),
														'yes'	=> esc_html__('Include in packages( Paid )', 'listingo')
													)
												),
											),
											'specific'  => array(
												'number' => array(
													'type' => 'slider',
													'value' => 50,
													'properties' => array(
														'min' => 1,
														'max' => 2500,
														'step' => 5, // Set slider step. Always > 0. Could be fractional.
													),
													'label' => esc_html__('User limit?', 'listingo'),
													'hint' => esc_html__('', 'listingo'),
													'desc' => esc_html__('You can define how much users would get lifetime all features free of cost. Default value would be 1', 'listingo'),
													'images_only' => true,
												),
												'sp_contact_information'     => array(
													'label' => esc_html__( 'Contact informations', 'listingo' ),
													'type'  => 'select',
													'value' => 'no',
													'desc' => esc_html__('Include contact informations in packages. If it is enabled then users have to buy a package to show contact informations like phone number and email address.', 'listingo'),
													'choices'	=> array(
														'no'  	=> esc_html__("Exclude from packages( Free )", 'listingo'),
														'yes'	=> esc_html__('Include in packages( Paid )', 'listingo')
													)
												),
												'sp_allow_type'     => array(
													'label' => esc_html__( 'Allow backend free registration?', 'listingo' ),
													'type'  => 'select',
													'value' => 'no',
													'desc' => wp_kses( __( '"Allow free registration from back-end" will enable admin to register users in the free category from the back-end and it would allow those registered users get free subscription throughout their registration period. If disabled option is selected then only those users who register from front-end will be able to use site features for free  throughout their registration period.', 'listingo' ),array(
																						'a' => array(
																							'href' => array(),
																							'title' => array()
																						),
																						'br' => array(),
																						'em' => array(),
																						'strong' => array(),
																					)),
													'choices'	=> array(
														'no'  	=> esc_html__("Disallow free registration from back-end", 'listingo'),
														'yes'	=> esc_html__('Allow free registration from back-end', 'listingo')
													)
												),
											), 
										),
									),
                                )
                            ),
                        )
                    ),
                    'company-box' => array(
                        'title' => esc_html__('Company Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'company-group' => array(
                                'type' => 'group',
                                'options' => array(
                                    'support-section' => array(
                                        'type' => 'html',
                                        'html' => 'Support Section',
                                        'label' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('please note that if you want to show company profile at user dashboard then please do settings which is given below. ', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'images_only' => true,
                                    ),
									'insight_page' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Hide Insight page?', 'listingo'),
                                        'desc' => esc_html__('You can hide insight page from providers dashboard.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Show', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Hide', 'listingo'),
                                        ),
                                    ),
                                    'company_profile' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Show Company Profile', 'listingo'),
                                        'desc' => esc_html__('Enable Company Profile section at user dashboard. Please note insight page should be enabled.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'com_title' => array(
                                        'type' => 'text',
                                        'label' => esc_html__('Add company title', 'listingo'),
                                        'hint' => esc_html__('Leave it empty to hide.', 'listingo'),
                                        'desc' => esc_html__('', 'listingo'),
                                    ),
                                    'com_description' => array(
                                        'type' => 'wp-editor',
                                        'label' => esc_html__('Add company description', 'listingo'),
                                        'hint' => esc_html__('Leave it empty to hide.', 'listingo'),
                                        'desc' => esc_html__('', 'listingo'),
										'size' => 'large', // small, large
										'editor_height' => 400,
                                    ),
                                    'com_person_desg' => array(
                                        'type' => 'text',
                                        'label' => esc_html__('Add designation.', 'listingo'),
                                        'hint' => esc_html__('Leave it empty to hide.', 'listingo'),
                                        'desc' => esc_html__('', 'listingo'),
                                    ),
                                    'com_person_image' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Add person image.', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Leave it empty to hide.', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    'com_logo' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Add company logo', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Leave it empty to hide.', 'listingo'),
                                        'images_only' => true,
                                    ),
                                )
                            ),
                        )
                    ),
                    'directory-box' => array(
                        'title' => esc_html__('Directory Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'directory-group' => array(
                                'type' => 'group',
                                'options' => array(
                                    'dir_profile_page' => array(
                                        'label' => esc_html__('User Dashboard Page.', 'listingo'),
                                        'type' => 'multi-select',
                                        'population' => 'posts',
                                        'source' => 'page',
                                        'desc' => esc_html__('Choose user dashboard page template.', 'listingo'),
                                        'limit' => 1
                                    ),
                                    'dir_datasize' => array(
                                        'type' => 'text',
                                        'value' => '5242880',
                                        'attr' => array(),
                                        'label' => esc_html__('Uplaod Size', 'listingo'),
                                        'desc' => esc_html__('Maximum Image Uplaod Size. Max 5MB, add in bytes. for example 5MB = 5242880 ( 1024x1024x5 )', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                    ),
									 'delete_account_text' => array(
										'label' => esc_html__('Account Deletion Description.', 'listingo'),
										'type' => 'textarea',
										'value' => 'Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim adia minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip extea commodo consequat.',
										'desc' => esc_html__('Add message to show it in security settings, wheb user will go to delete your account.', 'listingo'),
									),
									'invitation_signup_page' => array(
										'label' => esc_html__('Invitation Signup Page.', 'listingo'),
										'type' => 'multi-select',
										'population' => 'posts',
										'source' => 'page',
										'desc' => esc_html__('Choose signup page for invitation form.', 'listingo'),
										'limit' => 1,
										'prepopulate' => 100,
									),
                                )
                            ),
                        )
                    ),
                    'appointment-box' => array(
                        'title' => esc_html__('Appointment Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'appointment_form_page' => array(
                                'label' => esc_html__('Appointment Form Page.', 'listingo'),
                                'type' => 'multi-select',
                                'population' => 'posts',
                                'source' => 'page',
                                'desc' => esc_html__('Choose user appointment form page template.', 'listingo'),
                                'limit' => 1,
                                'prepopulate' => 100,
                            ),
                            'appointment_no_prefix' => array(
                                'label' => esc_html__('Appointment Number Prefix.', 'listingo'),
                                'type' => 'text',
                                'desc' => esc_html__('Enter your appointment no prefix.', 'listingo'),
                            ),
                        )
                    ),
					'tooltips' => array(
                        'title' => esc_html__('Tooltip Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
							
                            'tip_content_bg' => array(
                                'type' => 'color-picker',
								'value' => '#55b555',
								'label' => esc_html__('Content background?', 'listingo'),
								'desc' => esc_html__('Select tooltip content background color.', 'listingo'),
                            ),
							'tip_content_color' => array(
                                'type' => 'color-picker',
								'value' => '#FFF',
								'label' => esc_html__('Content color?', 'listingo'),
								'desc' => esc_html__('Select tooltip content text color.', 'listingo'),
                            ),
							'tip_title_bg' => array(
                                'type' => 'color-picker',
								'value' => '#484848',
								'label' => esc_html__('Title background?', 'listingo'),
								'desc' => esc_html__('Select tooltip title background color.', 'listingo'),
                            ),
							'tip_title_color' => array(
                                'type' => 'color-picker',
								'value' => '#FFF',
								'label' => esc_html__('Content color?', 'listingo'),
								'desc' => esc_html__('Select tooltip title text color.', 'listingo'),
                            ),
							'sections-tip' => array(
								'type' => 'html',
								'html' => 'Sections Tooltip',
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('Please add sections tooltip, leave them empty to hide. Content is compulsory to show tooltip. Titles are optional.', 'listingo'),
							),
							'tip_nicename' => array(
								'type' => 'addable-box',
								'label' => esc_html__('User nicename tooltip', 'listingo'),
								'desc' => esc_html__('Add user nicename hint text in registration form.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_photos' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Photos', 'listingo'),
								'desc' => esc_html__('Add tooltip for profile and banner photos.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_business_hour' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Business Hours', 'listingo'),
								'desc' => esc_html__('Add tooltip for business hours.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_services' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Services', 'listingo'),
								'desc' => esc_html__('Add tooltip for services.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_teams' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Teams', 'listingo'),
								'desc' => esc_html__('Add tooltip for teams.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_jobs' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Jobs', 'listingo'),
								'desc' => esc_html__('Add tooltip for jobs.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_articles' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Articles', 'listingo'),
								'desc' => esc_html__('Add tooltip for articles.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_packages' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Packages', 'listingo'),
								'desc' => esc_html__('Add tooltip for packages.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_privacy' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Privacy', 'listingo'),
								'desc' => esc_html__('Add tooltip for privacy.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_page_design' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Page design', 'listingo'),
								'desc' => esc_html__('Add tooltip for profile page design.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'element-tip' => array(
								'type' => 'html',
								'html' => 'Elements Tooltip',
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('Please add elements tooltip, leave them empty to hide. Content is compulsory to show tooltip. Titles are optional.', 'listingo'),
							),
							'tip_categories' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Categories', 'listingo'),
								'desc' => esc_html__('Add tooltip for categories selection in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_phone' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Phone', 'listingo'),
								'desc' => esc_html__('Add tooltip for phone number in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_zip' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Zipcode', 'listingo'),
								'desc' => esc_html__('Add tooltip for zipcode in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_tagline' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Tagline', 'listingo'),
								'desc' => esc_html__('Add tooltip for tagline in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_awards' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Certificates and awards', 'listingo'),
								'desc' => esc_html__('Add tooltip for certificates and awards in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_experience' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Experience', 'listingo'),
								'desc' => esc_html__('Add tooltip for experience in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_qualification' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Qualification', 'listingo'),
								'desc' => esc_html__('Add tooltip for qualification in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_amenities' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Amenities', 'listingo'),
								'desc' => esc_html__('Add tooltip for amenities in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_chat' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Facebook Chat', 'listingo'),
								'desc' => esc_html__('Add tooltip for facebook chat in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_location' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Location', 'listingo'),
								'desc' => esc_html__('Add tooltip for location in profile settings.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'menu-tip' => array(
								'type' => 'html',
								'html' => 'Dashboard Menu Tooltip',
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('Please add dashboard menu tooltip, leave them empty to hide. Content is compulsory to show tooltip. Titles are optional.', 'listingo'),
							),
							'tip_menu_settings' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Profile Settings', 'listingo'),
								'desc' => esc_html__('Add tooltip for profile settings menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_hours' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Business Hours', 'listingo'),
								'desc' => esc_html__('Add tooltip for business hours menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_services' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Services', 'listingo'),
								'desc' => esc_html__('Add tooltip for services menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_teams' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Teams', 'listingo'),
								'desc' => esc_html__('Add tooltip for teams menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_jobs' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Jobs', 'listingo'),
								'desc' => esc_html__('Add tooltip for jobs menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_articles' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Articles', 'listingo'),
								'desc' => esc_html__('Add tooltip for articles menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_appointments' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Appointments', 'listingo'),
								'desc' => esc_html__('Add tooltip for appointments menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_favorites' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Favorites', 'listingo'),
								'desc' => esc_html__('Add tooltip for favorites menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_packages' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Packages', 'listingo'),
								'desc' => esc_html__('Add tooltip for packages menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_security' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Security', 'listingo'),
								'desc' => esc_html__('Add tooltip for security menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_privacy' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Privacy', 'listingo'),
								'desc' => esc_html__('Add tooltip for privacy menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_earnings' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Earnings', 'listingo'),
								'desc' => esc_html__('Add tooltip for earnings menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							'tip_menu_design' => array(
								'type' => 'addable-box',
								'label' => esc_html__('Profile Design', 'listingo'),
								'desc' => esc_html__('Add tooltip for profile design menu.', 'listingo'),
								'box-options' => array(
									'title' => array('type' => 'text'),
									'content' => array('type' => 'textarea'),
								),
								'template' => '{{- content }}', // box title
								'limit' => 1, // limit the number of boxes that can be added
							),
							
							'social-tip' => array(
								'type' => 'html',
								'html' => 'Social icons tooltip',
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('Please add social icons tooltip, leave them empty to hide. Content is compulsory to show tooltip. Titles are optional.', 'listingo'),
							),
							$dynamic_social_icons_data
                        )
                    ),
                )
            ),
            'search-settings' => array(
                'title' => esc_html__('Search Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'map-box' => array(
                        'title' => esc_html__('Map Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'map-group' => array(
                                'type' => 'group',
                                'options' => array(
                                    'dir_map_type' => array(
                                        'label' => esc_html__('Map Type', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Select Map Type.', 'listingo'),
                                        'choices' => array(
                                            'ROADMAP' => 'ROADMAP',
                                            'SATELLITE' => 'SATELLITE',
                                            'HYBRID' => 'HYBRID',
                                            'TERRAIN' => 'TERRAIN',
                                        )
                                    ),
                                    'map_styles' => array(
                                        'label' => esc_html__('Map Style', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Select map style. It will override map type.', 'listingo'),
                                        'choices' => array(
                                            'none' => esc_html__('NONE', 'listingo'),
                                            'view_1' => esc_html__('Default', 'listingo'),
                                            'view_2' => esc_html__('View 2', 'listingo'),
                                            'view_3' => esc_html__('View 3', 'listingo'),
                                            'view_4' => esc_html__('View 4', 'listingo'),
                                            'view_5' => esc_html__('View 5', 'listingo'),
                                            'view_6' => esc_html__('View 6', 'listingo'),
                                        )
                                    ),
                                    'dir_map_scroll' => array(
                                        'label' => esc_html__('Map Dragable', 'listingo'),
                                        'type' => 'select',
                                        'desc' => esc_html__('Enbale map dragable', 'listingo'),
                                        'value' => 'false',
                                        'choices' => array(
                                            'false' => esc_html__('No', 'listingo'),
                                            'true' => esc_html__('Yes', 'listingo'),
                                        )
                                    ),
                                    'dir_cluster_marker' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Cluster Map Marker', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Default Cluster map marker.', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    'dir_cluster_color' => array(
                                        'type' => 'color-picker',
                                        'value' => '#505050',
                                        'attr' => array(),
                                        'label' => esc_html__('Map Cluster Color', 'listingo'),
                                        'desc' => esc_html__('Map cluster text color', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                    ),
                                    'dir_map_marker' => array(
                                        'type' => 'upload',
                                        'label' => esc_html__('Map Marker', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Default map marker. It will be used all over the site.', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    'dir_zoom' => array(
                                        'type' => 'slider',
                                        'value' => 11,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 20,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                        'label' => esc_html__('Map Zoom', 'listingo'),
                                        'hint' => esc_html__('', 'listingo'),
                                        'desc' => esc_html__('Select map zoom level', 'listingo'),
                                        'images_only' => true,
                                    ),
                                    
                                    'dir_latitude' => array(
                                        'type' => 'text',
                                        'value' => '51.5001524',
                                        'attr' => array(),
                                        'label' => esc_html__('Latitude', 'listingo'),
                                        'desc' => esc_html__('Default Latitude for map.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                    ),
                                    'dir_longitude' => array(
                                        'type' => 'text',
                                        'value' => '-0.1262362',
                                        'attr' => array(),
                                        'label' => esc_html__('Longitude', 'listingo'),
                                        'desc' => esc_html__('Default longitude for map.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                    ),
                                )
                            ),
                        )
                    ),
                    'search-box' => array(
                        'title' => esc_html__('Search Settings.', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'search-group' => array(
                                'type' => 'group',
                                'options' => array(
                                    'search_page_map' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Search result map', 'listingo'),
                                        'desc' => esc_html__('Enable/Disble google map at search page.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'dir_search_view' => array(
                                        'type' => 'select',
                                        'value' => 'list',
                                        'attr' => array(),
                                        'label' => esc_html__('Search Listing View', 'listingo'),
                                        'desc' => esc_html__('', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'choices' => array(
											'grid-default' => esc_html__('Grid Default', 'listingo'),
											'list-default' => esc_html__('List Default', 'listingo'),
                                            'list' => esc_html__('List with map at top', 'listingo'),
                                            'grid' => esc_html__('Grid with map at top', 'listingo'),
											'grid-left' => esc_html__('Grid with map at right', 'listingo'),
											'list-left' => esc_html__('List with map at right', 'listingo'),
											
                                        ),
                                    ),
                                    'dir_search_pagination' => array(
                                        'type' => 'slider',
                                        'attr' => array(),
                                        'label' => esc_html__('Search Result per page', 'listingo'),
                                        'desc' => esc_html__('', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'value' => 10,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 100,
                                            'step' => 1, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                    ),
                                    'dir_search_page' => array(
                                        'label' => esc_html__('Search Page', 'listingo'),
                                        'type' => 'multi-select',
                                        'population' => 'posts',
                                        'source' => 'page',
                                        'desc' => esc_html__('Search result page.', 'listingo'),
                                        'limit' => 1
                                    ),
                                    'dir_keywords' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Keywords Search', 'listingo'),
                                        'desc' => esc_html__('Enable Keywords Search', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
									'dir_gender' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Gender Search?', 'listingo'),
                                        'desc' => esc_html__('Enable gender search', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'dir_location' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Geo location autocomplete', 'listingo'),
                                        'desc' => esc_html__('Enable geo location autocomplete field', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'dir_radius' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Radius Search', 'listingo'),
                                        'desc' => esc_html__('Enable Radius Search, Note it will be display when geo location will be enable.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'dir_default_radius' => array(
                                        'type' => 'slider',
                                        'attr' => array(),
                                        'label' => esc_html__('Default radius', 'listingo'),
                                        'desc' => esc_html__('Please select default radius for radius slider.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'value' => 50,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 1000,
                                            'step' => 2, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                    ),
                                    'dir_max_radius' => array(
                                        'type' => 'slider',
                                        'attr' => array(),
                                        'label' => esc_html__('Maximum radius', 'listingo'),
                                        'desc' => esc_html__('Please select maximum radius for radius slider.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'value' => 300,
                                        'properties' => array(
                                            'min' => 1,
                                            'max' => 1000,
                                            'step' => 5, // Set slider step. Always > 0. Could be fractional.
                                        ),
                                    ),
                                    'dir_distance_type' => array(
                                        'type' => 'select',
                                        'value' => 'list',
                                        'attr' => array(),
                                        'label' => esc_html__('Distance in?', 'listingo'),
                                        'desc' => esc_html__('Search location radius in miles or kilometers.', 'listingo'),
                                        'help' => esc_html__('', 'listingo'),
                                        'choices' => array(
                                            'mi' => esc_html__('Miles', 'listingo'),
                                            'km' => esc_html__('Kilometers', 'listingo'),
                                        ),
                                    ),
                                    'country_restrict' => array(
                                        'type' => 'multi-picker',
                                        'label' => false,
                                        'desc' => false,
                                        'picker' => array(
                                            'gadget' => array(
                                                'type' => 'switch',
                                                'value' => 'disable',
                                                'label' => esc_html__('Restrict Country', 'listingo'),
                                                'desc' => esc_html__('Restrict Country in geo location auto complete field.', 'listingo'),
                                                'left-choice' => array(
                                                    'value' => 'enable',
                                                    'label' => esc_html__('Enable', 'listingo'),
                                                ),
                                                'right-choice' => array(
                                                    'value' => 'disable',
                                                    'label' => esc_html__('Disable', 'listingo'),
                                                ),
                                            )
                                        ),
                                        'choices' => array(
                                            'enable' => array(
                                                'country_code' => array(
                                                    'type' => 'text',
                                                    'value' => 'us',
                                                    'label' => esc_html__('Country Code', 'listingo'),
                                                    'desc' => wp_kses(__('Add your 2 digit country code eg : us, to check country code please visit link <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank"> Get Code </a>', 'listingo'), array(
                                                        'a' => array(
                                                            'href' => array(),
                                                            'title' => array()
                                                        ),
                                                        'br' => array(),
                                                        'em' => array(),
                                                        'strong' => array(),
                                                    )),
                                                ),
                                            )
                                        ),
                                        'show_borders' => true,
                                    ),
                                    'language_search' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Language search', 'listingo'),
                                        'desc' => esc_html__('Enable or disbale language search.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                    'country_cities' => array(
                                        'label' => esc_html__('Search by country/city', 'listingo'),
										'desc' => esc_html__('Enable country/cities search. Pleae note by enable this field, search by country and cities wil be shown in filters all over the site.', 'listingo'),
										'type' => 'select',
										'value' => 'enable',
										'choices' => array(
											'countries_only' => esc_html__('Countries Only', 'listingo'),
											'enable' => esc_html__('Both', 'listingo'),
											'none' => esc_html__('Hide', 'listingo'),
										)
                                    ),
                                    'dir_search_insurance' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Insurance base search', 'listingo'),
                                        'desc' => esc_html__('Enable insurance base search', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
									'zip_search' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Zip code search', 'listingo'),
                                        'desc' => esc_html__('Enable or disbale zip code search.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
									'misc_search' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Misc search', 'listingo'),
                                        'desc' => esc_html__('Enable or disbale misc search. It will include profile photo search.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
									'apt_search' => array(
                                        'type' => 'switch',
                                        'value' => 'enable',
                                        'label' => esc_html__('Appointment search?', 'listingo'),
                                        'desc' => esc_html__('Enable or disbale appointment search. It will include both online appointment search.', 'listingo'),
                                        'left-choice' => array(
                                            'value' => 'enable',
                                            'label' => esc_html__('Enable', 'listingo'),
                                        ),
                                        'right-choice' => array(
                                            'value' => 'disable',
                                            'label' => esc_html__('Disable', 'listingo'),
                                        ),
                                    ),
                                )
                            ),
                        )
                    ),
                ),
            ),
        )
    )
);
