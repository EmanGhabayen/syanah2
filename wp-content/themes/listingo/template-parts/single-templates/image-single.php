<?php
/**
 *
 * The template used for displaying image post formate
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
global $post, $thumbnail, $image_alt;
?>
<figure class="tg-themepost-img">
    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($image_alt); ?>">
</figure>