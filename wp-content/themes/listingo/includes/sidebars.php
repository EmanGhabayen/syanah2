<?php

/**
 *
 * Sidebar Resgister
 *
 * @package   Listingo
 * @author    themographics
 * @link      https://themeforest.net/user/themographics/portfolio
 * @since 1.0
 */
/**
 * @Register widget area.
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if (!function_exists('listingo_widgets_init')) {

    function listingo_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('Sidebar', 'listingo'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Default sidebar for home and archive pages.', 'listingo'),
            'before_widget' => '<div id="%1$s" class="tg-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Sidebar 1', 'listingo'),
            'id' => 'footer_sidebar_1',
            'description' => esc_html__('Footer sidebar column 1.', 'listingo'),
            'before_widget' => '<div class="tg-footercolumn %2$s tg-widget" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Sidebar 2', 'listingo'),
            'id' => 'footer_sidebar_2',
            'description' => esc_html__('Footer sidebar column 2.', 'listingo'),
            'before_widget' => '<div class="tg-footercolumn tg-widget %2$s tg-widget" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Sidebar 3', 'listingo'),
            'id' => 'footer_sidebar_3',
            'description' => esc_html__('Footer sidebar column 3.', 'listingo'),
            'before_widget' => '<div class="tg-footercolumn tg-widget %2$s tg-widget" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Sidebar 4', 'listingo'),
            'id' => 'footer_sidebar_4',
            'description' => esc_html__('Footer sidebar column 4.', 'listingo'),
            'before_widget' => '<div class="tg-footercolumn tg-widget %2$s tg-widget" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>'
        ));
		
		register_sidebar(array(
			'name' => esc_html__('Search result page sidebar | Ads', 'listingo'),
			'id' => 'search-page-sidebar',
			'description' => esc_html__('It will be shown on search result page', 'listingo'),
			'before_widget' => '<div id="%1$s" class="tg-widget tg-ads-wgdets %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('User detail page sidebar | Ads', 'listingo'),
			'id' => 'user-page-sidebar',
			'description' => esc_html__('It will be shown on user detail page', 'listingo'),
			'before_widget' => '<div id="%1$s" class="tg-widget tg-ads-wgdets %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-widgettitle"><h3>',
            'after_title' => '</h3></div>',
		));
		register_sidebar(array(
			'name' => esc_html__('User detail page top area | Ads', 'listingo'),
			'id' => 'user-page-top',
			'description' => esc_html__('It will be shown on user detail page after map', 'listingo'),
			'before_widget' => '<div id="%1$s" class="%2$s ads-user-page-top tg-ads-wgdets">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title'  => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('User dashboard page top | Ads', 'listingo'),
			'id' => 'user-dashboard-top',
			'description' => esc_html__('It will be shown on user dashboard top area', 'listingo'),
			'before_widget' => '<div id="%1$s" class="%2$s tg-ads-wgdets">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title'  => '</h2>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('User dashboard page sidebar | Ads', 'listingo'),
			'id' => 'user-dashboard-sidebar',
			'description' => esc_html__('It will be shown on user dashboard sidebar', 'listingo'),
			'before_widget' => '<div id="%1$s" class="%2$s tg-ads-wgdets">',
			'after_widget' => '</div>',
			'before_title' => '<div class="doc-widgetheading"><h2>',
			'after_title'  => '</h2></div>',
		));

        register_sidebar(array(
            'name' => esc_html__('Ad detail page sidebar | Ads', 'listingo'),
            'id' => 'ad-detail-sidebar',
            'description' => esc_html__('It will be shown on ad detail page sidebar', 'listingo'),
            'before_widget' => '<div id="%1$s" class="%2$s tg-ads-wgdets">',
            'after_widget' => '</div>',
            'before_title' => '<div class="doc-widgetheading"><h2>',
            'after_title'  => '</h2></div>',
        ));
    }

    add_action('widgets_init', 'listingo_widgets_init');
}