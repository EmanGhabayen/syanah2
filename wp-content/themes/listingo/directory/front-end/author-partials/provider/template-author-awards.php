<?php
/**
 *
 * Author Certificate and Awards Template.
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
 * Get the Languages
 */
$list_awards = array();
if (!empty($author_profile->awards)) {
    $list_awards = $author_profile->awards;
}

if (!empty($list_awards)) {?>
    <div class="tg-companyfeaturebox tg-certicicatesawards" id="section-awards">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Certificates &amp; Awards', 'listingo'); ?></h3>
        </div>
        <ul>
            <?php
            foreach ($list_awards as $key => $awards) {

                $award_title 		= !empty($awards['title']) ? $awards['title'] : '';
                $award_description  = !empty($awards['description']) ? $awards['description'] : '';
                $award_date 		= !empty($awards['date']) ? $awards['date'] : '';
				
                $award_image_meta = array();
                $award_banner = apply_filters(
                        'listingo_get_media_filter', '', array('width' => 0, 'height' => 0)
                );
				
                if (!empty($awards['attachment_id'])) {
                    $award_image_meta = listingo_get_image_metadata($awards['attachment_id']);
                    $award_banner = $awards['banner_url'];
                }
                $award_image_alt = !empty($award_image_meta['alt']) ? $award_image_meta['alt'] : '';
                $award_image_title = !empty($award_image_meta['title']) ? $award_image_meta['title'] : '';
				
                ?>
                <li>
                    <?php if (!empty($award_banner)) { ?>
                        <figure>
                            <img src="<?php echo esc_url($award_banner); ?>" alt="<?php echo!empty($award_image_alt) ? esc_attr($award_image_alt) : esc_attr($award_image_title); ?>">
                        </figure>
                    <?php } ?>
                    <?php
                    if (!empty($award_title) ||
						!empty($award_description) ||
						!empty($award_date)) {
                        ?>
                        <div class="tg-textbox">
                            <?php if (!empty($award_title)) { ?>
                                <h4><?php echo esc_attr($award_title); ?></h4>
                            <?php } ?>
                            <?php if (!empty($award_date)) { ?>
                                <time datetime="<?php echo date('Y-m-d', strtotime($award_date)); ?>">
                                    <?php echo esc_attr(date_i18n('F d, Y', $award_date)); ?>
                                </time>
                            <?php } ?>
                            <?php if (!empty($award_description)) { ?>
                                <div class="tg-description">
                                    <?php echo wp_kses_post(wpautop(do_shortcode($award_description))); ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>