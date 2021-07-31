<?php
/**
 * This file includes the ShortCodes GUI interfaces.
 *
 * @since 1.4.0
 * @package Tkt_Shortcodes/admin/partials
 */

/**
 * The class to generate a ShortCode GUI.
 *
 * Defines all type of Input fields necessary, also
 * creates specific methods to populate eventual options
 * and returns a fully usable GUI (jQuery dialog) for each ShortCode.
 *
 * @since      1.4.0
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/admin
 * @author     Your Name <hello@tukutoi.com>
 */
class Tkt_Shortcodes_Gui {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
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
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $sanitization_options    All the sanitization options of the plugin.
	 */
	private $sanitization_options;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since   1.0.0
	 * @param   string $plugin_prefix   The unique prefix of this plugin.
	 * @param   string $version         The version of this plugin.
	 * @param   string $shortcode       The ShortCode requested.
	 */
	public function __construct( $plugin_prefix, $version, $shortcode ) {

		$this->plugin_prefix = $plugin_prefix;
		$this->plugin_version = $version;
		$this->shortcode = $shortcode;

	}

	/**
	 * Get the GUI for the requested ShortCode.
	 *
	 * @since 1.4.0
	 * @return mixed $gui The Requested GUI Form.
	 */
	public function get_shortcode_gui() {

		$file = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tkt-shortcodes-' . $this->shortcode . '-form.php';

		ob_start();
		require_once( $file );
		$form = ob_get_contents();
		ob_end_clean();

		$gui = $this->fieldset_wrapper( 'pre' );
		$gui .= $form;
		$gui .= $this->fieldset_wrapper( 'after' );

		return $gui;

	}

	/**
	 * Standard wrapper for the GUI Forms
	 *
	 * @since 1.4.0
	 * @param string $wrap The Requested wrap element.
	 * @return array $wrapper An array with the wrapper elements.
	 */
	private function fieldset_wrapper( $wrap ) {

		$wrapper['pre']     = '<form class="tkt-shortcode-form">';
		$wrapper['after']   = '</form>';

		return $wrapper[ $wrap ];

	}

	/**
	 * Create a Generic Field set for the ShortCodes Forms.
	 *
	 * @since 1.4.0
	 * @param string $attribute  The ShortCode attribute.
	 * @param string $label      The ShortCode Attrbute Label.
	 * @param string $value      The ShortCode Attribute default value.
	 * @param string $explanation The ShortCode Attribute explanation.
	 */
	private function text_fieldset( $attribute, $label, $value, $explanation ) {

		?>
		<fieldset>
			  <label for="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $label ); ?></label>
			  <input type="text" name="<?php echo esc_attr( $attribute ); ?>" id="<?php echo esc_attr( $attribute ); ?>" value="<?php echo esc_attr( $value ); ?>" class="text ui-widget-content ui-corner-all">
			  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
		</fieldset>
		<?php

	}

	/**
	 * Create a Checkbox Field set for the ShortCodes Forms.
	 *
	 * @since 1.4.0
	 * @param string $attribute  The ShortCode attribute.
	 * @param string $label      The ShortCode Attrbute Label.
	 * @param string $value      The ShortCode Attribute default value.
	 * @param string $explanation The ShortCode Attribute explanation.
	 */
	private function checkbox_fieldset( $attribute, $label, $value, $explanation = 'Wether to return a single value or an array' ) {

		?>
		<fieldset>
			<label for="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $label ); ?></label>
			  <input type="checkbox" name="<?php echo esc_attr( $attribute ); ?>" id="<?php echo esc_attr( $attribute ); ?>" value="<?php echo esc_attr( $value ); ?>" class="text ui-widget-content ui-corner-all" checked>
			  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
		</fieldset>
		<?php

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms.
	 *
	 * @since 1.4.0
	 * @param string $attribute  The ShortCode attribute.
	 * @param string $label      The ShortCode Attrbute Label.
	 * @param string $value      The ShortCode Attribute default value.
	 * @param string $callback    The user Callback to generate the select options.
	 */
	private function select_fieldset( $attribute, $label, $value, $callback ) {
		
		?>
		<fieldset>
			  <label for="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $label ); ?></label>
			  <select name="<?php echo esc_attr( $attribute ); ?>" id="<?php echo esc_attr( $attribute ); ?>" class="tkt-select">
				<?php
				call_user_func( array( $this, $callback ) );
				$explanation = apply_filters( 'tkt_scs_shortcodes_fieldset_explanation', 'This option has no description' );
				?>
			  </select>
			  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
		</fieldset>
		<?php
	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Sanitization options.
	 *
	 * @since 1.4.0
	 */
	private function sanitize_options() {

		$sanitizer = new Tkt_Shortcodes_Sanitizer( $this->plugin_prefix, $this->version );

		foreach ( $sanitizer->sanitization_options as $sanitization_option => $array ) {
			$selected = 'text_field' === $sanitization_option ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $sanitization_option, $array['label'] );
		}
		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {

				return 'How to sanitize the data';

			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Post Display Options.
	 *
	 * @since 1.4.0
	 */
	private function postshow_options() {

		$post = new WP_Post( new stdClass() );

		$post_properties = get_object_vars( $post );

		foreach ( $post_properties as $post_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $post_property ) ) );
			$selected = 'post_name' === $post_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $post_property, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What Post Information to show. <strong>Careful, when inserting the Post Content in a Post, always make sure to pass an OTHER ID than the current!</strong>';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Term Display Options.
	 *
	 * @since 1.4.0
	 */
	private function termshow_options() {

		$term = new WP_Term( new stdClass() );
		$term_properties = get_object_vars( $term );

		foreach ( $term_properties as $term_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $term_property ) ) );
			$selected = 'name' === $term_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $term_property, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What Term Information to show';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Taxonomy Options.
	 *
	 * @since 1.4.0
	 */
	private function taxonomy_options() {

		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

		foreach ( $taxonomies as $taxonomy => $object ) {
			$label = $object->labels->menu_name;
			$name  = $object->name;
			printf( '<option value="' . esc_attr( '%s' ) . '">' . esc_html( '%s' ) . '</option>', $name, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'Get Term from this Taxonomy';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms User Display Options.
	 *
	 * @since 1.4.0
	 */
	private function usershow_options() {

		$user = new WP_User( 1 );// What if no user with role 1 exist?
		$user_properties = get_object_vars( $user );
		unset( $user_properties['data'] );
		$user_data = get_object_vars( $user->data );
		$user_properties = array_merge( $user_data, $user_properties );

		foreach ( $user_properties as $user_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $user_property ) ) );
			$selected = 'display_name' === $user_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $user_property, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What User Information to show';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms User Get By Options.
	 *
	 * @since 1.4.0
	 */
	private function usergetby_options() {

		$getby_fields = array(
			'id'    => 'User ID',
			'slug'  => 'User Nicename (sanitized Login Name)', // Slug is the user_nicename. The user_nicename is an url sanitized version of the user_login. It is used for Author Permalink, Post Permalink, and only different from user_login if the user_login used invalid chars (like email).
			'email' => 'User Email',
			'login' => 'User Login Name',
		);

		foreach ( $getby_fields as $getby_field => $label ) {
			$selected = 'id' === $getby_field ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $getby_field, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'By what field to the the User';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms SiteInfo Display Options.
	 *
	 * @since 1.4.0
	 */
	private function siteshow_options() {

		$declarations = new Tkt_Shortcodes_Declarations( $this->plugin_prefix, $this->version );
		$site_infos = $declarations->data_map( 'site_infos' );

		foreach ( $site_infos as $site_info => $label ) {
			$selected = 'name' === $site_info ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $site_info, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What Site Information to show';

			}
		);

	}

}
