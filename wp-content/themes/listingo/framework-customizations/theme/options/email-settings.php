<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'email_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Email Settings', 'listingo'),
        'options' => array(
            'email_general_settings' => array(
                'title' => esc_html__('Email Settings', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'email_from_name' => array(
                        'type' => 'text',
                        'value' => 'Listingo',
                        'label' => esc_html__('Email From Name', 'listingo'),
                        'desc' => esc_html__('Add From Name when email sent. Like: Listingo', 'listingo'),
                    ),
                    'email_from_id' => array(
                        'type' => 'text',
                        'value' => 'info@no-reply.com',
                        'label' => esc_html__('From : Email ID', 'listingo'),
                        'desc' => esc_html__('Add From Email when email sent. Like: info@no-reply.com', 'listingo'),
                    ),
                    'email_logo' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Email Logo', 'listingo'),
                        'desc' => esc_html__('Upload your email logo here.', 'listingo'),
                        'images_only' => true,
                        'files_ext' => array('png', 'jpg', 'jpeg', 'gif'),
                        'extra_mime_types' => array('audio/x-aiff, aif aiff')
                    ),
                    'email_banner' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Email Banner', 'listingo'),
                        'desc' => esc_html__('Upload your email banner here.', 'listingo'),
                        'images_only' => true,
                        'files_ext' => array('png', 'jpg', 'jpeg', 'gif'),
                        'extra_mime_types' => array('audio/x-aiff, aif aiff')
                    ),
                    'email_sender_avatar' => array(
                        'type' => 'upload',
                        'label' => esc_html__('Email Sender Avatar', 'listingo'),
                        'desc' => esc_html__('Upload email sender picture here.', 'listingo'),
                        'images_only' => true,
                        'files_ext' => array('png', 'jpg', 'jpeg', 'gif'),
                        'extra_mime_types' => array('audio/x-aiff, aif aiff')
                    ),
                    'email_sender_name' => array(
                        'type' => 'text',
                        'label' => esc_html__('Email Sender Name', 'listingo'),
                        'desc' => esc_html__('Add email sender name here like: Shawn Biyeam. Default your site name will be used.', 'listingo'),
                    ),
                    'email_sender_tagline' => array(
                        'type' => 'text',
                        'label' => esc_html__('Email Sender Tagline', 'listingo'),
                        'desc' => esc_html__('Add email sender tagline here like: Team Listingo. Default your site tagline will be used.', 'listingo'),
                    ),
                    'email_sender_url' => array(
                        'type' => 'text',
                        'label' => esc_html__('Email Sender URL', 'listingo'),
                        'desc' => esc_html__('Add email sender url here.', 'listingo'),
                    ),
                )
            ),
            'general_templates' => array(
                'title' => esc_html__('General Templates', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'register_user' => array(
                        'title' => esc_html__('Registration', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
							'customer_email' => array(
								'title' => esc_html__('Customer Email', 'listingo'),
								'type' => 'tab',
								'options' => array(
									'cus_regis_email' => array(
										'type' => 'html',
										'html' => esc_html__('Email Template For Customers/Service Seekers', 'listingo'),
										'label' => esc_html__('', 'listingo'),
										'desc' => esc_html__('This email will be sent to new registered customer', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'images_only' => true,
									),
									'register_subject' => array(
										'type' => 'text',
										'value' => 'Thank you for registering!',
										'label' => esc_html__('Subject', 'listingo'),
										'desc' => esc_html__('Please add subject for email', 'listingo'),
									),
									'cus_info' => array(
										'type' => 'html',
										'value' => '',
										'attr' => array(),
										'label' => esc_html__('Email Settings variables', 'listingo'),
										'desc' => esc_html__('', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'html' => '%name% — To display the person\'s name. <br/>
											%email% — To display the person\'s email address.<br/>
											%username% — To display the username for login.<br/>
											%password% — To display the password for login.<br/>
											%signature% — To display site logo.<br/>',
									),
									'register_content' => array(
										'type' => 'wp-editor',
										'value' => 'Hi %name%!<br/>

											Thanks for registering at Listingo. You can now login to manage your account using the following credentials:
											<br/>
											Username: %email%<br/>
											Password: %password%<br/>

											%signature%',
										'attr' => array(),
										'label' => esc_html__('Email Contents', 'listingo'),
										'desc' => esc_html__('', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'size' => 'large', // small, large
										'editor_height' => 400,
									),
								)
							),
							'provider_email' => array(
								'title' => esc_html__('Provider Email', 'listingo'),
								'type' => 'tab',
								'options' => array(
									'provider_regis_email' => array(
										'type' => 'html',
										'html' => esc_html__('Email Template For Service Providers( Business and Professionals )', 'listingo'),
										'label' => esc_html__('', 'listingo'),
										'desc' => esc_html__('This email will be sent to new registered providers.', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'images_only' => true,
									),
									'provider_register_subject' => array(
										'type' => 'text',
										'value' => 'Thank you for registering!',
										'label' => esc_html__('Subject', 'listingo'),
										'desc' => esc_html__('Please add subject for email', 'listingo'),
									),
									'provider_info' => array(
										'type' => 'html',
										'value' => '',
										'attr' => array(),
										'label' => esc_html__('Email Settings variables', 'listingo'),
										'desc' => esc_html__('', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'html' => '%name% — To display the person\'s name. <br/>
											%email% — To display the person\'s email address.<br/>
											%username% — To display the username for login.<br/>
											%password% — To display the password for login.<br/>
											%signature% — To display site logo.<br/>',
									),
									'provider_register_content' => array(
										'type' => 'wp-editor',
										'value' => 'Hi %name%!<br/>

											Thanks for registering at Listingo. You can now login to manage your account using the following credentials:
											<br/>
											Username: %email%<br/>
											Password: %password%<br/>

											%signature%',
										'attr' => array(),
										'label' => esc_html__('Email Contents', 'listingo'),
										'desc' => esc_html__('', 'listingo'),
										'help' => esc_html__('', 'listingo'),
										'size' => 'large', // small, large
										'editor_height' => 400,
									)
								)
							)
                        )
                    ),
                    'lp_email' => array(
                        'title' => esc_html__('Lost Password', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'lp_subject' => array(
                                'type' => 'text',
                                'value' => 'Forgot Password',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for lost password.', 'listingo'),
                            ),
                            'lp_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email settings', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display the person\'s name. <br/>
								%link% — To display the lost password link.<br/>
								%signature% — To display site logo.<br/>',
                            ),
                            'lp_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%!<br/>

											<p><strong>Lost Password reset</strong></p>
											<p>Someone requested to reset the password of following account:</p>
											<p>Email Address: %account_email%</p>
											<p>If this was a mistake, just ignore this email and nothing will happen.</p>
											<p>To reset your password, click reset link below:</p>
											<p><a href="%link%">Reset</a></p><br />
											%signature%
											',
                                'attr' => array(),
                                'label' => esc_html__('Lost Password?', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        ),
                    ),
					'account_verification_email' => array(
                        'title' => esc_html__('Account Verification', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'ave_subject' => array(
                                'type' => 'text',
                                'value' => 'Account Verification',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for account verification.', 'listingo'),
                            ),
                            'ave_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email settings', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display the person\'s name. <br/>
								%link% — Verify account link.<br/>
								%signature% — To display site logo.<br/>',
                            ),
                            'ave_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%!<br/>

											<p><strong>Verify Your Account</strong></p>
											<p>You account has created with given below email address:</p>
											<p>Email Address: %account_email%</p>
											<p>If this was a mistake, just ignore this email and nothing will happen.</p>
											<p>To verifiy your account, click below link:</p>
											<p><a href="%link%">Verify</a></p><br />
											%signature%
											',
                                'attr' => array(),
                                'label' => esc_html__('Account Verification?', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        ),
                    ),
                    'invitation' => array(
                        'title' => esc_html__('Invitation', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'invitation_subject' => array(
                                'type' => 'text',
                                'value' => 'You have invitation for signup!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for email', 'listingo'),
                            ),
                            'invitation_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%username% — To display the username who send invitation. <br/>
								%link% — To display link for signup.<br/>
								%message% — To display user message.<br/>
								%signature% — To display site logo.<br/>',
                            ),
                            'invitation_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>

                                            %username% has invited you to signup at %link%. You have invitation message given below
                                            <br/>
                                            %message%
                                            <br/>
                                            %signature%',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
                    'contact' => array(
                        'title' => esc_html__('Contact Form', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'contact_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used by professional and businesses to send an email.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'contact_subject' => array(
                                'type' => 'text',
                                'value' => 'Contact Form Received',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for email', 'listingo'),
                            ),
                            'contact_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Contact subject <br/>
                                            %name% — To display username who contact the professional.<br/>
                                            %email% — To display email who contact the professional.<br/>
                                            %phone% — To display phone number who contact the professional.<br/>
                                            %message% — To display user message.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'contact_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                        A person has contacted you, description of message is given below.<br/><br/>
										Subject : %subject%<br/>
										Name : %name%<br/>
										Email : %email%<br/>
										Phone Number : %phone%<br/>
										Message : %message%<br/><br/><br/>

										%signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
                )
            ),
            'admin_templates' => array(
                'title' => esc_html__('Admin Templates', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'admin_email' => array(
                        'title' => esc_html__('Admin Email Content - Registration', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'admin_email_section' => array(
                                'type' => 'html',
                                'html' => esc_html__('Admin Email', 'listingo'),
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This email will be sent to admin when new user register on your site.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'images_only' => true,
                            ),
                            'admin_register_subject' => array(
                                'type' => 'text',
                                'value' => 'New Registration!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Add email subject.', 'listingo'),
                            ),
                            'admin_email' => array(
                                'type' => 'text',
                                'value' => 'info@yourdomain.com',
                                'label' => esc_html__('Admin email address', 'listingo'),
                                'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
                            ),
                            'admin_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%username% — To display new registered  username. <br/>
						%link% — To display the new registered user profile page at admin site.<br/>
						%email% — To display the username for login.<br/>
						%signature% — To display site logo.<br/>',
                            ),
                            'admin_register_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hey!<br/>

									A new user "%username%" with email address "%email%" has registered on your website. Please login to check user detail.
									<br/>
									You can check user detail at: %link%<br/><br/>
									
									%signature%',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            /**
                             * Also available
                             * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                             */
                            )
                        )
                    ),
                    'claim' => array(
                        'title' => esc_html__('Claim/Report Email', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'claim_admin_email' => array(
                                'type' => 'text',
                                'value' => 'info@yourdomain.com',
                                'label' => esc_html__('Admin email address to send claim/report email', 'listingo'),
                                'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
                            ),
                            'claim_subject' => array(
                                'type' => 'text',
                                'value' => 'A user has claimed!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'claim_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%claimed_user% — To display the username who has claimed. <br/>
						%claimed_by% — To display the username who has claimed. <br/>
						%message% — To display message of visitor user.<br/>
                                                %signature%',
                            ),
                            'claim_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                            This %claimed_user% has been claimed by %claimed_by%
                                            <br/><br/>
                                            Message is given below.
                                            <br/>
                                            %message%
                                            <br/><br/>
                                            %signature%,<br/>',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
					'delete_account' => array(
						'title' => esc_html__('Delete Account', 'listingo'),
						'type' => 'tab',
						'options' => array(
							'delete_hint' => array(
								'type' => 'html',
								'html' => esc_html__('Admin Email', 'listingo'),
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('This email will be sent to admin when any provider/user delete their account.', 'listingo'),
								'help' => esc_html__('', 'listingo'),
							),
							'delete_subject' => array(
								'type' => 'text',
								'value' => 'Account Delete',
								'label' => esc_html__('Subject', 'listingo'),
								'desc' => esc_html__('Add email subject.', 'listingo'),
							),
							'delete_email' => array(
								'type' => 'text',
								'value' => 'info@domain.com',
								'label' => esc_html__('Admin email address', 'listingo'),
								'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
							),
							'delete_info' => array(
								'type'  => 'html',
								'value' => '',
								'attr'  => array(),
								'label' => esc_html__('Email Settings variables', 'listingo'),
								'desc'  => esc_html__('', 'listingo'),
								'help'  => esc_html__('', 'listingo'),
								'html'  => '%reason% — Reason to leave  account.<br/>
								%username% — Username of deleted user.<br/>
								%email% — Email address of deleted users.<br/>
								%signature% — To display site logo.<br/>',
							),
							'delete_content' => array(
								'type'  => 'wp-editor',
								'value' => 'Hi,<br/>

											An existing user has deleted account due to following reason: 
											<br/>
											%reason%
											<br/><br/>
                                            %signature%,<br/>',
								'attr'  => array(),
								'label' => esc_html__('Email Contents', 'listingo'),
								'desc'  => esc_html__('', 'listingo'),
								'help'  => esc_html__('', 'listingo'),
								'size' => 'large', // small, large
								'editor_height' => 400,
							)
						)
					),
					'article_approval' => array(
						'title' => esc_html__('Article Needs Approval', 'listingo'),
						'type' => 'tab',
						'options' => array(
							'article_hint' => array(
								'type' => 'html',
								'html' => esc_html__('Admin Email', 'listingo'),
								'label' => esc_html__('', 'listingo'),
								'desc' => esc_html__('This email will be sent to admin when any provider/user post an article. This email will only be sent when article settings will be set as needs approval from admin: Theme Settings > Directory Settings > Article Approval', 'listingo'),
								'help' => esc_html__('', 'listingo'),
							),
							'article_subject' => array(
								'type' => 'text',
								'value' => 'Article Needs Approval',
								'label' => esc_html__('Subject', 'listingo'),
								'desc' => esc_html__('Add email subject.', 'listingo'),
							),
							'article_email' => array(
								'type' => 'text',
								'value' => 'info@domain.com',
								'label' => esc_html__('Admin email address', 'listingo'),
								'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
							),
							'article_info' => array(
								'type'  => 'html',
								'value' => '',
								'attr'  => array(),
								'label' => esc_html__('Email Settings variables', 'listingo'),
								'desc'  => esc_html__('', 'listingo'),
								'help'  => esc_html__('', 'listingo'),
								'html'  => '%username% — Display username who publish article.<br/>
								%article_name% — Display article name.<br/>
								%link% — Article edit link on admin side.<br/>
								%signature% — To display site logo.<br/>',
							),
							'article_content' => array(
								'type'  => 'wp-editor',
								'value' => 'Hi,<br/>

											A provider has publish an article with the name "%article_name%" and needs approval. below is link to approve.
											<br/>
											<br/>
											<a style="color: #fff; padding: 0 50px; margin: 0 0 15px; font-size: 20px; font-weight: 600; line-height: 60px; border-radius: 8px; background: #5dc560; vertical-align: top; display: inline-block;" href="%link%">Approve</a>

											<br/><br/>
                                            %signature%,<br/>',
								'attr'  => array(),
								'label' => esc_html__('Email Contents', 'listingo'),
								'desc'  => esc_html__('', 'listingo'),
								'help'  => esc_html__('', 'listingo'),
								'size' => 'large', // small, large
								'editor_height' => 400,
							)
						)
					),                      
                    'ad_approval' => array(
                        'title' => esc_html__('Ad Needs Approval', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'ad_hint' => array(
                                'type' => 'html',
                                'html' => esc_html__('Admin Email', 'listingo'),
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This email will be sent to admin when any provider/user post an ad.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                            ),
                            'ad_subject' => array(
                                'type' => 'text',
                                'value' => 'Ad Created',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Add email subject.', 'listingo'),
                            ),
                            'ad_email' => array(
                                'type' => 'text',
                                'value' => 'info@domain.com',
                                'label' => esc_html__('Admin email address', 'listingo'),
                                'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
                            ),
                            'ad_info' => array(
                                'type'  => 'html',
                                'value' => '',
                                'attr'  => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc'  => esc_html__('', 'listingo'),
                                'help'  => esc_html__('', 'listingo'),
                                'html'  => '%username% — Display username who publish ad.<br/>
                                %ad_name% — Display ad name.<br/>
                                %userlink% — Display user link.<br/>
                                %ad_link% — Ad edit link on admin side.<br/>
                                %signature% — To display site logo.<br/>',
                            ),
                            'ad_content' => array(
                                'type'  => 'wp-editor',
                                'value' => 'Hi,<br/>

                                            A provider named "%username%" has publish an ad with the name "%ad_name%". <br/>
											Below is link to view ad for further action.
                                            <br/>
                                            <a style="color: #fff; padding: 0 50px; margin: 0 0 15px; font-size: 20px; font-weight: 600; line-height: 60px; border-radius: 8px; background: #5dc560; vertical-align: top; display: inline-block;" href="%ad_link%">Approve</a>

                                            <br/><br/>
                                            %signature%,<br/>',
                                'attr'  => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc'  => esc_html__('', 'listingo'),
                                'help'  => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),                                     
                    'apply_job_admin' => array(
                        'title' => esc_html__('Job apply - Admin', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'apply_job_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to site admin.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'apply_job_subject_admin' => array(
                                'type' => 'text',
                                'value' => 'Job application received',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'admin_email_id' => array(
                                'type' => 'text',
                                'value' => 'info@yourdomain.com',
                                'label' => esc_html__('Admin email address', 'listingo'),
                                'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
                            ),
                            'apply_job_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Job title <br/>
											%name% — To display username who apply for job.<br/>
											%email% — To display email who apply for job.<br/>
											%phone% — To display phone number who apply for job.<br/>
											%education% - To display education of the person. <br/>
											%status% - To display current job status.<br/>
											$address% - To display address of the job applying person. <br/>
											%description% — To display user message.<br/>
											%link% — To display job link.<br/>
											%author_name% — To display username who posted job.<br/>
											%author_email% — To display email who posted job.<br/>
											%author_phone% — To display phone number who posted job.<br/>
											%signature% — To display site information.<br/>',
                            ),
                            'apply_job_content_admin' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                    A person has applied to job on your website, description of message is given below.<br/><br/>
                                    Job Title : %subject%<br/>
                                    Applicant Name : %name%<br/>
                                    Applicant Email : %email%<br/>
                                    Applicant Phone : %phone%<br/>
                                   
                                    Job Author Name: %author_name%<br/>
                                    Job Author Email: %author_email%<br/>
                                    Job Author Phone: %author_phone%<br/>                             

                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
					'request_category' => array(
                        'title' => esc_html__('Request Category- Admin', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'request_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to admin to change provider category.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'request_subject' => array(
                                'type' => 'text',
                                'value' => 'Request to change category',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'request_email' => array(
                                'type' => 'text',
                                'value' => 'info@yourdomain.com',
                                'label' => esc_html__('Admin email address', 'listingo'),
                                'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'listingo'),
                            ),
                            'request_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Email Subject <br/>
											%message% — To display user message.<br/>
											%category_title% — Requested category title.<br/>
											%edit_user% - To edit user profile link to assign category. <br/>
											%username% — To display user name.<br/>
											%signature% — To display site information.<br/>',
                            ),
                            'request_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hello,<br/>
                                    "%username%" has requested to change the parent category with %category_title%<br/><br/>
									%username% comments are given below.<br/><br/>
									%message%<br/><br/>
                                    <a href="%edit_user%">Assign Now</a>
                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
                )
            ),
			'provider_templates' => array(
                'title' => esc_html__('Providers/Users Templates', 'listingo'),
                'type' => 'tab',
                'options' => array(
                    'package_payment' => array(
                        'title' => esc_html__('Invoice', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'invoice_subject' => array(
                                'type' => 'text',
                                'value' => 'Thank you for purchasing package!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for email', 'listingo'),
                            ),
                            'info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display the person\'s name. <br/>
						%email% — To display the person\'s email address.<br/>
						%invoice% — To display the invoice id for payment.<br/>
						%package_name% — To display the package name.<br/>
						%amount% — To display the payment amount.<br/>
						%status% — To display the payment status.<br/>
						%method% — To display payment mehtod.<br/>
						%date% — To display purchase date.<br/>
						%expiry% — To display package expiry date.<br/>
						%address% — To display payer address.<br/>
						%signature% — To display site logo.<br/>',
                            ),
                            'payment_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%!<br/>

									Thanks for purchasing the package. Your payment has been received and your invoice detail is given below:
									<br/>
									Invoice ID: %invoice%<br/>
									Package Name: %package_name%<br/>
									Payment Amount: %amount%<br/>
									Payment status: %status%<br/>
									Payment Method: %method%<br/>
									Purchase Date: %date%<br/>
									Expiry Date: %expiry%<br/>
									Address: %address%<br/>
									
									%signature%
									',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            /**
                             * Also available
                             * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                             */
                            )
                        )
                    ),
                    'appointment_authentication' => array(
                        'title' => esc_html__('Appt Authentication', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'appt_auth_subject' => array(
                                'type' => 'text',
                                'value' => 'Appointment Authentication Code!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for appointment authentication email.', 'listingo'),
                            ),
                            'appt_auth_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%user_name% — To display username, who request for appointment. <br/>
                                            %code% — To display authentication code.<br/>
                                            %signature% — To display the sender information.<br/>',
                            ),
                            'appt_auth_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hello %user_name%<br/>

									To complete your appointment please enter the below authentication code in appointment form.
									<br/>
									Your Authentication code is : %code%<br/>
									
									%signature%<br/>',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            /**
                             * Also available
                             * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                             */
                            )
                        )
                    ),
                    'appointment_confirmation' => array(
                        'title' => esc_html__('Appt Confirmation', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'appt_confirm_subject' => array(
                                'type' => 'text',
                                'value' => 'Appointment Confirmation Subject!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for appointment confirmation email.', 'listingo'),
                            ),
                            'appt_confirm_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%user_from% — To display username, who request for appointment. <br/>
                                            %signature% — To display the sender information.<br/>',
                            ),
                            'appt_confirm_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hello.<br/>

									This is confirmation that you have received a new appointment from %user_from%.
									<br/>
									
									%signature%<br/>',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            /**
                             * Also available
                             * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                             */
                            )
                        )
                    ),
                    'rating' => array(
                        'title' => esc_html__('Rating ( Received )', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'rating_subject' => array(
                                'type' => 'text',
                                'value' => 'New rating received!',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for email', 'listingo'),
                            ),
                            'info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display the person\'s name. <br/>
								%rating_from% — To display the person name who rate user.<br/>
								%reason% — To display the rating subject.<br/>
								%link% — To display the rating page link.<br/>
								%rating% — To display the rating.<br/>
								%signature% — To display site logo.<br/>',
                            ),
                            'rating_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%!<br/>

                                            A new rating has been received, Detail for rating is given below:
                                            <br/>
                                            Rating: %rating%<br/>
                                            Rating From: %rating_from%<br/>
                                            Reason: %reason%<br/>
                                            Comment: <br/>
                                            ---------------------------------------<br/>
                                            You can view this at %link%
                                            
                                            <br/>
                                            %signature%',
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            /**
                             * Also available
                             * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                             */
                            )
                        )
                    ),
                    'apply_job' => array(
                        'title' => esc_html__('Job apply - Author', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'apply_job_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to job author.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'apply_job_subject' => array(
                                'type' => 'text',
                                'value' => 'Job application received',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'apply_job_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Job title <br/>
											%name% — To display username who apply for job.<br/>
											%email% — To display email who apply for job.<br/>
											%phone% — To display phone number who apply for job.<br/>
											%education% - To display education of the person. <br/>
											%status% - To display current job status.<br/>
											$address% - To display address of the job applying person. <br/>
											%description% — To display user message.<br/>
											%link% — To display job link.<br/>
											%author_name% — To display username who posted job.<br/>
											%author_email% — To display email who posted job.<br/>
											%author_phone% — To display phone number who posted job.<br/>
											%signature% — To display site information.<br/>',
                            ),
                            'apply_job_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                    A person has applied to job you posted, description of message is given below.<br/><br/>
                                    Subject : %subject%<br/>
                                    Name : %name%<br/>
                                    Email : %email%<br/>
                                    Phone Number : %phone%<br/>
                                    Education : %education%<br/>
                                    Job Status : %status%<br/>
                                    Address : %address%<br/>
                                    Job Description : %description%<br/>                             

                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
                    'job' => array(
                        'title' => esc_html__('Job apply - User', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'job_user_hint' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to person who applied for job.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'job_subject' => array(
                                'type' => 'text',
                                'value' => 'Job application received',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add Subject for email', 'listingo'),
                            ),
                            'job_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Job title <br/>
											%name% — To display username who apply for job.<br/>
											%email% — To display email who apply for job.<br/>
											%phone% — To display phone number who apply for job.<br/>
											%education% - To display education of the person. <br/>
											%status% - To display current job status.<br/>
											$address% - To display address of the job applying person. <br/>
											%description% — To display user message.<br/>
											%link% — To display job link.<br/>
											%author_name% — To display username who posted job.<br/>
											%author_email% — To display email who posted job.<br/>
											%author_phone% — To display phone number who posted job.<br/>
											%signature% — To display site information.<br/>',
                            ),
                            'job_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%,<br/>
                                    Thank you very much for applying job. We will contact you shortly.<br/>                                                   
                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
					'qa_email' => array(
                        'title' => esc_html__('Post Questions', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'qa_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to provider who get question on their profiles.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'qa_subject' => array(
                                'type' => 'text',
                                'value' => 'A question has posted on your profile.',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'qa_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display provider name who will get questions.<br/>
											%question% — To display question title.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'qa_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%,<br/>
                                    A person has posted a question at your profile, question is given below.<br/><br/>
                                    
									%question%

                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
					'answer_email' => array(
                        'title' => esc_html__('Answers', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'answer_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to the question author', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'answer_subject' => array(
                                'type' => 'text',
                                'value' => 'New answer posted on your question.',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'answer_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display user name of question author.<br/>
											%username% — To display user name who post question.<br/>
											%question% — To display question title against which answers is posted.<br/>
											%link% — To display question detail page link.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'answer_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%,<br/>
                                    A person with name "%username%" has posted an answers on your question ( %question% ), To view all answers please follow given below link<br/><br/>
                                    
									%link%

                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),
					'withdrawal_email' => array(
                        'title' => esc_html__('Wathdrawal', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'withdrawal_subject' => array(
                                'type' => 'text',
                                'value' => 'Your Request for Withdrawal has been Processed',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'withdrawal_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%name% — To display user name.<br/>
											%amount% — To display total amount.<br/>
											%email% — To display PayPal email address.<br/>
											%method% — To payment method.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'withdrawal_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi %name%,<br/>
                                    We just processed your request for %amount% via %method%.<br/>
									Your payment was sent to %email%<br/><br/>
                                    
									Happy Spending!
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),                   
                    'providers_job_email' => array(
                        'title' => esc_html__('Job Email to Providers/Professionals', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'providers_apply_job_email' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will be used to send an email to professional/prviders of same category where job posted.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'providers_apply_job_subject' => array(
                                'type' => 'text',
                                'value' => 'New Job Posted',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'providers_apply_job_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Job subject <br/>
                                            %salary% — To display salary for the job.<br/>
                                            %description% — To display job description.<br/>
                                            %link% — To display job URL.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'providers_apply_job_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                    A new Job have been posted, If you are interested apply below.<br/><br/>
                                    Job Title       : %subject%<br/>
                                    Job Salary      : %salary%<br/>                                   
                                    Job Description : %description%<br/>                             

                                    <p style="text-align: center" ><a style="display: inline-block;padding: 15px 50px;margin: auto;text-decoration: none;font-size: 20px;font-weight: bold;background: black;color: white;color: #348eda;background: #348eda;color: white;" href="%link%">Apply Now</a>
                                    </p>
                                    <br/>
                                    %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),                         
                    'provider_contact' => array(
                        'title' => esc_html__('Ad Contact Form', 'listingo'),
                        'type' => 'tab',
                        'options' => array(
                            'contact_title' => array(
                                'type' => 'html',
                                'value' => '',
                                'label' => esc_html__('', 'listingo'),
                                'desc' => esc_html__('This template will send to professionals when any user contact from ad detail page.', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '',
                            ),
                            'ad_contact_subject' => array(
                                'type' => 'text',
                                'value' => 'Ad Contact',
                                'label' => esc_html__('Subject', 'listingo'),
                                'desc' => esc_html__('Please add subject for email', 'listingo'),
                            ),
                            'ad_contact_info' => array(
                                'type' => 'html',
                                'value' => '',
                                'attr' => array(),
                                'label' => esc_html__('Email Settings variables', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'html' => '%subject% — Contact subject <br/>
											%ad_title% — Ad title <br/>
											%ad_link% — Ad link <br/>
                                            %username% — To display username who contact the professional.<br/>
                                            %useremail% — To display email who contact the professional.<br/>  
                                            %phone% — To display phone who contact the professional.<br/>                                     
                                            %message% — To display user message.<br/>
                                            %signature% — To display site information.<br/>',
                            ),
                            'ad_contact_content' => array(
                                'type' => 'wp-editor',
                                'value' => 'Hi,<br/>
                                        A person has contact you for "%ad_title%", description of message is given below.<br/><br/>
                                        Subject : %subject%<br/>
                                        Name : %username%<br/>
                                        Email : %useremail%<br/> 
                                        Phone : %phone%<br/>                                 
                                        Message : %message%<br/><br/><br/>
                                        Ad Link : %ad_link%<br/><br/><br/>
                                        %signature%',
                                
                                'attr' => array(),
                                'label' => esc_html__('Email Contents', 'listingo'),
                                'desc' => esc_html__('', 'listingo'),
                                'help' => esc_html__('', 'listingo'),
                                'size' => 'large', // small, large
                                'editor_height' => 400,
                            )
                        )
                    ),                                
                )
            ),
        )
    ),
);


