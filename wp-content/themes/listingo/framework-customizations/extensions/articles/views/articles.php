<?php
/**
 *
 * Listingo display author articles..
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $current_user, $wp_query;
//Get User Queried Object Data
$queried_object = $wp_query->get_queried_object();

if( is_single() ){
	$exclude_post 	= $queried_object->ID;
	$post_author_id = $queried_object->post_author;
} else{
	$exclude_post	= array();
	$post_author_id = $queried_object->ID;
}

$args = array(
    'post_type' => 'sp_articles',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'author' => $post_author_id,
    'order' => 'DESC',
	'post__not_in' => array(intval($exclude_post))
);

$username	= '';
if( function_exists('listingo_get_username') ){
	$username = listingo_get_username($post_author_id);
}
$query = new WP_Query($args);


if ($query->have_posts()) :?>
    <div class="tg-widget tg-widgetrelatedposts sp-provider-articles" id="section-articles">
        <div class="tg-widgettitle">
            <h3><?php esc_html_e('Articles', 'listingo'); ?>&nbsp;<span class="written-by-sp"><?php esc_html_e('Written by', 'listingo'); ?>&nbsp;<?php echo esc_attr( $username );?></span></h3>
        </div>
        <div class="tg-widgetcontent">
            <ul>
                <?php
                while ($query->have_posts()) : $query->the_post();
                    global $post;
                    $height = 150;
                    $width = 150;
                    $user_ID = get_the_author_meta('ID');
                    $user_url = get_author_posts_url($user_ID);
                    $thumbnail = listingo_prepare_thumbnail($post->ID, $width, $height);
                    ?>
                    <li>
                        <div class="tg-serviceprovidercontent">
                            <?php if (!empty($thumbnail)) { ?>
                                <div class="tg-companylogo">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php esc_html_e('Related', 'listingo'); ?>">
                                    </a>
                                </div>
                            <?php } ?>
                            <div class="tg-companycontent">
                                <div class="tg-title">
                                    <h3><a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo esc_attr(get_the_title()); ?> </a></h3>
                                </div>
                                <ul class="tg-matadata">
                                    <li><a href="<?php echo esc_url(get_permalink()); ?>">  <?php esc_html_e('Read More', 'listingo'); ?> </a> </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div>
<?php endif; ?>