<?php
/**
 *
 * Theme Home Page
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
get_header(); ?>
<div class="container">
    <div class="row">
		<div class="serviceproviders-home-page haslayout">
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
		</div>
    </div>
</div>
<?php get_footer(); ?>