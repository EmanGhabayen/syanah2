<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$uniq_flag = fw_unique_increment();


if (function_exists('fw_get_db_settings_option')) {
    $dir_search_page = fw_get_db_settings_option('dir_search_page');
    $zip_search = fw_get_db_settings_option('zip_search');
    $misc_search = fw_get_db_settings_option('misc_search');
    $dir_search_insurance = fw_get_db_settings_option('dir_search_insurance');
    $language_search = fw_get_db_settings_option('language_search');
    $country_cities = fw_get_db_settings_option('country_cities');
    $dir_radius = fw_get_db_settings_option('dir_radius');
    $dir_location = fw_get_db_settings_option('dir_location');
    $dir_keywords = fw_get_db_settings_option('dir_keywords');
} else {
    $dir_search_page = '';
    $dir_radius = '';
    $dir_location = '';
    $dir_keywords = '';
    $misc_search = '';
    $zip_search = '';
    $dir_search_insurance = '';
    $language_search = '';
    $country_cities = '';
}

$color	=  !empty( $atts['color'] ) ? $atts['color'] : '';
$btn_text	=  !empty( $atts['btn_text'] ) ? $atts['btn_text'] : '';
$btn_class	=  !empty( $atts['btn_text'] ) ? 'btn-enabled' : '';
$subcats_status	=  !empty( $atts['sub_cats'] ) && $atts['sub_cats'] === 'yes' ? $atts['sub_cats'] : 'no';
$geo_type		=  !empty( $atts['geo_type'] ) ? $atts['geo_type'] : '';
$get_column_type	= listingo_get_column_type($subcats_status,$geo_type);
?>
<div class="sp-search-provider-banner-v2 tg-mapinnerbanner tg-haslayout has_ui_slider <?php echo esc_attr( $get_column_type );?> <?php echo esc_attr( $btn_class );?>">
	<div class="tg-searchbox">
		<?php if (!empty($atts['title']) || !empty($atts['subtitle']) ) { ?>
			<div class="tg-bannercontent">
				<?php if (!empty($atts['title'])) { ?><h1 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($atts['title']); ?></h1><?php }?>
				<?php if (!empty($atts['subtitle'])) { ?><h2 style="color:<?php echo ( $color ) ;?>"><?php echo esc_attr($atts['subtitle']); ?></h2><?php }?>
			</div>
		<?php }?>
		<div class="tg-themeform tg-formsearch tg-haslayout">
			<form class="sp-form-search" action="<?php echo listingo_get_search_page_uri();?>" method="get">  
				<fieldset>
					<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>
						<div class="form-group">
							<?php do_action('listingo_get_search_keyword'); ?>
						</div>
					<?php }?>
					<?php 
					if( isset( $geo_type ) && $geo_type === 'countries' ){
						do_action('listingo_get_countries_list');
					}else {
						if (!empty($dir_location) && $dir_location === 'enable') { ?>
							<div class="form-group tg-inputwithicon">
								<?php do_action('listingo_get_search_geolocation'); ?>
							</div>
						<?php }?>
					<?php }?>
					<div class="form-group">
						<?php do_action('listingo_get_search_category'); ?>
					</div>
					<?php if (!empty($atts['sub_cats']) && $atts['sub_cats'] === 'yes' ) { ?>
						<div class="form-group">
							<?php do_action('listingo_get_search_sub_category'); ?>
						</div>
					<?php }?>
					<?php do_action('listingo_get_search_permalink_setting');?>
					<button class="tg-btn" type="submit"><?php if( !empty( $btn_text ) ){ echo esc_attr( $btn_text ); }else{?><i class="lnr lnr-magnifier"></i><?php }?></button>
				</fieldset>
			</form>
		</div>
	</div>
</div>