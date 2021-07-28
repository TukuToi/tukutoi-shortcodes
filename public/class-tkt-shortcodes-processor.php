<?php
/**
 * The file that defines some Helper Methods of this plugin
 *
 * Defines a magic to resolve inner ShortCodes and allow custom shortcodes
 * to be used in HTML attributes, or ShortCode attributes.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 */

/**
 * The ShortCode Helper Class.
 *
 * This is used to make shortcodes nested in ShortCode attributes, or HTML attributes work
 *
 * It also defines an error array for ShortCode render failure
 * and a validation method for objects used in ShortCodes.
 *
 * @since      1.0.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Processor {

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

	}

	/**
	 * Register an array of Shortcodes of this plugin
	 *
	 * Key is ShortCode name and method name, Value is label/name of shortcode
	 *
	 * @since 1.0.0
	 * @return array @shortcodes The ShortCodes array.
	 */
	public function register_shortcodes() {

		$shortcodes = array(
			'bloginfo'          => 'Website Information',
			'postinfo'          => 'Post Data',
			'userinfo'          => 'User Data',
			'terminfo'          => 'Term Data',
			'post_termsinfo'    => 'Post Term Data',
			'usermeta'          => 'User Meta Data',
			'termmeta'          => 'Term Meta Data',
			'postmeta'          => 'Post Meta Data',
		);

		return $shortcodes;

	}

	/**
	 * Public facing filter callback on the_content.
	 *
	 * @since    1.0.0
	 * @param    string $content  The Post Content.
	 */
	public function pre_process_shortcodes( $content ) {

		// No need to proceed if empty.
		if ( empty( $content ) ) {
			return $content;
		}

		$contet = $this->apply_resolver( $content );

		return $contet;

	}

	/**
	 * Provate facing callback on the_content pre_process_shortcodes filter.
	 *
	 * @since    1.0.0
	 * @param    string $content  The Post Content.
	 */
	private function apply_resolver( $content ) {

		// This is separated because maybe we will need more resolver in future.
		$content = $this->resolve_shortcodes( $content );

		return $content;

	}

	/**
	 * Resolve internal shortcodes.
	 *
	 * @param string $content The Post Content.
	 * @return string
	 * @since 3.3.0
	 */
	private function resolve_shortcodes( $content ) {

		// Search for outer shortcodes, to process their inner expressions.
		$outer_shortcodes = array();
		$counts = $this->find_outer_brackets( $content, $outer_shortcodes );

		// Iterate shortcode elements and resolve their internal shortcodes, one by one.
		if ( 0 < $counts ) {

			$inner_expressions = $this->get_inner_expressions();

			foreach ( $outer_shortcodes as $outer_shortcode ) {

				foreach ( $inner_expressions as $inner_expression ) {

					$inner_counts = preg_match_all( $inner_expression, $outer_shortcode, $inner_shortcodes );

					// Replace all inner shortcodes.
					if ( 0 < $inner_counts ) {

						foreach ( $inner_shortcodes[0] as $inner_shortcode ) {

							$resolved_shortcode = do_shortcode( $inner_shortcode );

							// Minimum sanitization possible.
							$resolved_shortcode = str_replace( '"', '&quot;', $resolved_shortcode );
							$resolved_shortcode = str_replace( "'", '&#039;', $resolved_shortcode );

							// Replace the nested ShortCodes so WP/CP does not strip them off.
							$content = str_replace( $inner_shortcode, $resolved_shortcode, $content );

						}
					}
				}
			}
		}

		return $content;
	}

	/**
	 * Find shortcodes that contain other shortcodes as attribute values,
	 * and populate a list of their opening tag, to process those internal shortcodes.
	 *
	 * @param string $content The content to check.
	 * @param array  $matches List of shortcodes: full shortcode without brackets.
	 * @return int Number of top level shortcodes found.
	 * @since 3.3.0
	 */
	private function find_outer_brackets( $content, &$matches ) {
		$count = 0;

		$first = strpos( $content, '[' );
		if ( false !== $first ) {
			$length = strlen( $content );
			$brace_count = 0;
			$brace_start = -1;
			for ( $i = $first; $i < $length; $i++ ) {
				if ( '[' === $content[ $i ] ) {
					if ( 0 === $brace_count ) {
						$brace_start = $i + 1;
					}
					$brace_count++;
				}
				if ( ']' === $content[ $i ] ) {
					if ( $brace_count > 0 ) {
						$brace_count--;
						if ( 0 === $brace_count ) {
							$inner_content = substr( $content, $brace_start, $i - $brace_start );
							if (
								! empty( $inner_content )
								&& $this->has_shortcode_as_attribute_value( $inner_content )
								&& $this->is_unbracketed_shortcode( $inner_content )
							) {
								$matches[] = $inner_content;
								$count++;
							}
						}
					}
				}
			}
		}

		return $count;
	}

	/**
	 * Get the inner ShortCodes
	 *
	 * Also get a list of custom registered ShortCodes.
	 *
	 * @since 1.0.0
	 * @return array $inner_expressions An array of nested shortcodes.
	 */
	private function get_inner_expressions() {

		$inner_expressions = array();

		$shortcodes_regex = $this->get_inner_shortcodes_regex();
		$inner_expressions[] = '/\\[(' . $shortcodes_regex . ').*?\\]/i';

		$custom_shortcodes = $this->get_custom_shortcodes();
		if ( count( $custom_shortcodes ) > 0 ) {
			foreach ( $custom_shortcodes as $custom_inner_shortcode ) {
				$inner_expressions[] = '/\\[' . $custom_inner_shortcode . '.*?\\].*?\\[\\/' . $custom_inner_shortcode . '\\]/i';
			}
			$inner_expressions[] = '/\\[(' . implode( '|', $custom_shortcodes ) . ').*?\\]/i';
		}

		return $inner_expressions;
	}

	/**
	 * Get a list of regex compatible expressions to catch.
	 *
	 * @return array
	 * @since 3.3.0
	 */
	public function get_inner_shortcodes_regex() {

		$regex = '';

		foreach ( $this->register_shortcodes() as $shortcode => $name ) {
			$regex .= $shortcode . '|';
		}

		return $regex;

	}

	/**
	 * Make sure that a given content is indeed a shortcode without brackets:
	 * - Can not start with a closing tag delimiter.
	 * - Can not start with a bracket for another inner shortcode.
	 * - Must start with a valid shortcode tag.
	 *
	 * @since 1.0.0
	 * @param string $unbracketed_shortcode The content to check.
	 * @return bool
	 */
	private function is_unbracketed_shortcode( $unbracketed_shortcode ) {
		// Is this a closing shortcode perhaps?
		if ( 0 === strpos( $unbracketed_shortcode, '/' ) ) {
			return false;
		}

		// Is this a doube brackets structure perhaps?
		if ( 0 === strpos( $unbracketed_shortcode, '[' ) ) {
			return false;
		}

		$shortcode_pieces = explode( ' ', $unbracketed_shortcode );

		// Does this start with a valid shortcode tag?
		return (
			isset( $shortcode_pieces[0] )
			&& ! empty( $shortcode_pieces[0] )
			&& shortcode_exists( $shortcode_pieces[0] )
		);
	}

	/**
	 * Make sure that a content which presumes to be a shortcode without brackets
	 * does contain an inner shortcode.
	 *
	 * @param string $unbracketed_shortcode The content to check.
	 * @return bool
	 */
	private function has_shortcode_as_attribute_value( $unbracketed_shortcode ) {
		$has_inner_shortcode = strpos( $unbracketed_shortcode, '[' );

		return ( false !== $has_inner_shortcode );
	}

	/**
	 * Get the list of registered shortcodes to be used inside other shortcodes.
	 *
	 * @return array
	 * @since 3.3.0
	 */
	public function get_custom_shortcodes() {
		$custom_shortcodes = array();

		/**
		 * Filter the list of custom shortcodes that can be used inside other shortcodes or as HTML attribute values.
		 *
		 * @param array $custom_shortcodes List of shortcodes.
		 * @return array
		 * @since 1.0.0
		 */
		$custom_shortcodes = apply_filters( $this->plugin_prefix . 'custom_shortcodes', $custom_shortcodes );

		return array_unique( $custom_shortcodes );
	}

}
