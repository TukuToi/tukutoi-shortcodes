<?php
/**
 * The file that defines the ShortCode processor.
 *
 * Defines logic to resolve inner ShortCodes and allow custom shortcodes
 * to be used in HTML attributes, or ShortCode attributes.
 *
 * [Toolset Views](https://toolset.com/) by [OTGS](https://onthegosystems.com/)
 * was used as a loose inspiration for some of the code in this class.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 */

/**
 * The ShortCode Resolver Class.
 *
 * This is used to make shortcodes nested in ShortCode attributes,
 * or HTML attributes work.
 * WordPress 4.2.3 (thus also CP) breaks all ShortCodes in ShortCode attributes,
 * or ShortCodes in HTML attributes.
 *
 * @see https://wptavern.com/plugin-developers-demand-a-better-security-release-process-after-wordpress-4-2-3-breaks-thousands-of-websites
 *
 * This class attempts to fix that.
 *
 * @since      1.3.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/public
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Processor {

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
	 * @since    1.3.0
	 * @param    string $plugin_prefix    The unique prefix of this plugin.
	 * @param    string $version          The version of this plugin.
	 * @param    array $declarations    The Configuration object.
	 */
	public function __construct( $plugin_prefix, $version, $declarations ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->declarations 	= $declarations;

	}

	/**
	 * Public facing filter callback on the_content.
	 *
	 * @since    1.3.0
	 * @param    string $content  The Post Content.
	 */
	public function pre_process_shortcodes( $content ) {

		// No need to proceed if empty.
		if ( empty( $content ) ) {
			return $content;
		}

		$contet = $this->apply_resolver( $content );

		return $content;

	}

	/**
	 * Resolvers passed to the pre_process_shortcodes callback.
	 *
	 * @since    1.3.0
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
	 * @since 1.3.0
	 * @param string $content The Post Content.
	 * @return string
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
	 * @since 1.3.0
	 * @param string $content The content to check.
	 * @param array  $matches List of shortcodes: full shortcode without brackets.
	 * @return int Number of top level shortcodes found.
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
	 * @since 1.3.0
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
	 * @since 1.3.0
	 * @return array
	 */
	public function get_inner_shortcodes_regex() {

		$regex = '';

		foreach ( $this->declarations->shortcodes as $shortcode => $name ) {
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
	 * @since 1.3.0
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
	 * @since 1.3.0
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
	 * @since 1.3.0
	 * @return array
	 */
	public function get_custom_shortcodes() {
		$custom_shortcodes = array();

		/**
		 * Filter the list of custom shortcodes that can be used inside other shortcodes or as HTML attribute values.
		 *
		 * @param array $custom_shortcodes List of shortcodes.
		 * @return array
		 * @since 1.3.0
		 */
		$custom_shortcodes = apply_filters( $this->plugin_prefix . 'custom_shortcodes', $custom_shortcodes );

		return array_unique( $custom_shortcodes );
	}

}
