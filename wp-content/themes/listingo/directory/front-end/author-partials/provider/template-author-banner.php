<?php
/**
 *
 * Author Banner Template.
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

/**
 * Get the Banner Image
 */
?>
<?php if (is_active_sidebar('user-page-top')) {?>
  <div class="tg-advertisement">
	<?php dynamic_sidebar('user-page-top'); ?>
  </div>
<?php }?>
