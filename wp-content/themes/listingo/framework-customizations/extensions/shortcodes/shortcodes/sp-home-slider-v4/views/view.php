<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
$dir_location       = '';
$search_page    	= listingo_get_ads_search_page_uri();
if ( function_exists('fw_get_db_settings_option')){
	$dir_location       = fw_get_db_settings_option('dir_location');
	$dir_keywords = fw_get_db_settings_option('dir_keywords');
}

$posts_in['post__in']   = !empty($atts['posts']) ? $atts['posts'] : array();
$geo_type               = !empty( $atts['geo_type'] ) ? $atts['geo_type'] : '';
$pro_title              = !empty( $atts['pro_title'] ) ? $atts['pro_title'] : esc_html__('Providers','listingo');
$ad_title               = !empty( $atts['ad_title'] ) ? $atts['ad_title'] : esc_html__('Ads','listingo');
$pro_tab_title          = !empty( $atts['pro_tab_title'] ) ? $atts['pro_tab_title'] : '';
$ad_tab_title           = !empty( $atts['ad_tab_title'] ) ? $atts['ad_tab_title'] : '';
$provider_button        = !empty( $atts['provider_button'] ) ? $atts['provider_button'] : esc_html__('Start Provider Search', 'listingo');
$ad_button              = !empty( $atts['ad_button'] ) ? $atts['ad_button'] : esc_html__('Start Ads Search', 'listingo');
$sub_title              = !empty( $atts['sub_title'] ) ? $atts['sub_title'] : '';
$sub_title_below        = !empty( $atts['sub_title_below'] ) ? $atts['sub_title_below'] : '';
$autoplay               = !empty( $atts['autoplay'] ) ? $atts['autoplay'] : 'false';
$show_nav               = !empty( $atts['show_nav'] ) ? $atts['show_nav'] : 'false';
$progress               = !empty( $atts['progress'] ) ? $atts['progress'] : 'false';
$pause_on_hover         = !empty( $atts['pause_ov_hover'] ) ? $atts['pause_ov_hover'] : 'false';
$responsive             = !empty( $atts['responsive'] ) ? $atts['responsive'] : 'true';
$scroll                 = !empty( $atts['scroll'] ) ? $atts['scroll'] : 'true';
$time_out               = !empty( $atts['time_out'] ) ? $atts['time_out'] : intval(5000);
$height                 = !empty( $atts['height'] ) ? $atts['height'] : intval(445);

$searchClass = 'sp-single-search';
if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {
	$searchClass = 'sp-both-search';
}

if( !intval( $time_out ) ) {
    $time_out = intval(5000);
}

if( !intval( $height ) ) {
    $height = intval(445);
}

//posts Query 
$query_args = array(
    'posts_per_page' => -1,
    'post_type' => 'sp_categories',    
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}

$query = new WP_Query($query_args);
if( $query->have_posts() ){ 
	wp_enqueue_script('pogoslider');
	wp_enqueue_style('pogoslider');
	$counter = rand(9999, 999999);
?>
<div class="sc-ads-slider tg-homeslidervfourhold tg-haslayout <?php echo esc_attr( $searchClass ); ?>">
    <div id="tg-homeslidervfour-<?php echo esc_attr( $counter ); ?>" class="tg-homeslidervfour tg-homeslider tg-haslayout">
        <?php 
        while( $query->have_posts() ){ 
			$query->the_post(); 
			global $post; 
			$default_banner	= listingo_get_category_banner(array(1920,510),$post->ID);
		if( !empty( $default_banner ) ) {?>
        <div class="pogoSlider-slide tg-borderimg" data-transition="fade" data-duration="2000" style="background:url(<?php echo esc_url( $default_banner ) ; ?>) no-repeat scroll 0 0;">
            <div class="tg-slidercontenthold">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 pull-right">
                            <div class="row">
                                  <div class="tg-slidercontent pogoSlider-slide-element" data-in="slideLeft" data-out="slideLeft" data-duration="0">
                                    <div class="tg-slidertitle">
                                        <?php if( !empty( $sub_title ) ) { ?>
                                            <span class="tg-subtitle">
                                                <?php echo esc_attr( $sub_title ); ?>
                                            </span>
                                        <?php } ?>
                                        <h2><?php the_title(); ?></h2>
                                    </div>
                                    <?php if( !empty( $sub_title_below ) ) { ?>
                                        <div class="tg-description">
                                            <p><?php echo esc_attr( $sub_title_below ); ?></p>
                                        </div>
                                    <?php } ?>
                                    <div class="tg-btns">
                                        <a class="tg-btn tg-btnvtwo tg-btnwithicon" href="<?php the_permalink(); ?>"><?php esc_html_e('View All', 'listingo'); ?><i class="lnr lnr-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } } wp_reset_postdata(); ?>                      
    </div>
    <div class="tg-bannertabs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 pull-left">
                    <div class="tg-tabnavhold">
                        <ul class="tg-tabnav tg-tabnavtwo" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#regularuser" data-toggle="tab" aria-expanded="true">
                                    <div class="tg-navcontent">
                                        <div class="tg-navcontent">
                                            <span><?php echo esc_attr( $pro_title ); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {?>
                                <li role="presentation" class="">
                                    <a href="#company" data-toggle="tab" aria-expanded="false">
                                        <div class="tg-navcontent">
                                            <div class="tg-navcontent">
                                                <span><?php echo esc_attr( $ad_title ); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tg-searchbox tg-searchboxvtwo tab-content">
                            <form class="tg-formtheme tg-formsearch tab-pane active fade in" id="regularuser" action="<?php echo listingo_get_search_page_uri();?>" method="get">
								<fieldset>
									<?php if( !empty( $pro_tab_title ) ) { ?>
										<legend class="tg-formtitle">
											<?php echo do_shortcode($pro_tab_title ); ?>
										</legend>
									<?php } ?>
									<?php if (!empty($dir_keywords) && $dir_keywords === 'enable') { ?>                                        
										<div class="form-group tg-inputwithicon">
											<i class="lnr lnr-magnifier"></i>          
											<?php do_action('listingo_get_search_keyword'); ?>
										</div>
									<?php } ?>
									<?php 
									if( isset( $geo_type ) && $geo_type === 'countries' ){ ?>
										<div class="form-group tg-inputwithicon">
											<i class="lnr lnr-map-marker"></i>
											<?php do_action('listingo_get_countries_list'); ?>
										</div>
									<?php } else {
										if (!empty($dir_location) && $dir_location === 'enable') { ?>
											<div class="form-group tg-inputwithicon">
												<i class="lnr lnr-map-marker"></i>
												<?php do_action('listingo_get_search_geolocation'); ?>
											</div>
										<?php }?>
									<?php } ?>                         
									<div class="form-group tg-inputwithicon">
										<i class="lnr lnr-layers"></i>
										<?php do_action('listingo_get_search_category'); ?>
									</div>       
									<div class="tg-btns">
										<button class="tg-btn tg-btnvtwo" type="submit"><?php echo esc_attr( $provider_button ); ?></button>
									</div>
									<div class="tg-filterholder">
										<div class="tg-title"><h4><?php esc_html_e('Misc :', 'listingo'); ?></h4></div>
										<div class="tg-checkboxgroupvtwo">
											<span class="tg-checkboxvtwo">
												<input type="checkbox" id="tg-appointment1" name="appointment" value="true">
												<label for="tg-appointment1">
													<span><?php esc_html_e('Online Appointment', 'listingo'); ?></span>
												</label>
											</span>
											<span class="tg-checkboxvtwo">
												<input type="checkbox" id="tg-profile1" name="photo" value="true">
												<label for="tg-profile1">
													<span><?php esc_html_e('With Profile Photo', 'listingo'); ?></span>
												</label>
											</span>
										</div>
									</div>
								</fieldset>
                            </form>
                            <?php if ( function_exists('fw_get_db_settings_option') && fw_ext('ads')) {?>
                                <form class="tg-formtheme tg-formsearch tab-pane fade in" id="company" action="<?php echo esc_url( $search_page );?>" method="get">
                                    <fieldset>
                                        <?php if( !empty( $ad_tab_title ) ) { ?>
                                            <legend class="tg-formtitle">
                                                <?php echo do_shortcode( $ad_tab_title ); ?>
                                            </legend>
                                        <?php } ?>                                
                                        <div class="form-group tg-inputwithicon">
                                            <i class="lnr lnr-magnifier"></i>
                                            <?php do_action('listingo_get_search_keyword'); ?>
                                        </div>                                       
                                        <?php 
                                        if( isset( $geo_type ) && $geo_type === 'countries' ){ ?>
                                            <div class="form-group tg-inputwithicon">
                                                <i class="lnr lnr-map-marker"></i>
                                            <?php do_action('listingo_get_countries_list'); ?>
                                            </div>
                                        <?php } else {
                                            if (!empty($dir_location) && $dir_location === 'enable') { ?>
                                                <div class="form-group tg-inputwithicon">
                                                    <i class="lnr lnr-map-marker"></i>
                                                    <?php do_action('listingo_get_ads_search_geolocation'); ?>
                                                </div>
                                            <?php }?>
                                        <?php } ?>
                                        <div class="form-group tg-select tg-inputwithicon">
                                            <i class="lnr lnr-layers"></i>
                                            <?php do_action('listingo_get_ad_category_filter');?>
                                        </div>
                                        <div class="tg-btns">
                                            <button class="tg-btn tg-btnvtwo" type="submit"><?php echo esc_attr( $ad_button ); ?></button>
                                        </div>                                  
                                    </fieldset>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = '
jQuery(document).ready(function(){
    var mySlider = jQuery("#tg-homeslidervfour-'.esc_js($counter).'").pogoSlider({
        autoplay: '.esc_js($autoplay).',
        generateNav: '.esc_js($show_nav).',
        displayProgess: '.esc_js($progress).',
        pauseOnHover: '.esc_js($pause_on_hover).',
        targetHeight: '.esc_js($height).',
        responsive: '.esc_js($responsive).',
        autoplayTimeout: '.esc_js($time_out).',
        generateButtons:'.esc_js($scroll).',
    }).data("plugin_pogoSlider");});';
wp_add_inline_script('listingo_callbacks', $script, 'after');
}
