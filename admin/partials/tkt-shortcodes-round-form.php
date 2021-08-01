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
	$this->text_fieldset( 'round', 'Round', '', 'By how many Decimals to round the float value' );
	$this->select_fieldset( 'dir', 'Direction', 'PHP_ROUND_HALF_UP', 'roundconstants_options' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
