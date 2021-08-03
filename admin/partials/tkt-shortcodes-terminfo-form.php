<?php
/**
 * Provide a Form view for the Term Info ShortCode.
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
	$this->text_fieldset( 'item', 'Item', '', 'Show Term Information of this Term (Defaults to current Term)' );
	$this->select_fieldset( 'taxonomy', 'Taxonomy', null, 'taxonomy_options' );
	$this->select_fieldset( 'show', 'Show', 'name', 'termshow_options' );
	$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
