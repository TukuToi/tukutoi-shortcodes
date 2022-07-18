<?php
/**
 * Provide a Form view for the Site Information ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->select_fieldset( 'show', 'Show', 'name', array( $this, 'siteshow_options' ) );
	$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', array( $this, 'sanitize_options' ) );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
