<?php
/**
 * Provide a Form view for the Edit Links ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/admin/partials
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'item', 'Item', '', 'Show Edit Link of this Post, Term or User (Defaults to current post)' );
	$this->select_fieldset( 'type', 'Type', 'post', 'alltypes_options' );
	$this->select_fieldset( 'object', 'Object', null, 'posttypes_options' );
	$this->text_fieldset( 'delimiter', 'Delimiter', ', ', 'Delimiter to use between the values' );
	$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
