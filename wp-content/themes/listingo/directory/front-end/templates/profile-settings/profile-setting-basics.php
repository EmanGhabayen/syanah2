<?php
/**
 *
 * The template part for displaying the dashboard profile settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */

/* Define Global Variables */
global $current_user,
 $wp_roles,
 $userdata,
 $post;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (isset($_GET['identity']) && !empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$gender	= get_user_meta($user_identity, 'gender', true);

?>
<div class="tg-dashboardbox tg-basicinformation">
	<div class="tg-dashboardtitle">
		<h2><?php esc_html_e('Basic Infomartion', 'listingo'); ?></h2>
	</div>
	<div class="tg-basicinformationbox">
		<div class="row">
			<?php if( apply_filters('listingo_get_user_type', $user_identity) === 'business' ) { ?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
					<div class="form-group">
						<input type="text" class="form-control" name="basics[company_name]" value="<?php echo get_user_meta($user_identity, 'company_name', true); ?>" placeholder="<?php esc_html_e('Company Name', 'listingo'); ?>">
					</div>
				</div>
			<?php }else {?>
			
				<?php if( apply_filters('listingo_dev_manage_fields','true','first_name') === 'true' ){?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
						<div class="form-group">
							<input type="text" class="form-control" name="basics[first_name]" value="<?php echo get_user_meta($user_identity, 'first_name', true); ?>" placeholder="<?php esc_html_e('First Name', 'listingo'); ?>">
						</div>
					</div>
				<?php }?>
				<?php if( apply_filters('listingo_dev_manage_fields','true','last_name') === 'true' ){?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
						<div class="form-group">
							<input type="text" class="form-control" name="basics[last_name]" value="<?php echo get_user_meta($user_identity, 'last_name', true); ?>" placeholder="<?php esc_html_e('Last Name', 'listingo'); ?>">
						</div>
					</div>
				<?php }?>
				<?php if( apply_filters('listingo_dev_manage_fields','true','gender') === 'true' ){?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
						<div class="form-group">
							<span class="tg-select">
								<select name="basics[gender]">
									<option value=""><?php esc_html_e('Gender', 'listingo'); ?></option>
									<option value="male" <?php selected( $gender, 'male'); ?>><?php esc_html_e('Male', 'listingo'); ?></option>
									<option value="female" <?php selected( $gender, 'female'); ?>><?php esc_html_e('Female', 'listingo'); ?></option>
								</select>
							</span>
						</div>
					</div>
				<?php }?>
			<?php }?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
				<div class="form-group">
					<input type="text" class="form-control" name="basics[tag_line]" value="<?php echo get_user_meta($user_identity, 'tag_line', true); ?>" placeholder="<?php esc_html_e('Tag Line', 'listingo'); ?>">
					<?php do_action('listingo_get_tooltip','element','tagline');?>
				</div>
			</div>
			<?php if( apply_filters('listingo_dev_manage_fields','true','phone') === 'true' ){?>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
					<div class="form-group">
						<input type="text" class="form-control" name="basics[phone]" value="<?php echo get_user_meta($user_identity, 'phone', true); ?>" placeholder="<?php esc_html_e('Phone', 'listingo'); ?>">
						<?php do_action('listingo_get_tooltip','element','phone');?>
					</div>
				</div>
			<?php }?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
				<div class="form-group">
					<input type="text" class="form-control" name="basics[zip]" value="<?php echo get_user_meta($user_identity, 'zip', true); ?>" placeholder="<?php esc_html_e('Zip/Postal Code', 'listingo'); ?>">
					<?php do_action('listingo_get_tooltip','element','zip');?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
				<div class="form-group">
					<input type="text" class="form-control" name="basics[fax]" value="<?php echo get_user_meta($user_identity, 'fax', true); ?>" placeholder="<?php esc_html_e('Fax', 'listingo'); ?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 pull-left">
				<div class="form-group">
					<input type="text" class="form-control" name="basics[user_url]" value="<?php echo esc_url( $current_user->user_url ); ?>" placeholder="<?php esc_html_e('URL', 'listingo'); ?>">
				</div>
			</div>
			<?php do_action('listingo_dev_add_extra_basics_fields',$user_identity);?>
			<?php if( apply_filters('listingo_dev_manage_fields','true','description') === 'true' ){?>
				<div class="col-xs-12 col-sm-12 col-md-12 pull-left">
					<div class="form-group">
						<textarea class="form-control basic-short-desc" name="basics[description]" placeholder="<?php esc_attr_e('Short description', 'listingo'); ?>"><?php echo get_user_meta($user_identity, 'description', true); ?></textarea>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>