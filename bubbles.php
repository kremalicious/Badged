<?php
/**
 * Plugin Name: 	Bubbles
 * Plugin URI: 		http://kremalicious.com
 * Description: 	Transforms the standard WordPress update & comment notification bubbles into iOS-styled ones. Just activate and enjoy the red bubbles.
 * Author: 			Matthias Kretschmann
 * Author URI: 		http://matthiaskretschmann.com
 * Version: 		0.1.0
 * License: 		GPL
 */

 
if (function_exists('load_plugin_textdomain')) {
	load_plugin_textdomain('bbls', false, dirname(plugin_basename(__FILE__)).'/languages' );
}
 
function bubbles_init() {
	bubbles_register_settings();
	if ( get_option('menu') == 'yes') {
		wp_register_style('bubbles-menu-css', plugins_url('css/bubbles-menu.css', __FILE__), false, '9001');
		wp_enqueue_style('bubbles-menu-css');
	}
	
	if ( get_option('bar') == 'yes') {
		wp_register_style('bubbles-bar-css', plugins_url('css/bubbles-bar.css', __FILE__), false, '9001');
		wp_enqueue_style('bubbles-bar-css');
	}
}

function bubbles_bar_only_init() {
	if ( get_option('bar') == 'yes') {
		wp_register_style('bubbles-bar-css', plugins_url('css/bubbles-bar.css', __FILE__), false, '9001');
		wp_enqueue_style('bubbles-bar-css');
	}
}

function bubbles_settings() {
	add_options_page('Bubbles Options', 'Bubbles', 'manage_options', 'bubbles_settings', 'bubbles_settings_page');
}

function bubbles_register_settings() {
	register_setting('bubbles', 'menu');
	register_setting('bubbles', 'bar');
}

function bubbles_settings_page() { 
	require_once('bubbles-settings.php'); 
}

function bubbles_activation() {
	bubbles_register_settings();
	update_option('menu', 'yes');
	update_option('bar', 'yes');
}

if ( is_admin() ) {
	add_action('admin_init', 'bubbles_init');
	add_action('admin_menu', 'bubbles_settings');
} elseif ( !is_admin() && get_option('bar') == 'yes' ) {
	add_action('admin_bar_init', 'bubbles_bar_only_init');
}

register_activation_hook(__FILE__, 'bubbles_activation');

?>