<?php
/**
 * Badged
 *
 * Transforms the standard WordPress update & comment notification badges into iOS-styled ones.
 * Just activate and enjoy the red badges.
 *
 * @package   Badged
 * @author    Matthias Kretschmann <m@kretschmann.io>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2014 Matthias Kretschmann
 *
 * @wordpress-plugin
 * Plugin Name: 	Badged
 * Plugin URI: 		http://kremalicious.com/badged/
 * Description: 	Transforms the standard WordPress update & comment notification badges into iOS-styled ones. Just activate and enjoy the red badges.
 * Author: 			Matthias Kretschmann
 * Author URI: 		http://matthiaskretschmann.com
 * Version: 		1.0.1
 * License:     	GPL-2.0+
 * License URI: 	http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: 	/languages
 * Text Domain: 	badged
 * GitHub Plugin URI: https://github.com/kremalicious/Badged
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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

// Define constants
if ( ! defined( 'BADGED_FILE' ) ){
    define('BADGED_FILE', $badged_plugin_file);
}
if ( ! defined( 'BADGED_URL' ) ){
    define('BADGED_URL', plugin_dir_url($badged_plugin_file));
}
if ( ! defined( 'BADGED_PATH' ) ){
    define('BADGED_PATH', WP_PLUGIN_DIR.'/'.basename(dirname($badged_plugin_file)).'/');
}
if ( ! defined( 'BADGED_BASENAME' ) ){
    define('BADGED_BASENAME', plugin_basename( $badged_plugin_file ));
}

/**
 * Let's roll
 *
 * @since 1.0.0
 *
 */
    
require_once( BADGED_PATH . '/admin/class-badged-admin.php' );
add_action( 'plugins_loaded', array( 'Badged', 'get_instance' ) );

register_activation_hook( $badged_plugin_file, array( 'Badged', 'activate' ) );
register_deactivation_hook( $badged_plugin_file, array( 'Badged', 'deactivate' ) );
