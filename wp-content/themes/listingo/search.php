<?php
/**
 *
 * Theme Search Page
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
get_header();
?>
<div class="container">
    <div class="row">
        <div class="serviceproviders-search-page haslayout">
			<?php get_template_part('template-parts/content' , 'search'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>