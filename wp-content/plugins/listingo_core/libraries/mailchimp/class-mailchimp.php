<?php
if (!class_exists('Listingo_MailChimp')) {

    class Listingo_MailChimp {

        function __construct() {
            add_action('wp_ajax_nopriv_listingo_mailchimp_form', array(&$this, 'listingo_mailchimp_form'));
            add_action('wp_ajax_listingo_mailchimp_form', array(&$this, 'listingo_mailchimp_form'));
            add_action('wp_ajax_nopriv_listingo_subscribe_mailchimp', array(&$this, 'listingo_subscribe_mailchimp'));
            add_action('wp_ajax_listingo_subscribe_mailchimp', array(&$this, 'listingo_subscribe_mailchimp'));
        }

        public function listingo_mailchimp_form() {
            $counter = 0;
            $footer_text = '';
            $mailchimp = '';
            if (function_exists('fw_get_db_settings_option')) :
                $footer_text = fw_get_db_settings_option('mailchimp_title');
                $mailchimp = fw_get_db_settings_option('mailchimp_list');

            endif;
            $counter++;
            ?>
            <div class="form-group">
                <div id="newsletter_<?php echo intval($counter); ?>" class="mailchimp-message"></div> 
                <form class="tg-themeform signup-newletter tg-form-newsletter tg-haslayout comingsoon-newsletter" id="mailchimpwidget_<?php echo intval($counter); ?>">
                    <fieldset>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="<?php esc_attr_e('Enter Email Here', 'listingo_core'); ?>">
                        </div>
                        <button type="submit" class="tg-btn subscribe_me" data-counter="<?php echo intval($counter); ?>"><?php esc_html_e('Signup', 'listingo_core'); ?></button>
                    </fieldset>
                </form>
                <div id="newsletter_message_<?php echo intval($counter); ?>" class="mailchimp-error tg-haslayout elm-display-none"><div class="mailchimp-message"></div></div>
                <script>
                    jQuery(document).ready(function (e) {
						var loader_html = '<div class="provider-site-wrap"><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
                        jQuery(document).on('click', '.subscribe_me', function (event) {
                            'use strict';
                            event.preventDefault();
                            $ = jQuery;
                            var _this = jQuery(this);
                            var counter = _this.data('counter');
                            jQuery('body').append(loader_html);
							
                            jQuery('#newsletter_message_' + counter).hide();
                            jQuery('#newsletter_message_' + counter + " .mailchimp-message").removeClass('alert alert-success');
                            jQuery('#newsletter_message_' + counter + " .mailchimp-message").removeClass('alert alert-danger');

                            jQuery.ajax({
                                type: 'POST',
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: jQuery('.comingsoon-newsletter').serialize() + '&action=listingo_subscribe_mailchimp',
                                dataType: "json",
                                success: function (response) {
									jQuery('body').find('.provider-site-wrap').remove();
                                    if (response.type == 'success') {
                                         jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000 });
                                        jQuery('#mailchimpwidget_' + counter).get(0).reset();

                                    } else {
                                        jQuery.sticky(response.message, {classList: 'important',position:'center-center', speed: 200, autoclose: 5000, });
                                    }

                                }
                            });
                        });
                    });

                </script>
            </div>
            <?php
        }

        /**
         * @get Mail chimp list
         *
         */
        public function listingo_mailchimp_list($apikey) {
			if ( $apikey <> '' && $apikey !== 'Add your key here' ) {
				$apikey	= $apikey;
			} else{
				return '';
			}
			
            $MailChimp = new Listingo_OATH_MailChimp($apikey);
            $mailchimp_list = $MailChimp->listingo_call('lists/list');
            return $mailchimp_list;
        }

        /**
         * @get Mail chimp list
         *
         */
        public function listingo_subscribe_mailchimp() {
            global $counter;
            $mailchimp_key = '';
            $mailchimp_list = '';
            $json = array();

            if (function_exists('fw_get_db_settings_option')) :
                $mailchimp_key = fw_get_db_settings_option('mailchimp_key');
                $mailchimp_list = fw_get_db_settings_option('mailchimp_list',null);
            endif;
			
			
            if (empty($_POST['email'])) {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Email address is required.', 'listingo_core');
                echo json_encode($json);
                die();
            }

            if (isset($_POST['email']) && !empty($_POST['email']) && $mailchimp_key != '') {
                if ( $mailchimp_key <> '' && $mailchimp_key !== 'Add your key here' ) {
                    $MailChimp = new Listingo_OATH_MailChimp($mailchimp_key);
                } else{
					$json['type'] = 'error';
                	$json['message'] = esc_html__('An error occurred, please try again later', 'listingo_core');
					echo json_encode($json);
					die();
				}

                $email = esc_attr( $_POST['email'] );

                if (isset($_POST['fname']) && !empty($_POST['fname'])) {
                    $fname = esc_attr( $_POST['fname'] );
                } else {
                    $fname = '';
                }

                if (isset($_POST['lname']) && !empty($_POST['lname'])) {
                    $lname = esc_attr( $_POST['lname'] );
                } else {
                    $lname = '';
                }

				
                if (trim($mailchimp_list) == '') {
                    $json['type'] = 'error';
                    $json['message'] = esc_html__('No list selected yet! please contact administrator', 'listingo_core');
                    echo json_encode($json);
                    die;
                }

                //https://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php
                $result = $MailChimp->listingo_call('lists/subscribe', array(
                    'id' => $mailchimp_list,
                    'email' => array('email' => $email),
                    'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname),
                    'double_optin' => false,
                    'update_existing' => false,
                    'replace_interests' => false,
                    'send_welcome' => true,
                ));
				
                if ($result <> '') {
                    if (isset($result['status']) and $result['status'] == 'error') {
                        $json['type'] = 'error';
                        $json['message'] = $result['error'];
                    } else {
                        $json['type'] = 'success';
                        $json['message'] = esc_html__('Subscribe Successfully', 'listingo_core');
                    }
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = esc_html__('An error occurred, please try again later', 'listingo_core');
            }
			
            echo json_encode($json);
            die();
        }

    }

    new Listingo_MailChimp();
}