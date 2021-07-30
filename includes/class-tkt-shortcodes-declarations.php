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
		$this->shortcodes 		= $this->declare_shortcodes();

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
			'bloginfo'          => 'Website Information',
			'postinfo'          => 'Post Data',
			'userinfo'          => 'User Data',
			'terminfo'          => 'Term Data',
			'post_termsinfo'    => 'Post Term Data',
			'usermeta'          => 'User Meta Data',
			'termmeta'          => 'Term Meta Data',
			'postmeta'          => 'Post Meta Data',
			'conditional'       => 'TukuToi Conditional ShortCode',
		);

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

		return $$map;
	}

}
