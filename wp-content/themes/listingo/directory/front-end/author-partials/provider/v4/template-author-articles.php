<?php
/**
 *
 * Author Company Template.
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
if ( function_exists('fw_get_db_settings_option') && fw_ext('articles')) {?>
<?php do_action('render_sp_display_articles_v2');?>
<?php }
