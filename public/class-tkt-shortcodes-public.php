<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks to
 * enqueue the public-facing stylesheet and JavaScript.
 * As you add hooks and methods, update this description.
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Public {

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
	 * The meta type to retrieve of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $meta_type    The meta type of the object to retrieve.
	 */
	private $meta_type;

	/**
	 * Wether simple debug is enabled.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $debug    boolean wether the Simple Debug mode is active (visible on front end).
	 */
	private $debug;

	/**
	 * Wether backtrace debug is enabled.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $debug    boolean wether the Debug Log of backrace is enabled.
	 */
	private $log_debug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name      The name of the plugin.
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_prefix, $version ) {

		$this->plugin_name      = $plugin_name;
		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->meta_type        = 'post';
		$this->debug            = false;
		$this->log_debug        = false;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tkt-shortcodes-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-shortcodes-public.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Bloginfo ShortCode.
	 *
	 * Return all properties of the get_bloginfo() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function bloginfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'show'      => 'name',
				'filter'    => 'raw',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			$atts[ $key ] = $this->sanitize( 'text_field', $value );
		}

		// Get our data.
		$out = get_bloginfo( $atts['show'], $atts['filter'] );

		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Data ShortCode.
	 *
	 * Return all properties of the get_post() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function postinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_the_ID(),
				'show'      => 'post_title',
				'filter'    => 'raw',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_post( $atts['item'], OBJECT, $atts['filter'] );

		// Validate our data.
		if ( $this->has_errors( $out ) ) {
			$out = $this->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->get_validated_object_property( $out, $atts['show'] );
		}

		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * User Data ShortCode.
	 *
	 * Return all properties of the get_post() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function userinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_current_user_id(),
				'field'     => 'ID',
				'value'     => '',
				'show'      => 'display_name', // Note: ONLY If called with the "id" or "name" parameter, the constructor queries the wp_users table. If successful, the additional row data become properties of the object: user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name, spam (multisite only), deleted (multisite only).
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitize( 'intval', $value );
			} elseif ( 'field' === $key ) {
				if ( 'ID' === $value || 'id' === $value ) {
					$atts['value'] = $this->sanitize( 'intval', $atts['value'] );
				} elseif ( 'email' === $value ) {
					$atts['value'] = $this->sanitize( $value, $atts['value'] );
				}
			} else {
				$atts[ $key ] = $this->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$value = ! empty( $atts['value'] ) ? $atts['value'] : $atts['item'];
		$out = get_user_by( $atts['field'], $value );

		if ( $this->has_errors( $out ) ) {
			$out = $this->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->get_validated_object_property( $out->data, $atts['show'] );
		}
		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Term Data ShortCode.
	 *
	 * Return all properties of the get_term() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function terminfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_queried_object_id(),
				'taxonomy'  => '',
				'show'      => 'name',
				'filter'    => 'raw',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_term( $atts['item'], $atts['taxonomy'], OBJECT, $atts['filter'] );

		if ( $this->has_errors( $out ) ) {
			$out = $this->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->get_validated_object_property( $out, $atts['show'] );
		}

		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Term Data ShortCode.
	 *
	 * Return all properties of the get_the_terms() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function post_termsinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_the_ID(),
				'taxonomy'  => 'category',
				'show'      => 'term_id',
				'delimiter' => ', ',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitize( 'intval', $value );
			} elseif ( 'delimiter' === $key ) {
				$atts['delimiter'] = wp_kses( $atts['delimiter'], 'post' );
			} else {
				$atts[ $key ] = $this->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_the_terms( $atts['item'], $atts['taxonomy'] );

		if ( $this->has_errors( $out ) ) {
			$out = $this->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = join( $atts['delimiter'], wp_list_pluck( $out, $atts['show'] ) );
		}

		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Meta Data ShortCode.
	 *
	 * Return all properties of the get_post_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function postmeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_the_ID(),
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitize( 'intval', $value );
			} elseif ( 'single' === $key ) {
				$atts['single'] = $this->sanitize( 'is_bool', $value );
			} elseif ( 'key' === $key ) {
				$atts['key'] = $this->sanitize( 'key', $value );
			} elseif ( 'delimiter' === $key ) {
				$atts['delimiter'] = wp_kses( $atts['delimiter'], 'post' );
			} else {
				$atts[ $key ] = $this->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		if ( 'term' === $this->meta_type ) {
			$out = get_term_meta( $atts['item'], $atts['key'], $atts['single'] );
		} elseif ( 'user' === $this->meta_type ) {
			$out = get_user_meta( $atts['item'], $atts['key'], $atts['single'] );
		} else {
			$out = get_post_meta( $atts['item'], $atts['key'], $atts['single'] );
		}

		if ( $this->has_errors( $out ) ) {
			$out = $this->get_errors( $out, __METHOD__, debug_backtrace() );
		} elseif ( ! is_array( $out ) ) {
			$out = $this->sanitize( 'meta', $out, $atts['key'], 'post', '' );
		} else {
			$out = $this->sanitize( 'meta', implode( $atts['delimiter'], $out ), $atts['key'], 'post', '' );
		}

		// Sanitize our data.
		$out = $this->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Term Meta Data ShortCode.
	 *
	 * Return all properties of the get_post_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function termmeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_queried_object_id(),
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		$this->meta_type = 'term';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';
		return $out;

	}

	/**
	 * User Meta Data ShortCode.
	 *
	 * Return all properties of the get_post_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function usermeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => get_current_user_id(),
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		$this->meta_type = 'user';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';

		// Return our data.
		return $out;

	}

	/**
	 * All Sanitization possibilities
	 *
	 * @since 1.0.0
	 * @param string $type The type of sanitization to apply.
	 * @param mixed  $value The value to sanitize.
	 * @param string $item  The meta key of the field to sanitize.
	 * @param string $object_type The object type of the meta to sanitize.
	 * @param string $object_subtype The object subtype of the meta to sanitize.
	 * @return mixed $value sanitized value.
	 */
	private function sanitize( $type, $value, $item = '', $object_type = '', $object_subtype = '' ) {

		switch ( $type ) {
			case 'email':
				$value = sanitize_email( $value );
				break;

			case 'file_name':
				$value = sanitize_file_name( $value );
				break;

			case 'html_class':
				$value = sanitize_html_class( $value );
				break;

			case 'key':
				$value = sanitize_key( $value );
				break;

			case 'meta':
				$value = sanitize_meta( $item, $value, $object_type, $object_subtype );
				break;

			case 'mime_type':
				$value = sanitize_mime_type( $value );
				break;

			case 'option':
				$value = sanitize_option( $value );
				break;

			case 'sql_orderby':
				$value = sanitize_sql_orderby( $value );
				break;

			case 'text_field':
				$value = sanitize_text_field( $value );
				break;

			case 'title':
				$value = sanitize_title( $value );
				break;

			case 'title_for_query':
				$value = sanitize_title_for_query( $value );
				break;

			case 'title_with_dashes':
				$value = sanitize_title_with_dashes( $value );
				break;

			case 'user':
				$value = sanitize_user( $value );
				break;

			case 'url_raw':
				$value = esc_url_raw( $value );
				break;

			case 'post_kses':
				$value = wp_filter_post_kses( $value );
				break;

			case 'nohtml_kses':
				$value = wp_filter_nohtml_kses( $value );
				break;

			case 'intval':
				$value = intval( $value );
				break;

			case 'is_bool':
				$value = is_bool( $value );
				break;

			default:
				$value = sanitize_text_field( $value );
				break;
		}

		return $value;

	}

	/**
	 * Validate Object, then Validated requested property.
	 *
	 * @since 1.0.0
	 * @param mixed  $value The value to validate.
	 * @param string $prop The property to validate and return.
	 * @return mixed $out validated property value (NOT Sanitized).
	 */
	private function get_validated_object_property( $value, $prop ) {

		$out = $value;

		if ( ! is_object( $out ) || is_null( $out ) ) {

			$out = 'It is not an object';

			return $out;

		} elseif ( is_object( $out ) && ! property_exists( $out, $prop ) ) {

			$out = 'This Object Property is not set';

			return $out;

		} else {
			return $out->$prop;
		}

	}

	/**
	 * Check if result has errors.
	 *
	 * @since 1.0.0
	 * @param mixed $result The value to check.
	 * @return bool true if has errors, false if not.
	 */
	private function has_errors( $result ) {

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
	private function get_errors( $result, $location, $backtrace ) {

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
