<?php
/**
 *
 * Author Sidebar Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $wp_query, $current_user;
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();
$social_links = apply_filters('listingo_get_social_media_icons_list',array());
$social_target	= !empty( $author_profile->social_target ) ? $author_profile->social_target : '_blank';
?>
<section class="tg-haslayout spv4-socials">
	<?php if( !empty( $social_links ) ){?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="tg-usersocialicons">
						<ul class="tg-socialicons tg-socialiconssilmple">
							<?php 
								foreach( $social_links as $key => $social ){
									$item 		= get_user_meta($author_profile->ID,$key,true);
									$icon		= !empty( $social['icon'] ) ? $social['icon'] : '';
									$classes	= !empty( $social['classses'] ) ? $social['classses'] : '';
									$title		= !empty( $social['title'] ) ? $social['title'] : '';
									$color		= !empty( $social['color'] ) ? $social['color'] : '#484848';				
									if( $key === 'whatsapp' ){
										if ( !empty( $item ) ){
											$item	= 'https://api.whatsapp.com/send?phone='.$item;
										}
									} else if( $key === 'skype' ){
										if ( !empty( $item ) ){
											$item	= 'skype:'.$item.'?call';
										}
									}else{
										$item	= esc_url($item);;
									}

									if(!empty($item)) {?>
										<li class="<?php echo esc_attr($classes); ?>"><a style="background:none" target="<?php echo esc_attr( $social_target );?>" href="<?php echo esc_attr($item); ?>"><i style="color:<?php echo esc_attr( $color );?>" class="<?php echo esc_attr($icon); ?>"></i></a></li>
									<?php } ?>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?php }?>
	<?php if (!empty($author_profile->address)) { ?>
	<div class="tg-innerpagebannervtwo tg-innerpagebannervthree">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ol class="tg-breadcrumb">
						<li><a href="//maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($author_profile->address); ?>" target="_blank"><i class="fa fa-location-arrow"></i></a><span><?php echo esc_attr($author_profile->address); ?></span></li>
						<li class="tg-active"><a href="//maps.google.com/maps?saddr=&amp;daddr=<?php echo esc_attr($author_profile->address); ?>" target="_blank"><?php esc_html_e('Get Directions', 'listingo'); ?></a></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</section>
