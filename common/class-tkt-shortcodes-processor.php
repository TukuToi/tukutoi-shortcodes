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
	 * @param    array  $declarations    The Configuration object.
	 */
	public function __construct( $plugin_prefix, $version, $declarations ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->declarations     = $declarations;
		$this->shortcode_start  = '{tkt_shortcode{';
		$this->shortcode_end    = '}tkt_shortcode}';

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

		$content = $this->apply_encoder( $content );

		return $content;

	}

	/**
	 * Public facing filter callback on the_content.
	 *
	 * @since    1.3.0
	 * @param    string $content  The Post Content.
	 */
	public function post_process_shortcodes( $content ) {

		// No need to proceed if empty.
		if ( empty( $content ) ) {
			return $content;
		}

		$content = $this->apply_decoder( $content );

		return $content;

	}

	/**
	 * Encoders passed to the pre_process_shortcodes callback.
	 *
	 * @since    1.3.0
	 * @param    string $content  The Post Content.
	 */
	private function apply_encoder( $content ) {

		// This is separated because maybe we will need more resolver in future.
		$content = $this->encode_inner_shortcodes( $content );
		$content = $this->encode_html_attribute_shortcodes( $content );

		return $content;

	}

	/**
	 * Decoders passed to the post_process_shortcodes callback.
	 *
	 * @since    1.3.0
	 * @param    string $content  The Post Content.
	 */
	private function apply_decoder( $content ) {

		// This is separated because maybe we will need more resolver in future.
		$content = $this->decode_shortcodes( $content );

		return $content;

	}

	private function decode_shortcodes( $content ) {

		$shortcodes = $this->get_all_encoded_matches( $content, $this->shortcode_start, $this->shortcode_end );
		foreach ( $shortcodes as $key => $shortcode ) {
			$executed = do_shortcode( '[' . $shortcode . ']' );
			$content = str_replace( $this->shortcode_start . $shortcode . $this->shortcode_end, $executed, $content );
		}

		return $content;
	}


	public function get_all_encoded_matches( $str, $start, $end ) {

		$contents = array();
		$start_l = strlen( $start );
		$end_l = strlen( $end );

		$start_match = $match_start = $match_end = 0;
		while ( false !== ( $match_start = strpos( $str, $start, $start_match ) ) ) {
			$match_start += $start_l;
			$match_end = strpos( $str, $end, $match_start );
			if ( false === $match_end ) {
				break;
			}
			$contents[] = substr( $str, $match_start, $match_end - $match_start );
			$start_match = $match_end + $end_l;
		}

		return $contents;
	}

	private function encode_html_attribute_shortcodes( $content ) {
		// Normalize entities.
		$trans = array(
			'&#91;' => '&#091;', // Encoded [.
			'&#93;' => '&#093;', // Encoded ].
		);
		$content = strtr( $content, $trans );

		$textarr = $this->html_split( $content );
		$inner_expressions = $this->get_inner_html_expressions();

		foreach ( $textarr as &$element ) {

			if ( $this->should_skip_html_node( $element ) ) {
				continue;
			}

			// Look for every valid shortcode inside the node, and expand it.
			foreach ( $inner_expressions as $shortcode ) {
				$counts = preg_match_all( $shortcode['regex'], $element, $matches );
				if ( $counts > 0 ) {
					foreach ( $matches[0] as $index => &$match ) {

						$string_to_replace = $match;

						$replacement = str_replace( '[', $this->shortcode_start, $match );
						$replacement = str_replace( ']', $this->shortcode_end, $replacement );

						$element = str_replace( $string_to_replace, $replacement, $element );

					}
				}
			}
		}

		$content = implode( '', $textarr );

		return $content;
	}

	/**
	 *
	 */
	private function should_skip_html_node( $element ) {
		if (
			'' === $element
			|| '<' !== $element[0]
		) {
			// This element is not an HTML tag.
			return true;
		}

		$noopen = false === strpos( $element, '[' );
		$noclose = false === strpos( $element, ']' );
		if (
			$noopen
			|| $noclose
		) {
			// This element does not contain shortcodes.
			return true;
		}

		if (
			'<!--' === substr( $element, 0, 4 )
			|| '<![CDATA[' === substr( $element, 0, 9 )
		) {
			// This element is a comment or a CDATA piece.
			return true;
		}

		return false;
	}

	/**
	 * Separate HTML elements and comments from the text.
	 *
	 * Heavily inspired in wp_html_split.
	 *
	 * @param string $input The text which has to be formatted.
	 * @return array The formatted text.
	 * @since 3.3.0
	 */
	private function html_split( $input ) {
		$comments =
				'!'           // Start of comment, after the <.
			. '(?:'         // Unroll the loop: Consume everything until --> is found.
				. '-(?!->)' // Dash not followed by end of comment.
				. '[^\-]*+' // Consume non-dashes.
			. ')*+'         // Loop possessively.
			. '(?:-->)?';   // End of comment. If not found, match all input.

		$cdata =
				'!\[CDATA\['  // Start of comment, after the <.
			. '[^\]]*+'     // Consume non-].
			. '(?:'         // Unroll the loop: Consume everything until ]]> is found.
				. '](?!]>)' // One ] not followed by end of comment.
				. '[^\]]*+' // Consume non-].
			. ')*+'         // Loop possessively.
			. '(?:]]>)?';   // End of comment. If not found, match all input.

		$regex =
				'/('              // Capture the entire match.
				. '<'           // Find start of element.
				. '(?(?=!--)'   // Is this a comment?
					. $comments // Find end of comment.
				. '|'
					. '(?(?=!\[CDATA\[)' // Is this a comment?
						. $cdata // Find end of comment.
					. '|'
						. '[^>]*>?' // Find end of element. If not found, match all input.
					. ')'
				. ')'
			. ')/s';

		return preg_split( $regex, $input, -1, PREG_SPLIT_DELIM_CAPTURE );
	}

	private function get_inner_html_expressions() {
		$inner_expressions = array();

		$views_shortcodes_regex = $this->get_inner_shortcodes_regex();
		$inner_expressions[] = array(
			'regex' => '/\\[(' . $views_shortcodes_regex . ').*?\\]/i',
			'has_content' => false,
		);

		$custom_inner_shortcodes = $this->get_custom_shortcodes();
		if ( count( $custom_inner_shortcodes ) > 0 ) {
			foreach ( $custom_inner_shortcodes as $custom_inner_shortcode ) {
				$inner_expressions[] = array(
					'regex' => '/\\[' . $custom_inner_shortcode . '.*?\\](.*?)\\[\\/' . $custom_inner_shortcode . '\\]/is',
					'has_content' => true,
				);
			}
			$inner_expressions[] = array(
				'regex' => '/\\[(' . implode( '|', $custom_inner_shortcodes ) . ').*?\\]/i',
				'has_content' => false,
			);
		}

		return $inner_expressions;
	}

	/**
	 * Resolve internal shortcodes.
	 *
	 * @since 1.3.0
	 * @param string $content The Post Content.
	 * @return string
	 */
	private function encode_inner_shortcodes( $content ) {

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

						foreach ( $inner_shortcodes[0] as &$inner_shortcode ) {

							// Minimum sanitization possible.
							$replacement = str_replace( '[', $this->shortcode_start, $inner_shortcode );
							$replacement = str_replace( ']', $this->shortcode_end, $replacement );

							// Replace the nested ShortCodes so WP/CP does not strip them off.
							$content = str_replace( $inner_shortcode, $replacement, $content );
							// $outer_shortcode = str_replace( $inner_shortcode, $resolved_shortcode, $outer_shortcode );

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
		$regex = 'tkt_scs_searchtemplate|tkt_scs_selectsearch|'
			. 'tkt_scs_buttons|'
			. 'tkt_scs_loop|'
			. 'tkt_scs_attachmentimage|'
			. 'tkt_scs_postinfo|'
			. 'the_post_id|'
			. 'the_post|';
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
