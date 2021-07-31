<?php
/**
 * The ShortCodes of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 */

/**
 * Defines all ShortCodes.
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Shortcodes {

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
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 */
	public function __construct( $plugin_prefix, $version ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->meta_type        = 'post';
		$this->debug            = false;
		$this->log_debug        = false;

		$this->sanitizer        = new Tkt_Shortcodes_Sanitizer( $this->plugin_prefix, $this->version );

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
			$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
		}

		// Get our data.
		if ( 'is_rtl' === $atts['show'] ) {

			/**
			 * Coding with WordPress is like untangling a ball of wool after a 3 years old had it in hands.
			 *
			 * @since 1.5.0
			 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
			 * @see https://docs.classicpress.net/reference/functions/is_rtl/
			 */
			$out = is_rtl() ? 'rtl' : 'ltr';

		} else {

			$out = get_bloginfo( $atts['show'], $atts['filter'] );

		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Data ShortCode.
	 *
	 * Return all properties of the get_post() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_post/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function postinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'show'      => 'post_title',
				'filter'    => 'raw',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_post( $atts['item'], OBJECT, $atts['filter'] );

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->sanitizer->validate( 'object', $out, $atts['show'] );
		}

		// Get our data.
		if ( 'post_content' === $atts['show'] ) {

			/**
			 * We need to run the content thru ShortCodes Processor, otherwise ShortCodes are not expanded.
			 *
			 * @since 1.5.0
			 */
			$out = apply_filters( $this->plugin_prefix . 'pre_process_shortcodes', $out );
			$out = do_shortcode( $out, false );

		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * User Data ShortCode.
	 *
	 * Return all properties of the get_user() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_user/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function userinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'field'     => 'ID',
				'value'     => '',
				'show'      => 'display_name',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) &&
			( 'ID' === $atts['field']
			|| 'id' === $atts['field']
			)
		) {
			$atts['item'] = get_current_user_id();
		}

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} elseif ( 'field' === $key ) {
				if ( 'ID' === $value || 'id' === $value ) {
					$atts['value'] = $this->sanitizer->sanitize( 'intval', $atts['value'] );
				} elseif ( 'email' === $value ) {
					$atts['value'] = $this->sanitizer->sanitize( $value, $atts['value'] );
				}
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$value = ! empty( $atts['value'] ) ? $atts['value'] : $atts['item'];
		$out = get_user_by( $atts['field'], $value );

		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			/**
			 * The user object is a huge mess. Try to fix this as effectively as possible.
			 */
			// An array of nested User Values (object "data" inside object "wpUser").
			$declarations = new Tkt_Shortcodes_Declarations( $this->plugin_prefix, $this->version );
			if ( in_array( $atts['show'], $declarations->data_map( 'user_data' ) ) ) {
				// This is the nested data object.
				$out = $this->sanitizer->validate( 'object', $out->data, $atts['show'] );
			} elseif ( 'caps' === $atts['show'] ) {
				// This is an array of [cap] => (bool) true or false.
				$out = implode( ', ', array_keys( $this->sanitizer->validate( 'array', $out->caps ), 1 ) );
			} elseif ( 'roles' === $atts['show'] ) {
				// This is an array of [key] => (string) role.
				$out = implode( ', ', $this->sanitizer->validate( 'array', $out->roles ) );
			} elseif ( 'allcaps' === $atts['show'] ) {
				// This is an array of [allcaps] => (bool) true or false.
				$out = implode( ', ', array_keys( $this->sanitizer->validate( 'array', $out->allcaps ), 1 ) );
			} else {
				// Else, it is a string property of object.
				$out = $out->{'$atts["show"]'};
			}
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Term Data ShortCode.
	 *
	 * Return all properties of the get_term() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_term/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function terminfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'taxonomy'  => '',
				'show'      => 'name',
				'filter'    => 'raw',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) &&
			is_tax()
			|| is_tag()
			|| is_category()
		) {
			$atts['item'] = get_queried_object_id();
		} elseif ( empty( $atts['item'] ) ) {
			return esc_html__( 'This is not a Taxonomy Archive, and you specified no Taxonomy Term ID' );
		}

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_term( $atts['item'], $atts['taxonomy'], OBJECT, $atts['filter'] );

		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->sanitizer->validate( 'object', $out, $atts['show'] );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Term Data ShortCode.
	 *
	 * Return all properties of the get_the_terms() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_the_terms/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function post_termsinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'taxonomy'  => 'category',
				'show'      => 'term_id',
				'delimiter' => ', ',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} elseif ( 'delimiter' === $key ) {
				$atts['delimiter'] = wp_kses( $atts['delimiter'], 'post' );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_the_terms( $atts['item'], $atts['taxonomy'] );

		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = join( $atts['delimiter'], wp_list_pluck( $out, $atts['show'] ) );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Post Meta Data ShortCode.
	 *
	 * Return all properties of the get_post_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_post_meta/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function postmeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} elseif ( 'single' === $key ) {
				$atts['single'] = $this->sanitizer->sanitize( 'is_bool', $value );
			} elseif ( 'key' === $key ) {
				$atts['key'] = $this->sanitizer->sanitize( 'key', $value );
			} elseif ( 'delimiter' === $key ) {
				$atts['delimiter'] = wp_kses( $atts['delimiter'], 'post' );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
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

		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} elseif ( ! is_array( $out ) ) {
			$out = $this->sanitizer->sanitize( 'meta', $atts['key'], $out, $this->meta_type );
		} else {
			$out = $this->sanitizer->sanitize( 'meta', $atts['key'], implode( $atts['delimiter'], $out ), $this->meta_type );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * Term Meta Data ShortCode.
	 *
	 * Return all properties of the get_term_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_term_meta/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function termmeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) &&
			is_tax()
			|| is_tag()
			|| is_category()
		) {
			$atts['item'] = get_queried_object_id();
		} elseif ( empty( $atts['item'] ) ) {
			return esc_html__( 'This is not a Taxonomy Archive, and you specified no Taxonomy Term ID' );
		}

		$this->meta_type = 'term';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';

		return $out;

	}

	/**
	 * User Meta Data ShortCode.
	 *
	 * Return all properties of the get_user_meta() function.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_user_meta/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function usermeta( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'key'       => '',
				'single'    => true,
				'delimiter' => '',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_current_user_id();
		}

		$this->meta_type = 'user';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';

		// Return our data.
		return $out;

	}

	/**
	 * Conditional ShortCode
	 *
	 * Return all contents only if conditions met.
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function conditional( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'left'      => '',
				'right'     => '',
				'operator'  => 'eq',
				'else'      => '',
			),
			$atts,
			$tag
		);

		foreach ( $atts as $key => $value ) {

			$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );

		}

		$true = false;

		switch ( $atts['operator'] ) {
			case 'eqv':
				if ( $atts['left'] == $atts['right'] ) {
					$true = true;
				}
				break;
			case 'eqvt':
				if ( $atts['left'] === $atts['right'] ) {
					$true = true;
				}
				break;
			case 'lt':
				if ( $atts['left'] < $atts['right'] ) {
					$true = true;
				}
				break;
			case 'gt':
				if ( $atts['left'] > $atts['right'] ) {
					$true = true;
				}
				break;
			case 'gte':
				if ( $atts['left'] >= $atts['right'] ) {
					$true = true;
				}
				break;
			case 'lte':
				if ( $atts['left'] <= $atts['right'] ) {
					$true = true;
				}
				break;
			case 'nev':
				if ( $atts['left'] != $atts['right'] ) {
					$true = true;
				}
				break;
			case 'nevt':
				if ( $atts['left'] !== $atts['right'] ) {
					$true = true;
				}
				break;
			default:
				if ( $atts['left'] == $atts['right'] ) {
					$true = true;
				}
				break;
		}

		if ( true === $true ) {
			$content = apply_filters( $this->plugin_prefix . 'pre_process_shortcodes', $content );
			$content = do_shortcode( $content, false );
			$content = $this->sanitizer->sanitize( 'post_kses', $content );
		} else {
			$content = $atts['else'];
		}

		// Return our data.
		return $content;

	}

	/**
	 * Calculation ShortCode
	 *
	 * Return mathematically calculated contents.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_user_meta/
	 *
	 * @since    1.0.0
	 * @param    array  $atts    ShortCode Attributes.
	 * @param    mixed  $content ShortCode enclosed content.
	 * @param    string $tag    The Shortcode tag.
	 */
	public function math( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'operand_one'   => '',
				'operand_two'   => '',
				'operator'      => '',
				'sanitize'      => 'intval',
			),
			$atts,
			$tag
		);

		// Sanitize the attributes.
		foreach ( $atts as $key => $value ) {
			if ( 'operator' === $key ) {
				$atts['operator'] = $this->sanitizer->sanitize( 'text_field', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'intval', $value );
			}
		}

		// Validate the operator.
		$operator = $this->sanitizer->validate( 'operation', $atts['operator'] );

		// Calculate our result.
		if ( ! $this->sanitizer->invalid_or_error( $operator ) ) {
			switch ( $operator ) {
				case '+':
					$out = $atts['operand_one'] + $atts['operand_two'];
					break;
				case '-':
					$out = $atts['operand_one'] - $atts['operand_two'];
					break;
				case '/':
					$out = $atts['operand_one'] / $atts['operand_two'];
					break;
				case '*':
					$out = $atts['operand_one'] * $atts['operand_two'];
					break;
				case '**':
					$out = $atts['operand_one'] ** $atts['operand_two'];
					break;
				case 'mod':
					$out = $atts['operand_one'] % $atts['operand_two'];
					break;
				case 'sqrt':
					$out = pow( $atts['operand_one'], ( 1 / $atts['operand_two'] ) );
					break;
				case '%':
					$out = ( $atts['operand_two'] / 100 ) * $atts['operand_one'];
					break;
				case '‰':
					$out = ( $atts['operand_two'] / 1000 ) * $atts['operand_one'];
					break;
			}
		} else {
			$out = '0'; // Invalid operands give 0.
		}

		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

}
