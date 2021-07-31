<?php
/**
 *
 * 404 Page
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
get_header();

if (!function_exists('fw_get_db_settings_option')) {
    $logo_404['url'] = get_template_directory_uri().'/images/404.jpg';
    $title 	 = esc_html__('we are sorry!', 'listingo');
    $sub_title = esc_html__('The page you requested cannot be found.', 'listingo');
    $desc = '';
} else {
    $logo_404  = fw_get_db_settings_option('404_logo');
    $title 	 = fw_get_db_settings_option('404_title');
    $sub_title = fw_get_db_settings_option('404_sub_title');
    $desc 	  = fw_get_db_settings_option('404_description');
}

if( empty( $logo_404['url'] ) ){
	$logo_404['url'] = get_template_directory_uri().'/images/404.jpg';
}

if (empty($desc)){
	$desc	= esc_html__("Can't find what you need? Take a moment and do a search below!", 'listingo');;
}

$class_404 = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
if (!empty($logo_404['url'])) {
    $class_404 = 'col-xs-12 col-sm-7 col-md-7 col-lg-8';
}
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-10 col-lg-push-1">
            <div class="row">
                <?php if (!empty($logo_404['url'])) { ?>
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                        <figure class="tg-404errorimg">
                            <img src="<?php echo esc_url($logo_404['url']); ?>" alt="<?php esc_attr_e('404 Page', 'listingo'); ?>">
                        </figure>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_attr($class_404); ?>">
                    <div class="tg-404errorcontent">
                        <?php if (!empty($title) || !empty($sub_title) || !empty($desc)) { ?>
                            <div class="tg-bordertitle">
                                <?php if (!empty($title)) { ?>
                                    <h2><?php echo esc_attr($title); ?></h2>
                                <?php } ?>
                                <?php if (!empty($sub_title)) { ?>
                                    <h3><?php echo esc_attr($sub_title); ?></h3>
                                <?php } ?>
                            </div>
                            <?php if (!empty($desc)) { ?>
                                <div class="tg-description">
                                    <?php echo wp_kses_post( wpautop(do_shortcode($desc)) ); ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php get_search_form();?>
                        <span class="tg-gobackhome"><?php esc_attr_e('Go Back To', 'listingo'); ?>&nbsp;<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_attr_e('Home Page', 'listingo'); ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
