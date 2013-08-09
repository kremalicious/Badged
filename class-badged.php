<?php
/**
 * Badged
 *
 * @package   Badged
 * @author    Matthias Kretschmann <desk@kremalicious.com>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2013 Matthias Kretschmann
 */

/**
 * Plugin class.
 *
 *
 * @package Badged
 * @author  Matthias Kretschmann <desk@kremalicious.com>
 */
class Badged {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'badged';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Load admin style sheet
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		
		// add settings link on plugins page
		add_filter('plugin_action_links_'.$this->plugin_slug, array( $this, 'filter_settings_link' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		register_setting('badged', 'menu');
		register_setting('badged', 'bar');
		register_setting('badged', 'ios6');
		register_setting('badged', 'ios7');
		
		update_option('menu', 'yes');
		update_option('bar', 'no');
		update_option('ios6', 'yes');
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'bdgd', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( BADGED_BASENAME ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/options.css', BADGED_BASENAME ), array(), $this->version );
		}
		
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/badged.css', BADGED_BASENAME ), array(), $this->version );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Badged Settings', $this->plugin_slug ),
			__( 'Badged', $this->plugin_slug ),
			'read',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/options.php' );
	}

	/**
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

	/**
	 * Add settings link on plugin page
	 * @since    1.0.0
	 */
	public function filter_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=badged">'. __('Settings') .'</a>'; 
		array_unshift($links, $settings_link); 
		return $links;
	}

}