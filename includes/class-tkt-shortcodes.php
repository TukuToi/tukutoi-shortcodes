<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/includes
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tkt_Shortcodes_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	protected $plugin_prefix;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'TKT_SHORTCODES_VERSION' ) ) {

			$this->version = TKT_SHORTCODES_VERSION;

		} else {

			$this->version = '1.0.0';

		}

		$this->plugin_name = 'tkt-shortcodes';
		$this->plugin_prefix = 'tkt_scs_';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tkt_Shortcodes_Loader. Orchestrates the hooks of the plugin.
	 * - Tkt_Shortcodes_i18n. Defines internationalization functionality.
	 * - Tkt_Shortcodes_Declarations. Declares all ShortCode and Data names => labels.
	 * - Tkt_Shortcodes_Sanitizer. Maintains all Sanitization, Validation and Error handling.
	 * - Tkt_Shortcodes_Admin. Defines all hooks for the admin area.
	 * - Tkt_Shortcodes_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tkt-shortcodes-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tkt-shortcodes-i18n.php';

		/**
		 * The class responsible for declaring all ShortCodes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tkt-shortcodes-declarations.php';

		/**
		 * The class responsible for Sanitizing and Validating inputs.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tkt-shortcodes-sanitizer.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tkt-shortcodes-admin.php';

		/**
		 * The class responsible for registering all ShortCode definitions.
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tkt-shortcodes-public.php';

		/**
		 * The class responsible to load all common code
		 */
		if ( ! defined( 'TKT_COMMON_LOADED' ) ) {
			require_once( plugin_dir_path( dirname( __FILE__ ) ) . '/common/class-tkt-common.php' );
		}

		$this->common = Tkt_Common::get_instance();
		$this->loader = new Tkt_Shortcodes_Loader();
		$this->declarations = new Tkt_Shortcodes_Declarations( $this->plugin_prefix, $this->version );

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tkt_Shortcodes_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Tkt_Shortcodes_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		if ( is_admin()
			&& ( current_user_can( 'manage_options' )
				|| current_user_can( 'manage_network_options' )
			)
			&& ! is_customize_preview()
		) {

			/**
			 * The class responsible for creating the ShortCodes GUI.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tkt-shortcodes-gui.php';

			$plugin_admin = new Tkt_Shortcodes_Admin( $this->plugin_name, $this->plugin_prefix, $this->version, $this->declarations );

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

			$this->loader->add_action( 'media_buttons', $plugin_admin, 'insert_shortcodes_menu' );

			$this->loader->add_action( 'wp_ajax_tkt_scs_get_shortcode_form', $plugin_admin, 'tkt_scs_get_shortcode_form' );

		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		if ( ! is_admin()
			&& ! is_customize_preview()
			|| ( is_admin()
				&& wp_doing_ajax()
				&& ! is_customize_preview()
			)
		) {

			/**
			 * The class responsible for processing ShortCodes in ShortCodes or attributes.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tkt-shortcodes-shortcodes.php';

			$plugin_public = new Tkt_Shortcodes_Public( $this->plugin_name, $this->plugin_prefix, $this->version, $this->declarations );

			$shortcodes = new Tkt_Shortcodes_Shortcodes( $this->plugin_prefix, $this->version, $this->declarations );

			//$processor = new Tkt_Shortcodes_Processor( $this->plugin_prefix, $this->version, $this->declarations );

			// $this->loader->add_filter( 'the_content', $processor, 'pre_process_shortcodes', 5 );
			// $this->loader->add_filter( 'tkt_post_process_shortcodes', $processor, 'post_process_shortcodes' );

			foreach ( $this->declarations->shortcodes as $shortcode => $label ) {

				$callback = $shortcode;
				if ( method_exists( $shortcodes, $callback ) ) {
					$this->loader->add_shortcode( $this->get_plugin_prefix() . $shortcode, $shortcodes, $callback );
				}
			}
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The unique prefix of the plugin used to uniquely prefix technical functions.
	 *
	 * @since     1.0.0
	 * @return    string    The prefix of the plugin.
	 */
	public function get_plugin_prefix() {
		return $this->plugin_prefix;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tkt_Shortcodes_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
