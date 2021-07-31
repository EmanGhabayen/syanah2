<?php
/**
 *
 * Author Experience Template.
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
 * Get The Dashboard Experience
 */
$list_experience = array();
if (!empty($author_profile->experience)) {
    $list_experience = $author_profile->experience;
}

$flag = sp_unique_increment();
?>
<?php if (!empty($list_experience)) { ?>
    <div class="tg-companyfeaturebox tg-experience" id="section-experience">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Experience', 'listingo'); ?></h3>
        </div>
        <div id="tg-accordion" class="tg-accordion tg-experiences-<?php echo esc_attr($flag); ?>">
            <?php
            foreach ($list_experience as $key => $experience) {
                $start_year = '';
                $end_year = '';
                $period = '';

                $title = !empty($experience['title']) ? $experience['title'] : '';
                $company = !empty($experience['company']) ? $experience['company'] : '';
                $description = !empty($experience['description']) ? $experience['description'] : '';
                $current = !empty($experience['current']) ? $experience['current'] : '';

                if (!empty($experience['start_date']) || !empty($experience['end_date'])) {
                    if (!empty($experience['start_date'])) {
                        $start_year = date_i18n('M Y', $experience['start_date']);
                    }

                    if (!empty($experience['end_date'])) {
                        $end_year = date_i18n('M Y', $experience['end_date']);
                    }

                    if (!empty($current) && $current === 'on') {
                        $end_year = esc_html__('To Date', 'listingo');
                    }

                    if (!empty($start_year) || !empty($end_year)) {
                        $period = $start_year . '&nbsp;-&nbsp;' . $end_year;
                    }
                }
                ?>
                <div class="tg-service tg-panel">
                    <div class="tg-accordionheading tg-active">
                        <?php
                        if (!empty($title) ||
                                !empty($period) ||
                                !empty($company)) {
                            ?>
                            <h4>
                                <?php if (!empty($title)) { ?>
                                    <span><?php echo esc_attr($title); ?></span>
                                <?php } ?>
                                <?php if (!empty($period)) { ?>
                                    <span><?php echo esc_attr($period); ?></span>
                                <?php } ?>
                                <?php if (!empty($company)) { ?>
                                    <em><?php echo esc_attr($company); ?></em>
                                <?php } ?>
                            </h4>
                        <?php } ?>
                    </div>
                    <div class="tg-panelcontent" style="display: none;">
                        <?php if (!empty($description)) { ?>
                            <div class="tg-description">
                                <?php echo wp_kses_post(wpautop(do_shortcode($description))); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>