<?php
/**
 *
 * The template part for displaying the dashboard appointment settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user, $wp_roles, $userdata, $post;
$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$appointment_title = get_user_meta($user_identity, 'appointment_inst_title', true);
$appointment_desc = get_user_meta($user_identity, 'appointment_inst_desc', true);
$appointment_types = get_user_meta($user_identity, 'appointment_types', true);
$appointment_reasons = get_user_meta($user_identity, 'appointment_reasons', true);
$appointment_reminder = get_user_meta($user_identity, 'appointment_reminder', true);
$currencies = listingo_prepare_currency_symbols();

//Default template for booking confirmation				
$booking_confirmed_default = esc_html__('Hi, %customer_name%!
This is confirmation that your booking regarding "%service%" with %provider% has approved.
We are waiting on %appointment_date% at %appointment_time%.

%signature%','listingo');

//Default template for booking cancellation
$booking_cancelled_default = esc_html__('Hi %customer_name%!
This is confirmation that your booking regarding "%service%" with %provider% has cancelled.
We are very sorry to process your booking right now.
%reason_title%
%reason_description%
%signature%','listingo');

//Default template for booking Approved
$booking_approved_default = esc_html__('Hi, %customer_name%!
This is confirmation that your booking regarding "%service%" with %provider% has approved.
We are waiting on %appointment_date% at %appointment_time%.

%signature%','listingo');


$confirmation_title_default 	= esc_html__('Your Appointment Confirmation', 'listingo');
$approved_title_default 		= esc_html__('Your Appointment Approved', 'listingo');
$cancelled_title_default 		= esc_html__('Your Appointment Cancelled', 'listingo');

$confirmation_title 	= get_user_meta($user_identity, 'appt_confirmation_title', true);
$approved_title 		= get_user_meta($user_identity, 'appt_approved_title', true);
$cancelled_title 		= get_user_meta($user_identity, 'appt_cancelled_title', true);

$booking_cancelled 	= get_user_meta($user_identity, 'appt_booking_cancelled', true);
$booking_confirmed 	= get_user_meta($user_identity, 'appt_booking_confirmed', true);
$booking_approved 	= get_user_meta($user_identity, 'appt_booking_approved', true);

$confirmation_title = !empty($confirmation_title) ? $confirmation_title : $confirmation_title_default;
$approved_title 	= !empty($approved_title) ? $approved_title : $approved_title_default;
$cancelled_title 	= !empty($cancelled_title) ? $cancelled_title : $cancelled_title_default;

$booking_cancelled 	= !empty($booking_cancelled) ? $booking_cancelled : $booking_cancelled_default;
$booking_confirmed 	= !empty($booking_confirmed) ? $booking_confirmed : $booking_confirmed_default;
$booking_approved 	= !empty($booking_approved) ? $booking_approved : $booking_approved_default;
?>
<div class="tg-dashboard">
    <form class="tg-themeform tg-appointment-settings-form">
        <div class="tg-dashboard-appointment-settings sp-appointment-settings-wrap">
            <fieldset>
               <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-dashboardhead">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Instruction Title', 'listingo'); ?></h2>
							</div>
						</div>
						<div class="form-group">
							<input type="text" value="<?php echo esc_attr($appointment_title); ?>" name="appointment_inst_title" class="form-control" placeholder="<?php esc_html_e('Instructions Heading', 'listingo'); ?>">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-dashboardhead">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Instruction Description', 'listingo'); ?></h2>
							</div>
						</div>
						<div class="tg-introductionbox">
							<p><strong><?php esc_html_e('It will be shown on appointment instruction page.', 'listingo'); ?></strong></p>
							<?php
								$description = !empty($appointment_desc) ? $appointment_desc : '';
								$settings = array('media_buttons' => false,'quicktags' => true);
								wp_editor($description, 'instruction_description', $settings);
							?>
						</div>
					</div>
                </div>
            </fieldset>
            <fieldset>
               <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-dashboardbox tg-appointment-types">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Appointment Types', 'listingo'); ?></h2>
							</div>
							<div class="tg-general-box">
								<div class="appointment-type-wrap">
									<?php
										if (!empty($appointment_types)) {
											foreach ($appointment_types as $key => $types) {
												?>
												<div class="tg-startendtime">
													<div class="form-group">
														<div class="tg-inpuicon">
															<i class="lnr lnr-calendar-full"></i>
															<input type="text" value="<?php echo esc_attr($types); ?>" name="appointment_types[<?php echo esc_attr($key); ?>]" class="form-control" placeholder="<?php esc_html_e('Add Appointment Type', 'listingo'); ?>">
														</div>
													</div>
													<button type="button" class="tg-addtimeslot tg-deleteslot delete-appointment-type-slot"><i class="lnr lnr-trash"></i></button>
												</div>
												<?php
											}
										}
									?>
									<button type="button" class="tg-addtimeslot add-new-appointment-type">+</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-dashboardbox tg-appointment-types">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Reasons For Visit', 'listingo'); ?></h2>
							</div>
							<div class="tg-general-box">
								<div class="appointment-reasons-wrap">
									<?php
									if (!empty($appointment_reasons)) {
										foreach ($appointment_reasons as $key => $reason) {
											?>
											<div class="tg-startendtime">
												<div class="form-group">
													<div class="tg-inpuicon">
														<i class="lnr lnr-calendar-full"></i>
														<input type="text" value="<?php echo esc_attr($reason); ?>" name="appointment_reasons[<?php echo esc_attr($key); ?>]" class="form-control" placeholder="<?php esc_html_e('Add Appointment Reason', 'listingo'); ?>">
													</div>
												</div>
												<button type="button" class="tg-addtimeslot tg-deleteslot delete-appointment-reason-slot"><i class="lnr lnr-trash"></i></button>
											</div>
											<?php
										}
									}
									?>
									<button type="button" class="tg-addtimeslot add-new-appointment-reason">+</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-dashboardbox appointment-confirm appointment-email-wrap">
							<div class="tg-dashboardtitle">
								<h2><?php esc_attr_e('Email Settings - Booking Confirmation', 'listingo'); ?></h2>
							</div>
							<em class="email-hint"><strong>%customer_name%</strong>&nbsp;-- <?php esc_html_e('To display customer name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%service%</strong>&nbsp;-- <?php esc_html_e('To display appointment service', 'listingo'); ?></em>
							<em class="email-hint"><strong>%provider%</strong>&nbsp;-- <?php esc_html_e('To display provider name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%appointment_date%</strong>&nbsp;-- <?php esc_html_e('Appointment Date', 'listingo'); ?></em>
							<em class="email-hint"><strong>%appointment_time%</strong>&nbsp;-- <?php esc_html_e('Appointment Time', 'listingo'); ?></em>
							
							<div class="email-contents">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<input type="text" name="confirmation_title" value="<?php echo esc_attr($confirmation_title); ?>" />
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<?php
											$booking_confirmed = !empty($booking_confirmed) ? $booking_confirmed : '';
											$settings = array('media_buttons' => false,'quicktags' => true);
											wp_editor($booking_confirmed, 'booking_confirmed', $settings);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tg-dashboardbox appointment-cancelled appointment-email-wrap">
							<div class="tg-dashboardtitle">
								<h2><?php esc_attr_e('Email Settings - Appointment Cancelled', 'listingo'); ?></h2>
							</div>
							<em class="email-hint"><strong>%customer_name%</strong>&nbsp;-- <?php esc_html_e('To display customer name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%service%</strong>&nbsp;-- <?php esc_html_e('To display appointment service', 'listingo'); ?></em>
							<em class="email-hint"><strong>%provider%</strong>&nbsp;-- <?php esc_html_e('To display provider name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%reason_title%</strong>&nbsp;-- <?php esc_html_e('To display rejection reason title name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%reason_description%</strong>&nbsp;-- <?php esc_html_e('To display rejection reason description', 'listingo'); ?></em>
							<div class="email-contents">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<input type="text" name="cancelled_title" value="<?php echo esc_attr($cancelled_title); ?>" />
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<?php
											$booking_cancelled = !empty($booking_cancelled) ? $booking_cancelled : '';
											$settings = array('media_buttons' => false,'quicktags' => true);
											wp_editor($booking_cancelled, 'booking_cancelled', $settings);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tg-dashboardbox appointment-approved  appointment-email-wrap">
							<div class="tg-dashboardtitle">
								<h2><?php esc_attr_e('Email Settings - Appointment Approved', 'listingo'); ?></h2>
							</div>
							<em class="email-hint"><strong>%customer_name%</strong>&nbsp;-- <?php esc_html_e('To display customer name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%service%</strong>&nbsp;-- <?php esc_html_e('To display appointment service', 'listingo'); ?></em>
							<em class="email-hint"><strong>%provider%</strong>&nbsp;-- <?php esc_html_e('To display provider name', 'listingo'); ?></em>
							<em class="email-hint"><strong>%appointment_date%</strong>&nbsp;-- <?php esc_html_e('Appointment Date', 'listingo'); ?></em>
							<em class="email-hint"><strong>%appointment_time%</strong>&nbsp;-- <?php esc_html_e('Appointment Time', 'listingo'); ?></em>
							<div class="email-contents">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<input type="text" name="approved_title" value="<?php echo esc_attr($approved_title); ?>" />
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<?php
											$booking_approved = !empty($booking_approved) ? $booking_approved : '';
											$settings = array(
												'editor_class' => 'booking_approved',
												'teeny' => false,
												'media_buttons' => false,
												'textarea_rows' => 10,
												'quicktags' => true,
												'editor_height' => 300
											);

											wp_editor($booking_approved, 'booking_approved', $settings);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </fieldset>
        </div>
        <?php wp_nonce_field('sp_appointment_settings_nonce', 'appointment-settings-update'); ?>
    </form>
</div>
<div id="tg-updateall" class="tg-updateall">
    <div class="tg-holder">
        <span class="tg-note"><?php esc_html_e('Click update now to update the latest added details.', 'listingo'); ?></span>
        <a class="tg-btn update-appointment-settings" href="javascript:;"><?php esc_html_e('Update Now', 'listingo'); ?></a>
    </div>
</div>
<script type="text/template" id="tmpl-load-appointment-types">
    <div class="tg-startendtime">
    <div class="form-group">
    <div class="tg-inpuicon">
    <i class="lnr lnr-calendar-full"></i>
    <input type="text" name="appointment_types[]" class="form-control" placeholder="<?php esc_html_e('Add Appointment Type', 'listingo'); ?>">
    </div>
    </div>
    <button type="button" class="tg-addtimeslot tg-deleteslot delete-appointment-type-slot"><i class="lnr lnr-trash"></i></button>
    </div>
</script>
<script type="text/template" id="tmpl-load-appointment-reasons">
    <div class="tg-startendtime">
    <div class="form-group">
    <div class="tg-inpuicon">
    <i class="lnr lnr-calendar-full"></i>
    <input type="text" name="appointment_reasons[]" class="form-control" placeholder="<?php esc_html_e('Add Appointment Reason', 'listingo'); ?>">
    </div>
    </div>
    <button type="button" class="tg-addtimeslot tg-deleteslot delete-appointment-reason-slot"><i class="lnr lnr-trash"></i></button>
    </div>
</script>