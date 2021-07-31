<?php
/**
 *
 * The template part to edit articles.
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $current_user,
 $wp_roles,
 $userdata;
$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$content = esc_html__('Article detail will be here', 'listingo');
$placeholder = fw_get_template_customizations_directory_uri() . '/extensions/articles/static/img/thumbnails/placeholder.jpg';
$settings = array('media_buttons' => false,'quicktags' => true);
$edit_id = !empty($_GET['id']) ? intval($_GET['id']) : '';
$post_author = get_post_field('post_author', $edit_id);
$status = get_post_status($edit_id);
?>
<div id="tg-content" class="tg-content edit-mode">
    <div class="tg-dashboardbox tg-businesshours">
        <?php
        if (intval($url_identity) === intval($post_author)) {
            if (isset($status) && $status === 'publish') {
                $args = array('posts_per_page' => '-1',
                    'post_type' => 'sp_articles',
                    'orderby' => 'ID',
                    'post_status' => 'publish',
                    'post__in' => array($edit_id),
                    'suppress_filters' => false
                );

                $query = new WP_Query($args);

                while ($query->have_posts()) : $query->the_post();
                    global $post;
                    $width = '150';
                    $height = '150';

                    $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                    if (has_post_thumbnail()) {
                        $thumbnail = $thumbnail;
                    } else {
                        $thumbnail = $placeholder;
                    }
                    ?>
                    <div class="tg-dashboardtitle">
                        <h2><?php esc_html_e('Edit Article', 'listingo'); ?></h2>
                    </div>
                    <div class="tg-servicesmodal tg-categoryModal"
                         <div class="tg-modalcontent">
                            <form class="tg-themeform tg-formamanagejobs tg-addarticle sp-dashboard-profile-form">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                            <div class="form-group">
                                                <input type="text" value="<?php the_title(); ?>" name="article_title" class="form-control" placeholder="<?php esc_html_e('Article Title', 'listingo'); ?>">
                                                <input type="hidden" name="current" value="<?php echo intval($post->ID); ?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                            <div class="form-group">
                                                <?php wp_editor(get_the_content(), 'article_detail', $settings); ?> 
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <h2><?php esc_html_e('Tags', 'listingo'); ?></h2>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                            <div class="tg-addallowances">
                                                <div class="tg-addallowance">
                                                    <div class="form-group">
                                                        <input type="text" name="article_tags" class="form-control input-feature" placeholder="<?php esc_html_e('Article Tags', 'listingo'); ?>">
                                                        <a class="tg-btn add-article-tags" href="javascript:;"><?php esc_html_e('Add Now', 'listingo'); ?></a>
                                                    </div>
                                                    <ul class="tg-tagdashboardlist sp-feature-wrap">
                                                        <?php
                                                        $terms = wp_get_post_terms($post->ID, 'article_tags');
                                                        if (!empty($terms)) {
                                                            foreach ($terms as $key => $term) {
                                                                ?>
                                                                <li>
                                                                    <span class="tg-tagdashboard">
                                                                        <i class="fa fa-close delete_article_tags"></i>
                                                                        <em><?php echo esc_attr($term->name); ?></em>
                                                                    </span>
                                                                    <input type="hidden" name="article_tags[]" value="<?php echo esc_attr($term->slug); ?>">
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                            <div class="tg-upload">
                                                <div class="tg-uploadhead">
                                                    <span>
                                                        <h3><?php esc_html_e('Upload Featured Image', 'listingo'); ?></h3>
                                                        <i class="fa fa-exclamation-circle"></i>
                                                    </span>
                                                    <i class="lnr lnr-upload"></i>
                                                </div>
                                                <div class="tg-box">
                                                    <label class="tg-fileuploadlabel" for="tg-featuredimage">
                                                        <div id="plupload-featured-container">
															<a href="javascript:;" id="upload-featured-image" class="tg-fileinput sp-upload-container">
																<i class="lnr lnr-cloud-upload"></i>
																<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'listingo'); ?></span>
															</a> 
														</div>
                                                    </label>
                                                    <div class="tg-gallery">
                                                        <div class="tg-galleryimg tg-galleryimg-item">
                                                            <figure>
                                                                <img src="<?php echo esc_url($thumbnail); ?>" class="attachment_src" />
                                                                <input type="hidden" class="attachment_id" name="attachment_id" value="<?php echo get_post_thumbnail_id(); ?>">
                                                                <figcaption>
                                                                    <i class="fa fa-close del-featured-image" data-placeholder="<?php echo esc_url($placeholder); ?>"></i>
                                                                </figcaption>
                                                            </figure>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div id="tg-updateall" class="tg-updateall">
                                        <div class="tg-holder">
                                            <span class="tg-note"><?php esc_html_e('Click to', 'listingo'); ?> <strong> <?php esc_html_e('Update Article Button', 'listingo'); ?> </strong> <?php esc_html_e('to update the article.', 'listingo'); ?></span>
                                            <?php wp_nonce_field('listingo_article_nounce', 'listingo_article_nounce'); ?>
                                            <a class="tg-btn process-article" data-type="update" href="javascript:;"><?php esc_html_e('Update Article', 'listingo'); ?></a>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            } else {
                ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('This article needs to be approve/publish to update.', 'listingo')); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php Listingo_Prepare_Notification::listingo_warning(esc_html__('Restricted Access', 'listingo'), esc_html__('You have not any privilege to view this page.', 'listingo')); ?>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/template" id="tmpl-load-article-tags">
    <li>
    <span class="tg-tagdashboard">
    <i class="fa fa-close delete_article_tags"></i>
    <em>{{data}}</em>
    </span>
    <input type="hidden" name="article_tags[]" value="{{data}}">
    </li>
</script>