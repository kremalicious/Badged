<?php
/**
 * Plugin Name: 	Bubbles
 * Plugin URI: 		http://kremalicious.com
 * Description: 	Transforms the standard WordPress update & comment notification bubbles into iOS-styled ones. No settings needed, just activate and enjoy the red bubbles.
 * Author: 			Matthias Kretschmann
 * Author URI: 		http://matthiaskretschmann.com
 * Version: 		0.1.0
 * License: 		GPL
 */


/**
 * Throw in the styles
 *
 * Enqueue the css file
 *
 * @since 0.1.0
 */
 
function bubbles_init() {
	wp_register_style('bubbles-css', plugins_url('/bubbles/bubbles.css'), false, '9001');
	wp_enqueue_style('bubbles-css');
}

if ( is_admin() ) {
	add_action('admin_init', 'bubbles_init');
}

?>