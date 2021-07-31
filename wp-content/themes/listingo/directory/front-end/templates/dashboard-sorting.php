<?php
/**
 *
 * The template part for displaying the dashboard privacy settings.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
get_header();

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
$default_style	= listingo_get_provider_page_style($url_identity);

$cotent_list 	= apply_filters('listingo_get_profile_sections',$url_identity,'content');
$sidebar_list	= apply_filters('listingo_get_profile_sections',$url_identity,'sidebar');
?>
<div id="tg-content" class="tg-content">
    <div class="tg-designcontent">
		<div class="tg-contentheading">
			<h3><?php esc_html_e('Select Page Design', 'listingo'); ?><?php do_action('listingo_get_tooltip','section','page_design');?></h3>
		</div>
   		<div class="tg-selectpagedesign">
   			<form action="" method="post" class="do-activate-style">
   				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="tg-designone activate-detail-page">
							<div class="tg-radio current-active">
								<input type="radio" id="designone" <?php echo checked( $default_style, 'view_1', true ); ?> name="style" value="view_1">
								<label for="designone">
									<img src="<?php echo get_template_directory_uri();?>/images/design-one.jpg" alt="<?php esc_html_e('Style 1', 'listingo'); ?>">
								</label>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="tg-designtwo activate-detail-page">
							<div class="tg-radio current-active">
								<input type="radio" id="designtwo" <?php echo checked( $default_style, 'view_2', true ); ?> name="style"  value="view_2">
								<label for="designtwo">
									<img src="<?php echo get_template_directory_uri();?>/images/design-two.jpg" alt="<?php esc_html_e('Style 2', 'listingo'); ?>">
								</label>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="tg-designone activate-detail-page">
							<div class="tg-radio current-active">
								<input type="radio" id="desigthree" <?php echo checked( $default_style, 'view_3', true ); ?> name="style" value="view_3">
								<label for="desigthree">
									<img src="<?php echo get_template_directory_uri();?>/images/design-three.jpg" alt="<?php esc_html_e('Style 3', 'listingo'); ?>">
								</label>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="tg-designone activate-detail-page">
							<div class="tg-radio current-active">
								<input type="radio" id="desigthree" <?php echo checked( $default_style, 'view_4', true ); ?> name="style" value="view_4">
								<label for="desigthree">
									<img src="<?php echo get_template_directory_uri();?>/images/design-four.jpg" alt="<?php esc_html_e('Style 4', 'listingo'); ?>">
								</label>
							</div>
						</div>
					</div>
				</div>
   			</form>
		</div>
  		<?php 
		if( isset( $default_style ) && $default_style === 'view_4' ){
			//do nothing
		} else {?>
   		<div class="tg-dragdropoption">
			<div class="tg-contentheading">
				<h3><?php esc_html_e('Sort Page Elements', 'listingo'); ?></h3>
			</div>
			
			<?php if (( apply_filters('listingo_get_user_type', $user_identity) === 'business' 
					 || apply_filters('listingo_get_user_type', $user_identity) === 'professional' 
					) && function_exists('fw_get_db_settings_option')
				) {?>
				<a class="tg-btnreset sp-reset-sorting" target="_blank" href="<?php echo esc_url(get_author_posts_url($url_identity));?>"><span><?php esc_html_e('View Settings', 'listingo'); ?></span><i class="lnr lnr-eye"></i></a>
			<?php }?>
			
			<figure class="tg-dragdropimg">
				<img src="<?php echo get_template_directory_uri();?>/images/drag-drop-banner-img.jpg" alt="<?php esc_html_e('Visit Profile', 'listingo'); ?>">
				<h3><?php esc_html_e('Drag and Drop', 'listingo'); ?><span><?php esc_html_e('Sections', 'listingo'); ?></span></h3>
			</figure>
		</div>
   		<div class="tg-sortcontentitems sp-item-sortable">
			<div class="row">
				<form class="tg-themeform sp-sorting-form">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-7">
						<div class="tg-profilewidget tg-peaoplereviews">
							<div class="tg-profilewidgethead">
								<h2><?php esc_html_e('Sort Main Content', 'listingo'); ?></h2>
							</div>
							<div class="tg-box sp-content-sort">
								<?php 
								if( !empty( $cotent_list ) ){
									foreach($cotent_list as $key => $value){?>
										<div class="tg-timebox">
											<i class="lnr lnr-move"></i>
											<input type="hidden" name="sort[content][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $key ); ?>">
											<span><?php echo esc_attr( $value['title'] ); ?></span>
										</div>
								<?php }}?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
						<div class="tg-profilewidget tg-recentactivities">
							<div class="tg-profilewidgethead">
								<h2><?php esc_html_e('Sort sidebar content', 'listingo'); ?></h2>
							</div>
							<div class="tg-box sp-sidebar-sort">
								<?php 
								if( !empty( $sidebar_list ) ){
									foreach($sidebar_list as $key => $value){?>
								<div class="tg-timebox">
									<i class="lnr lnr-move"></i>
									<input type="hidden" name="sort[sidebar][<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $key ); ?>">
									<span><?php echo esc_attr( $value['title'] ); ?></span>
								</div>
								<?php }}?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php }?>
	</div>
</div>