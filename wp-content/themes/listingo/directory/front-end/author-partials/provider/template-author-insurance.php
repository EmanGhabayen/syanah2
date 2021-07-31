<?php
/**
 *
 * Author insurance Template.
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
 * Get the insurance/Features
 */
$list_insurance = array();
if (!empty($author_profile->profile_insurance)) {
    $list_insurance = $author_profile->profile_insurance;
}

$username = listingo_get_username($author_profile->ID);
?>
<?php if (!empty($list_insurance)) { ?>
   	<div class="spv4-insurance layout-default" id="section-insurance">
		<div class="tg-companyfeaturebox tg-insurance-wrap">
			<div class="tg-companyfeaturetitle">
				<h3><?php echo esc_attr( $username );?>&nbsp;<em><?php esc_html_e('get given below insurance plan', 'listingo'); ?></em></h3>
			</div>
			<ul>
				<?php
				foreach ($list_insurance as $key => $insurance) {
					$get_insurance_term = get_term_by('slug', $insurance, 'insurance');
					$insurance_title = '';
					$term_id = '';
					if (!empty($get_insurance_term)) {
						$insurance_title = $get_insurance_term->name;
						$term_id = $get_insurance_term->term_id;
					}

					$insurance_meta = array();
					if (function_exists('fw_get_db_term_option')) {
						$insurance_meta = fw_get_db_term_option($term_id, 'insurance');
					}

					//Class
					$ins_img	= '';
					if( !empty( $insurance_meta['logo']['url'] ) ){
						$ins_img = 'ins_img_render';
					}
					?>
					<li class="tg-activated <?php echo esc_attr( $ins_img );?>">
						<?php if( !empty( $insurance_meta['logo']['url'] ) ){?>
							<img src="<?php echo esc_url($insurance_meta['logo']['url']); ?>" alt="<?php esc_html_e('insurance', 'listingo'); ?>">
						<?php }?>
						<span><?php echo esc_attr($insurance_title); ?></span>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
<?php } ?>