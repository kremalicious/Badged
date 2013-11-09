<?php
/**
 * Badged
 *
 * @package   Badged
 * @author    Matthias Kretschmann <m@kretschmann.io>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2013 Matthias Kretschmann
 */

/**
 * Plugin class.
 *
 *
 * @package Badged_Admin
 * @author  Matthias Kretschmann <m@kretschmann.io>
 */
class Badged_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since   2.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since   2.0.0
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since   2.0.0
	 */
	private function __construct() {
        
		$plugin = Badged::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
        
		// Load admin style sheet
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
        
        // register settings, nicely isolated
        if ( ! empty ( $GLOBALS['pagenow'] )
            and ( 'options-general.php' === $GLOBALS['pagenow']
                or 'options.php' === $GLOBALS['pagenow']
            )
        ) {
            add_action( 'admin_init', array( $this, 'initialize_badged_settings' ) );
        }
        
		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
        
		/*
		 * Do Custom Stuff
		 *
		 */

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since   2.0.0
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
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since   2.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
            return;
        }

		$screen = get_current_screen();
        if ( $screen->id == $this->plugin_screen_hook_suffix ) {
            wp_enqueue_style( $this->plugin_slug .'-admin-styles', BADGED_URL . 'admin/assets/css/admin.css', array(), Badged::VERSION );
        }
		
        $options = get_option( 'badged_settings' );
        
        // Default Style
        if ( 'ios7' == $options['style'] ) {
            wp_enqueue_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged.css', array(), Badged::VERSION );
        }
        
        // Old Style
        if ( 'ios6' == $options['style'] ) {
            wp_enqueue_style( $this->plugin_slug .'-badged-styles', BADGED_URL . 'admin/assets/css/badged-ios6.css', array(), Badged::VERSION );
        }

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 * @since   2.0.0
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
	 * @since   2.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}
    
	/**
	 * Set default options
	 * @since   2.0.0
	 */
    public function badged_default_settings() {
        
        $defaults = array(
            'style' => 'ios7'    
        );
    
        return apply_filters( 'badged_default_settings', $defaults );
        
    }
    
	/**
	 * Register settings
	 * @since   2.0.0
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
            __( 'Badged Style', 'badged' ),
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
        
        $html .= '<p>';
        $html = '<input type="radio" id="style_ios7" name="badged_settings[style]" value="ios7"' . checked( 'ios7', $options['style'], false ) . '/>';
        $html .= '&nbsp;';
        $html .= '<label for="style_ios7">iOS 7</label>';
        $html .= '</p>';
        $html .= '<p>';
        $html .= '<input type="radio" id="style_ios6" name="badged_settings[style]" value="ios6"' . checked( 'ios6', $options['style'], false ) . '/>';
        $html .= '&nbsp;';
        $html .= '<label for="style_ios6">iOS 6</label>';
        $html .= '</p>';
        
        echo $html;

    }

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    2.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}
    
	/**
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since   2.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

}