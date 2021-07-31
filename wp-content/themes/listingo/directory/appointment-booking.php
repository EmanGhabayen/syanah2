<?php
/**
 *
 * Template Name: Appointment Booking
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();
global $current_user;
//Get hash key from url
$check_hash = '';
if (!empty($_GET['key'])) {
    $check_hash = esc_attr($_GET['key']);
}

//Get user appointment key data meta
$key_hash = get_user_meta($current_user->ID, 'appointment_key', true);
$apointment_meta = get_user_meta($current_user->ID, 'appointment_data', true);
?>
<div class="container">
    <div class="row">
        <div id="tg-twocolumns" class="tg-twocolumns">
            <?php
				if (!empty($key_hash) && !empty($apointment_meta) && is_user_logged_in() && $key_hash === $check_hash) {
					get_template_part('directory/front-end/bookings/appointment', 'wizard');
				} else {
					Listingo_Prepare_Notification::listingo_warning(esc_html__('Warning', 'listingo'), esc_html__('Key does not match or your key does not contains valid information.', 'listingo'));
				}
            ?>
        </div>
    </div>
</div>
<?php
get_footer();
