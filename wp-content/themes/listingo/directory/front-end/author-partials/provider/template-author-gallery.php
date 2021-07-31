<?php
/**
 *
 * Author Gallery Template.
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

/**
 * Get The Dashboard Gallery
 */
$list_gallery = array();
if (!empty($author_profile->profile_gallery_photos)) {
    $list_gallery = $author_profile->profile_gallery_photos;
}

$flag = sp_unique_increment();
?>
<?php if (!empty($list_gallery)) { ?>
    <div class="tg-companyfeaturebox tg-gallery" id="section-gallery">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Gallery', 'listingo'); ?></h3>
        </div>
        <ul>
            <?php
            foreach ($list_gallery['image_data'] as $key => $gallery) {
                $thumb 	= !empty($gallery['thumb']) ? $gallery['thumb'] : '';
                $full 	= !empty($gallery['full']) ? $gallery['full'] : '';
				$link 	= !empty($gallery['link']) ? $gallery['link'] : '';
				$title  = !empty($gallery['title']) ? $gallery['title'] : '';
				
                if (!empty($gallery['image_id'])) {
                    $image_meta = listingo_get_image_metadata($gallery['image_id']);
                }
                $image_alt = !empty($image_meta['alt']) ? $image_meta['alt'] : '';
                $image_title = !empty($image_meta['title']) ? $image_meta['title'] : '';
                $image_meta_data = $image_title;
                if (!empty($image_alt)) {
                    $image_meta_data = $image_alt;
                }
				
				$linkClass	= empty( $link ) ? 'sp-link-empty' : 'sp-link-available';
                ?>
                <li class="<?php echo esc_attr( $linkClass );?>">
                    <div class="tg-galleryimgbox">
                        <?php if (!empty($thumb) || !empty($full)) { ?>
                            <figure>
                                <?php if (!empty($thumb)) { ?>
                                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($image_meta_data); ?>">
                                <?php } ?>
                                <?php if (!empty($full)) { ?>
                                    <a class="tg-btngallery" href="<?php echo esc_url($full); ?>" data-rel="prettyPhoto[gallery]">
                                        <i class="lnr lnr-magnifier"></i>
                                    </a>
                                <?php } ?>
                                <?php if (!empty($link)) { ?>
									 <a target="_blank" title="<?php echo esc_attr($title); ?>" class="tg-btngallery btn-media-link" href="<?php echo esc_url($link); ?>" >
										<i class="lnr lnr-link"></i>
									 </a>
                           		<?php } ?>
                            </figure>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>