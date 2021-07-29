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
generic_fieldset( 'item', 'Item', '', 'Show User Information of this User (Defaults to current User). Use ID if Field is ID, or else value for that field' );
generic_fieldset( 'field', 'Field', 'ID', 'What field to retrieve user by (defaults to ID)' );
generic_fieldset( 'value', 'value', '', 'The value of the field to retriever the user by, if other than ID' );
usershow_fieldset();
sanitize_fieldset();
?>
</form>
