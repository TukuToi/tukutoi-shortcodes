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
	 * The Configuration object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $declarations    All configurations and declarations of this plugin.
	 */
	private $declarations;

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
	 * @param      string $declarations    The Configuration object.
	 */
	public function __construct( $plugin_prefix, $version, $shortcode, $declarations ) {

		$this->plugin_prefix = $plugin_prefix;
		$this->plugin_version = $version;
		$this->shortcode = $shortcode;
		$this->declarations = $declarations;

	}

	/**
	 * Get the GUI for the requested ShortCode.
	 *
	 * @since 1.4.0
	 * @return mixed $gui The Requested GUI Form.
	 */
	public function get_shortcode_gui() {

		$file = plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/tkt-shortcodes-' . $this->shortcode . '-form.php';

		/**
		 * Apply filter to allow other ShortCodesto be added.
		 *
		 * Other plugins or users can add ShortCodes to the TukuToi ShortCodes GUI.
		 * They will then be displaying inside the TukuToi ShortCodes GUI Dialogue.
		 * It is up to the third party to provide valid Forms for those ShortCodes and source code.
		 *
		 * @since 1.12.2
		 *
		 * @param string  $file The path to the ShortCode Form GUI.
		 * @param string  $shortcode The ShortCode for which we add new GUI.
		 */
		$file = apply_filters( "tkt_scs_{$this->shortcode}_shortcode_form_gui", $file, $this->shortcode );

		ob_start();
		require_once( $file );
		$form = ob_get_contents();
		ob_end_clean();

		$gui = $form;

		return $gui;

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
	private function checkbox_fieldset( $attribute, $label, $value, $explanation = 'Wether to return a single value or an array', $checked = 'checked' ) {

		?>
		<fieldset>
			<label for="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $label ); ?></label>
			  <div class="tkt-block-checkbox">
				  <input type="checkbox" name="<?php echo esc_attr( $attribute ); ?>" id="<?php echo esc_attr( $attribute ); ?>" value="<?php echo esc_attr( $value ); ?>" class="checkbox ui-widget-content ui-corner-all" <?php echo esc_attr( $checked ); ?>>
			  </div>
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

		$sanitizer = new Tkt_Shortcodes_Sanitizer( $this->plugin_prefix, $this->version, $this->declarations );

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
	 * Create a Select Field set for the ShortCodes Forms Taxonomy Options.
	 *
	 * @since 1.4.0
	 */
	private function posttypes_options() {

		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		foreach ( $post_types as $post_types => $object ) {
			$label = $object->labels->menu_name;
			$name  = $object->name;
			printf( '<option value="' . esc_attr( '%s' ) . '">' . esc_html( '%s' ) . '</option>', $name, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'The Post Type to which to link when Editing Terms';
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
	 * Create a Select Field set for the ShortCodes Forms Math Options.
	 *
	 * @since 1.4.0
	 */
	private function math_options() {

		$valid_operators = $this->declarations->data_map( 'valid_operators' );

		foreach ( $valid_operators as $valid_operator => $label ) {
			$selected = '+' === $valid_operator ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $valid_operator, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What operator to use';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Conditional Options.
	 *
	 * @since 1.4.0
	 */
	private function conditional_options() {

		$valid_comparisons = $this->declarations->data_map( 'valid_comparison' );

		foreach ( $valid_comparisons as $valid_comparison => $label ) {
			$selected = '==' === $valid_comparison ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $valid_comparison, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What Comparison Operator to use';
			}
		);

	}


	/**
	 * Create a Select Field set for the ShortCodes Forms SiteInfo Display Options.
	 *
	 * @since 1.4.0
	 */
	private function siteshow_options() {

		$site_infos = $this->declarations->data_map( 'site_infos' );

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

	/**
	 * Create a Select Field set for the ShortCodes Forms SiteInfo Display Options.
	 *
	 * @since 1.4.0
	 */
	private function alltypes_options() {

		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$alltypes = array_merge( $taxonomies, $post_types );

		foreach ( $alltypes as $alltype => $object ) {
			$label = $object->labels->menu_name;
			$name  = $object->name;
			$selected = 'post' === $alltype ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $name, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'The Content Type of which to get the Edit link';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Attachment Display Options.
	 *
	 * @since 1.4.0
	 */
	private function attachment_options() {

		$attachment_options = array(
			'featured_image'    => 'Featured Image',
			'other'             => 'Other Image',
		);

		foreach ( $attachment_options as $attachment_option => $label ) {
			$selected = 'featured_image' === $attachment_option ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $attachment_option, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'Whether Show a Featured Image or any other Image';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Attachment Display Options.
	 *
	 * @since 1.4.0
	 */
	private function imagesize_options() {

		$imagesize_options = get_intermediate_image_sizes();

		foreach ( $imagesize_options as $imagesize_option => $label ) {
			$selected = 'thumbnail' === $imagesize_option ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $imagesize_option, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'What Registered Image size to use';
			}
		);

	}

	/**
	 * Create a Select Field set for the ShortCodes Forms Attachment Display Options.
	 *
	 * @since 1.4.0
	 */
	private function roundconstants_options() {

		$valid_round_constants = $this->declarations->data_map('valid_round_constants');

		foreach ( $valid_round_constants as $valid_round_constant => $label ) {
			$selected = 'PHP_ROUND_HALF_UP' === $valid_round_constant ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $valid_round_constant, $label );
		}

		add_filter(
			'tkt_scs_shortcodes_fieldset_explanation',
			function( $explanation ) {
				return 'How to round the value';
			}
		);

	}

}
