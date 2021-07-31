<?php
/**
 *
 * Author Hits View Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();

$page_id            = listingo_get_social_settings_value('facebook','chat','page_id',$author_profile->ID);
$app_id             = listingo_get_social_settings_value('facebook','chat','app_id',$author_profile->ID);
$theme_color        = listingo_get_social_settings_value('facebook','chat','theme_color',$author_profile->ID);
$loggedin_message   = listingo_get_social_settings_value('facebook','chat','loggedin_message',$author_profile->ID);
$loggedout_message  = listingo_get_social_settings_value('facebook','chat','loggedout_message',$author_profile->ID);
if(empty( $page_id )){return;} 

$app_id             = !empty( $app_id ) ? $app_id : '';
$theme_color        = !empty( $theme_color ) ? $theme_color : '#0084ff';
$loggedin_message   = !empty( $loggedin_message ) ? $loggedin_message : esc_html__('Hi, can we help you?','listingo');
$loggedout_message  = !empty( $loggedout_message ) ? $loggedout_message : esc_html__('Hi, can we help you?','listingo');
?>

<div class="fb-customerchat" page_id="<?php echo esc_attr($page_id);?>" theme_color="<?php echo esc_attr( $theme_color ); ?>" logged_in_greeting="<?php echo esc_attr( $loggedin_message ); ?>" logged_out_greeting="<?php echo esc_attr( $loggedout_message ); ?>"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '<?php echo esc_attr( $app_id );?>',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v3.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>