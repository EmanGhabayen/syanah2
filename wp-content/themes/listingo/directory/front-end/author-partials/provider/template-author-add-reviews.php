<?php
/**
 *
 * Author Add Reviews Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
global $wp_query,$current_user;
$author_profile = $wp_query->get_queried_object();

/**
 * Get The Category Type
 */
$category_type = $author_profile->category;

/* Get the total wait time. */
$total_time = listingo_get_reviews_evaluation($category_type, 'total_wait_time');
/* Get the rating headings */
$rating_titles = listingo_get_reviews_evaluation($category_type, 'leave_rating');

if( isset( $current_user->ID ) 
	 && $current_user->ID != $author_profile->ID
 ){
?>
<div class="tg-companyfeaturebox tg-reviewformrating" id="section-reviews">
	<form class="tg-themeform tg-formleavefeedback">
		<fieldset>
			<div class="row">
				<?php if (!empty($rating_titles)) { ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
						<div class="tg-companyfeaturetitle reviewer-form-title">
							<h3><?php esc_html_e('Leave Your Rating', 'listingo'); ?></h3>
						</div>
						<ul class="tg-servicesrating">
							<?php
							foreach ($rating_titles as $key => $value) {
								$flag = rand(1, 9999);
								$field_name = $key;
								?>
								<li data-ratingtitle="<?php echo esc_attr($key); ?>">
									<em><?php echo esc_attr($value); ?></em>
									<div class="tg-ratingbox-<?php echo esc_attr($flag); ?>">
										<strong></strong>
										<div class="current-rate"><div id="jRate-<?php echo esc_attr($flag); ?>"></div></div>
										<input type="hidden" name="<?php echo esc_attr($field_name); ?>" class="rating-<?php echo esc_attr($flag); ?>" value="1" />
									</div>
								</li>
								<?php
								$script = "jQuery(function () {
									var that = this;
									var toolitup = jQuery('#jRate-" . esc_js($flag) . "').jRate({
										rating: 1,
										min: 0,
										max: 5,
										precision: 1,
										startColor: '#fdd003',
										endColor: '#fdd003',
										width: 16,
										height: 16,
										touch: true,
										backgroundColor: '#DFDFE0',
										onChange: function (rating) {
											jQuery('.rating-" . $flag . "').val(rating);
											if (rating === 0) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html('');
											} else {
												if (rating == 1) {
													jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_1);
												} else if (rating == 2) {
													jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_2);
												} else if (rating == 3) {
													jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_3);
												} else if (rating == 4) {
													jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_4);
												} else if (rating == 5) {
													jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_5);
												}
											}
										},
										onSet: function (rating) {
											jQuery('.rating-" . esc_js($flag) . "').val(rating);
											if (rating == 1) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_1);
											} else if (rating == 2) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_2);
											} else if (rating == 3) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_3);
											} else if (rating == 4) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_4);
											} else if (rating == 5) {
												jQuery('.tg-ratingbox-" . esc_js($flag) . " strong').html(scripts_vars.rating_5);
											}
										}
									});
								});";
								wp_add_inline_script('listingo_callbacks', $script, 'after');
								?>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
					<div class="tg-companyfeaturetitle">
						<h3><?php esc_html_e('Leave Your Review', 'listingo'); ?></h3>
					</div>
					<?php if (!empty($total_time)) { ?>
						<div class="form-group">
							<label><?php esc_html_e('Total Wait Time:', 'listingo'); ?></label>
							<span class="tg-select">
								<select name="review_wait_time">
									<option value=""><?php esc_html_e('Choose Wait Time', 'listingo'); ?></option>
									<?php foreach ($total_time as $key => $value) { ?>
										<option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
									<?php } ?>
								</select>
							</span>
						</div>
					<?php } ?>
					<div class="form-group">
						<div class="tg-reviewtitle">
							<input type="text" name="reviewtitle" class="form-control" placeholder="<?php esc_html_e('Review Title', 'listingo'); ?>">
						</div>
						<div class="tg-recommendedradio">
							<span class="tg-radio">
								<input type="radio" id="yes" name="recommended" value="yes" checked>
								<label for="yes"><i class="fa fa-thumbs-o-up"></i><?php esc_html_e('Yes', 'listingo'); ?></label>
							</span>
							<span class="tg-radio">
								<input type="radio" id="no" name="recommended" value="no">
								<label for="no"><i class="fa fa-thumbs-o-down"></i><?php esc_html_e('No', 'listingo'); ?></label>
							</span>
						</div>
					</div>
					<div class="form-group">
						<textarea name="review_desc" class="form-control" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
					</div>
					<?php wp_nonce_field('sp_review_data_nonce', 'review-data-submit'); ?>
					<input type="hidden" name="user_to" value="<?php echo intval($author_profile->ID); ?>" />
					<button type="button" class="tg-btn review-submit-btn"><?php esc_html_e('Submit', 'listingo'); ?></button>
				</div>
				
			</div>
		</fieldset>
	</form>
</div>
<?php }?>