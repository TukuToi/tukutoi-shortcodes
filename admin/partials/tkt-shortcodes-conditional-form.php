<?php
/**
 * Provide a Form view for the Conditional ShortCode.
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
	$this->text_fieldset( 'left', 'Left', '', 'Compare this value...' );
	$this->text_fieldset( 'right', 'Right', '', '... with this value' );
	$this->select_fieldset( 'operator', 'Comparison Operator', '==', array( $this, 'conditional_options' ) );
	$this->checkbox_fieldset( 'float', 'Float', '', 'Check to evaluate as Float Values', '' );
	$this->text_fieldset( 'epsilon', 'Epsilon', '', 'Epsilon Precision Value to use when comparing Float Values' );
	$this->text_fieldset( 'else', 'Else', '', 'What to output if the evaluation is false' );
	?>
</form>
