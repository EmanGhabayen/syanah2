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

$social_links = apply_filters('listingo_get_social_media_icons_list',array());
$social_target	= !empty( $author_profile->social_target ) ? $author_profile->social_target : '_blank';
$profile_status	= get_user_meta($author_profile->ID,'profile_status',true);
?>
<div class="tg-contactinfobox tg-widget">
	<ul class="tg-contactinfo">
		<?php if (!empty($author_profile->address)) { ?>
			<li>
				<i class="lnr lnr-location"></i>
				<address><?php echo esc_attr($author_profile->address); ?></address>
			</li>
		<?php } ?>
		<?php do_action('listingo_get_user_meta','phone',$author_profile);?>
        <?php do_action('listingo_get_user_meta','email',$author_profile);?>
		<?php if (!empty($author_profile->fax)) { ?>
			<li>
				<i class="lnr lnr-printer"></i>
				<span><?php echo esc_attr($author_profile->fax); ?></span>
			</li>
		<?php } ?>
		<?php if( !empty( $profile_status ) && $profile_status != 'sphide'){ ?>
			<li>
				<i class="lnr lnr-clock"></i>
				<span><?php listingo_get_profile_status('','echo',$author_profile->ID);?></span>
			</li>
		<?php } ?>
		<?php do_action('listingo_dev_print_extra_basics_fields',$author_profile);?>
		<?php if (!empty($author_profile->user_url)) { ?>
			<li>
				<i class="lnr lnr-screen"></i>
				<span><a href="<?php echo esc_url($author_profile->user_url); ?>" target="_blank"><?php echo esc_attr($author_profile->user_url); ?></a></span>
			</li>
		<?php } ?>
	</ul>
	<?php if (!empty($author_profile->address)) { ?>
		<a class="tg-btn tg-btn-lg" href="//maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($author_profile->address); ?>" target="_blank"><?php esc_html_e('Get Directions', 'listingo'); ?></a>
	<?php } ?>
</div>
