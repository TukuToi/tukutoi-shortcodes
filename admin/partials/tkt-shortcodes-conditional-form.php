<?php
/**
 * Provide a Form view for the Conditional ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 * @package    Plugins\ShortCodes\Admin\Partials
 * @author     Beda Schmid <beda@tukutoi.com>
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'left', 'Left', '', 'Compare this value...' );
	$this->text_fieldset( 'right', 'Right', '', '... with this value' );
	$this->select_fieldset( 'operator', 'Comparison Operator', '==', array( $this, 'conditional_options' ) );
	$this->text_fieldset( 'fx_args', 'FX Arguments', '', 'Arguments to pass to the Custom Function. Accepts \'arg_one:value_one,arg_two:value_two\'' );
	$this->checkbox_fieldset( 'float', 'Float', '', 'Check to evaluate as Float Values', '' );
	$this->text_fieldset( 'epsilon', 'Epsilon', '', 'Epsilon Precision Value to use when comparing Float Values' );
	$this->text_fieldset( 'else', 'Else', '', 'What to output if the evaluation is false' );
	?>
</form>
