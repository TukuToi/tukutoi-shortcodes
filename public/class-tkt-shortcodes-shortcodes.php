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
	 * The Configuration object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $declarations    All configurations and declarations of this plugin.
	 */
	private $declarations;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 * @param      string $declarations    The Configuration object.
	 */
	public function __construct( $plugin_prefix, $version, $declarations ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->meta_type        = 'post';
		$this->declarations     = $declarations;

		$this->sanitizer        = new Tkt_Shortcodes_Sanitizer( $this->plugin_prefix, $this->version, $this->declarations );

	}

	/**
	 * TukuToi `[bloginfo]` ShortCode.
	 *
	 * Sometimes you want to display information about your Website, such as Tagline, Site Name, RSS links.</br>
	 * The TukuToi `[bloginfo]` ShortCode allows you to display any information about your Website easily and safely.
	 *
	 * Example usage: `[bloginfo show="description" filter="display" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_bloginfo()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_bloginfo/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $show       What detail of the retrieved Bloginfo to show. Default: 'name'. Accepts: {@see Tkt_Shortcodes_Declarations::data_map()} -> $site_infos
	 *      @type string    $filter     What fiter to apply to the output. Default: 'raw'. Accepts: 'display'.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'bloginfo'.
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

		// Sanitize the User input atts.
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
	 * TukuToi `[postinfo]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary Post, such as Post Title, Name, Post Body or Post Status.</br>
	 * The TukuToi `[postinfo]` ShortCode allows you to display any information about any post easily and safely.
	 *
	 * Example usage: `[postinfo show="post_status" filter="display" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_post()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_post/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the Post to show information about. Default: ''. Accepts: '', Valid Post ID.
	 *      @type string    $show       What detail of the retrieved Post to show. Default: 'post_title'. Accepts: all public properties of the WP_Post Object, see {@see https://docs.classicpress.net/reference/classes/wp_post/}.
	 *      @type string    $filter     What fiter to apply to the output. Default: 'raw'. Accepts: 'raw', 'edit', 'db', or 'display'.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'postinfo'.
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

		// Default to current post if no value passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		// Sanitize the User input atts.
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

		// Get post body data if requested.
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
	 * TukuToi `[userinfo]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary User, such as User Name, Email, Description and else.</br>
	 * The TukuToi `[userinfo]` ShortCode allows you to display any information about any user easily and safely.
	 *
	 * Example usage: `[userinfo show="user_email" sanitize="email"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_user()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_user/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the User to show information about. Default: ''. Accepts: '', Valid User ID.
	 *      @type string    $field      The field to retrieve the user with. Default: 'ID'. Accepts: 'id', 'ID', 'slug', 'email', 'login'.
	 *      @type string    $value      The value of the field to retrieve the user with. Default: ''. Accepts: valid user ID, valid user slug, valid user email, valid user login name.
	 *      @type string    $show       What detail of the retrieved User to show. Default: 'display_name'. Accepts: all public properties of the WP_User Object <em>and</em> its data, see {@see https://docs.classicpress.net/reference/classes/wp_post/} and {@see Tkt_Shortcodes_Declarations::data_map()} -> $user_data.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'userinfo'.
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

		// Default to current User if no value passed to item and other than ID chosen.
		if ( empty( $atts['item'] ) &&
			( 'ID' === $atts['field']
			|| 'id' === $atts['field']
			)
		) {
			$atts['item'] = get_current_user_id();
		}

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} elseif ( 'field' === $key ) {
				if ( 'ID' === $value || 'id' === $value ) {
					$atts['value'] = $this->sanitizer->sanitize( 'intval', $atts['value'] );
				} elseif ( 'email' === $value ) {
					$atts['value'] = $this->sanitizer->sanitize( 'email', $atts['value'] );
				}
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$value = ! empty( $atts['value'] ) ? $atts['value'] : $atts['item'];
		$out = get_user_by( $atts['field'], $value );

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			/**
			 * The user object is a huge mess. Try to fix this as effectively as possible.
			 */
			// An array of nested User Values (object "data" inside object "wpUser").
			if ( in_array( $atts['show'], $this->declarations->data_map( 'user_data' ) ) ) {
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
	 * TukuToi `[terminfo]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary Term, such as Term Name, ID or Parent ID.</br>
	 * The TukuToi `[terminfo]` ShortCode allows you to display any information about any term easily and safely.
	 *
	 * Example usage: `[terminfo show="parent" sanitize="intval"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_term()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_term/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the Term to show information about. Default: ''. Accepts: '', Valid Term ID.
	 *      @type string    $taxonomy   The Taxonomy to which the term belongs. Default: ''. Accepts: valid taxonomy name.
	 *      @type string    $show       What detail of the retrieved Term to show. Default: 'name'. Accepts: all public properties of the WP_Term Object, see {@see https://docs.classicpress.net/reference/classes/wp_term/}.
	 *      @type string    $filter     What fiter to apply to the output. Default: 'raw'. Accepts: '', raw'.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'terminfo'.
	 */
	public function terminfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'          => '',
				'taxonomy'      => '',
				'show'          => 'name',
				'filter'        => 'raw',
				'sanitize'      => 'text_field',
			),
			$atts,
			$tag
		);

		// Default to Current Taxonomy Term if no value passed to item, and we are on an archive.
		if ( empty( $atts['item'] ) &&
			is_tax()
			|| is_tag()
			|| is_category()
		) {
			$atts['item'] = get_queried_object_id();
		} elseif ( empty( $atts['item'] ) ) {
			return esc_html__( 'This is not a Taxonomy Archive, and you specified no Taxonomy Term ID' );
		}

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// Get our data.
		$out = get_term( $atts['item'], $atts['taxonomy'], OBJECT, $atts['filter'] );

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = $this->sanitizer->validate( 'object', $out );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * TukuToi `[post_termsinfo]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary Post Terms, such as Term Name, ID or Parent ID.</br>
	 * The TukuToi `[post_termsinfo]` ShortCode allows you to display any information about any term easily and safely.
	 *
	 * Example usage: `[post_termsinfo show="name" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_the_terms()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_the_terms/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the Post to show Post Terms of. Default: ''. Accepts: '', Valid Post ID.
	 *      @type string    $taxonomy   The Taxonomy of which to get Post Terms of. Default: 'category'. Accepts: valid taxonomy name.
	 *      @type string    $show       What detail of the retrieved Terms to show. Default: 'term_id'. Accepts: all public properties of the WP_Term Object, see {@see https://docs.classicpress.net/reference/classes/wp_term/}.
	 *      @type string    $delimiter  How to separate the Terms Information to display, Defaul: ', '. Accepts: any valid string or HTML.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'post_termsinfo'.
	 */
	public function post_termsinfo( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'taxonomy'  => 'category',
				'delimiter' => ', ',
				'sanitize'  => 'text_field',
			),
			$atts,
			$tag
		);

		// Default to the current post if no value was passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		// Sanitize the User input atts.
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

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} else {
			$out = join( $atts['delimiter'], wp_list_pluck( $out, 'term_id' ) );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * TukuToi `[postmeta]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary Post Meta, such as a Custom Field.</br>
	 * The TukuToi `[postmeta]` ShortCode allows you to display any information about any Post Meta easily and safely.
	 *
	 * Example usage: `[postmeta show="my-awesome-custom-field" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_post_meta()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_post_meta/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the Post to show Post Meta of. Default: ''. Accepts: '', Valid Post ID.
	 *      @type string    $key        The Meta Key of which to get Post Meta of. Default: ''. Accepts: valid postmeta key.
	 *      @type string    $single     Wether to retrieve single or array Meta Data. Default: 'true'. Accepts: boolean.
	 *      @type string    $delimiter  How to separate the Post Meta data if retreived as Array. Default: ''. Accepts: any valid string or HTML.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'postmeta'.
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

		// Default to current post if no value was passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		// Sanitize the User input atts.
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

		/**
		 * Get our data
		 *
		 * We handle all three post, term and usermeta here.
		 *
		 * @see termmeta()
		 * @see usermeta()
		 */
		if ( 'term' === $this->meta_type ) {
			$out = get_term_meta( $atts['item'], $atts['key'], $atts['single'] );
		} elseif ( 'user' === $this->meta_type ) {
			$out = get_user_meta( $atts['item'], $atts['key'], $atts['single'] );
		} else {
			$out = get_post_meta( $atts['item'], $atts['key'], $atts['single'] );
		}

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		} elseif ( ! is_array( $out ) ) {
			// Validate single field values.
			$out = $this->sanitizer->sanitize( 'meta', $atts['key'], $out, $this->meta_type );
		} else {
			// Validate array field values.
			$out = $this->sanitizer->sanitize( 'meta', $atts['key'], implode( $atts['delimiter'], $out ), $this->meta_type );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		// Return our data.
		return $out;

	}

	/**
	 * TukuToi `[termmeta]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary Term Meta, such as a Custom Field.</br>
	 * The TukuToi `[termmeta]` ShortCode allows you to display any information about any Term Meta easily and safely.
	 *
	 * Example usage: `[termmeta show="my-awesome-custom-field" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_term_meta()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_term_meta/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the Term to show Term Meta of. Default: ''. Accepts: '', Valid Term ID.
	 *      @type string    $key        The Meta Key of which to get Term Meta of. Default: ''. Accepts: valid termmeta key.
	 *      @type string    $single     Wether to retrieve single or array Meta Data. Default: 'true'. Accepts: boolean.
	 *      @type string    $delimiter  How to separate the Term Meta data if retreived as Array. Default: ''. Accepts: any valid string or HTML.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'termmeta'.
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

		// Default to current Taxonomy Term if no value was passed to item and we are on an archive.
		if ( empty( $atts['item'] ) &&
			is_tax()
			|| is_tag()
			|| is_category()
		) {
			$atts['item'] = get_queried_object_id();
		} elseif ( empty( $atts['item'] ) ) {
			return esc_html__( 'This is not a Taxonomy Archive, and you specified no Taxonomy Term ID' );
		}

		/**
		 * Get our data.
		 *
		 * We sanitize and validate in postmeta().
		 *
		 * We set current meta_type to "term",
		 * telling postmeta() to get term data.
		 * The we set it back to default post.
		 *
		 * @see postmeta()
		 */
		$this->meta_type = 'term';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';

		return $out;

	}

	/**
	 * TukuToi `[usermeta]` ShortCode.
	 *
	 * Sometimes you want to display information about either the current or any arbitrary User Meta, such as a Custom Field.</br>
	 * The TukuToi `[usermeta]` ShortCode allows you to display any information about any User Meta easily and safely.
	 *
	 * Example usage: `[usermeta show="my-awesome-custom-field" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding function in ClassicPress is `get_user_meta()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_user_meta/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the User to show User Meta of. Default: ''. Accepts: '', Valid User ID.
	 *      @type string    $key        The Meta Key of which to get User Meta of. Default: ''. Accepts: valid usermeta key.
	 *      @type string    $single     Wether to retrieve single or array Meta Data. Default: 'true'. Accepts: boolean.
	 *      @type string    $delimiter  How to separate the User Meta data if retreived as Array. Default: ''. Accepts: any valid string or HTML.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'text_field'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'usermeta'.
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

		// Default to current user if no value was passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_current_user_id();
		}

		/**
		 * Get our data.
		 *
		 * We sanitize and validate in postmeta().
		 *
		 * We set current meta_type to "user",
		 * telling postmeta() to get term data.
		 * The we set it back to default post.
		 *
		 * @see postmeta()
		 */
		$this->meta_type = 'user';
		$out = $this->postmeta( $atts, $content = null, $tag );
		$this->meta_type = 'post';

		// Return our data.
		return $out;

	}

	/**
	 * TukuToi `[conditional]` ShortCode.
	 *
	 * Sometimes you want to display things conditionally, for example, only if the current Users's ID is equal to the Current Post Author's ID, or any other type of condition.
	 * The TukuToi `[conditional]` ShortCode allows you to conditionall show any information easily and safely.
	 *
	 * Example usage: `[conditional left="Any Value to Compare" right="Any Value to Compare With" else="Shows if the condition evaluates to false"]The Content that is conditionally Shown[/conditional]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $left       The value to compare in the conditional evaluation. Default: ''. Accepts: Any possible value.
	 *      @type string    $right      The value to compare with in the conditional evaluation. Default: ''. Accepts: Any possible value.
	 *      @type string    $operator   The comparison operator to use. Default: 'eqv'. Accepts: {@see Tkt_Shortcodes_Declarations::data_map()} -> $valid_comparison.
	 *      @type string    $float      Whether the compared values are Float Values. Default: ''. Accepts: '', 'float'.
	 *      @type string    $epsilon    The precision to use when comparing Float Values. Default: ''. Accepts: '', float value.
	 *      @type string    $else       The value to show if the evaluation returns false. Default: ''. Accepts: any valid string or HTML.
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Any  Valid string, HTML or ShortCode(s).
	 * @param string $tag       The Shortcode tag. Value: 'conditional'.
	 */
	public function conditional( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'left'      => '',
				'right'     => '',
				'operator'  => 'eqv',
				'float'     => '',
				'epsilon'   => '',
				'else'      => '',
			),
			$atts,
			$tag
		);

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'epsilon' === $key ) {
				$atts[ $key ] = $this->sanitizer->sanitize( 'floatval', $value );
			} else {
				if ( ! empty( $atts['float'] ) && ( 'left' === $key || 'right' === $key ) ) {
					$float_value_left = (float) $atts['left'];
					$atts['left'] = strval( $float_value_left ) == $atts['left'] ? floatval( $atts['left'] ) : $atts['left'];
					$float_value_right = (float) $atts['right'];
					$atts['right'] = strval( $float_value_right ) == $atts['right'] ? floatval( $atts['right'] ) : $atts['right'];
				} else {
					$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
				}
			}
		}

		/**
		 * Compare the values according operator.
		 *
		 * Supports float numbers
		 *
		 * $true is the condition result, which is set to false by default.
		 */
		$true = false;
		switch ( $atts['operator'] ) {
			case 'eqv':
				if ( is_float( $atts['left'] ) || is_float( $atts['right'] ) ) {

					if ( abs( $atts['left'] - $atts['right'] ) < $atts['epsilon'] ) {
						$true = true;
					}
				} else {
					if ( $atts['left'] == $atts['right'] ) {
						$true = true;
					}
				}
				break;
			case 'eqvt':
				if ( $atts['left'] === $atts['right'] ) {
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
			default:
				if ( $atts['left'] == $atts['right'] ) {
					$true = true;
				}
				break;
		}

		/**
		 * If condition passed, process the wrapped $content.
		 * We need to run the content thru ShortCodes Processor, otherwise ShortCodes are not expanded.
		 *
		 * We sanitize output directly here, so we can return later without sanitization.
		 * $atts['else'] IS already sanitized, see "Sanitize the User input atts."
		 *
		 * @since 1.5.0
		 * @todo pass user variable for sanitize option here.
		 */
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
	 * TukuToi `[math]` ShortCode.
	 *
	 * Sometimes you want to do calculations with values dynamically when displaying the values. For example, you might want to calculate the sum of one field with another field of a post.
	 * The TukuToi `[math]` ShortCode allows you to do mathematical operations easily and safely.
	 *
	 * Example usage: `[math operand_one="3" operand_two="5" operator="*" sanitize="intval"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $operand_one    The first operand of the calculation. Default: ''. Accepts: Any calculable value.
	 *      @type string    $operand_two    The second operand of the calculation. Default: ''. Accepts: Any calculable value.
	 *      @type string    $operator       The operator to use. Default: ''. Accepts: {@see Tkt_Shortcodes_Declarations::data_map()} -> $valid_operators.
	 *      @type string    $sanitize       The value to show if the evaluation returns false. Default: ''. Accepts: any valid string or HTML.
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'conditional'.
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

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'operator' === $key ) {
				$atts['operator'] = $this->sanitizer->sanitize( 'text_field', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'intval', $value );
			}
		}

		// Validate the operator.
		$operator = $this->sanitizer->validate( 'operation', $atts['operator'] );

		// Validate and Calculate our result.
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

	/**
	 * TukuToi `[editlinks]` ShortCode.
	 *
	 * Sometimes you want to display edit links to edit the current, or an arbitrary Post, Term or User.</br>
	 * The TukuToi `[editlinks]` ShortCode allows you to display any edit links easily and safely.
	 *
	 * Example usage: `[editlinks item="33" type="my-awesome-custom-post" filter="display" sanitize="url_raw"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding functions in ClassicPress are `get_edit_post_link()` and `get_edit_term_link()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_edit_post_link/
	 * @see https://docs.classicpress.net/reference/functions/get_edit_term_link/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the item to get the Edit Link of. Default: ''. Accepts: '', Valid item ID.
	 *      @type string    $type       The type of content to get the Edit Link of. Default: ''. Accepts: valid post, user or taxonomy type.
	 *      @type string    $object     Used when retrieving Term Edit Links. Default: ''. Accepts: '', valid post type.
	 *      @type string    $delimiter  How to separate the User Meta data if retreived as Array. Default: ''. Accepts: any valid string or HTML.
	 *      @type string    $filter     How to output the '&' character. Default: 'display'. Accepts: '', 'display'.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'url_raw'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'editlinks'.
	 */
	public function editlinks( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'type'      => '', // either post type name or taxonomy name.
				'object'    => '', // the post type for when linking to taxonomy edit screen.
				'delimiter' => '',
				'filter'    => '',
				'sanitize'  => 'url_raw',
			),
			$atts,
			$tag
		);

		// Default to current post if no value passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// If several Term IDs are passed ot item (post_termsinfo).
		if ( strpos( $atts['item'], ',' ) !== false ) {
			$atts['item'] = explode( ',', $atts['item'] );
		}

		// Get our data.
		if ( post_type_exists( $atts['type'] ) ) {
			$out = get_edit_post_link( $atts['item'], $atts['filter'] );
		} elseif ( taxonomy_exists( $atts['type'] ) && ! is_array( $atts['item'] ) ) {
			$out = get_edit_term_link( $atts['item'], $atts['type'], $atts['object'] );
		} elseif ( is_array( $atts['item'] ) ) {
			foreach ( $atts['item'] as $term_id ) {
				$out[] = get_edit_term_link( $term_id, $atts['type'], $atts['object'] );
			}
			$out = join( $atts['delimiter'], $out );

		}

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		return $out;

	}

	/**
	 * TukuToi `[archivelinks]` ShortCode.
	 *
	 * Sometimes you want to display links to the archives of the current, or an arbitrary Post, Term or User.</br>
	 * The TukuToi `[archivelinks]` ShortCode allows you to display any archive links easily and safely.
	 *
	 * Example usage: `[archivelinks type="my-awesome-custom-taxonomy" sanitize="url_raw"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding functions in ClassicPress are `get_post_type_archive_link()` and `get_term_link()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_post_type_archive_link/
	 * @see https://docs.classicpress.net/reference/functions/get_term_link/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the item to get the Archive Link of. Default: ''. Accepts: '', Valid item ID.
	 *      @type string    $type       Used for Term Archive Links. Takes the taxonomy name to get the Archive Link of. Default: ''. Accepts: valid taxonomy name.
	 *      @type string    $delimiter  How to separate the URls if retrieving several Term Links (of a post). Default: ''. Accepts: any valid string or HTML.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'url_raw'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'archivelinks'.
	 */
	public function archivelinks( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'type'      => '', // either post type name or taxonomy name.
				'delimiter' => '',
				'sanitize'  => 'esc_url_raw',
			),
			$atts,
			$tag
		);

		// Default to current post if no value passed to item.
		if ( empty( $atts['item'] ) ) {
			$atts['item'] = get_the_ID();
		}

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		// If several Term IDs are passed ot item (post_termsinfo).
		if ( strpos( $atts['item'], ',' ) !== false ) {
			$atts['item'] = explode( ',', $atts['item'] );
			// Sanitize.
			$atts['item'] = array_map( 'intval', $atts['item'] );
		}

		// Get our data.
		if ( post_type_exists( $atts['type'] ) ) {
			$out = get_post_type_archive_link( $atts['type'] );
		} elseif ( taxonomy_exists( $atts['type'] ) && ! is_array( $atts['item'] ) ) {
			$out = get_term_link( (int) $atts['item'], $atts['type'] );
		} elseif ( is_array( $atts['item'] ) ) {
			foreach ( $atts['item'] as $term_id ) {
				$out[] = get_term_link( (int) $term_id, $atts['type'] );
			}
			$out = join( $atts['delimiter'], $out );
		}

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		return $out;

	}

	/**
	 * TukuToi `[attachmentimage]` ShortCode.
	 *
	 * Sometimes you want to display either the Posts Thumbnail or any Image from your website.</br>
	 * The TukuToi `[attachmentimage]` ShortCode allows you to display any image links easily and safely.
	 *
	 * Example usage: `[attachmentimage size="thumbnail" sanitize="url_raw"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding functions in ClassicPress are `get_post_type_archive_link()` and `get_term_link()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_the_post_thumbnail_url/
	 * @see https://docs.classicpress.net/reference/functions/wp_get_attachment_image_url/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $item       ID of the item to get the data of. Defaults to Post ID, or if passed, the ID of an attachemnt can be used as well. Default: ''. Accepts: '', Valid item ID.
	 *      @type string    $url       The url of an attachment, if ID empty. Default: ''. Accepts: valid attachment URL.
	 *      @type string    $show       Wether to show featured Image or any other image data. Default: 'featured_image'. Accepts: 'featured_image', 'other'.
	 *      @type string    $width      Width in Pixels. Must be registered size width. Default: ''. Accepts: valid registered width in pixel.
	 *      @type string    $height     Height in Pixels. Must be registered size height. Default: ''. Accepts: valid registered height in pixel.
	 *      @type string    $size       Valid registered media size. Default: ''. Accpets: any valid registered image size.
	 *      @type string    $icon       Whether to treat image as icon. Default: ''. Accepts: '', 'icon'.
	 *      @type string    $sanitize   How to sanitize the output. Default: 'url_raw'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'attachmentimage'.
	 */
	public function attachmentimage( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'item'      => '',
				'url'       => '',
				'show'      => '',
				'width'     => '',
				'height'    => '',
				'size'      => '',
				'icon'      => '',
				'sanitize'  => 'esc_url_raw',
			),
			$atts,
			$tag
		);

		/**
		 * We do not default to current item
		 * even if the item attr might be empty.
		 *
		 * This because we might want data from an URL.
		 */

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'item' === $key && ! empty( $atts['item'] ) ) {
				$atts['item'] = $this->sanitizer->sanitize( 'intval', $value );
			} elseif ( 'url' === $key ) {
				$atts[ $key ] = $this->sanitizer->sanitize( 'esc_url_raw', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'text_field', $value );
			}
		}

		/**
		 * Get our data.
		 *
		 * We first check if we have an URL and
		 * get the ID of the attachment by that URL.
		 *
		 * Then we check if sizes are provided and build those.
		 *
		 * Later either get thumbnail URL or attachment URL with
		 * dimensions attached.
		 *
		 * NOTE:
		 * at first it might seem redundant to get attachment URL if we
		 * already have attachment URL in the item attr, but dont forget
		 * we do not have size, and those are user configurated...
		 */
		if ( empty( $atts['item'] ) && ! empty( $atts['url'] ) ) {
			// We want ID from URL.
			$atts['item'] = attachment_url_to_postid( $atts['url'] );
		}
		if ( empty( $atts['size'] ) ) {
			$atts['size'] = array(
				$atts['width'],
				$atts['height'],
			);
		}
		if ( 'featured_image' === $atts['show'] ) {
			$out = get_the_post_thumbnail_url( $atts['item'], $atts['size'] );
		} else {
			$out = wp_get_attachment_image_url( $atts['item'], $atts['size'], $atts['icon'] );
		}

		// Validate our data.
		if ( $this->sanitizer->invalid_or_error( $out ) ) {
			$out = $this->sanitizer->get_errors( $out, __METHOD__, debug_backtrace() );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		return $out;

	}

	/**
	 * TukuToi `[round]` ShortCode.
	 *
	 * Sometimes you want to round up or down any floating value.</br>
	 * The TukuToi `[round]` ShortCode allows you to round any float value easily and safely into any direction and towards either odd or even.
	 *
	 * Example usage: `[round round="12.3927366478" dir="" sanitize="text_field"]`</br>
	 * For possible attributes see the Parameters > $atts section below or use the TukuToi ShortCodes GUI.
	 *
	 * The corresponding functions in ClassicPress are `get_post_type_archive_link()` and `get_term_link()`.
	 *
	 * @see https://docs.classicpress.net/reference/functions/get_the_post_thumbnail_url/
	 * @see https://docs.classicpress.net/reference/functions/wp_get_attachment_image_url/
	 *
	 * @since    1.0.0
	 * @param array  $atts {
	 *      The ShortCode Attributes.
	 *
	 *      @type string    $round      The float value to round. Default: ''. Accepts: Valid float value.
	 *      @type string    $dir        A valid PHP Round Constant, see {@see Tkt_Shortcodes_Declarations::data_map()} -> $valid_round_constants
	 *      @type string    $sanitize   How to sanitize the output. Default: 'url_raw'. Accepts: {@see Tkt_Shortcodes_Declarations::sanitize_options()}
	 * }
	 * @param mixed  $content   ShortCode enclosed content. Not applicable in this ShortCode.
	 * @param string $tag       The Shortcode tag. Value: 'round'.
	 */
	public function round( $atts, $content = null, $tag ) {

		$atts = shortcode_atts(
			array(
				'round'     => '',
				'dir'       => '',
				'sanitize'  => '',
			),
			$atts,
			$tag
		);

		// Sanitize the User input atts.
		foreach ( $atts as $key => $value ) {
			if ( 'sanitize' === $key ) {
				$atts['sanitize'] = $this->sanitizer->sanitize( 'text_field', $value );
			} else {
				$atts[ $key ] = $this->sanitizer->sanitize( 'intval', $value );
			}
		}

		// Get our data.
		if ( ! is_numeric( $content ) ) {
			$out = 'You are trying to round non-numeric values!';
		} else {
			$out = round( $content, $atts['round'], $atts['dir'] );
		}

		// Sanitize our data.
		$out = $this->sanitizer->sanitize( $atts['sanitize'], $out );

		return $out;

	}

}
