<?php
/**
 *
 * Author Language Template.
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
$profile_languages = array();
if (!empty($author_profile->profile_languages)) {
    $profile_languages = $author_profile->profile_languages;
}

if (!empty($profile_languages) && is_array($profile_languages)) { ?>
    <div class="tg-companyfeaturebox tg-languages" id="section-language">
        <div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Languages', 'listingo'); ?></h3>
        </div>
        <ul class="tg-themeliststyle tg-themeliststyledisc">
            <?php 
			foreach ($profile_languages as $key => $language) {
                $get_language_term = get_term_by('slug', $language, 'languages');
                $language_title = '';
                $term_id = '';
                if (!empty($get_language_term)) {
                    $language_title = $get_language_term->name;
                    $term_id 	    = $get_language_term->term_id;
                }
				if( !empty( $language_title ) ) {
				?>
                	<li><?php echo esc_attr($language_title); ?></li>
            <?php }} ?>
        </ul>
    </div>
<?php } ?>