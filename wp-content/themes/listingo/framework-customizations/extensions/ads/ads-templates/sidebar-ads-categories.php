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
$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
$categories = wp_get_post_terms( $post->ID, 'ad_category', $args );     
    if( !empty( $categories ) ) { 
?>
<div class="tg-widgetvtwo tg-categoriestags">
	<div class="tg-titlewithicon">
        <h3>
            <span class="lnr lnr-layers"></span>
            <?php esc_html_e('Ad Categories', 'listingo'); ?>
        </h3>
    </div>
    <div class="tg-widgetcontent tg-categoriestagholder">
        <?php 
            foreach ($categories as $key => $value) {        
				$color = '';
				if (function_exists('fw_get_db_term_option')) {
					$get_categories_meta = fw_get_db_term_option($value->term_id, 'ad_category');
					$color = !empty( $get_categories_meta['cat_color'] ) ? $get_categories_meta['cat_color'] : '';                
				}             
        	?>
    	   <a href="<?php echo esc_url( get_term_link( $value->term_id ) ); ?>" class="tg-tagwithicon tg-tagwithbus" style="background: <?php echo esc_attr( $color ); ?>"><?php echo esc_attr( $value->name ); ?></a>
        <?php } ?>
    </div>
</div>
<?php } ?>