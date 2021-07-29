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
generic_fieldset( 'item', 'Item', '', 'Show User Meta Data of this User (Defaults to current Term)' );
generic_fieldset( 'key', 'Meta Key', '', 'What Meta Key to use' );
generic_fieldset( 'single', 'Single', '', 'Wether to return a single value or an array' );
generic_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
sanitize_fieldset( 'How to sanitize the data' );
?>
</form>
