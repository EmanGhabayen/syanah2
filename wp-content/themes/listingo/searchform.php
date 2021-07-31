<?php
/**
 *
 * Theme Search form
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
?>
<div class="search" id="search-form">
    <form class="tg-themeform" method="get" role="search" action="<?php echo esc_url(home_url('/')); ?>">
        <fieldset>
            <div class="form-group">
                <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="form-control" placeholder="<?php esc_html_e('Search Here', 'listingo'); ?>">
            </div>
            <button type="submit" class="tg-btn"><?php esc_html_e('Search', 'listingo'); ?></button>
        </fieldset>
    </form>
</div>


