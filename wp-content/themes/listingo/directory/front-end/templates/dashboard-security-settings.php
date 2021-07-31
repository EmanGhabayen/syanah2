<?php
/**
 *
 * The template part for displaying the dashboard security settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}
$delete_account_text = fw_get_db_settings_option('delete_account_text');
$activation_status 	 = get_user_meta($url_identity, 'activation_status', true);
?>
<div id="tg-content" class="tg-content">
    <div class="tg-dashboardsecuritysetting">
        <form class="tg-themeform tg-formsecuritysetting change-account-password-form">
            <fieldset>
                <h2><?php esc_html_e('Change Your Password', 'listingo'); ?></h2>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                        <div class="form-group">
                            <input type="password" name="old_passowrd" class="form-control" placeholder="<?php esc_html_e('Current Password', 'listingo'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                        <div class="form-group">
                            <input type="password" name="new_passowrd" class="form-control" placeholder="<?php esc_html_e('New Password', 'listingo'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                        <div class="form-group">
                            <input type="password" name="confirm_password" class="form-control" placeholder="<?php esc_html_e('Retype Password', 'listingo'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                        <button type="submit" class="tg-btn do-change-password"><?php esc_html_e('Change Password', 'listingo'); ?></button>
                    </div>
                    <?php wp_nonce_field('sp_change_account_password', 'change-account-password'); ?>
                </div>
            </fieldset>
        </form>
        <form class="tg-themeform tg-formsecuritysetting deactivate-account-form">
            <fieldset>
                <h2><?php esc_html_e('Activate/Deactivate Account', 'listingo'); ?></h2>
                <?php if (!empty($delete_account_text)) { ?>
                    <div class="tg-description">
                        <p><?php echo esc_attr($delete_account_text); ?></p>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if (isset($activation_status) && $activation_status == 'active') { ?>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                            <div class="form-group">
                                <input type="password" name="currentpassword" class="form-control" placeholder="<?php esc_html_e('Current Password', 'listingo'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
                            <div class="form-group">
                                <input type="password" name="retypepassword" class="form-control" placeholder="<?php esc_html_e('Retype Password', 'listingo'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                            <div class="form-group">
                                <textarea name="message" placeholder="<?php esc_html_e('Why Leave Us.', 'listingo'); ?>"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                            <button type="submit" data-action="deleteme" class="tg-btn tg-btndeactivate do-process-account-status"><?php esc_html_e('Delete now', 'listingo'); ?></button>
                            <button type="submit"  data-action="deactivateme" class="tg-btn do-process-account-status"><?php esc_html_e('Deactivate Now', 'listingo'); ?></button>
                        </div>
                    <?php } else { ?>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 pull-left">
                            <?php wp_nonce_field('sp_account_change_status_nonce', 'account-change-status-process'); ?>
                            <button type="submit"  data-action="activateme" class="tg-btn tg-btn-lg do-process-account-status"><?php esc_html_e('Activate now', 'listingo'); ?></button>
                        </div>
                    <?php } ?>
                    <?php wp_nonce_field('sp_account_change_status_nonce', 'account-change-status-process'); ?>
                </div>
            </fieldset>
        </form>
    </div>
</div>