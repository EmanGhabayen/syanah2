<?php
if (!defined('FW'))
    die('Forbidden');
/**
 * @var $atts
 */
global $paged;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

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
        $meta_query_args = array();
        foreach ($cat_sepration as $key => $value) {
            $meta_query_args[] = array(
                'key' => 'question_cat',
                'value' => (int) $value,
                'compare' => '=',
            );
        }

        $query_relation = array('relation' => 'OR',);
        $meta_query_args = array_merge($query_relation, $meta_query_args);
        $meta_args['meta_query'] = $meta_query_args;
    }
}

//Main Query 
$query_args = array(
    'posts_per_page' => $show_posts,
    'post_type' => 'sp_questions',
    'paged' => $paged,
    'order' => $order,
    'orderby' => $orderby,
    'post_status' => 'publish',
    'ignore_sticky_posts' => 1,
);

//By Categories
if (!empty($meta_args)) {
    $query_args = array_merge($query_args, $meta_args);
}
//By Posts 
if (!empty($posts_in)) {
    $query_args = array_merge($query_args, $posts_in);
}

$loop = !empty($atts['loop']) && $atts['loop'] === 'true' ? 'true' : 'false';
$nav = !empty($atts['nav']) && $atts['nav'] === 'true' ? 'true' : 'false';
$autoplay = !empty($atts['autoplay']) && $atts['autoplay'] === 'true' ? 'true' : 'false';
$excerpt = !empty($atts['excerpt']) ? $atts['excerpt']: '60';
$query = new WP_Query($query_args);
$flag = rand(999, 9999);
?>
<div class="sp-sc-questions-slider tg-haslayout">
    <div id="tg-searchslider-<?php echo esc_attr($flag); ?>" class="tg-searchslider tg-haslayout owl-carousel">
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                global $post;
                $question_by = get_post_meta($post->ID, 'question_by', true);
                $question_to = get_post_meta($post->ID, 'question_to', true);
                $category = get_post_meta($post->ID, 'question_cat', true);

                $category_icon = '';
                $category_color = '';
                $bg_color = '';

                if (function_exists('fw_get_db_post_option') && !empty($category)) {
                    $categoy_bg_img = fw_get_db_post_option($category, 'category_image', true);
                    $category_icon = fw_get_db_post_option($category, 'category_icon', true);
                    $category_color = fw_get_db_post_option($category, 'category_color', true);

                    $bg_color = fw_get_db_post_option($category, 'category_color', true);
                    if (!empty($bg_color)) {
                        $bg_color = 'style=background:' . $bg_color;
                    }
                }
                ?>
                <div class="item tg-searchsliderinfo">
                    <div class="tg-searchdtails">
                        <?php if (!empty($category)) { ?>
                            <div class="tg-adverifiedadd">
                                <a class="tg-verifiedadditem tg-business" <?php echo esc_attr($bg_color); ?> href="<?php echo esc_url(get_permalink($category)); ?>">
                                    <?php echo esc_attr(get_the_title($category)); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="tg-title">
                            <h2><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h2>
                        </div>
                        <div class="tg-description">
                            <?php listingo_prepare_excerpt($excerpt, 'false', '...'); ?>
                        </div>
                    </div>
                    <?php if (function_exists('fw_get_db_settings_option') && fw_ext('questionsanswers')){?>
						<div class="tg-searchmeta">
							<?php fw_ext_get_views_and_time_html($post->ID); ?>
							<?php fw_ext_get_votes_html($post->ID, esc_html__('Is this helpful?', 'listingo')); ?>
						</div>
                    <?php }?>
                </div>
                <?php
            } wp_reset_postdata();
            $script = "
                jQuery('#tg-searchslider-" . esc_js($flag) . "').owlCarousel({
                    items:2,
                    nav:" . esc_js($nav) . ",
                    margin:20,
                    loop:" . esc_js($loop) . ",
                    autoplay:" . esc_js($autoplay) . ",
					rtl: " . listingo_owl_rtl_check() . ",
                    dotsClass: 'tg-sliderdots',
                    navClass: ['tg-prev', 'tg-next'],
                    navContainerClass: 'tg-slidernav',
                    navText: ['<span class=\'lnr lnr-chevron-left\'></span>', '<span class=\'lnr lnr-chevron-right\'></span>'],
                    responsiveClass:true,
                        responsive:{
                            0:{items:1,},
                            991:{items:1,},
                            992:{items:2}
                        },
                });
            ";
            wp_add_inline_script('listingo_callbacks', $script, 'after');
        }
        ?>
    </div>
</div>