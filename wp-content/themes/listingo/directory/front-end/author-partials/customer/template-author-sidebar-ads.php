<?php
/**
 *
 * Author Sidebar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
?>
<?php if (is_active_sidebar('user-page-sidebar')) {?>
  <div class="tg-advertisement">
	<?php dynamic_sidebar('user-page-sidebar'); ?>
  </div>
<?php }?>