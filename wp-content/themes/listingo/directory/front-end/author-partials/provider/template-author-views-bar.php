<?php
/**
 *
 * Author Hits View Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
$author_profile = $wp_query->get_queried_object();

/* ===============Get Total Profile Views================== */
$profile_view = apply_filters('sp_get_profile_views', $author_profile->ID, 'set_profile_view');

/* =============Get the Category ID From User Object============= */
$post_id = '';
$category_name = '';
if (!empty($author_profile->category)) {
    $post_id = $author_profile->category;
    $category_name = get_the_title($post_id);
}

$subcats = get_user_meta($author_profile->ID, 'sub_category', true);	

if( !empty( $subcats ) ){
	$cat_titles	= '';
	$total = listingo_count_items($subcats);
	$count	= 0;
	if( is_array( $subcats ) ){
		foreach( $subcats as $key=>$value ){
			$count++;
			$sub_category_term = get_term_by('slug', $value, 'sub_category');
			if (!empty($sub_category_term)) {
				$cat_titles		.= $sub_category_term->name;
				if ($count < ( $total )) {
				  $cat_titles		.= ', ';
			   }
			}
		}
	}
}

if (!empty($category_name) || !empty($profile_view)) {?>
    <div class="tg-companynameandviews sp-detail-cats">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-left">
                    <?php if (!empty($category_name)) { ?>
                        <h2 class="cats-count"><strong><?php echo esc_attr($category_name); ?></strong><?php if( !empty( $cat_titles ) ) {?>&nbsp;<i class="fa fa-angle-right"></i>&nbsp;<?php echo esc_attr( $cat_titles );?><?php }?></h2>
                    <?php } ?>
                    <?php if (!empty($profile_view)) { ?>
                        <span class="tg-totalsviews">
                            <i class="fa fa-eye"></i>
                            <i><?php echo intval($profile_view); ?></i>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
