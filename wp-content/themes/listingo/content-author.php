<?php
/**
 *
 * Author contents
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */

get_header();
$userobject = get_queried_object();
$facebook	   = get_user_meta( $userobject->ID, 'facebook', true);
$twitter	   = get_user_meta( $userobject->ID, 'twitter', true);
$linkedin	   = get_user_meta( $userobject->ID, 'linkedin', true);
$pinterest	   = get_user_meta( $userobject->ID, 'pinterest', true);
$google_plus	   = get_user_meta( $userobject->ID, 'google_plus', true);
$instagram	   = get_user_meta( $userobject->ID, 'instagram', true);
$tumblr	   = get_user_meta( $userobject->ID, 'tumblr', true);
$skype	   = get_user_meta( $userobject->ID, 'skype', true);
$registered = $userobject->user_registered;
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<div class="tg-author th-author-detail">
				<div class="tg-authorbox">
					<figure class="tg-authordp">
						<?php echo get_avatar($userobject->ID, 100); ?>
					</figure>
					<div class="tg-authorcontent">
						<div class="tg-authorhead">
							<div class="tg-leftbox">
								<div class="tg-authorname">
									<h4><a href="javascript:;"><?php the_author(); ?></a> </h4>
									<time datetime="2017-12-12"><?php esc_html_e ('Author Since:', 'listingo'); ?> <?php echo date(get_option('date_format'), strtotime($registered)); ?></time>        
								</div>
							</div>
							<div class="tg-rightbox">
							<?php
								$facebook = get_the_author_meta('facebook', $userobject->ID);
								$twitter = get_the_author_meta('twitter', $userobject->ID);
								$pinterest = get_the_author_meta('pinterest', $userobject->ID);
								$linkedin = get_the_author_meta('linkedin', $userobject->ID);
								$tumblr = get_the_author_meta('tumblr', $userobject->ID);
								$google = get_the_author_meta('google', $userobject->ID);
								$instagram = get_the_author_meta('instagram', $userobject->ID);
								$skype = get_the_author_meta('skype', $userobject->ID);
								?>
								<?php
								if (!empty($facebook) || !empty($twitter) || !empty($pinterest) || !empty($linkedin) || !empty($tumblr) || !empty($google) || !empty($instagram) || !empty($skype)
								) {
									?>
									<ul class="tg-socialicons">
										<?php if (isset($facebook) && !empty($facebook)) { ?>
											<li class="tg-facebook">
												<a href="<?php echo esc_url(get_the_author_meta('facebook', $userobject->ID)); ?>">
													<i class="fa fa-facebook"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($twitter) && !empty($twitter)) { ?>
											<li class="tg-twitter">
												<a href="<?php echo esc_url(get_the_author_meta('twitter', $userobject->ID)); ?>">
													<i class="fa fa-twitter"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($pinterest) && !empty($pinterest)) { ?>
											<li class="tg-dribbble">
												<a href="<?php echo esc_url(get_the_author_meta('pinterest', $userobject->ID)); ?>">
													<i class="fa fa-pinterest-p"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($linkedin) && !empty($linkedin)) { ?>
											<li class="tg-linkedin">
												<a href="<?php echo esc_url(get_the_author_meta('linkedin', $userobject->ID)); ?>">
													<i class="fa fa-linkedin"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($tumblr) && !empty($tumblr)) { ?>
											<li class="tg-tumblr">
												<a href="<?php echo esc_url(get_the_author_meta('tumblr', $userobject->ID)); ?>">
													<i class="fa fa-tumblr"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($google) && !empty($google)) { ?>
											<li class="tg-googleplus">
												<a href="<?php echo esc_url(get_the_author_meta('google', $userobject->ID)); ?>">
													<i class="fa fa-google-plus"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($instagram) && !empty($instagram)) { ?>
											<li class="tg-dribbble">
												<a href="<?php echo esc_url(get_the_author_meta('instagram', $userobject->ID)); ?>">
													<i class="fa fa-instagram"></i>
												</a>
											</li>
										<?php } ?>
										<?php if (isset($skype) && !empty($skype)) { ?>
											<li  class="tg-skype">
												<a href="<?php echo esc_url(get_the_author_meta('skype', $userobject->ID)); ?>">
													<i class="fa fa-skype"></i>
												</a>
											</li>
										<?php } ?>
									</ul>
								<?php } ?>
							</div>
						</div>
						<div class="tg-description">
							<p><?php echo nl2br(get_the_author_meta('description', $userobject->ID)); ?></p>
						</div>  
					</div>                                   
				</div>
			</div>
		</div>
		<div class="tg-authorpostlist">
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>