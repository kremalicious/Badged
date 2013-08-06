<?php
/**
 * Plugin Name: 	Badged
 * Plugin URI: 		http://kremalicious.com/badged/
 * Description: 	Transforms the standard WordPress update & comment notification badges into iOS-styled ones. Just activate and enjoy the red badges.
 * Author: 			Matthias Kretschmann
 * Author URI: 		http://matthiaskretschmann.com
 * Version: 		0.3.6
 * License: 		GPL
 */


/**
 * Make the plugin work if symlinked
 *
 * Thanks to: 
 * http://alexking.org/blog/2011/12/15/wordpress-plugins-and-symlinks
 *
 * @since 0.3.2
 *
 */

$badged_plugin_file = __FILE__;

if (isset($plugin)) {
	$badged_plugin_file = $plugin;
}
else if (isset($mu_plugin)) {
	$badged_plugin_file = $mu_plugin;
}
else if (isset($network_plugin)) {
	$badged_plugin_file = $network_plugin;
}

define('BADGED_PLUGIN_FILE', $badged_plugin_file);
define('BADGED_PLUGIN_PATH', WP_PLUGIN_DIR.'/'.basename(dirname($badged_plugin_file)));


/**
 * Load translation
 *
 */
if (function_exists('load_plugin_textdomain')) {
	load_plugin_textdomain('bdgd', false, BADGED_PLUGIN_PATH.'/languages' );
}


/**
 * Plugin version, used for cache-busting of style and script file references.
 *
 * @since   1.0.0
 *
 * @var     string
 */
$version = '1.0.0';


/**
 * Register the styles depending on options
 *
 */
function badged_init() {
	badged_register_settings();
	wp_enqueue_style( 'badged-admin-styles', plugins_url( 'css/options.css', BADGED_PLUGIN_FILE), false, $version );
	
	if ( get_option('menu') == 'yes') {
		wp_register_style('badged-menu-css', plugins_url('css/badged-menu.css', BADGED_PLUGIN_FILE), false, $version);
		wp_enqueue_style('badged-menu-css');
	}
	
	if ( get_option('bar') == 'yes') {
		wp_register_style('badged-bar-css', plugins_url('css/badged-bar.css', BADGED_PLUGIN_FILE), false, $version);
		wp_enqueue_style('badged-bar-css');
	}
}

function badged_bar_only_init() {
	if ( get_option('bar') == 'yes') {
		wp_register_style('badged-bar-css', plugins_url('css/badged-bar.css', BADGED_PLUGIN_FILE), false, $version);
		wp_enqueue_style('badged-bar-css');
	}
}

/**
 * Create the options page with our settings
 *
 */
function badged_settings() {
	add_options_page('Badged Options', 'Badged', 'manage_options', 'badged_settings', 'badged_settings_page');
}

function badged_register_settings() {
	register_setting('badged', 'menu');
	register_setting('badged', 'bar');
	register_setting('badged', 'ios6');
	register_setting('badged', 'ios7');
}

function badged_settings_page() { 
	require_once('badged-settings.php'); 
}


/**
 * Set default options upon activation
 *
 */
function badged_activation() {
	badged_register_settings();
	update_option('menu', 'yes');
	update_option('bar', 'yes');
	update_option('ios6', 'yes');
}

if ( is_admin() ) {
	add_action('admin_init', 'badged_init');
	add_action('admin_menu', 'badged_settings');
} elseif ( !is_admin() && get_option('bar') == 'yes' ) {
	add_action('admin_bar_init', 'badged_bar_only_init');
}

register_activation_hook(BADGED_PLUGIN_FILE, 'badged_activation');


/**
 * Add settings link on plugin page
 *
 */
function badged_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=badged_settings">'. __('Settings') .'</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(BADGED_PLUGIN_FILE); 
add_filter('plugin_action_links_'.$plugin, 'badged_settings_link' );

?>