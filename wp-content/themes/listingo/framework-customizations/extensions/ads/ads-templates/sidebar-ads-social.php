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
?>
<div class="tg-asideauthor tg-authorscan">
    <?php do_action('listingo_get_qr_code', 'post', $post->ID ); ?>
    <div class="qr-socailicons">
        <?php listingo_get_social_share_v2(''); ?>                
    </div>
</div>