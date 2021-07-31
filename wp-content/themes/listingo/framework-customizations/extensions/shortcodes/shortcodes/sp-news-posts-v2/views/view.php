<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
global $paged;
$tax_query = array();
if (isset($atts['get_mehtod']['gadget']) && $atts['get_mehtod']['gadget'] === 'by_posts' && !empty($atts['get_mehtod']['by_posts']['posts'])) {
    $posts_in['post__in'] = !empty($atts['get_mehtod']['by_posts']['posts']) ? $atts['get_mehtod']['by_posts']['posts'] : array();
    $order = 'DESC';
    $orderby = 'ID';
    $show_posts = !empty($atts['get_mehtod']['by_posts']['show_posts']) ? $atts['get_mehtod']['by_posts']['show_posts'] : '-1';
} else {
    $cat_sepration = array();
    $cat_sepration = $atts['get_mehtod']['by_cats']['categories'];
    $order = !empty($atts['get_mehtod']['by_cats']['order']) ? $atts['get_mehtod']['by_cats']['order'] : 'DESC';
    $orderby = !empty($atts['get_mehtod']['by_cats']['orderby']) ? $atts['get_mehtod']['by_cats']['orderby'] : 'ID';
    $show_posts = !empty($atts['get_mehtod']['by_cats']['show_posts']) ? $atts['get_mehtod']['by_cats']['show_posts'] : '-1';

    if (!empty($cat_sepration)) {
        $slugs = array();
        foreach ($cat_sepration as $key => $value) {
            $term = get_term($value, 'category');
            $slugs[] = $term->slug;
        }

        $filterable = $slugs;
        $tax_query['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'terms' => $filterable,
                'field' => 'slug',
        ));
    }
}

//Main Query 
$query_args = array(
    'posts_per_page' => $show_posts,
    'post_type' => 'post',
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1);

//By Categories
if (!empty($cat_sepration)) {
    $query_args = array_merge($query_args, $tax_query);
}
//By Posts 
if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}
$query = new WP_Query($query_args);
$section_heading = !empty($atts['section_heading']) ? $atts['section_heading'] : '';
$section_sub_heading = !empty($atts['section_subheading']) ? $atts['section_subheading'] : '';
$btn_text = !empty($atts['btn_text']) ? $atts['btn_text'] : '';
$btn_link = !empty($atts['btn_link']) ? $atts['btn_link'] : '#';
$excerpt  = !empty($atts['excerpt']) ? $atts['excerpt'] : 60;
?>
<div class="sp-sc-news-v2 tg-haslayout">
    <?php if (!empty($section_heading) || !empty($section_subheading)) { ?>
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
            <div class="tg-sectionheadvtwo">
                <div class="tg-sectiontitle">
                    <?php if (!empty($section_sub_heading)) { ?>
                        <span><?php echo esc_attr($section_sub_heading); ?></span>
                    <?php } ?>
                    <?php if (!empty($section_heading)) { ?>
                        <h2><?php echo esc_attr($section_heading); ?></h2>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="tg-latestarticles">
        <div class="row">
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                global $post;
                $height = 152;
                $width  = 275;

                $user_ID = get_the_author_meta('ID');
                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 tg-verticaltop">
                    <div class="tg-newsarticle">
                        <?php if (!empty($thumbnail)) { ?>
                            <figure class="tg-newsimg">
                                <?php if (is_sticky($post->ID)) { ?>
                                    <span class="tg-posttag"><i class="fa fa-bolt"></i></span>
                                <?php } ?>
                                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_html_e('Post image','listingo'); ?>">
                            </figure>
                        <?php } ?>
                        <div class="tg-postauthorname">
                            <div class="tg-articlecontent">
                                <div class="tg-articletitle">
                                    <h3><?php listingo_get_post_title($post->ID); ?></h3>
                                </div>
                                <?php if( function_exists('listingo_prepare_excerpt') ){?>
                                <div class="tg-description">
									<p><?php echo listingo_prepare_excerpt($excerpt, true, esc_html__('read more', 'listingo')); ?></p>
								</div>
                           		<?php }?>
                            </div>
                            <ul class="tg-postarticlemeta">
                                <li> <span><?php listingo_get_post_date($post->ID); ?></span> </li>
                             </ul>
                        </div>
                    </div>
                </div>
                <?php
            } wp_reset_postdata();
        }
        ?>
        <?php if (!empty($btn_text)) { ?>
            <div class="tg-btnboxvtwo">
                <a class="tg-btn tg-btnvtwo" href="<?php echo esc_url($btn_link); ?>"><?php echo esc_attr($btn_text); ?></a>
            </div>
        <?php } ?>
        </div>
    </div>
</div>