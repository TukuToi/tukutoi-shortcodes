<?php
/**
 * Provide a Form view for the Post Meta ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'item', 'Item', '', 'Show Post Meta Information of this Post (Defaults to current Post)' );
	$this->text_fieldset( 'key', 'Key', '', 'What Post Meta Key to use' );
	$this->checkbox_fieldset( 'single', 'Single', 'true' );
	$this->text_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
	$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', array( $this, 'sanitize_options' ) );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
