<?php
/**
 * Badged
 *
 * Transforms the standard WordPress update & comment notification badges into iOS-styled ones.
 * Just activate and enjoy the red badges.
 *
 * @package   Badged
 * @author    Matthias Kretschmann <desk@kremalicious.com>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2013 Matthias Kretschmann
 *
 * @wordpress-plugin
 * Plugin Name: 	Badged
 * Plugin URI: 		http://kremalicious.com/badged/
 * Description: 	Transforms the standard WordPress update & comment notification badges into iOS-styled ones. Just activate and enjoy the red badges.
 * Author: 			Matthias Kretschmann
 * Author URI: 		http://matthiaskretschmann.com
 * Version: 		1.0.0
 * License:     	GPL-2.0+
 * License URI: 	http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: 	/lang
 * Text Domain: 	bdgd
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

define('BADGED_PLUGIN_FILE', $badged_plugin_file);
//define('BADGED_PLUGIN_PATH', WP_PLUGIN_DIR.'/'.basename(dirname($badged_plugin_file)));

/**
 * Let's roll
 *
 * @since 1.0.0
 *
 */

require_once( plugin_dir_path( BADGED_PLUGIN_FILE ) . 'class-badged.php' );

register_activation_hook( BADGED_PLUGIN_FILE, array( 'Badged', 'activate' ) );
register_deactivation_hook( BADGED_PLUGIN_FILE, array( 'Badged', 'deactivate' ) );

Badged::get_instance();