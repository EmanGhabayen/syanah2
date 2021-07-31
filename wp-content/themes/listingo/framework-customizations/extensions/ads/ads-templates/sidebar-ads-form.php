<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post;
$author_id      = $post->post_author; 
$author_email   = get_the_author_meta( 'email' , $author_id );
$user_name  = '';
$user_email = '';
$user_phone = '';
if( is_user_logged_in() ){
    $user_data  = wp_get_current_user();
    $user_name  = listingo_get_username( $user_data->ID );
    $user_email = $user_data->user_email;
    $user_phone = get_user_meta($user_data->ID, 'phone', true);
}
?>
    <div class="tg-asideauthor tg-authorform">
        <div class="tg-title">
            <h3><span class="lnr lnr-envelope"></span>  <?php esc_html_e('Contact Form', 'listingo') ?></h3>
        </div>
        <div class="tg-subform">
            <form class="tg-formtheme tg-subformtheme tg-formsearchvtwo tg-adform">
                <fieldset>
                    <?php wp_nonce_field('sp_dashboard_contact_form', 'security'); ?>
                    <div class="form-group tg-inputwithicon">
                        <i class="lnr lnr-user"></i>
                        <input type="text" name="name" value="<?php echo esc_attr( $user_name ); ?>" class="form-control" placeholder="<?php esc_html_e('Your Name', 'listingo'); ?>">
                    </div>
                    <div class="form-group tg-inputwithicon">
                        <i class="lnr lnr-envelope"></i>
                        <input type="email" name="email" value="<?php echo esc_attr( $user_email ); ?>" class="form-control" placeholder="<?php esc_html_e('Your Email', 'listingo'); ?>">
                    </div>                                                            
                    <div class="form-group tg-inputwithicon">
                        <i class="lnr lnr-tag"></i>
                        <input type="text" name="subject" class="form-control" placeholder="<?php esc_html_e('Subject', 'listingo'); ?>">
                    </div>                                                            
                    <div class="form-group tg-inputwithicon">
                        <i class="lnr lnr-phone-handset"></i>
                        <input type="text" name="phone" value="<?php echo esc_attr( $user_phone ); ?>" class="form-control" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
                    </div>                                                            
                    <div class="form-group">
                        <div class="tg-authortextarea">
                            <span><i class="lnr lnr-bubble"></i><?php esc_html_e('Your Message', 'listingo'); ?></span>
                            <textarea name="description"></textarea>
                        </div>
                    </div>                       
                    <input type="hidden" name="ad_id" value="<?php echo esc_attr( $post->ID ); ?>" class="form-control">                    
                    <div class="form-group">
                        <div class="tg-authorbtnarea">
                           <a class="tg-btn tg-submit-ad-form" href="javascript:;"><?php esc_html_e('Submit', 'listingo'); ?></a>
                        </div>
                    </div>                                                            
                </fieldset>
            </form>
        </div>
    </div>
<?php 