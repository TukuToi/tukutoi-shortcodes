<?php
/**
 * The file that defines Sanitization and Validations of this plugin.
 *
 * Registers all possible sanitization and validation options.
 * Registers all possible sanitization and validation methods.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/includes
 */

/**
 * The ShortCode Sanitziation Class.
 *
 * This is used to sanitzie and validate input.
 *
 * It registers a list of sanitization otopns and theyr callbacks
 *
 * @since      1.0.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Sanitizer {

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
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $sanitization_options    All the sanitization options of the plugin.
	 */
	public $sanitization_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 */
	public function __construct( $plugin_prefix, $version ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->sanitization_options = $this->sanitize_options();
		$this->debug            = false;
		$this->debug_log        = false;

	}

	/**
	 * All Sanitization Options.
	 *
	 * @since 1.0.0
	 * @return mixed $value sanitized value.
	 */
	private function sanitize_options() {

		$sanitization_options = array(
			'none' => array(
				'label'     => __( 'No Sanitization', 'tkt-shortcodes' ),
			),
			'email' => array(
				'label'     => __( 'Sanitize Email', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_email',
			),
			'file_name' => array(
				'label'     => __( 'File Name', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_file_name',
			),
			'html_class' => array(
				'label'     => __( 'HTML Class', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_html_class',
			),
			'key' => array(
				'label'     => __( 'Key', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_key',
			),
			'meta' => array(
				'label'     => __( 'Meta', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_meta',
			),
			'mime_type' => array(
				'label'     => __( 'Mime Type', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_mime_type',
			),
			'option' => array(
				'label'     => __( 'Option', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_option',
			),
			'sql_orderby' => array(
				'label'     => __( 'SQL Orderby', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_sql_orderby',
			),
			'text_field' => array(
				'label'     => __( 'Text Field', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_text_field',
			),
			'textarea_field' => array(
				'label'     => __( 'Text Area', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_textarea_field',
			),
			'title' => array(
				'label'     => __( 'Title', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_title',
			),
			'title_for_query' => array(
				'label'     => __( 'Title for Query', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_title_for_query',
			),
			'title_with_dashes' => array(
				'label'     => __( 'Title with Dashes', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_title_with_dashes',
			),
			'user' => array(
				'label'     => __( 'User', 'tkt-shortcodes' ),
				'callback'  => 'sanitize_user',
			),
			'url_raw' => array(
				'label'     => __( 'URL Raw', 'tkt-shortcodes' ),
				'callback'  => 'esc_url_raw',
			),
			'post_kses' => array(
				'label'     => __( 'Post KSES', 'tkt-shortcodes' ),
				'callback'  => 'wp_filter_post_kses',
			),
			'nohtml_kses' => array(
				'label'     => __( 'NoHTML KSES', 'tkt-shortcodes' ),
				'callback'  => 'wp_filter_nohtml_kses',
			),
			'intval' => array(
				'label'     => __( 'Integer', 'tkt-shortcodes' ),
				'callback'  => 'intval',
			),
			'is_bool' => array(
				'label'     => __( 'Boolean', 'tkt-shortcodes' ),
				'callback'  => 'is_bool',
			),
		);

		return $sanitization_options;

	}

	/**
	 * All Sanitization Callabacks.
	 *
	 * @since 1.0.0
	 * @param string $type The type of sanitization to apply.
	 * @param array  $args The arguments to pass to the user function.
	 * @return mixed $value sanitized value.
	 */
	private function handle_sanitizer( $type = '', $args = array() ) {

		$value = '';

		if ( ! empty( $type )
			&& array_key_exists( $type, $this->sanitization_options )
			&& 'none' !== $type
			&& ! empty( $args )
		) {

			// Sanitization should happen, and exist.
			$value = call_user_func_array( $this->sanitization_options[ $type ]['callback'], $args );

		} elseif ( ! empty( $type )
			&& 'none' === $type
			&& ! empty( $args )
		) {

			// Sanitization is explicitly set to none, thus should not happen.
			$value = array_shift( $args );

		} elseif ( empty( $type ) ||
			( ! empty( $type )
				&& ! array_key_exists( $type, $this->sanitization_options )
			)
			&& ! empty( $args )
		) {

			// Either the sanitization argument is missing, invalid or malformed.
			// Be safe and escape as it could be user error or else.
			$value = call_user_func_array( $this->sanitization_options['text_field']['callback'], $args );

		} else {

			// Something went VERY wrong. Be safe.
			$value = '';

		}

		return $value;

	}

	/**
	 * Validate Object, then Validated requested property.
	 *
	 * @since 1.0.0
	 * @param mixed $value The value to validate.
	 * @return mixed $value validated object (Sanitized).
	 */
	private function handle_object_validation( $value ) {

		if ( ! is_object( $value )
			|| is_null( $value )
		) {

			return new WP_Error( 'no_object', __( 'This is not an object', 'tkt-shortcodes' ) );

		} elseif ( is_object( $value ) ) {

			return $value;

		} else {

			return new WP_Error( 'no_object', __( 'Something else went wrong', 'tkt-shortcodes' ) );

		}

	}

	/**
	 * Validate Object, then Validated requested property.
	 *
	 * @since 1.0.0
	 * @param mixed  $value The value to validate.
	 * @param string $prop The property to validate and return.
	 * @return mixed $value->$prop validated property value (NOT Sanitized).
	 */
	private function handle_object_prop_validation( $value, $prop ) {

		if ( ! is_wp_error( $this->handle_object_validation( $value ) )
			&& ! property_exists( $value, $prop )
		) {

			return new WP_Error( 'no_property', __( 'This property does not exist', 'tkt-shortcodes' ) );

		} elseif ( ! is_wp_error( $this->handle_object_validation( $value ) )
			&& property_exists( $value, $prop )
		) {

			return $value->$prop;

		} else {

			return new WP_Error( 'no_property', __( 'Something else went wrong', 'tkt-shortcodes' ) );

		}

	}

	/**
	 * All Sanitization Callabacks.
	 *
	 * @since 1.0.0
	 * @param string $type The type of sanitization to apply.
	 * @param mixed  $value The value to sanitize.
	 * @param string $item  The meta key of the field to sanitize.
	 * @param string $object_type The object type of the meta to sanitize.
	 * @param string $object_subtype The object subtype of the meta to sanitize.
	 * @return mixed $value sanitized value.
	 */
	public function sanitize( $type, $value, $item = '', $object_type = '', $object_subtype = '' ) {

		$args = func_get_args();
		$real_args = array_slice( $args, 1 );

		$value = $this->handle_sanitizer( $type, $real_args );

		return $value;

	}

	/**
	 * All Sanitization Callabacks.
	 *
	 * @since 1.0.0
	 * @param string $type The type of validation to apply.
	 * @param mixed  $value The value to validate.
	 * @param string $prop  The property or array key to validate.
	 * @return mixed $value validated value.
	 */
	public function validate( $type, $value, $prop = null ) {

		if ( 'object' === $type &&
			! empty( $value )
			&& is_null( $prop )
		) {

			$value = $this->handle_object_validation( $value );

		} elseif ( 'object' === $type
			&& ! empty( $value )
			&& ! is_null( $prop )
		) {

			$value = $this->handle_object_prop_validation( $value, $prop );

		} else {

			return;// We can add more validation calls here, like for array, etc.

		}

		return $value;

	}

	/**
	 * Check if result has errors.
	 *
	 * @since 1.0.0
	 * @param mixed $result The value to check.
	 * @return bool true if has errors, false if not.
	 */
	public function invalid_or_error( $result ) {

		if ( is_null( $result )
			|| is_wp_error( $result )
			|| false === $result
		) {
			return true;
		}

		return false;

	}

	/**
	 * Get errors if any.
	 *
	 * @since 1.0.0
	 * @param mixed  $result The value to get error of.
	 * @param string $location The method where the error happened.
	 * @param string $backtrace The Debug backtrace to the error.
	 * @return mixed $out validated property value (NOT Sanitized).
	 */
	public function get_errors( $result, $location, $backtrace ) {

		$errors = array();

		if ( is_null( $result ) ) {
			$errors['return'] = '';
			$errors['debug']  = 'The response was null in ' . $location;
		} elseif ( is_wp_error( $result ) ) {
			$errors['return'] = '';
			$errors['debug']  = 'The response was an instance of wp_error: ' . $result->get_error_message() . ' in ' . $location;
		} elseif ( false === $result ) {
			$errors['return'] = '';
			$errors['debug']  = 'There was a failure in response in ' . $location;
		} else {
			$errors = 'Unknown type of error occurred in' . $location;
		}

		if ( true === $this->debug ) {
			if ( true === $this->log_debug ) {
				error_log( $errors['debug'] . ' This is the full backlog: ' . print_r( $backtrace, true ) );
			}
			return $errors['debug'];
		}
		if ( true === $this->log_debug ) {
			error_log( $errors['debug'] . ' This is the full backlog: ' . print_r( $backtrace, true ) );
		}

		return $errors['return'];

	}

}
