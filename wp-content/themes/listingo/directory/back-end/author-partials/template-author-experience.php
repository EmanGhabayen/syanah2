<?php
/**
 *
 * Author Experience Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */


global $profileuser;
$user_identity = $profileuser->ID;
if ( ( $profileuser->roles[0] === 'professional' || $profileuser->roles[0] === 'business' ) ){
	$profile_experinces = get_user_meta($user_identity, 'experience', true);
	$provider_category	= listingo_get_provider_category($user_identity);
	$date_format		= listingo_get_calendar_format();

	if( apply_filters('listingo_is_feature_allowed', $provider_category, 'experience') === true ){?>
	<div class="tg-dashboardbox tg-experiences">
		<div class="sp-row">
			<div class="sp-xs-12 sp-sm-12 sp-md-9 sp-lg-6">
				<div class="tg-dashboardtitle">
					<h2><?php esc_html_e('Experience', 'listingo'); ?></h2>
					<a class="tg-btnaddnew add-profile-experience" href="javascript:;"><?php esc_html_e('+ add new', 'listingo'); ?></a>
				</div>
				<div class="tg-certificatesawardsbox profile-experience-wrap">
					<?php if (!empty($profile_experinces)) { ?>
						<?php
						$count_exp = 0;
						foreach ($profile_experinces as $key => $value) {
							$title = !empty($value['title']) ? $value['title'] : esc_attr('Job Title');
							$company = !empty($value['company']) ? $value['company'] : esc_attr('Company Name');
							$start_date = !empty($value['start_date']) ? date($date_format, $value['start_date']) : '';
							$end_date = !empty($value['end_date']) ? date($date_format, $value['end_date']) : '';
							$description = !empty($value['description']) ? $value['description'] : '';
							$checked = '';
							if ($value['current'] === 'on') {
								$checked = 'checked';
							}
							?>
							<div class="tg-experience tg-certificatesaward" data-count-experinces="<?php echo intval($count_exp); ?>">
								<?php if (!empty($value['title'])) { ?>
									<div class="tg-imgandtitle">
										<h3><a class="sp-job-title" href="javascript:;"><?php echo esc_attr($value['title']); ?></a></h3>
									</div>
								<?php } ?>
								<div class="tg-btntimeedit">
									<button type="button" class="tg-btnedite edit_experience"><i class="lnr lnr-pencil"></i></button>
									<button type="button" class="tg-btndel delete_experience"><i class="lnr lnr-trash"></i></button>
								</div>
								<div class="sp-experience-edit-collapse tg-haslayout elm-display-none">
									<div class="tg-themeform tg-formexperience">
									   <div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
											<div class="form-group">
												<div class="tg-checkbox">
													<input id="tg-currentjob-<?php echo intval($count_exp); ?>" <?php echo esc_attr($checked); ?> class="tg-checkbox" type="checkbox" name="experience[<?php echo intval($count_exp); ?>][current]">
													<label for="tg-currentjob-<?php echo intval($count_exp); ?>"><?php esc_html_e('Current Job: ','listingo'); ?></label>
												</div>
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input type="text" class="form-control sp-job-title-input" name="experience[<?php echo intval($count_exp); ?>][title]" placeholder="<?php esc_html_e('Job Title', 'listingo'); ?>" value="<?php echo esc_attr($title); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input type="text" class="form-control sp-job-company-input" name="experience[<?php echo intval($count_exp); ?>][company]" placeholder="<?php esc_html_e('Company Name', 'listingo'); ?>" value="<?php echo esc_attr($company); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input readonly type="text" class="form-control start_date" name="experience[<?php echo intval($count_exp); ?>][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>" value="<?php echo esc_attr($start_date); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
											<div class="form-group">
												<input readonly type="text" class="form-control end_date" name="experience[<?php echo intval($count_exp); ?>][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>" value="<?php echo esc_attr($end_date); ?>">
											</div>
										</div>
										<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
											<textarea class="form-control" name="experience[<?php echo intval($count_exp); ?>][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"><?php echo esc_textarea($description); ?></textarea>
										</div>
									</div>
								</div>
							</div>
							<?php
							$count_exp++;
						}
						?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/template" id="tmpl-load-experience">
		<div class="tg-experience tg-certificatesaward" data-count-experinces="{{data}}">
			<div class="tg-imgandtitle">
				<h3><a class="sp-job-title" href="javascript:;"><?php esc_html_e('Enter Your Experience Name', 'listingo'); ?></a></h3>

			</div>
			<div class="tg-btntimeedit">
				<button type="button" class="tg-btnedite edit_experience"><i class="lnr lnr-pencil"></i></button>
				<button type="button" class="tg-btndel delete_experience"><i class="lnr lnr-trash"></i></button>
			</div>
			<div class="sp-experience-edit-collapse tg-haslayout elm-display-none">
				<div class="tg-themeform tg-formexperience">

						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<div class="form-group">
								<div class="tg-checkbox">
									<input id="tg-currentjob-{{data}}" class="tg-checkbox" type="checkbox" name="experience[{{data}}][current]">
									<label for="tg-currentjob-{{data}}"><?php esc_html_e('Current Job: ','listingo'); ?></label>
								</div>
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control sp-job-title-input" name="experience[{{data}}][title]" placeholder="<?php esc_html_e('Job Title', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control sp-job-company-input" name="experience[{{data}}][company]" placeholder="<?php esc_html_e('Company Name', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control start_date" name="experience[{{data}}][start_date]" placeholder="<?php esc_html_e('Starting Date', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-6 sp-md-6 sp-lg-6">
							<div class="form-group">
								<input type="text" class="form-control end_date" name="experience[{{data}}][end_date]" placeholder="<?php esc_html_e('Ending Date', 'listingo'); ?>">
							</div>
						</div>
						<div class="sp-xs-12 sp-sm-12 sp-md-12 sp-lg-12">
							<textarea class="form-control" name="experience[{{data}}][description]" placeholder="<?php esc_html_e('Description', 'listingo'); ?>"></textarea>
						</div>

				</div>
			</div>
		</div>
	</script>
	<?php }
}