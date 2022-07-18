<?php
/**
 * Provide a Form view for the Term Meta ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'item', 'Item', '', 'Show Term Meta Data of this Term (Defaults to current Term)' );
	$this->text_fieldset( 'key', 'Meta Key', '', 'What Term Meta Key to use' );
	$this->checkbox_fieldset( 'single', 'Single', 'true' );
	$this->text_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', array( $this, 'sanitize_options' ) );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
