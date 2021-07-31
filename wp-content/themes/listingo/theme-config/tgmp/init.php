<?php

/**
 * Plugin installation and activation for WordPress themes.
 *
 * Please note that this is a drop-in library for a theme or plugin.
 * The authors of this library (Thomas, Gary and Juliette) are NOT responsible
 * for the support of your plugin or theme. Please contact the plugin
 * or theme author for support.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.6.1
 * @link      http://tgmpluginactivation.com/
 * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright Copyright (c) 2011, Thomas Griffin
 * @license   GPL-2.0+
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/theme-config/tgmp/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'listingo_plugin_activation');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function listingo_plugin_activation() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $dir = get_template_directory() . '/theme-config/plugins/';
    $plugins = array(
        array(
            'name' => esc_html__('Unyson', 'listingo'),
            'slug' => 'unyson',
            'required' => true,
			'source' => 'https://github.com/etwordpress01/Unyson/archive/master.zip',
        ),
        array(
            'name' => esc_html__('Listingo Core', 'listingo'),
            'slug' => 'listingo_core',
            'source' => $dir . 'listingo_core.zip',
            'required' => true,
        ),
		array(
            'name' => esc_html__('Listingo CRON', 'listingo'),
            'slug' => 'listingo_cron',
            'source' => $dir . 'listingo_cron.zip',
            'required' => true,
        ),
        array(
            'name' => esc_html__('Woocommerce', 'listingo'),
            'slug' => 'woocommerce',
            'required' => true,
        ),
		array(
            'name' => esc_html__('WP Bakery Page Builder', 'listingo'),
            'slug' => 'js_composer',
            'source' => $dir . 'js_composer.zip',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
		array(
            'name' => esc_html__('Listingo VC-ADDON( Work With WP Bakery Page Builder )', 'listingo'),
            'slug' => 'listingo_vc_shortcodes',
            'source' => $dir . 'listingo_vc_shortcodes.zip',
            'required' => false,
        ),
		array(
            'name'      => 'bbPress',
            'slug'      => 'bbpress',
            'required'  => false,
        ),
        array(
            'name' => esc_html__('WooCommerce Stripe Gateway', 'listingo'),
            'slug' => 'woocommerce-gateway-stripe',
            'required' => true,
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'listingo'),
            'slug' => 'contact-form-7',
            'required' => false,
        ),
        array(
            'name' => esc_html__('Loco Translate', 'listingo'),
            'slug' => 'loco-translate',
            'required' => false,
        ),
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'listingo';
    /*
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are wrapped in a sprintf(), so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to pre-packaged plugins.
        'menu' => 'install-required-plugins', // Menu slug.
        'parent_slug' => 'themes.php', // Parent menu slug.
        'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => esc_html__('Install Required Plugins', 'listingo'),
            'menu_title' => esc_html__('Install Plugins', 'listingo'),
            'installing' => esc_html__('Installing Plugin: %s', 'listingo'), // %s = plugin name.
            'oops' => esc_html__('Something went wrong with the plugin API.', 'listingo'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'listingo'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'listingo'), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'listingo'), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'listingo'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'listingo'), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'listingo'), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'listingo'), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'listingo'), // %1$s = plugin name(s).
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'listingo'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'listingo'),
            'return' => esc_html__('Return to Required Plugins Installer', 'listingo'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'listingo'),
            'complete' => esc_html__('All plugins installed and activated successfully. %s', 'listingo'), // %s = dashboard link.
            'nag_type' => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa($plugins, $config);
}
