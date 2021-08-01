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
	$this->text_fieldset( 'left', 'Left', '', 'Compare this value...' );
	$this->text_fieldset( 'right', 'Right', '', '... with this value' );
	$this->select_fieldset( 'operator', 'Comparison Operator', '==', 'conditional_options' );
	$this->checkbox_fieldset( 'float', 'Float', '', 'Check to evaluate as Float Values', '' );
	$this->text_fieldset( 'epsilon', 'Epsilon', '', 'Epsilon Precision Value to use when comparing Float Values' );
	$this->text_fieldset( 'else', 'Else', '', 'What to output if the evaluation is false' );
	?>
</form>
