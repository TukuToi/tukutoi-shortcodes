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

		wp_enqueue_style( 'tkt-jquery-ui', plugin_dir_url( __FILE__ ) . 'css/tkt-jquery-ui.min.css', array( 'wp-jquery-ui-dialog' ), $this->version, 'screen' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tkt-shortcodes-admin.css', array( 'tkt-jquery-ui' ), $this->version, 'screen' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix The current admin page.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-shortcodes-admin.js', array( 'jquery-ui-dialog', 'jquery-ui-autocomplete' ), $this->version, true );
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

		}

		if ( ! isset( $_GET['shortcode'] ) ) {

			wp_send_json_error( 'No ShortCode chosen.' );

		}

		$shortcode = sanitize_title( wp_unslash( $_GET['shortcode'] ) );

		$form = new Tkt_Shortcodes_Gui( $this->plugin_prefix, $this->version, $shortcode, $this->declarations );

		$response = array(
			'form' => $form->get_shortcode_gui(),
		);

		wp_send_json_success( $response );

	}

	/**
	 * Add a Insert ShortCodes menu.
	 *
	 * @since    1.0.0
	 * @param int $editor_id The Editor ID.
	 */
	public function insert_shortcodes_menu( $editor_id ) {

		printf( '<button id="tkt-shortcodes-dialog-trigger" class="button"><span><svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1008.52 835.08" style="margin-top: 4px;margin-bottom: -4px;"><path fill="#2e7ba5" d="M1800.48,797.83Q1685.31,683,1570.31,568.06c-9.69-9.69-19-19.79-27.89-30.26C1385.26,352,1100.6,339.05,928.62,511.43c-94.12,94.34-134.82,209.23-121.35,342,9.92,97.68,50.77,181.69,120.65,250.32,87.31,85.75,193.25,126.3,315.91,120.67,102.35-4.69,191.18-42.88,265.63-112.87,26.71-25.1,50.16-53.61,76-79.65q107.16-107.84,215.16-214.84c2.86-2.84,6.6-4.81,12.63-9.1C1806.87,802.93,1803.36,800.7,1800.48,797.83ZM1165.29,1052.3c-113.09-27.12-191.44-125.58-193.76-242.73-2.21-111.42,77.09-214.53,187.27-243.2,112-29.15,218.38,22.64,268.84,99.6l-142.16,141.7,142.86,142.19C1381.17,1024.15,1276.15,1078.88,1165.29,1052.3Zm381.14-171.21c-40.56.18-74.45-33.65-74.41-74.3a74.38,74.38,0,0,1,74.43-74.07c40.86.09,74.06,33.66,73.83,74.64C1620.05,847.6,1586.68,880.91,1546.43,881.09Z" transform="translate(-804.76 -389.88)"></path><path d="M1540.45,772.44c-18.93.47-34.43,16.22-34.47,35a35.14,35.14,0,0,0,35.41,35,35,35,0,1,0-.94-70.06Z" transform="translate(-804.76 -389.88)" fill="#2e7ba5"></path></svg></span>' . esc_html__( 'TukuToi ShortCodes', 'tkt-shortcodes' ) . '</button>' );
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
				if ( 'internal' !== $group ) {
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
			}
			?>
		</div>
		<div id="tkt-shortcode-form"></div>
		<?php
	}

}
