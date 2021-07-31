<?php
/**
 *
 * The template part for displaying the dashboard appointment.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $paged, $current_user;

$per_page = intval(10);
if (!empty($_GET['showposts'])) {
    $per_page = $_GET['showposts'];
}

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$json = array();

$sort_by = !empty($_GET['sortby']) ? $_GET['sortby'] : 'ID';
$showposts = !empty($_GET['showposts']) ? $_GET['showposts'] : -1;

//Order
$order = 'DESC';
if (!empty($_GET['orderby'])) {
    $order = esc_attr($_GET['orderby']);
}

if (!empty($_GET['appointment_date'])) {
    $apt_date = strtotime(esc_attr( $_GET['appointment_date'] ));
}

$status = array('pending', 'publish');
if (!empty($_GET['appointment_status'])) {
    $status = array();
    $status[] = $_GET['appointment_status'];
}


$query_args = array(
    'posts_per_page' => "-1",
    'post_type' => 'sp_appointments',
    'order' => $order,
    'orderby' => $sort_by,
    'post_status' => $status,
    'ignore_sticky_posts' => 1);

$total_query = new WP_Query($query_args);
$total_posts = $total_query->post_count;

$query_args = array(
    'posts_per_page' => $showposts,
    'post_type' 	 => 'sp_appointments',
    'paged' 		 => $paged,
    'order' 		 => $order,
    'orderby' 		 => $sort_by,
    'post_status' 	 => $status,
    'ignore_sticky_posts' => 1);

$meta_query_args[] = array(
    'key' 		=> 'apt_user_to',
    'value' 	=> $current_user->ID,
    'compare'   => '=',
    'type' 		=> 'NUMERIC'
);

if( !empty( $apt_date ) ) {
	$meta_query_args[] = array(
		'key' => 'apt_date',
		'value' => esc_attr($apt_date),
		'compare' => '=',
	);
}
if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboard tg-dashboardappointmentsetting">
        <form method="get" class="tg-themeform sp-appointment-form-search">
            <input type="hidden" name="ref" value="<?php echo isset($_GET['ref']) ? $_GET['ref'] : ''; ?>">
            <input type="hidden" name="mode" value="<?php echo isset($_GET['mode']) ? $_GET['mode'] : ''; ?>">
            <input type="hidden" name="identity" value="<?php echo isset($_GET['identity']) ? $_GET['identity'] : ''; ?>">
            <input type="hidden" name="appointment_date" value="<?php echo isset($_GET['appointment_date']) ? $_GET['appointment_date'] : ''; ?>" class="set_appt_date">
            <fieldset>
                <div class="tg-dashboardbox tg-dashboardappointments">
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Your Appointments', 'listingo'); ?></h2>
                    </div>
                    <div id="tg-datepicker" class="tg-datepicker"></div>
                    <?php if(!empty($apt_date) ) {?>
						<div class="tg-reset-apt">
							<a href="javascript:;" class="sp-view-profile-btn tg-btn"><?php esc_html_e('Show All Appointment', 'listingo'); ?></a>
						</div>
					<?php }?>
                    <div class="tg-sortfilters">
                        <div class="tg-sortfilter tg-sortby">
                            <?php do_action('listingo_get_default_sortby'); ?>
                        </div>
                        <div class="tg-sortfilter tg-arrange">
                            <?php do_action('listingo_get_orderby'); ?>
                        </div>
                        <div class="tg-sortfilter tg-show">
                            <?php do_action('listingo_get_showposts'); ?>
                        </div>
                        <div class="tg-sortfilter tg-show">
                            <?php do_action('listingo_get_appointment_status'); ?>
                        </div>
                        
                    </div>
                    <div class="tg-dashboardappointmentbox">
                        <?php
                        $appt_data = new WP_Query($query_args);
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        if ($appt_data->have_posts()) {
                            $counter = 1;
                            while ($appt_data->have_posts()) : $appt_data->the_post();
                                global $post;

                                $apt_types = get_post_meta($post->ID, 'apt_types', true);
                                $apt_services = get_post_meta($post->ID, 'apt_services', true);
                                $apt_reasons = get_post_meta($post->ID, 'apt_reasons', true);
                                $apt_description = get_post_meta($post->ID, 'apt_description', true);
                                $apt_currency_symbol = get_post_meta($post->ID, 'apt_currency_symbol', true);
                                $apt_user_from = get_post_meta($post->ID, 'apt_user_from', true);
                                $apt_user_to = get_post_meta($post->ID, 'apt_user_to', true);
                                $apt_date = get_post_meta($post->ID, 'apt_date', true);
                                $apt_time = get_post_meta($post->ID, 'apt_time', true);
                                $time = explode('-', $apt_time);

                                $booking_services = get_user_meta($apt_user_to, 'profile_services', true);
                                $booking_types = get_user_meta($apt_user_to, 'appointment_types', true);
                                $booking_reasons = get_user_meta($apt_user_to, 'appointment_reasons', true);
                                $username = listingo_get_username($apt_user_from);
                                $avatar = apply_filters(
                                        'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $apt_user_from), array('width' => 100, 'height' => 100)
                                );
								
								$status	= get_post_status($post->ID);
								if(!empty($status) && ( $status === 'pending' || $status === 'draft' )){
									$staus	= esc_html__('Pending','listingo');
								} if(!empty($status) && ( $status === 'publish' )){
									$staus	= esc_html__('Approved','listingo');
								}
                                ?>
                                <div class="tg-dashboardappointment" data-postid="<?php echo intval($post->ID); ?>">
                                    <div class="tg-servicetitle">
                                        <?php if (!empty($avatar)) { ?>
                                            <figure>
                                                <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Appointment Avatar', 'listingo'); ?>">
                                            </figure>
                                        <?php } ?>
                                        <?php if (!empty($username)) { ?>
                                            <div class="tg-clientcontent">
                                                <h2>
                                                    <a href="<?php echo esc_url(get_author_posts_url($apt_user_from)); ?>">
                                                        <?php echo esc_attr($username); ?>
                                                    </a>
                                                </h2>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($booking_services[$apt_services])) { ?>
                                        <div class="tg-serviceandservicetype">
                                            <h3><?php esc_html_e('Service', 'listingo'); ?></h3>
                                            <span><?php echo esc_attr($booking_services[$apt_services]['title']); ?></span>
                                        </div>
                                    <?php } ?>
                                    <div class="tg-btntimeedit">
                                        <?php if (!empty($booking_types[$apt_types])) { ?>
                                            <div class="tg-appointmenttype">
                                                <h3><?php esc_html_e('Appointment Type', 'listingo'); ?></h3>
                                                <span><?php echo esc_attr($booking_types[$apt_types]); ?></span>
                                            </div>
                                        <?php } ?>
                                        <a href="javascript:;" class="tg-btnedite" data-toggle="modal" data-target=".tg-approvemodal-<?php echo esc_attr($counter); ?>"><i class="lnr lnr-checkmark-circle"></i></a>
                                        <?php if ($post->post_status === 'pending') { ?>
                                            <a href="javascript:;" class="tg-btndel tg-rejection-model" data-target=".tg-rejectmodal-<?php echo esc_attr($counter); ?>"><i class="lnr lnr-cross-circle"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Appointment Approve Model-->
                                <div class="modal fade tg-appointmentapprovemodal tg-approvemodal-<?php echo esc_attr($counter); ?>" tabindex="-1">
                                    <div class="modal-dialog tg-modaldialog" role="document">
                                        <div class="modal-content tg-modalcontent">
                                            <div class="tg-modalhead">
                                                <h2><?php esc_html_e('Appointment Detail', 'listingo'); ?></h2>
                                            </div>
                                            <div class="tg-modalbody">

                                                <ul class="tg-invoicedetail">
                                                   	 <?php if (!empty($staus)) { ?>
                                                        <li><span><strong><?php esc_html_e('Appointment Status:', 'listingo'); ?></strong></span><span><strong><?php echo esc_attr($staus); ?></strong></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($username)) { ?>
                                                        <li><span><?php esc_html_e('Customer Name:', 'listingo'); ?></span><span><?php echo esc_attr($username); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($apt_date)) { ?>
                                                        <li><span><?php esc_html_e('Appointment Date:', 'listingo'); ?></span><span><?php echo date($date_format, $apt_date); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($time[0]) && !empty($time[1])) { ?>
                                                        <li><span><?php esc_html_e('Appointment Time:', 'listingo'); ?></span><span><?php echo date($time_format, strtotime('2016-01-01 ' . $time[0])); ?>&nbsp;-&nbsp;<?php echo date($time_format, strtotime('2016-01-01 ' . $time[1])); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($booking_services[$apt_services])) { ?>
                                                        <li><span><?php esc_html_e('Service:', 'listingo'); ?></span><span><?php echo esc_attr($booking_services[$apt_services]['title']); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($booking_types[$apt_types])) { ?>
                                                        <li><span><?php esc_html_e('Appointment Type:', 'listingo'); ?></span><span><?php echo esc_attr($booking_types[$apt_types]); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($booking_reasons[$apt_reasons])) { ?>
                                                        <li><span><?php esc_html_e('Reason For Visit:', 'listingo'); ?></span><span><?php echo esc_attr($booking_reasons[$apt_reasons]); ?></span></li>
                                                    <?php } ?>
                                                    <?php if (!empty($apt_description)) { ?>   
                                                        <li><span><?php esc_html_e('Description:', 'listingo'); ?></span><span><?php echo wp_kses_post(wpautop(do_shortcode($apt_description))); ?></span></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <?php if ($post->post_status === 'pending') { ?>
                                                <div class="tg-modalfoot">
                                                    <button class="tg-btn tg-btnapproved tg-appt-approval" type="button"><?php esc_html_e('Approve', 'listingo'); ?></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Appointment Approve Model End-->
                                <?php
                                $counter++;
                            endwhile;
                            wp_reset_postdata();
                        } else {
                            Listingo_Prepare_Notification::listingo_warning(esc_html__('Not Found', 'listingo'), esc_html__('Sorry there are no appointments found.', 'listingo'));
                        }
                        ?>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
    if (!empty($total_posts) && !empty($showposts) && $total_posts > $showposts) {
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php listingo_prepare_pagination($total_posts, $showposts); ?>
        </div>
    <?php } ?>
</div>

<script type="text/template" id="tmpl-load-rejection-form">
    <form class="tg-themeform tg-formreject">
    <fieldset>
    <div class="form-group">
    <input required name="rejection_title" type="text" placeholder="<?php esc_html_e('Rejection Title', 'listingo'); ?>">
    </div>
    <textarea required name="rejection_reason" placeholder="<?php esc_html_e('Rejection Description', 'listingo'); ?>"></textarea>
    </fieldset>
    <input type="hidden" name="post_id" value="{{data}}">
    </form>
</script>
<div class="modal fade tg-appointmentrejectmodal sp-rejectmodal" tabindex="-1" >
    <div class="modal-dialog tg-modaldialog" role="document">
        <div class="modal-content tg-modalcontent">
            <div class="tg-modalhead">
                <h2><?php esc_html_e('Rejection Reason', 'listingo'); ?></h2>
            </div>
            <div class="tg-modalbody">
                <div class="tg-haslayout sp-rejection-appt-wrap"></div>
            </div>
            <div class="tg-modalfoot">
                <button class="tg-btn tg-btnreject sp-appt-rejection" type="button"><?php esc_html_e('Reject Now', 'listingo'); ?></button>
            </div>
        </div>
    </div>
</div>