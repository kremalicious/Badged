<?php
/**
 * Badged
 *
 * @package   Badged
 * @author    Matthias Kretschmann <m@kretschmann.io>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2014 Matthias Kretschmann
 */

/**
 * Plugin class.
 *
 *
 * @package Badged
 * @author  Matthias Kretschmann <m@kretschmann.io>
 */
class Badged {
    
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since    1.0.0
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier.
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
	 * Initialize the plugin by loading scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since    1.0.0
	 */
	private function __construct() {
        
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );
        
		// Load admin style sheets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        
		// Load admin bar style sheets
        if ( is_admin_bar_showing() ) {
		    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_adminbar_styles' ) );
        }
            
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
        
        // init settings, nicely isolated
        if ( ! empty ( $GLOBALS['pagenow'] )
            and ( 'options-general.php' === $GLOBALS['pagenow']
                or 'options.php' === $GLOBALS['pagenow']
            )
        ) {
            add_action( 'admin_init', array( $this, 'initialize_badged_settings' ) );
        }

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since    1.0.0
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
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {

        // construct the default option array
        $options = get_option('badged_settings');
        $options['style'] = 'ios7';
        
        // set option
		update_option( 'badged_settings', $options );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		
        // deregister all settings
        unregister_setting(
            'badged_settings',
            'badged_settings'
        );
        
        // clean up options in database
        delete_option('badged_settings');
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( BADGED_PATH ) . '/languages/' );

	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since    1.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
            return;
        }

		$screen = get_current_screen();
        if ( $screen->id == $this->plugin_screen_hook_suffix ) {
            wp_register_style( $this->plugin_slug .'-admin-styles', BADGED_URL . 'admin/assets/css/admin.min.css', array(), self::VERSION );
            wp_enqueue_style( $this->plugin_slug .'-admin-styles' );
        }
		
        $options = get_option( 'badged_settings' );
        
        // Default Style
        if ( 'ios7' == $options['style'] ) {
            wp_register_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged.min.css', array(), self::VERSION );
            wp_enqueue_style( $this->plugin_slug .'-badged-styles' );
        }
        
        // Old Style
        if ( 'ios6' == $options['style'] ) {
            wp_register_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged-ios6.min.css', array(), self::VERSION );
            wp_enqueue_style( $this->plugin_slug .'-badged-styles' );
        }

	}
    
	/**
	 * Register and enqueue admin bar specific style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_adminbar_styles() {
		
        $options = get_option( 'badged_settings' );
        
        // Default Style
        if ( 'ios7' == $options['style'] ) {
            wp_register_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged.min.css', array(), self::VERSION );
            wp_enqueue_style( $this->plugin_slug .'-badged-styles' );
        }
        
        // Old Style
        if ( 'ios6' == $options['style'] ) {
            wp_register_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged-ios6.min.css', array(), self::VERSION );
            wp_enqueue_style( $this->plugin_slug .'-badged-styles' );
        }

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Badged Settings', $this->plugin_slug ),
			__( 'Badged', $this->plugin_slug ),
			'manage_options',
			'badged_settings',
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}
    
	/**
	 * Set default options
	 * @since    1.0.0
	 */
    public function badged_default_settings() {
        
        $defaults = array(
            'style' => 'ios7'
        );
    
        return apply_filters( 'badged_default_settings', $defaults );
        
    }
    
	/**
	 * Register settings
	 * @since    1.0.0
	 */
    public function initialize_badged_settings() {
        
        if ( false == get_option( 'badged_settings' ) ) {        
            add_option( 
                'badged_settings', 
                apply_filters( 
                    'badged_default_settings', 
                    $this->badged_default_settings()
                )
            );
        } // end if
        
        add_settings_section(
            'badged_style_section',
            __( 'Style', 'badged' ),
            array( $this, 'badged_style_settings_callback' ),
            'badged_settings'
        );
        
        add_settings_field(
            'Badged Style',
            __( 'Set Style', 'badged' ),
            array( $this, 'badged_style_settings_radios_callback' ),
            'badged_settings',
            'badged_style_section'
        );
        
        register_setting(
            'badged_settings',
            'badged_settings'
        );
    }
    
    public function badged_style_settings_callback() {
            echo '<p></p>';
    }
    
    public function badged_style_settings_radios_callback() {

        $options = get_option( 'badged_settings' );
        
        $html = '<p class="radio-row">';
        $html .= '<input type="radio" id="style_ios7" name="badged_settings[style]" value="ios7"' . checked( 'ios7', $options['style'], false ) . '/>';
        $html .= '&nbsp;';
        $html .= '<label for="style_ios7">iOS 7</label>';
        $html .= '</p>';
        $html .= '<p class="radio-row">';
        $html .= '<input type="radio" id="style_ios6" name="badged_settings[style]" value="ios6"' . checked( 'ios6', $options['style'], false ) . '/>';
        $html .= '&nbsp;';
        $html .= '<label for="style_ios6">iOS 6</label>';
        $html .= '</p>';
        
        echo $html;

    }

}