<?php
/**
 *
 * The template part for displaying a message that posts cannot be found.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e('Nothing Found' , 'listingo'); ?>
		</h1>
	</header>
	
	<div class="page-content">
		<?php if (is_home() && current_user_can('publish_posts')) : ?>
			<p>
				<?php
				printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.' , 'listingo') , array (
					'a' => array (
						'href' => array () ) )) , esc_url(admin_url('post-new.php')));
				?>
			</p>
		<?php elseif (is_search()) : ?>
			<p>
				<?php Listingo_Prepare_Notification::listingo_info( esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.' , 'listingo') );?>
			</p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p>
				<?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' , 'listingo'); ?>
			</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
	
