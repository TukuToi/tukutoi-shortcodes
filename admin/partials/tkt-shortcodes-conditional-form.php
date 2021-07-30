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
$this->text_fieldset( 'right', 'Right', '', 'Compare with this value...' );
$this->text_fieldset( 'operator', 'Operator', 'eq', 'How to compare the values' );
$this->text_fieldset( 'else', 'Else', '', 'What to output if the evaluation is false' );
?>
</form>
