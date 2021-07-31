<?php
/**
 *
 * The template used for displaying default post style
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
get_header();
global $post;
$listingo_sidebar = 'full';
$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
if (function_exists('fw_ext_sidebars_get_current_position')) {
    $current_position = fw_ext_sidebars_get_current_position();
    if ($current_position != 'full' && ( $current_position == 'left' || $current_position == 'right' )) {
        $listingo_sidebar = $current_position;
        $section_width = 'col-xs-12 col-sm-7 col-md-8 col-lg-8';
    }
}

if (isset($listingo_sidebar) && $listingo_sidebar === 'right') {
    $aside_class = 'pull-right';
    $content_class = 'pull-left';
} else {
    $aside_class = 'pull-left';
    $content_class = 'pull-right';
}
?>
<div class="container">
    <div class="row">
        <div id="tg-twocolumns" class="tg-twocolumns">
            <div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>">
                <?php
                while (have_posts()) : the_post();
                    global $post, $thumbnail, $post_video, $blog_post_gallery, $image_alt;
                    $height = 400;
                    $width = 1180;
                    $user_ID = get_the_author_meta('ID');
                    $user_url = get_author_posts_url($user_ID);
                    $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                    $post_thumbnail_id = get_post_thumbnail_id($post->ID);

                    $udata = get_userdata($user_ID);
					if( !empty( $udata ) ){
						$registered = $udata->user_registered;
					} else{
						$registered = '';
					}

                    $enable_author = '';
                    $enable_comments = 'enable';
                    $enable_date = '';
                    $enable_categories = 'enable';
                    $post_settings = '';

                    if (function_exists('fw_get_db_post_option')) {

                        $enable_author = fw_get_db_settings_option('enable_author');
                        $enable_comments = fw_get_db_settings_option('enable_comments');
                        $enable_categories = fw_get_db_settings_option('enable_categories');
                        $enable_sharing = fw_get_db_settings_option('enable_sharing');

                        if (isset($enable_author) && $enable_author === "enable") {
                            $enable_author = fw_get_db_post_option($post->ID, 'enable_author', true);
                        }

                        if (isset($enable_comments) && $enable_comments === "enable") {
                            $enable_comments = fw_get_db_post_option($post->ID, 'enable_comments', true);
                        }

                        if (isset($enable_categories) && $enable_categories === "enable") {
                            $enable_categories = fw_get_db_post_option($post->ID, 'enable_categories', true);
                        }

                        if (isset($enable_sharing) && $enable_sharing === "enable") {
                            $enable_sharing = fw_get_db_post_option($post->ID, 'enable_sharing', true);
                        }

                        $post_settings = fw_get_db_post_option($post->ID, 'post_settings', true);
                        $enable_comments = $enable_comments == 1 ? 'enable' : $enable_comments;
                    }

                    $thumb_meta = array();
                    if (!empty($post_thumbnail_id)) {
                        $thumb_meta = listingo_get_image_metadata($post_thumbnail_id);
                    }
                    $image_title = !empty($thumb_meta['title']) ? $thumb_meta['title'] : 'no-name';
                    $image_alt = !empty($thumb_meta['alt']) ? $thumb_meta['alt'] : $image_title;

                    $blog_post_gallery = array();
                    $post_video = '';

                    if (isset($post_settings['gallery']['blog_post_gallery']) &&
                            !empty($post_settings['gallery']['blog_post_gallery'])
                    ) {
                        $blog_post_gallery = $post_settings['gallery']['blog_post_gallery'];
                    }

                    if (isset($post_settings['video']['blog_video_link']) && !empty($post_settings['video']['blog_video_link'])
                    ) {
                        $post_video = $post_settings['video']['blog_video_link'];
                    }
					
					$title_show	= 'true';
					if(function_exists('fw_get_db_settings_option')){
						$titlebar_type 		  = fw_get_db_post_option($post->ID, 'titlebar_type', true);

						if(  isset( $titlebar_type['gadget'] ) 
							&& $titlebar_type['gadget'] === 'default' 
						){
							$title_show	= 'false';
						} else if(  isset( $titlebar_type['gadget'] ) 
							&& $titlebar_type['gadget'] === 'none' 
						){
							$title_show	= 'true';
						} else{
							$title_show	= 'false';
						}
					} else{
						$title_show	= 'false';
					}

                    //Creating schema data

                    $listingo_schema_post_data = array();             
                    $listingo_schema_post_data['@context'] = "http://schema.org";
                    $listingo_schema_post_data['@type'] = "BlogPosting";              
                    $listingo_schema_post_data['mainEntityOfPage'] =  get_the_permalink($post->ID);    
                    $listingo_schema_post_data['name']          = get_the_title($post->ID);
                    $listingo_schema_post_data['url']           = get_the_permalink($post->ID);
                    $listingo_schema_post_data['author']        = array(
                        "@type" => "Person",
                        "name"  => get_the_author(),                   
                    );
                    $listingo_schema_post_data['dateModified']  = get_the_modified_date();
                    $listingo_schema_post_data['datePublished'] = get_the_date();
                    $listingo_schema_post_data['description']   = get_the_excerpt($post->ID);
                    $listingo_schema_post_data['headline']      = get_the_title($post->ID);
                    $listingo_schema_post_data['image']         = get_the_post_thumbnail_url($post->ID);
                    $listingo_schema_post_data['publisher']     = array(
                        "@type" => "Organization",
                        "name"  => get_bloginfo('name'),                    
                        "logo"  => array(
                            "@type" => "ImageObject",
                            "url"   => get_the_post_thumbnail_url($post->ID),                                            
                        ),    
                    );             			

                    ?>
                    <div id="tg-content" class="tg-content">
                        <article class="tg-post tg-detailpage tg-postdetail">
                            <?php
                            if (isset($post_settings['gadget']) && $post_settings['gadget'] === 'image' && !empty($thumbnail)
                            ) {
                                get_template_part('/template-parts/single-templates/image-single');
                            } elseif (isset($post_settings['gadget']) && $post_settings['gadget'] === 'gallery' && !empty($blog_post_gallery)
                            ) {
                                get_template_part('/template-parts/single-templates/gallery-single');
                            } elseif (isset($post_settings['gadget']) && $post_settings['gadget'] === 'video' && !empty($post_video)
                            ) {
                                get_template_part('/template-parts/single-templates/video-single');
                            } else if (!empty($thumbnail)) {
                                get_template_part('/template-parts/single-templates/image-single');
                            }
                            ?>
                            <div class="tg-postcontent">
                                <?php if( $title_show === 'true' ){?>
									<div class="tg-title">
										<h3><?php listingo_get_post_title($post->ID); ?></h3>
									</div>
                                <?php }?>
                                <ul class="tg-postmatadata">
                                    <?php if (!empty($enable_author) && $enable_author === 'enable') { ?>
                                        <li>
                                            <?php listingo_get_post_author($user_ID, 'linked', $post->ID); ?>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="javascript:;"><?php listingo_get_post_date($post->ID); ?></a>
                                    </li>
                                </ul>
                                <?php if (is_sticky()) {?>
									<span class="sticky-wrap tg-themetag tg-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','listingo');?></span>
								<?php }?>
                            </div>
                            <div class="tg-description">
                                <?php
                                the_content();
                                wp_link_pages(array(
                                    'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'listingo') . '</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>',
                                ));
                                ?>
                            </div>
                        </article>
                        <?php
                        
                        if (( isset($enable_categories) && $enable_categories === 'enable' ) ||
                                ( isset($enable_sharing['gadget']) && $enable_sharing['gadget'] === 'enable' )
                        ) {
                            ?>
                            <div class="tg-tagsshare blog_single">
                                <?php
									if (isset($enable_categories) && $enable_categories === 'enable') {
										listingo_get_post_categories($post->ID, 'tg-tag', 'category',esc_html__('Categories','listingo'),'yes');
									}
                                ?>
                                <?php
									if (isset($enable_sharing['gadget']) && $enable_sharing['gadget'] === 'enable') {
										listingo_prepare_social_sharing(false, $enable_sharing['enable']['share_title'], 'true', '', $thumbnail);
									}
                                ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($enable_author) && $enable_author === 'enable') { ?>
                            <div class="tg-author">
								<figure><?php echo get_avatar($user_ID, 80);?></figure>
                                <div class="tg-authorcontent">
                                    <div class="tg-authorbox">
                                        <div class="tg-authorhead">
                                            <div class="tg-leftbox">
                                                <div class="tg-name">
                                                    <h4><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a></h4>
                                                    <span><?php esc_html_e('Author Since', 'listingo'); ?>:&nbsp; <?php echo date(get_option('date_format'), strtotime($registered)); ?></span>
                                                </div>
                                            </div>
                                            <?php
                                            $facebook = get_the_author_meta('facebook', $user_ID);
                                            $twitter = get_the_author_meta('twitter', $user_ID);
                                            $pinterest = get_the_author_meta('pinterest', $user_ID);
                                            $linkedin = get_the_author_meta('linkedin', $user_ID);
                                            $tumblr = get_the_author_meta('tumblr', $user_ID);
                                            $google = get_the_author_meta('google', $user_ID);
                                            $instagram = get_the_author_meta('instagram', $user_ID);
                                            $skype = get_the_author_meta('skype', $user_ID);
                                            ?>
                                            <div class="tg-rightbox">
                                                <?php
                                                if (!empty($facebook) || !empty($twitter) || !empty($pinterest) || !empty($linkedin) || !empty($tumblr) || !empty($google) || !empty($instagram) || !empty($skype)
                                                ) {
                                                    ?>
                                                    <ul class="tg-socialicons">
                                                        <?php if (isset($facebook) && !empty($facebook)) { ?>
                                                            <li class="tg-facebook">
                                                                <a href="<?php echo esc_url(get_the_author_meta('facebook', $user_ID)); ?>">
                                                                    <i class="fa fa-facebook"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($twitter) && !empty($twitter)) { ?>
                                                            <li class="tg-twitter">
                                                                <a href="<?php echo esc_url(get_the_author_meta('twitter', $user_ID)); ?>">
                                                                    <i class="fa fa-twitter"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($pinterest) && !empty($pinterest)) { ?>
                                                            <li class="tg-dribbble">
                                                                <a href="<?php echo esc_url(get_the_author_meta('pinterest', $user_ID)); ?>">
                                                                    <i class="fa fa-pinterest-p"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($linkedin) && !empty($linkedin)) { ?>
                                                            <li class="tg-linkedin">
                                                                <a href="<?php echo esc_url(get_the_author_meta('linkedin', $user_ID)); ?>">
                                                                    <i class="fa fa-linkedin"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($tumblr) && !empty($tumblr)) { ?>
                                                            <li class="tg-tumblr">
                                                                <a href="<?php echo esc_url(get_the_author_meta('tumblr', $user_ID)); ?>">
                                                                    <i class="fa fa-tumblr"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($google) && !empty($google)) { ?>
                                                            <li class="tg-googleplus">
                                                                <a href="<?php echo esc_url(get_the_author_meta('google', $user_ID)); ?>">
                                                                    <i class="fa fa-google-plus"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($instagram) && !empty($instagram)) { ?>
                                                            <li class="tg-dribbble">
                                                                <a href="<?php echo esc_url(get_the_author_meta('instagram', $user_ID)); ?>">
                                                                    <i class="fa fa-instagram"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (isset($skype) && !empty($skype)) { ?>
                                                            <li  class="tg-skype">
                                                                <a href="<?php echo esc_url(get_the_author_meta('skype', $user_ID)); ?>">
                                                                    <i class="fa fa-skype"></i>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tg-description">
                                            <p><?php echo nl2br(get_the_author_meta('description', $user_ID)); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
              
                        ?>
                        <?php } ?>
                        <!--Comments Area-->
                        <?php
                        if (isset($enable_comments) && $enable_comments === 'enable') {
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                        }
                        ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php
            if (function_exists('fw_ext_sidebars_get_current_position')) {
                if ($current_position !== 'full') {
                    ?>
                    <div class="col-xs-12 col-sm-5 col-md-4 col-lg-4 <?php echo sanitize_html_class($aside_class); ?>">
                        <aside id="tg-sidebar" class="tg-sidebar">
                            <?php echo fw_ext_sidebars_show('blue'); ?>
                        </aside>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php
do_action('print_schema_tags', $listingo_schema_post_data);
get_footer();?>