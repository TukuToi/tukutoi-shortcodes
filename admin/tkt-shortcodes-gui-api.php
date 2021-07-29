<?php
/**
 * This file includes globally available functions for the TukuToi ShortCode GUI.
 *
 * @since 1.4.0
 * @package Tkt_Shortcodes/admin/partials
 */

/**
 * Create a Generic Field set for the ShortCodes Forms.
 *
 * @since 1.4.0
 * @param string $attribute  The ShortCode attribute.
 * @param string $label      The ShortCode Attrbute Label.
 * @param string $value      The ShortCode Attribute default value.
 * @param string $explanation The ShortCode Attribute explanation.
 * @param string $type       The ShortCode Attribute Type.
 */
function generic_fieldset( $attribute, $label, $value, $explanation, $type = 'text' ) {
	?>
	<fieldset>
	  <label for="<?php echo esc_attr( $attribute ); ?>"><?php echo esc_html( $label ); ?></label>
	  <input type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $attribute ); ?>" id="<?php echo esc_attr( $attribute ); ?>" value="<?php echo esc_attr( $value ); ?>" class="text ui-widget-content ui-corner-all">
	  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
	</fieldset>
	<?php
}

/**
 * Create a Select Field set for the ShortCodes Forms Sanitization options.
 *
 * @since 1.4.0
 * @param string $explanation The ShortCode Attribute explanation.
 */
function sanitize_fieldset( $explanation = 'How to sanitize the data' ) {
	$sanitization_options = array(
		'email'                 => __( 'Sanitize Email', 'tkt-shortcodes' ),
		'file_name'             => __( 'File Name', 'tkt-shortcodes' ),
		'html_class'            => __( 'HTML Class', 'tkt-shortcodes' ),
		'key'                   => __( 'Key', 'tkt-shortcodes' ),
		'meta'                  => __( 'Meta', 'tkt-shortcodes' ),
		'mime_type'             => __( 'Mime Type', 'tkt-shortcodes' ),
		'option'                => __( 'Option', 'tkt-shortcodes' ),
		'sql_orderby'           => __( 'SQL Orderby', 'tkt-shortcodes' ),
		'textarea_field'        => __( 'Text Area', 'tkt-shortcodes' ),
		'title'                 => __( 'Title', 'tkt-shortcodes' ),
		'title_for_query'       => __( 'Title for Query', 'tkt-shortcodes' ),
		'title_with_dashes'     => __( 'Title with Dashes', 'tkt-shortcodes' ),
		'user'                  => __( 'User', 'tkt-shortcodes' ),
		'url_raw'               => __( 'URL Raw', 'tkt-shortcodes' ),
		'post_kses'             => __( 'Post KSES', 'tkt-shortcodes' ),
		'nohtml_kses'           => __( 'NoHTML KSES', 'tkt-shortcodes' ),
		'intval'                => __( 'Integer', 'tkt-shortcodes' ),
		'is_bool'               => __( 'Boolean', 'tkt-shortcodes' ),
	);

	?>
	<fieldset>
	  <label for="sanitize">Sanitize</label>
	  <select name="sanitize" id="sanitize" class="tkt-sanitize-select">
		<option value="">No Sanitization</option>
		<option value="text_field" selected="selected">Text Field</option>
		<?php
		foreach ( $sanitization_options as $sanitization_option => $label ) {
			printf( '<option value="' . esc_attr( '%s' ) . '">' . esc_html( '%s' ) . '</option>', $sanitization_option, $label );
		}
		?>
	  </select>
	  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
	</fieldset>
	<?php
}

/**
 * Create a Select Field set for the ShortCodes Forms Post Display Options.
 *
 * @since 1.4.0
 * @param string $explanation The ShortCode Attribute explanation.
 */
function postshow_fieldset( $explanation = 'What Post Information to Show' ) {

	$post = new WP_Post( null );

	$post_properties = get_object_vars( $post );

	?>
	<fieldset>
	  <label for="show">Show</label>
	  <select name="show" id="show" class="tkt-shortcodes-select">
		<?php
		foreach ( $post_properties as $post_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $post_property ) ) );
			$selected = 'post_name' === $post_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $post_property, $label );
		}selected( $selected, true, true );
		?>
	  </select>
	  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
	</fieldset>
	<?php

}

/**
 * Create a Select Field set for the ShortCodes Forms Term Display Options.
 *
 * @since 1.4.0
 * @param string $explanation The ShortCode Attribute explanation.
 */
function termshow_fieldset( $explanation = 'What Term Information to Show' ) {

	$term = new WP_Term( null );

	$term_properties = get_object_vars( $term );

	?>
	<fieldset>
	  <label for="show">Show</label>
	  <select name="show" id="show" class="tkt-shortcodes-select">
		<?php
		foreach ( $term_properties as $term_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $term_property ) ) );
			$selected = 'name' === $term_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $term_property, $label );
		}selected( $selected, true, true );
		?>
	  </select>
	  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
	</fieldset>
	<?php

}

/**
 * Create a Select Field set for the ShortCodes Forms User Display Options.
 *
 * @since 1.4.0
 * @param string $explanation The ShortCode Attribute explanation.
 */
function usershow_fieldset( $explanation = 'What Term Information to Show' ) {

	$user = new WP_User( 1 );// What if no user with role 1 exist?
	$user_properties = get_object_vars( $user );
	unset( $user_properties['data'] );
	$user_data = get_object_vars( $user->data );
	$user_properties = array_merge( $user_data, $user_properties );

	?>
	<fieldset>
	  <label for="show">Show</label>
	  <select name="show" id="show" class="tkt-shortcodes-select">
		<?php
		foreach ( $user_properties as $user_property => $value ) {
			$label = implode( ' ', array_map( 'ucfirst', explode( '_', $user_property ) ) );
			$selected = 'display_name' === $user_property ? 'selected' : '';
			printf( '<option value="' . esc_attr( '%s' ) . '" ' . $selected . '>' . esc_html( '%s' ) . '</option>', $user_property, $label );
		}selected( $selected, true, true );
		?>
	  </select>
	  <small class="tkt-shortcode-option-explanation"><em><?php printf( esc_html__( '%s', 'tkt-shortcodes' ), $explanation ); ?></em></small>
	</fieldset>
	<?php

}
