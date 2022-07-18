<?php
/**
 * Provide a Form view for the Post Terms Info ShortCode.
 *
 * @pwpcs this is the only error in the plugin (filename not using - but _)
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'item', 'Item', '', 'Show Post Terms Information of this Post (Defaults to current post)' );
	$this->select_fieldset( 'taxonomy', 'Taxonomy', null, array( $this, 'taxonomy_options' ) );
	$this->select_fieldset( 'show', 'Show', 'term_id', array( $this, 'termshow_options' ) );
	$this->text_fieldset( 'delimiter', 'Delimiter', ', ', 'Delimiter to use between the values' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', array( $this, 'sanitize_options' ) );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
