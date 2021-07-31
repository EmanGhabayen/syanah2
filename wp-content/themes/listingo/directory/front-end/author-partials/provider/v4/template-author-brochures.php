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

$provider_category 		= listingo_get_provider_category($author_profile->ID);
$profile_brochure 	= !empty($author_profile->profile_brochure) ? $author_profile->profile_brochure : array();

if (!empty($profile_brochure['file_data']) && apply_filters('listingo_is_feature_allowed', $provider_category, 'brochures') === true) {?>
<section class="tg-haslayout tg-sectionspacevtwo spv-bglight spv4-brochures  spv4-section" id="section-brochures">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="tg-sectiontitlevthree">
					<h2><?php esc_html_e('Download Brochure', 'listingo'); ?></h2>
				</div>
				<div class="tg-brochuresholder">
					<ul class="tg-brochures">
						<?php
						foreach ($profile_brochure['file_data'] as $key => $value) {
							if (!empty($value['file_title']) || !empty($value['file_relpath'])) {?>
								<li>
									<div class="tg-brochure">
										<?php if (!empty($value['file_icon'])) { ?>
											<figure><i class="<?php echo esc_attr($value['file_icon']); ?>"></i></figure>
										<?php } ?>
										<div class="tg-brochuredetails">
											<a download href="<?php echo esc_url($value['file_relpath']); ?>">
												<?php if (!empty($value['file_title'])) { ?>
													<h3><?php echo esc_attr($value['file_title']); ?></h3>
												<?php } ?>
											</a>
											<a download href="<?php echo esc_url($value['file_relpath']); ?>"><?php esc_html_e('Download Now', 'listingo'); ?></a>
										</div>
									</div>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php }
