<?php
/**
 *
 * Author Qualification Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$user_identity = $profileuser->ID;

	$profile_qualification = get_user_meta($user_identity, 'qualification', true);
	$provider_category	= listingo_get_provider_category($user_identity);

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'qualifications') === true ){?>
	<div class="tg-dashboardbox tg-qualifications">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Qualification', 'listingo'); ?></h2>
					<a class="tg-btnaddnew add-profile-qualification" href="javascript:;"><?php esc_html_e('+ add new', 'listingo'); ?></a>
				</div>
				<div class="tg-certificatesawardsbox profile-qualification-wrap">
					<?php if (!empty($profile_qualification)) { ?>
						<?php
						$count_qual = 0;
						foreach ($profile_qualification as $key => $value) {
							$title = !empty($value['title']) ? $value['title'] : '';
							$institute = !empty($value['institute']) ? $value['institute'] : '';
							$start_date = !empty($value['start_date']) ? date('Y-m-d', strtotime($value['start_date'])) : '';
							$end_date = !empty($value['end_date']) ? date('Y-m-d', strtotime($value['end_date'])) : '';
							$description = !empty($value['description']) ? $value['description'] : '';
							?>
							<div class="tg-qualification tg-certificatesaward" data-count-qualification="<?php echo intval($count_qual); ?>">
								<div class="tg-imgandtitle">
									<h3><a class="sp-degree-title" href="javascript:;"><?php echo esc_attr($title); ?></a></h3>
								</div>
								<div class="tg-btntimeedit">
									<button type="button" class="tg-btnedite edit_qualification"><i class="lnr lnr-pencil"></i></button>
									<button type="button" class="tg-btndel delete_qualification"><i class="lnr lnr-trash"></i></button>
								</div>
								<div class="sp-qualification-edit-collapse tg-haslayout elm-display-none">
									<div class="tg-themeform tg-formqualification">
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input type="text" class="form-control sp-degree-title-input" name="qualification[<?php echo intval($count_qual); ?>][title]" placeholder="<?php esc_html_e('Degree Name', 'listingo'); ?>" value="<?php echo esc_attr($title); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input type="text" class="form-control sp-job-institute-input" name="qualification[<?php echo intval($count_qual); ?>][institute]" placeholder="<?php esc_html_e('Institute Name', 'listingo'); ?>" value="<?php echo esc_attr($institute); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input readonly type="text" class="form-control start_date" name="qualification[<?php echo intval($count_qual); ?>][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>" value="<?php echo esc_attr($start_date); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input readonly type="text" class="form-control end_date" name="qualification[<?php echo intval($count_qual); ?>][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>" value="<?php echo esc_attr($end_date); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
											<textarea class="form-control" name="qualification[<?php echo intval($count_qual); ?>][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"><?php echo esc_textarea($description); ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<?php
							$count_qual++;
						}
						?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-qualification">
		<div class="tg-qualification tg-certificatesaward" data-count-qualification="{{data}}">
			<div class="tg-imgandtitle">
				<h3><a class="sp-degree-title" href="javascript:;"><?php esc_html_e('Enter Your Degree Name', 'listingo'); ?></a></h3>
			</div>
			<div class="tg-btntimeedit">
				<button type="button" class="tg-btnedite edit_qualification"><i class="lnr lnr-pencil"></i></button>
				<button type="button" class="tg-btndel delete_qualification"><i class="lnr lnr-trash"></i></button>
			</div>
			<div class="sp-qualification-edit-collapse tg-haslayout elm-display-none">
				<div class="tg-themeform tg-formqualification">
					<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
						<div class="form-group">
							<input type="text" class="form-control sp-degree-title-input" name="qualification[{{data}}][title]" placeholder="<?php esc_html_e('Degree Name', 'listingo'); ?>">
						</div>
					</div>
					<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
						<div class="form-group">
							<input type="text" class="form-control sp-job-institute-input" name="qualification[{{data}}][institute]" placeholder="<?php esc_html_e('Institute Name', 'listingo'); ?>">
						</div>
					</div>
					<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
						<div class="form-group">
							<input type="text" class="form-control start_date" name="qualification[{{data}}][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>">
						</div>
					</div>
					<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
						<div class="form-group">
							<input type="text" class="form-control end_date" name="qualification[{{data}}][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>">
						</div>
					</div>
					<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
						<textarea class="form-control" name="qualification[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</script>
	<?php }
}