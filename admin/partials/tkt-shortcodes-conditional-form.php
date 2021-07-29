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
<?php
require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'tkt-shortcodes-gui-api.php' );
?>
<form class="tkt-shortcode-form">
<?php
generic_fieldset( 'left', 'Left', '', 'Compare this value...' );
generic_fieldset( 'right', 'Right', '', 'Compare with this value...' );
generic_fieldset( 'operator', 'Operator', 'eq', 'How to compare the values' );
generic_fieldset( 'else', 'Else', '', 'What to output if the evaluation is false' );
?>
</form>
