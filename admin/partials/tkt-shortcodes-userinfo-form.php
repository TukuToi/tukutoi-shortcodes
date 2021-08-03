<?php
/**
 * Provide a Form view for the User Info ShortCode.
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
	$this->text_fieldset( 'item', 'Item', '', 'Show User Information of this User (Defaults to current User). Takes an User ID, works only if "Get User By" is set to ID. Else pass "Field Value" for the "Get User By"' );
	$this->select_fieldset( 'field', 'Get User By', 'id', 'usergetby_options' );
	$this->text_fieldset( 'value', 'Field Value', '', 'The value of the field to retriever the user by, if other than ID' );
	$this->select_fieldset( 'show', 'Show', 'display_name', 'usershow_options' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
