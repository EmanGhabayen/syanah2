<?php
/**
 *
 * Author Amenities Template.
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
 * Get the Amenities/Features
 */
$list_amenities = array();
if (!empty($author_profile->profile_amenities)) {
    $list_amenities = $author_profile->profile_amenities;
}
?>
<?php if (!empty($list_amenities) && is_array($list_amenities)) { ?>
    <div class="tg-companyfeaturebox tg-amenities" id="section-amenity">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Amenities and Features', 'listingo'); ?></h3>
        </div>
        <ul>
            <?php
            foreach ($list_amenities as $key => $amenity) {
                $get_amenity_term = get_term_by('slug', $amenity, 'amenities');
                $amenity_title = '';
                $term_id = '';
                if (!empty($get_amenity_term)) {
                    $amenity_title = $get_amenity_term->name;
                    $term_id = $get_amenity_term->term_id;
                }

                $amenity_meta = array();
                if (function_exists('fw_get_db_term_option')) {
                    $amenity_meta = fw_get_db_term_option($term_id, 'amenities');
                }
				
				if ( isset($amenity_meta['amenities_icon']['type']) 
					&& $amenity_meta['amenities_icon']['type'] === 'icon-font'
				    && !empty($amenity_meta['amenities_icon']['icon-class'])
				   ) {
					do_action('enqueue_unyson_icon_css');
					 $amenity_icon = $amenity_meta['amenities_icon']['icon-class'];
					?>
					<li class="tg-activated">
						<?php if (!empty($amenity_icon)) { ?>
							<i class="<?php echo esc_attr($amenity_icon); ?>"></i>
						<?php } ?>
						<span><?php echo esc_attr($amenity_title); ?></span>
					</li>
					<?php
				} else if (isset($amenity_meta['amenities_icon']['type']) 
				   && $amenity_meta['amenities_icon']['type'] === 'custom-upload'
				   && !empty($amenity_meta['amenities_icon']['url'])
				 ) {
				?>
					<li class="tg-activated">
						<img src="<?php echo esc_url($amenity_meta['amenities_icon']['url']); ?>" alt="<?php esc_html_e('category', 'listingo'); ?>">
						<span><?php echo esc_attr($amenity_title); ?></span>
					</li>
				<?php
				} elseif( !empty( $amenity_title ) ){
					?>
					<li class="tg-activated">
						<span><?php echo esc_attr($amenity_title); ?></span>
					</li>
					<?php
				}
            }
            ?>
        </ul>
    </div>
<?php } ?>