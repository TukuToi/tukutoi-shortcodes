<?php
/**
 * The file that declares all ShortCodes of this Plugin
 *
 * Registers an array of ShortCodes with labels,
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/includes
 */

/**
 * The ShortCode Declaration Class.
 *
 * This is used both in public and admin when we need an instance of all shortcodes.
 *
 * @since      1.0.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/includes
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Declarations {

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
	 * @param      string $plugin_prefix          The unique prefix of this plugin.
	 * @param      string $version          The version of this plugin.
	 */
	public function __construct( $plugin_prefix, $version ) {

		$this->plugin_prefix    = $plugin_prefix;
		$this->version          = $version;
		$this->shortcodes       = $this->declare_shortcodes();

	}

	/**
	 * Register an array of Shortcodes of this plugin
	 *
	 * Key is ShortCode name and method name, Value is label/name of shortcode
	 *
	 * @since 1.0.0
	 * @return array @shortcodes The ShortCodes array.
	 */
	private function declare_shortcodes() {

		$shortcodes = array(
			'bloginfo' => array(
				'label' => 'Website Information',
				'type'  => 'informational',
			),
			'postinfo' => array(
				'label' => 'Post Data',
				'type'  => 'informational',
			),
			'userinfo' => array(
				'label' => 'User Data',
				'type'  => 'informational',
			),
			'terminfo' => array(
				'label' => 'Term Data',
				'type'  => 'informational',
			),
			'post_termsinfo' => array(
				'label' => 'Post Term Data',
				'type'  => 'informational',
			),
			'usermeta' => array(
				'label' => 'User Meta Data',
				'type'  => 'informational',
			),
			'termmeta' => array(
				'label' => 'Term Meta Data',
				'type'  => 'informational',
			),
			'postmeta' => array(
				'label' => 'Post Meta Data',
				'type'  => 'informational',
			),
			'conditional' => array(
				'label' => 'Conditional ShortCode',
				'type'  => 'operational',
			),
			'math' => array(
				'label' => 'Mathematical Operation',
				'type'  => 'operational',
			),
			'editlinks' => array(
				'label' => 'Edit Links',
				'type'  => 'managerial',
			),
			'archivelinks' => array(
				'label' => 'Archive Links',
				'type'  => 'informational',
			),
			'attachmentimage' => array(
				'label' => 'Images',
				'type'  => 'informational',
			),
			'round' => array(
				'label' => 'Round Floating Values',
				'type'  => 'operational',
			),
		);

		/**
		 * Apply filter to allow other ShortCodesto be added.
		 *
		 * Other plugins or users can add ShortCodes to the TukuToi ShortCodes GUI.
		 * They will then be displaying inside the TukuToi ShortCodes GUI Dialogue.
		 * It is up to the third party to provide valid Forms for those ShortCodes and source code.
		 *
		 * @since 1.12.2
		 *
		 * @param array $args {
		 *     Associative Array where $key is  ShortCode method and tagname, $value is an array of ShortCode Name and Type.
		 *
		 *     @type string $label The Name of the ShortCode (Button Label). Default ''. Accepts 'string'.
		 *     @type string $type The type of ShortCode (determines Section in GUI). Default ''. Accepts 'managerial', 'operational', 'informational'.
		 * }
		 */
		$shortcodes = apply_filters( 'tkt_scs_register_shortcode', $shortcodes );

		return $shortcodes;

	}

	/**
	 * Register an array of Shortcodes of this plugin
	 *
	 * Key is ShortCode name and method name, Value is label/name of shortcode
	 *
	 * @since 1.0.0
	 * @param string $map the data map to retrieve.
	 * @return array $$map THe Map requested.
	 */
	public function data_map( $map ) {

		$site_infos = array(
			'name'                  => 'Website Name',
			'url'                   => 'Home URL',
			'wpurl'                 => 'Site URL',
			'description'           => 'Site Tagline',
			'rdf_url'               => 'RDF Feed URL',
			'rss_url'               => 'RSS Feed URL',
			'rss2_url'              => 'RSS2 Feed URL',
			'atom_url'              => 'Atom Feed URL',
			'comments_atom_url'     => 'Atom Comments Feed URL',
			'comments_rss2_url'     => 'RSS2 Comments Feed URL',
			'pingback_url'          => 'Pingback URL',
			'stylesheet_url'        => 'Theme Stylesheet URL',
			'stylesheet_directory'  => 'Theme Stylesheet Directory',
			'template_url'          => 'Template Directory URL',
			'admin_email'           => 'Site Admin Email',
			'charset'               => 'Site Charset',
			'html_type'             => 'HTML Type',
			'version'               => 'ClassicPress Version',
			'language'              => 'Site Language',
			'is_rtl'                => 'Text Direction',
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
			'+'     => 'Plus',
			'-'     => 'Minus',
			'*'     => 'Times',
			'/'     => 'Divided',
			'**'    => 'Exponentiation',
			'mod'   => 'Modulo (weirdest stuff ever)',
			'sqrt'  => '√ (nth Root)',
			'%'     => '% (Percent)',
			'‰'     => '‰ (Permille)',
		);

		$valid_comparison = array(
			'eqv'   => 'Equal',
			'eqvt'  => 'Identical',
			'nev'   => 'Not equal',
			'nevt'  => 'Not identical',
			'lt'    => 'Lesss than',
			'gt'    => 'Greater than',
			'gte'   => 'Less than or equal to',
			'lte'   => 'Greater than or equal to',
		);

		$valid_round_constants = array(
			'PHP_ROUND_HALF_UP'     => 'Round half up',
			'PHP_ROUND_HALF_DOWN'   => 'Round half down',
			'PHP_ROUND_HALF_EVEN'   => 'Round towards nearest even value',
			'PHP_ROUND_HALF_ODD'    => 'Round towards nearest odd value',
		);

		$shortcode_types = array(
			'informational' => 'Informational',
			'operational' => 'Operational',
			'managerial' => 'Managerial',
		);

		return $$map;
	}

}
