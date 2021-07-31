<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post;
$related_categories = 'ad_category';
$related_terms = wp_get_object_terms($post->ID, $related_categories, array('fields' => 'ids'));

$args = array(
    'post_type' => 'sp_ads',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'order' => 'DESC',
    'orderby' => 'ID',
    'tax_query' => array(
        array(
            'taxonomy' => $related_categories,
            'field' => 'term_id',
            'terms' => $related_terms
        )
    ),
    'post__not_in' => array($post->ID),
);

$related_query = new wp_query($args);

if( $related_query->have_posts() ){ ?>
<div class="tg-asideauthor tg-authorscan">
    <div class="tg-title">
        <h3>
            <span class="lnr lnr-bullhorn"></span> 
            <?php esc_html_e('Related Posts', 'listingo'); ?>
        </h3>
    </div>
    <div class="tg-authorwidget tg-widgettrendingposts">
        <div class="tg-authorslidercontent">
            <div id="tg-oneslides" class="tg-oneslides owl-carousel">
                <?php
                while( $related_query->have_posts() ){ 
                    $related_query->the_post();
                    global $post;
                    $width      = intval(360);
                    $height     = intval(240);
                    $thumbnail  = listingo_prepare_thumbnail($post->ID, $width, $height);
                    if( empty( $thumbnail ) ) {
                        $thumbnail = get_template_directory_uri().'/images/placeholder-360x240.jpg';
                    }                   
                    $author_id = $post->post_author;                
                	?>
                    <div class="item">
                        <div class="tg-automotive">                           
                            <?php do_action('listingo_get_ad_featured_tag', $post->ID ); ?>
                            <figure class="tg-featuredimg tg-authorlink">
                                <div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
                                <?php do_action('listingo_get_ad_category',$post->ID);?>
                                <?php do_action('listingo_print_favorite_ads',$post->ID,$author_id);?>
                            </figure>
                            <div class="tg-companycontent tg-authorfeature">
                                <div class="tg-featuredetails">
                                    <div class="tg-title">
                                        <h2>
                                            <?php do_action('listingo_get_ad_title',$post->ID,get_the_title());?>               
                                        </h2>
                                    </div>                                    
                                    <?php do_action('listingo_get_ad_address',$post->ID);?>
                                </div>
                                <?php do_action('listingo_get_ad_provider_detail',$post->ID,$author_id);?>
                                <?php do_action('listingo_get_ad_meta',$post->ID,$author_id);?>
                            </div>
                        </div>       
                    </div>
                <?php } wp_reset_postdata(); ?>                                
            </div>
        </div>
    </div>
    <?php
		$script = "
		jQuery(document).ready(function(){
			if(jQuery('.single-sp_ads .tg-oneslides').length){        
				jQuery('.tg-oneslides').owlCarousel({
					loop: true,
					margin: 0,
					nav: false,
					dots: false,
					nav: true,
					dots: false,
					rtl: ".listingo_owl_rtl_check().",
					items : 1,
					pagination: true,
					navContainerClass: 'tg-oneslidesnav',
					navClass: ['tg-prev', 'tg-next'],
					navText: [
							'<span class=\"tg-btnroundsmallprev\"><i class=\"lnr lnr-chevron-left\"></i></span>',
							'<span class=\"tg-btnroundsmallnext\"><i class=\"lnr lnr-chevron-right\"></i></span>',
					],
				});   
			}
		});";

		wp_add_inline_script('listingo_callbacks', $script, 'after');
	?>
</div>
<?php }?>