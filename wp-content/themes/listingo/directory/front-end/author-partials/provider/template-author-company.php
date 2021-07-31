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

/**
 * Get the Professional Statement
 */
$professional_statements = '';
$description = '';

if (!empty($author_profile->professional_statements)) {
    $professional_statements = $author_profile->professional_statements;
}

if (!empty($author_profile->description)) {
    $description = $author_profile->description;
}

if (function_exists('fw_get_db_settings_option')) {
	$more_less = fw_get_db_settings_option('more_less');
}

if (!empty($professional_statements) || !empty( $description ) ) { ?>
    <div class="tg-companyfeaturebox tg-introduction sp-introreadmore" id="section-company">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Introduction', 'listingo'); ?></h3>
        </div>
        <?php if( !empty( $description ) || !empty( $professional_statements ) ){?>
			<div class="tg-description">
				<?php if( !empty( $description ) ){?>                
					<?php echo wp_kses_post(wpautop(do_shortcode( $description ))); ?> 
				<?php }?>    
				<?php if( !empty( $professional_statements ) ){?>
					<?php echo wp_kses_post(wpautop(do_shortcode($professional_statements ))); ?>     
				<?php }?>          
			</div>
        <?php }?>
    </div>
    <?php
		if( isset( $more_less ) && $more_less === 'yes' ){
			$script = "
			jQuery(document).ready(function(){
			jQuery('.sp-introreadmore .tg-description').readmore({
				speed: 500,
				collapsedHeight: 140,
				moreLink: '<a class=\"tg-btntext\" href=\"#\">".esc_html__('more...','listingo')."</a>',
				lessLink: '<a class=\"tg-btntext\" href=\"#\">".esc_html__('less...','listingo')."</a>',
			});
			});";
			wp_add_inline_script('listingo_callbacks', $script, 'after');
		}
    ?>
<?php } ?>
