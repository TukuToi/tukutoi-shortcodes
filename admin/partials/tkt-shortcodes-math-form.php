<?php
/**
 * Provide a Form view for the Math Operations ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'operand_one', 'Operand One', '', 'The base value (as in The Dividend)' );
	$this->text_fieldset( 'operand_two', 'Operand Two', '', 'The manipulating value (as in The Divisor)' );
	$this->select_fieldset( 'operator', 'Operator', '+', array( $this, 'math_options' ) );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', array( $this, 'sanitize_options' ) );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes', '' );
	?>
</form>
