<?php
if (function_exists('fw_get_db_settings_option')) :
    $maintenance = fw_get_db_settings_option('maintenance');
    $maintenance_logo = fw_get_db_settings_option('maintenance_logo');
    $background = fw_get_db_settings_option('background');
    $maintenance_title = fw_get_db_settings_option('maintenance_title');
    $maintenance_subtitle = fw_get_db_settings_option('maintenance_subtitle');
    $description = fw_get_db_settings_option('maintenance_description');
    $maintenance_copyright = fw_get_db_settings_option('maintenance_copyright');
    $newsletter = fw_get_db_settings_option('newsletter');
    $date = fw_get_db_settings_option('maintenance_date');

    $formatted_date = date("Y, n, d, H, i, s", strtotime("-1 month", strtotime($date)));

endif;

$post_name = listingo_get_post_name();

if ((!empty($maintenance) && $maintenance == 'enable' && (!is_user_logged_in())) || $post_name == "coming-soon") {

    $bg_image = '';
    $background_comingsoon = listingo_comingsoon_background();

    $bg_image = get_template_directory_uri() . '/images/commingsoon-bg.jpg';
    if (!empty($background_comingsoon)) {
        $bg_image = $background_comingsoon;
    }
    ?>
    <main id="tg-main" class="tg-main tg-paddingzero tg-haslayout tg-commingsoonpage" style="background:url( <?php echo esc_url($bg_image); ?> )">
        <div class="tg-commingsoonholder">
            <div class="tg-commingsoonbox">
                <div id="tg-comming-sooncounter" class="tg-twocols tg-comming-sooncounter">
                    <div class="tg-counterbox">
                        <div id="days" class="timer_box"><h1><?php echo intval(00); ?></h1><p><?php esc_html_e('Days', 'listingo'); ?></p></div>
                    </div>
                    <div class="tg-counterbox">
                        <div id="hours" class="timer_box"><h1><?php echo intval(00); ?></h1><p><?php esc_html_e('Hours', 'listingo'); ?></p></div>
                    </div>
                    <div class="tg-counterbox">
                        <div id="minutes" class="timer_box"><h1><?php echo intval(00); ?></h1><p><?php esc_html_e('Minute', 'listingo'); ?></p></div>
                    </div>
                    <div class="tg-counterbox">
                        <div id="seconds" class="timer_box"><h1><?php echo intval(00); ?></h1><p><?php esc_html_e('Seconds', 'listingo'); ?></p></div>
                    </div>
                </div>
                <div class="tg-twocols tg-commingsooncontent">
                    <?php if (!empty($maintenance_logo['url'])) { ?>
                        <strong class="tg-logo">
                            <img src="<?php echo esc_url($maintenance_logo['url']); ?>" alt="<?php esc_attr_e('Maintenance', 'listingo'); ?>">
                        </strong>
                    <?php } ?>
                    <?php if (!empty($maintenance_title) || !empty($maintenance_subtitle)) { ?>
                        <div class="tg-bordertitle">
                            <?php if (!empty($maintenance_title)) { ?>
                                <h2><?php echo esc_attr($maintenance_title); ?></h2>
                            <?php } ?>
                            <?php if (!empty($maintenance_subtitle)) { ?>  
                                <h3><?php echo esc_attr($maintenance_subtitle); ?></h3>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($description)) { ?>
                        <div class="tg-description">
                            <?php echo wp_kses_post(wpautop(do_shortcode($description))); ?></p>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($newsletter) && $newsletter === 'enable') {
                        $mailchimp = new Listingo_MailChimp();
                        $mailchimp->listingo_mailchimp_form();
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php if (!empty($maintenance_copyright)) { ?>
        <p class="tg-copyrights"><?php echo esc_attr($maintenance_copyright); ?></p>
    <?php } ?>
    <?php
    $script = "jQuery(document).ready(function (e) {
            (function ($) {
                var launch = new Date(" . esc_js($formatted_date) . ");
                console.log(launch);
                var days = $('#days');
                var hours = $('#hours');
                var minutes = $('#minutes');
                var seconds = $('#seconds');
                setDate();
                function setDate() {
                    var now = new Date();
                    if (launch < now) {
                        days.html('<p>" . esc_html__('Days', 'listingo') . "</p><h1>" . intval(0) . "0</h1>');
                        hours.html('<p>" . esc_html__('Hour', 'listingo') . "</p><h1>" . intval(0) . "0</h1>');
                        minutes.html('<p>" . esc_html__('Minute', 'listingo') . "</p><h1>" . intval(0) . "0</h1>');
                        seconds.html('<p>" . esc_html__('Second', 'listingo') . "</p><h1>" . intval(0) . "0</h1>');
                    }
                    else {
                        var s = -now.getTimezoneOffset() * 60 + (launch.getTime() - now.getTime()) / 1000;
                        var d = Math.floor(s / 86400);
                        days.html('<h1>' + d + '</h1><p>" . esc_html__('Day', 'listingo') . "' + (d > 1 ? 's' : ''), '</p>');
                        s -= d * 86400;
                        var h = Math.floor(s / 3600);
                        hours.html('<h1>' + h + '</h1><p>" . esc_html__('Hour', 'listingo') . "' + (h > 1 ? 's' : ''), '</p>');
                        s -= h * 3600;
                        var m = Math.floor(s / 60);
                        minutes.html('<h1>' + m + '</h1><p>" . esc_html__('Minute', 'listingo') . "' + (m > 1 ? 's' : ''), '</p>');
                        s = Math.floor(s - m * 60);
                        seconds.html('<h1>' + s + '</h1><p>" . esc_html__('Second', 'listingo') . "' + (s > 1 ? 's' : ''), '</p>');
                        setTimeout(setDate, 1000);
                    }
                }
            })(jQuery);
            });";
    wp_add_inline_script('listingo_callbacks', $script, 'after');
    
    wp_footer();
    die();
}
