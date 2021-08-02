<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the admin-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/admin
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_prefix    The string used to uniquely prefix technical functions of this plugin.
	 */
	private $plugin_prefix;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Configuration object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $declarations    All configurations and declarations of this plugin.
	 */
	private $declarations;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $plugin_prefix    The unique prefix of this plugin.
	 * @param      string $version    The version of this plugin.
	 * @param      array  $declarations    The Configuration object.
	 */
	public function __construct( $plugin_name, $plugin_prefix, $version, $declarations ) {

		$this->plugin_name   = $plugin_name;
		$this->plugin_prefix = $plugin_prefix;
		$this->version = $version;
		$this->declarations = $declarations;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_styles( $hook_suffix ) {

		wp_enqueue_style( $this->plugin_name . 'jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		// wp_enqueue_style( $this->plugin_name . 'jquery-ui-structure', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.structure.min.css', array( 'tkt_scs-jquery-ui' ), $this->version, 'all' );
		// wp_enqueue_style( $this->plugin_name . 'jquery-ui-theme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.min.css', array( 'tkt_scs-jquery-ui', 'tkt_scs_jquery-ui-structure' ), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tkt-shortcodes-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		// wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-shortcodes-admin.js', array( 'jquery-ui-dialog', 'jquery-ui-selectmenu' ), $this->version, true );
		wp_localize_script(
			$this->plugin_name,
			$this->plugin_prefix . 'ajax_object',
			array(
				'ajax_url'  => admin_url( 'admin-ajax.php' ),
				'security'  => wp_create_nonce( $this->plugin_name . '-security-nonce' ),
			)
		);

	}

	/**
	 * AJAX Callback to get the ShortCode form to insert.
	 *
	 * @since    1.0.0
	 */
	public function tkt_scs_get_shortcode_form() {

		if ( ! check_ajax_referer( $this->plugin_name . '-security-nonce', 'security', false ) ) {

			wp_send_json_error( 'Invalid security token sent.' );
			wp_die();

		}

		if ( ! isset( $_GET['shortcode'] ) ) {

			wp_send_json_error( 'No ShortCode chosen.' );
			wp_die();

		}

		$shortcode = sanitize_title( wp_unslash( $_GET['shortcode'] ) );

		$form = new Tkt_Shortcodes_Gui( $this->plugin_prefix, $this->version, $shortcode, $this->declarations );

		$response = array(
			'form' => $form->get_shortcode_gui(),
		);

		wp_send_json( $response );

		wp_die();

	}

	/**
	 * Add a Insert ShortCodes menu.
	 *
	 * @since    1.0.0
	 * @param int $editor_id The Editor ID.
	 */
	public function insert_shortcodes_menu( $editor_id ) {

		printf( '<button id="tkt-shortcodes-dialog-trigger" class="button">' . esc_html__( 'TukuToi ShortCodes', 'tkt-shortcodes' ) . '</button>' );
		$this->shortcodes_dialog();

	}

	/**
	 * The dialog to show all available ShortCodes.
	 *
	 * @since    1.0.0
	 */
	private function shortcodes_dialog() {

		$groups = $this->declarations->data_map( 'shortcode_types' );

		?>
		<div id="tkt-shortcodes-dialog" title="TukuToi ShortCodes">
			<?php
			foreach ( $groups as $group => $label ) {
				?>
			<div class="tkt-shortcodes-sub-section" title="<?php echo esc_attr( $label ); ?>">
				<h4><?php echo esc_html( $label ); ?></h4>
				<div class="tkt-sub-section-content">
					<?php
					foreach ( $this->declarations->shortcodes as $shortcode => $array ) {
						if ( $array['type'] === $group ) {
							echo '<a href="#" id="' . esc_attr( $shortcode ) . '" title="' . esc_attr( $array['label'] ) . '" class="button tkt-shortcode-buttons">' . esc_html( $array['label'] ) . '</a>';
						}
					}
					?>
				</div>
			</div>
				<?php
			}
			?>
		</div>
		<div id="tkt-shortcode-form"></div>
		<?php
	}

}
