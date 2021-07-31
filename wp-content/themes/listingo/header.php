<!doctype html>
<!--[if (gt IE 9)|!(IE)]><html lang="en"><![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php if( is_author() ){
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
				$author_profile = $wp_query->get_queried_object();
				$user_avatar = apply_filters(
						'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $author_profile->ID), array('width' => 100, 'height' => 100) //size width,height
				);
			?>
			<meta property="og:url" content="<?php echo get_the_permalink();?>" />
			<meta property="og:type" content="<?php echo esc_url(home_url('/')); ?>" />
			<meta property="og:title" content="<?php echo esc_attr($blogname);?>" />
			<meta property="og:description" content="<?php echo esc_attr($author_profile->description); ?>" />
			<meta property="og:image" content="<?php echo esc_attr($user_avatar);?>" />
        <?php }?>
        
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
      		<?php wp_body_open(); ?>
       	<?php do_action('blink_systemloader');?>
        <?php do_action('listingo_systemloader'); ?>
        <?php do_action('listingo_app_available'); ?>
        <div id="tg-wrapper" class="tg-wrapper tg-haslayout">
            <?php do_action('listingo_do_process_headers'); ?>
            <?php do_action('listingo_prepare_titlebars'); ?>
            <main id="tg-main" class="tg-main tg-haslayout">