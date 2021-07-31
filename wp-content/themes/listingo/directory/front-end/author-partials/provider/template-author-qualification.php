<?php
/**
 *
 * Author Qualification Template.
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * Get User Queried Object Data
 */
global $wp_query;
$author_profile = $wp_query->get_queried_object();

/**
 * Get The Dashboard Qualification
 */
$list_qualification = array();
if (!empty($author_profile->qualification)) {
    $list_qualification = $author_profile->qualification;
}

$flag = sp_unique_increment();
?>
<?php if (!empty($list_qualification)) { ?>
    <div class="tg-companyfeaturebox tg-qaulifications" id="section-qualifications">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Qualification', 'listingo'); ?></h3>
        </div>

        <div id="tg-accordion" class="tg-accordion tg-qualifications-<?php echo esc_attr($flag); ?>">
            <?php
            foreach ($list_qualification as $key => $value) {
                $start_year = '';
                $end_year = '';
                $period = '';

                if (!empty($value['start_date']) || !empty($value['end_date'])) {
                    if (!empty($value['start_date'])) {
                        $start_year = date_i18n('M Y', $value['start_date']);
                    }

                    if (!empty($value['end_date'])) {
                        $end_year = date_i18n('M Y', $value['end_date']);
                    } else {
                        $end_year = esc_html__('Current', 'listingo');
                    }

                    if (!empty($start_year) || !empty($end_year)) {
                        $period = $start_year . '&nbsp;-&nbsp;' . $end_year;
                    }
                }
                $title = !empty($value['title']) ? $value['title'] : '';
                $institute = !empty($value['institute']) ? $value['institute'] : '';
                $description = !empty($value['description']) ? $value['description'] : '';
                ?>
                <div class="tg-service tg-panel">
                    <div class="tg-accordionheading tg-active">
                        <?php
                        if (!empty($title) ||
                                !empty($period) ||
                                !empty($institute)) {
                            ?>
                            <h4>
                                <?php if (!empty($title)) { ?>
                                    <span><?php echo esc_attr($title); ?></span>
                                <?php } ?>
                                <?php if (!empty($period)) { ?>
                                    <span><?php echo esc_attr($period); ?></span>
                                <?php } ?>
                                <?php if (!empty($institute)) { ?>
                                    <em><?php echo esc_attr($institute); ?></em>
                                <?php } ?>
                            </h4>
                        <?php } ?>
                    </div>
                    <div class="tg-panelcontent" style="display: block;">
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