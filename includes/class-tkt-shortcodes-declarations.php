<?php
/**
 * The Declarations File of this Plugin.
 *
 * Registers an array of ShortCodes with localised labels,
 * as well maintains a list of arrays containing object properties and array members
 * which are used allover this plugin, and a list of all sanitization options, plus their callbacks.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Includes
 * @author     Beda Schmid <beda@tukutoi.com>
 */

/**
 * The Declarations Class.
 *
 * This is used both in public and admin when we need an instance of all shortcodes,
 * or a centrally managed list of object properties or array members where we cannot already
 * get it from the code (such as user object, which is a entangled mess, or get_bloginfo which is a case switcher).
 *
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Includes
 * @author     Beda Schmid <beda@tukutoi.com>
 */
class Tkt_Shortcodes_Declarations {

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
	 * The ShortCodes of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $shortcodes    All ShortCode tags, methods and labels of this plugin.
	 */
	public $shortcodes;

	/**
	 * The Sanitization options and callbacks.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $sanitization_options    All Sanitization Options of this plugin and their callbacks.
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

		$this->plugin_prefix        = $plugin_prefix;
		$this->version              = $version;
		$this->shortcodes           = $this->declare_shortcodes();
		$this->sanitization_options = $this->sanitize_options();

	}

	/**
	 * Register an array of Shortcodes of this plugin
	 *
	 * Multidimensional array keyed by ShortCode tagname,
	 * each holding an array of ShortCode data:
	 * - Label
	 * - Type
	 *
	 * @since 1.0.0
	 * @return array $shortcodes The ShortCodes array.
	 */
	private function declare_shortcodes() {

		$shortcodes = array(
			'bloginfo'        => array(
				'label' => esc_html__( 'Website Information', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'postinfo'        => array(
				'label' => esc_html__( 'Post Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'userinfo'        => array(
				'label' => esc_html__( 'User Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'terminfo'        => array(
				'label' => esc_html__( 'Term Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'post_termsinfo'  => array(
				'label' => esc_html__( 'Post Term Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'usermeta'        => array(
				'label' => esc_html__( 'User Meta Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'termmeta'        => array(
				'label' => esc_html__( 'Term Meta Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'postmeta'        => array(
				'label' => esc_html__( 'Post Meta Data', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'conditional'     => array(
				'label' => esc_html__( 'Conditional ShortCode', 'tkt-shortcodes' ),
				'type'  => 'operational',
				'inner' => false,
			),
			'math'            => array(
				'label' => esc_html__( 'Mathematical Operation', 'tkt-shortcodes' ),
				'type'  => 'operational',
				'inner' => true,
			),
			'editlinks'       => array(
				'label' => esc_html__( 'Edit Links', 'tkt-shortcodes' ),
				'type'  => 'managerial',
				'inner' => true,
			),
			'archivelinks'    => array(
				'label' => esc_html__( 'Archive Links', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'attachmentimage' => array(
				'label' => esc_html__( 'Images', 'tkt-shortcodes' ),
				'type'  => 'informational',
				'inner' => true,
			),
			'round'           => array(
				'label' => esc_html__( 'Round Floating Values', 'tkt-shortcodes' ),
				'type'  => 'operational',
				'inner' => true,
			),
		);

		/**
		 * Allow External ShortCodes to be added to the TukuToi ShortCodes GUI.
		 *
		 * Other plugins or users can add ShortCodes to the TukuToi ShortCodes GUI.
		 * They will then be displaying inside the TukuToi ShortCodes GUI Dialogue.
		 * It is up to the third party to provide valid Forms for those ShortCodes and source code.
		 *
		 * Note: Translations can not be done in this plugin because there litereally could be any string
		 * passed as the ShortCode label. Instead, 118n has to be done when adding the Shortcode using this filter,
		 * on the "external" side.
		 *
		 * @since 1.12.2
		 * @param array $external_shortcodes {
		 *      The array of new shortcodes keyed by their tagname. Default value array().
		 *
		 *     @type array  $tagname    {
		 *          ShortCode Data.
		 *
		 *          @type   string  $label  The ShortCode Label (Used for GUI Buttons).
		 *          @type   string  $type   The ShortCode Type. Accepts 'informational', 'operational', 'managerial'.
		 *     }
		 * }
		 */
		$external_shortcodes = apply_filters( 'tkt_scs_register_shortcode', $external_shortcodes = array() );

		/**
		 * Validate the external ShortCodes
		 */
		if ( ! empty( $external_shortcodes && is_array( $external_shortcodes ) ) ) {
			// We have some possibly valid external shortcode.
			if ( empty( array_intersect_key( $external_shortcodes, $shortcodes ) ) ) {
				// The ShortCode Tag is not already registered.
				// Sanitize and validate because we do not trust the input.
				foreach ( $external_shortcodes as $tag => $array ) {
					$tag = sanitize_text_field( $tag );
					foreach ( $array as $key => $value ) {
						$key           = sanitize_text_field( $key );
						$value         = sanitize_text_field( $value );
						$array[ $key ] = $value;
					}
					$external_shortcodes[ $tag ] = $array;
				}
				// We have possibly still invalid input but at least safe.
				$shortcodes = array_merge( $shortcodes, $external_shortcodes );
			}
		}

		return $shortcodes;

	}

	/**
	 * Register an array of object properties, array members to re-use as configurations.
	 *
	 * Adds Array Maps for:
	 * - 'site_infos':              Members and corresponding GUI labels of get_bloginfo.
	 * - 'user_data':               Keys of WP_User object property "data".
	 * - 'valid_operators':         Members represent valid math operatiors and their GUI label.
	 * - 'valid_comparison':        Members represent valid comparison operators and their GUI label.
	 * - 'valid_round_constants':   Members represent valid PHP round() directions and their GUI label.
	 * - 'shortcode_types':         Members represent valid ShortCode Types.
	 *
	 * @since 1.0.0
	 * @param string $map the data map to retrieve. Accepts: 'site_infos', 'user_data', 'valid_operators', 'valid_comparison', 'valid_round_constants', 'shortcode_types'.
	 * @return array $$map The Array Map requested.
	 */
	public function data_map( $map ) {

		$site_infos = array(
			'name'                 => esc_html__( 'Website Name', 'tkt-shortcodes' ),
			'url'                  => esc_html__( 'Home URL', 'tkt-shortcodes' ),
			'wpurl'                => esc_html__( 'Site URL', 'tkt-shortcodes' ),
			'description'          => esc_html__( 'Site Tagline', 'tkt-shortcodes' ),
			'rdf_url'              => esc_html__( 'RDF Feed URL', 'tkt-shortcodes' ),
			'rss_url'              => esc_html__( 'RSS Feed URL', 'tkt-shortcodes' ),
			'rss2_url'             => esc_html__( 'RSS2 Feed URL', 'tkt-shortcodes' ),
			'atom_url'             => esc_html__( 'Atom Feed URL', 'tkt-shortcodes' ),
			'comments_atom_url'    => esc_html__( 'Atom Comments Feed URL', 'tkt-shortcodes' ),
			'comments_rss2_url'    => esc_html__( 'RSS2 Comments Feed URL', 'tkt-shortcodes' ),
			'pingback_url'         => esc_html__( 'Pingback URL', 'tkt-shortcodes' ),
			'stylesheet_url'       => esc_html__( 'Theme Stylesheet URL', 'tkt-shortcodes' ),
			'stylesheet_directory' => esc_html__( 'Theme Stylesheet Directory', 'tkt-shortcodes' ),
			'template_url'         => esc_html__( 'Template Directory URL', 'tkt-shortcodes' ),
			'admin_email'          => esc_html__( 'Site Admin Email', 'tkt-shortcodes' ),
			'charset'              => esc_html__( 'Site Charset', 'tkt-shortcodes' ),
			'html_type'            => esc_html__( 'HTML Type', 'tkt-shortcodes' ),
			'version'              => esc_html__( 'ClassicPress Version', 'tkt-shortcodes' ),
			'language'             => esc_html__( 'Site Language', 'tkt-shortcodes' ),
			'is_rtl'               => esc_html__( 'Text Direction', 'tkt-shortcodes' ),
		);

		$user_data = array(
			'ID',
			'user_login',
			'user_pass',
			'user_nicename',
			'user_email',
			'user_url',
			'user_registered',
			'user_activation_key',
			'user_status',
			'display_name',
		);

		/**
		 * Valid Math Operators.
		 *
		 * Note, we consciously choose % for percentage, even if the actual code will use % for modulo.
		 *
		 * @see https://en.wikipedia.org/wiki/Modulo_operation
		 * @see https://en.wikipedia.org/wiki/Percentage
		 * @see https://www.php.net/manual/en/language.operators.arithmetic.php
		 */
		$valid_operators = array(
			'+'    => esc_html__( 'Plus', 'tkt-shortcodes' ),
			'-'    => esc_html__( 'Minus', 'tkt-shortcodes' ),
			'*'    => esc_html__( 'Times', 'tkt-shortcodes' ),
			'/'    => esc_html__( 'Divided', 'tkt-shortcodes' ),
			'**'   => esc_html__( 'Exponentiation', 'tkt-shortcodes' ),
			'mod'  => esc_html__( 'Modulo (weirdest stuff ever)', 'tkt-shortcodes' ),
			'sqrt' => esc_html__( '√ (nth Root)', 'tkt-shortcodes' ),
			'%'    => esc_html__( '% (Percent)', 'tkt-shortcodes' ),
			'‰'    => esc_html__( '‰ (Permille)', 'tkt-shortcodes' ),
		);

		/**
		 * Valid Comparisons
		 *
		 * @since 1.2.5.0 Added fx operator (Custom PHP Function).
		 */
		$valid_comparison = array(
			'eqv'  => esc_html__( 'Equal', 'tkt-shortcodes' ),
			'eqvt' => esc_html__( 'Identical', 'tkt-shortcodes' ),
			'nev'  => esc_html__( 'Not equal', 'tkt-shortcodes' ),
			'nevt' => esc_html__( 'Not identical', 'tkt-shortcodes' ),
			'lt'   => esc_html__( 'Lesss than', 'tkt-shortcodes' ),
			'gt'   => esc_html__( 'Greater than', 'tkt-shortcodes' ),
			'gte'  => esc_html__( 'Less than or equal to', 'tkt-shortcodes' ),
			'lte'  => esc_html__( 'Greater than or equal to', 'tkt-shortcodes' ),
			'fx'   => esc_html__( 'Custom PHP Function', 'tkt-shortcodes' ),
		);

		$valid_round_constants = array(
			'PHP_ROUND_HALF_UP'   => esc_html__( 'Round half up', 'tkt-shortcodes' ),
			'PHP_ROUND_HALF_DOWN' => esc_html__( 'Round half down', 'tkt-shortcodes' ),
			'PHP_ROUND_HALF_EVEN' => esc_html__( 'Round towards nearest even value', 'tkt-shortcodes' ),
			'PHP_ROUND_HALF_ODD'  => esc_html__( 'Round towards nearest odd value', 'tkt-shortcodes' ),
		);

		$shortcode_types = array(
			'informational' => esc_html__( 'Informational', 'tkt-shortcodes' ),
			'operational'   => esc_html__( 'Operational', 'tkt-shortcodes' ),
			'managerial'    => esc_html__( 'Managerial', 'tkt-shortcodes' ),
		);
		/**
		 * Allow External ShortCodes to be added to the TukuToi ShortCodes GUI.
		 *
		 * Other plugins or users can add ShortCodes to the TukuToi ShortCodes GUI.
		 * They will then be displaying inside the TukuToi ShortCodes GUI Dialogue.
		 * It is up to the third party to provide valid Forms for those ShortCodes and source code.
		 *
		 * Note: Translations can not be done in this plugin because there litereally could be any string
		 * passed as the ShortCode label. Instead, 118n has to be done when adding the Shortcode using this filter,
		 * on the "external" side.
		 *
		 * @since 1.12.2
		 * @param array $external_shortcodes {
		 *      The array of new shortcodes keyed by their tagname. Default value array().
		 *
		 *     @type array  $tagname    {
		 *          ShortCode Data.
		 *
		 *          @type   string  $label  The ShortCode Label (Used for GUI Buttons).
		 *          @type   string  $type   The ShortCode Type. Accepts 'informational', 'operational', 'managerial'.
		 *     }
		 * }
		 */
		$external_shortcode_types = apply_filters( 'tkt_scs_register_shortcode_type', $external_shortcode_types = array() );
		/**
		 * Validate the external ShortCode Types
		 */
		if ( ! empty( $external_shortcode_types && is_array( $external_shortcode_types ) ) ) {
			// We have some possibly valid external shortcode.
			if ( empty( array_intersect_key( $external_shortcode_types, $shortcode_types ) ) ) {
				// The ShortCode Tag is not already registered.
				// Sanitize and validate because we do not trust the input.
				foreach ( $external_shortcode_types as $tag => $label ) {
					$tag                              = sanitize_text_field( $tag );
					$label                            = sanitize_text_field( $label );
					$external_shortcode_types[ $tag ] = $label;
				}
				// We have possibly still invalid input but at least safe.
				$shortcode_types = array_merge( $shortcode_types, $external_shortcode_types );
			}
		}

		return $$map;
	}

	/**
	 * All Sanitization Options.
	 *
	 * @since 1.0.0
	 * @return array {
	 *      Multidimensional Array keyed by Sanitization options.
	 *
	 *      @type array $sanitization_option {
	 *          Single sanitization option array, holding label and callback of sanitization option.
	 *
	 *          @type string $label Label of Sanitization option as used in GUI.
	 *          @type string $callback The callback to the Sanitization function.
	 *      }
	 * }
	 */
	private function sanitize_options() {

		$sanitization_options = array(
			'none'              => array(
				'label' => esc_html__( 'No Sanitization', 'tkt-shortcodes' ),
			),
			'email'             => array(
				'label'    => esc_html__( 'Sanitize Email', 'tkt-shortcodes' ),
				'callback' => 'sanitize_email',
			),
			'file_name'         => array(
				'label'    => esc_html__( 'File Name', 'tkt-shortcodes' ),
				'callback' => 'sanitize_file_name',
			),
			'html_class'        => array(
				'label'    => esc_html__( 'HTML Class', 'tkt-shortcodes' ),
				'callback' => 'sanitize_html_class',
			),
			'key'               => array(
				'label'    => esc_html__( 'Key', 'tkt-shortcodes' ),
				'callback' => 'sanitize_key',
			),
			'meta'              => array(
				'label'    => esc_html__( 'Meta', 'tkt-shortcodes' ),
				'callback' => 'sanitize_meta',
			),
			'mime_type'         => array(
				'label'    => esc_html__( 'Mime Type', 'tkt-shortcodes' ),
				'callback' => 'sanitize_mime_type',
			),
			'option'            => array(
				'label'    => esc_html__( 'Option', 'tkt-shortcodes' ),
				'callback' => 'sanitize_option',
			),
			'sql_orderby'       => array(
				'label'    => esc_html__( 'SQL Orderby', 'tkt-shortcodes' ),
				'callback' => 'sanitize_sql_orderby',
			),
			'text_field'        => array(
				'label'    => esc_html__( 'Text Field', 'tkt-shortcodes' ),
				'callback' => 'sanitize_text_field',
			),
			'textarea_field'    => array(
				'label'    => esc_html__( 'Text Area', 'tkt-shortcodes' ),
				'callback' => 'sanitize_textarea_field',
			),
			'title'             => array(
				'label'    => esc_html__( 'Title', 'tkt-shortcodes' ),
				'callback' => 'sanitize_title',
			),
			'title_for_query'   => array(
				'label'    => esc_html__( 'Title for Query', 'tkt-shortcodes' ),
				'callback' => 'sanitize_title_for_query',
			),
			'title_with_dashes' => array(
				'label'    => esc_html__( 'Title with Dashes', 'tkt-shortcodes' ),
				'callback' => 'sanitize_title_with_dashes',
			),
			'user'              => array(
				'label'    => esc_html__( 'User', 'tkt-shortcodes' ),
				'callback' => 'sanitize_user',
			),
			'url_raw'           => array(
				'label'    => esc_html__( 'URL Raw', 'tkt-shortcodes' ),
				'callback' => 'esc_url_raw',
			),
			'post_kses'         => array(
				'label'    => esc_html__( 'Post KSES', 'tkt-shortcodes' ),
				'callback' => 'wp_filter_post_kses',
			),
			'nohtml_kses'       => array(
				'label'    => esc_html__( 'NoHTML KSES', 'tkt-shortcodes' ),
				'callback' => 'wp_filter_nohtml_kses',
			),
			'intval'            => array(
				'label'    => esc_html__( 'Integer', 'tkt-shortcodes' ),
				'callback' => 'intval',
			),
			'floatval'          => array(
				'label'    => esc_html__( 'Float', 'tkt-shortcodes' ),
				'callback' => 'floatval',
			),
			'is_bool'           => array(
				'label'    => esc_html__( 'Boolean', 'tkt-shortcodes' ),
				'callback' => 'is_bool',
			),
		);

		return $sanitization_options;

	}

}
