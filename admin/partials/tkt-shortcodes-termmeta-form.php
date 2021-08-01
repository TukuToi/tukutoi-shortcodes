<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
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
	$this->text_fieldset( 'item', 'Item', '', 'Show Term Meta Data of this Term (Defaults to current Term)' );
	$this->text_fieldset( 'key', 'Meta Key', '', 'What Term Meta Key to use' );
	$this->checkbox_fieldset( 'single', 'Single', 'true' );
	$this->text_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
