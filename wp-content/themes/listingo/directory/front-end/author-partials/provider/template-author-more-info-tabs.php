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
/* Check if reviews enable from category settings then include the template. */
$category_type = $author_profile->category;

$enable_reviews = '';
if (function_exists('fw_get_db_settings_option')) {
    $enable_reviews = fw_get_db_post_option($category_type, 'enable_reviews', true);
}


if ( apply_filters('listingo_is_feature_allowed', $category_type, 'qa') === true
	|| 
	 !empty($enable_reviews) && $enable_reviews['gadget'] === 'enable'
) { 
	
$active_tab 		= 'active';
$active_content 	= 'active';
?>

<div class="detail-panel-wrap tg-haslayout tg-companyfeaturebox"  id="section-tabs">
   <div class="tg-companyfeaturebox tg-reviews">
		<ul class="tg-reviewstabs" role="tablist">
			<?php if (!empty($enable_reviews) && $enable_reviews['gadget'] === 'enable') {?>
				<li role="presentation" class="<?php echo esc_attr( $active_tab );?>"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab"><?php esc_html_e('Reviews', 'listingo'); ?></a></li>
			<?php $active_tab='';}?>
			<?php 
			if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')
				 && apply_filters('listingo_is_feature_allowed', $category_type, 'qa') === true
				 ) { ?>
				<li role="presentation" class="<?php echo esc_attr( $active_tab );?>"><a href="#consult" aria-controls="consult" role="tab" data-toggle="tab"><?php esc_html_e('Consult Q&A', 'listingo'); ?></a></li>
			<?php }?>
		</ul>
		<div class="tg-tabcontent tab-content">
			<?php if (!empty($enable_reviews) && $enable_reviews['gadget'] === 'enable') {?>
				<div role="tabpanel" class="tg-tabpane tab-pane <?php echo esc_attr( $active_content );?>" id="reviews">
					<?php
						get_template_part('directory/front-end/author-partials/provider/template-author', 'reviews');
						get_template_part('directory/front-end/author-partials/provider/template-author-add', 'reviews');
					?>
				</div>
			<?php  $active_content=''; }?>
			<?php 
   			if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')
			 && apply_filters('listingo_is_feature_allowed', $category_type, 'qa') === true
			 ) { ?>
				<div role="tabpanel" class="tg-tabpane tab-pane <?php echo esc_attr( $active_content );?>" id="consult">
					<?php do_action('render_questions_listing_view'); ?>
				</div>
			<?php }?>
		</div>
    </div>
</div>
<?php }?>