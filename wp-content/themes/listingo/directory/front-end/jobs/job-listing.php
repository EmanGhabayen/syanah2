<?php
/**
 *
 * Job template, job listing view
 *
 * @package   Listingo
 * @author    Themographics
 * @link      http://themographics.com/
 * @since 1.0
 */
global $paged, $total_posts, $query_args, $showposts;
get_header();
?>
<div class="container">
    <div class="row">
        <div id="tg-twocolumns" class="tg-twocolumns">
            <form class="sp-form-search tg-themeform tg-formrefinesearch" action="" method="get">
                <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9 pull-right">
                    <div class="row">
                        <div id="tg-content" class="tg-content">
                            <div class="tg-joblisting tg-listing tg-listview">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="tg-sortfilters">
                                        <div class="tg-sortfilter">
                                            <?php do_action('listingo_get_default_sortby'); ?>
                                        </div>
                                        <div class="tg-sortfilter">
                                            <?php do_action('listingo_get_orderby'); ?>
                                        </div>
                                        <div class="tg-sortfilter">
                                            <?php do_action('listingo_get_showposts'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table class="tg-tablejoblidting">
                                        <tbody>
                                            <?php
                                            $job_data = new WP_Query($query_args);

                                            if ($job_data->have_posts()) {
                                                while ($job_data->have_posts()) : $job_data->the_post();
                                                    global $post;
                                                    $job_type = '';
                                                    $career_level = '';
                                                    $location = '';
                                                    if (function_exists('fw_get_db_post_option')) {
                                                        $job_type = fw_get_db_post_option($post->ID, 'job_type', true);
                                                        $career_level = fw_get_db_post_option($post->ID, 'career_level', true);
                                                        $location = fw_get_db_post_option($post->ID, 'address', true);
                                                        $list_career_type = listingo_get_career_level();
                                                        $list_job_types = listingo_get_job_type();
                                                        if (array_key_exists($job_type, $list_job_types)) {
                                                            $job_type = $list_job_types[$job_type];
                                                        }
                                                        if (array_key_exists($career_level, $list_career_type)) {
                                                            $career_level = $list_career_type[$career_level];
                                                        }
                                                    }
													
                                                    $avatar = apply_filters(
                                                            'listingo_get_media_filter', listingo_get_user_avatar(array('width' => 100, 'height' => 100), $post->post_author), array('width' => 100, 'height' => 100)
                                                    );
													
													
													if(!empty($post->post_author)){
														$author_name = listingo_get_username($post->post_author);
													}
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <figure class="tg-companylogo">
                                                                <img src="<?php echo esc_url($avatar); ?>" alt="<?php esc_html_e('Job post author.', 'listingo'); ?>">
                                                            </figure>
                                                            <div class="tg-contentbox">
                                                                <?php if (!empty($job_type)) { ?>
                                                                    <a class="tg-tag tg-featuredtag" href="javascript:;"><?php echo esc_attr($job_type); ?></a>
                                                                <?php } ?>
                                                                <div class="tg-title">
                                                                    <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_title(); ?></a></h3>
                                                                </div>
                                                                <?php if (!empty($author_name)) { ?>
                                                                    <span><?php esc_html_e('By: ', 'listingo'); ?><?php echo esc_attr($author_name); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($location)) { ?>
                                                                <span><?php echo esc_attr($location); ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($career_level)) { ?>
                                                                <span><?php echo esc_attr($career_level); ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><span> <?php printf( _x( '%s Ago', '%s = human-readable time difference', 'listingo' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?> </span></td>
                                                    </tr>
                                                    <?php
                                                endwhile;
                                                wp_reset_postdata();
                                            }else{
                                                Listingo_Prepare_Notification::listingo_info(esc_html__('Info', 'listingo'), esc_html__('Sorry we could not find any job right now.', 'listingo'));
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                if (!empty($total_posts) && !empty($showposts) && $total_posts > $showposts) {
                                    ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <?php listingo_prepare_pagination($total_posts, $showposts); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3 pull-left">
                    <aside id="tg-sidebar" class="tg-sidebar">
                        <fieldset>
                            <h4><?php esc_html_e('Filter By Categories', 'listingo'); ?></h4>
                            <div class="tg-checkboxgroup">
                                <div class="form-group tg-inpuicon">
                                    <i class="lnr lnr-magnifier"></i>
                                    <?php do_action('listingo_get_search_keyword'); ?>
                                </div>
                                <?php do_action('listingo_get_search_category'); ?>
                            </div>
                        </fieldset>
                        <?php do_action('listingo_get_job_search_filtrs'); ?>
                    </aside>
                </div>
            </form>
            <?php
            $script = "jQuery(document).ready(function(){
                jQuery(document) . on('change', '.sp-sortby, .sp-orderby, .sp-showposts', function (event) {
                        jQuery('.sp-form-search') . submit();
                    });
                });";
            wp_add_inline_script('listingo_callbacks', $script, 'after')
            ?>
        </div>
    </div>
</div>
<?php
get_footer();
