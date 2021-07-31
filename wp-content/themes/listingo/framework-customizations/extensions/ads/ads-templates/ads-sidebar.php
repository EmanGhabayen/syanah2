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
?>
<aside id="tg-sidebarvtwo" class="tg-sidebarvtwo">
	<?php 
        get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-contact'); 
        get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-categories'); 
    	get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-userdetails'); 
    	get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-form'); 
        get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-social');
        get_template_part('/framework-customizations/extensions/ads/ads-templates/sidebar-ads-related');        
    ?>      
    <?php if (is_active_sidebar('ad-detail-sidebar')) {?>      
        <div class="tg-listingiaad">        	
            <?php dynamic_sidebar('ad-detail-sidebar'); ?>        	
        </div> 
    <?php } ?>
</aside>