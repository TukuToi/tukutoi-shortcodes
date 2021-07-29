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
generic_fieldset( 'item', 'Item', '', 'Show Post Meta Information of this Post (Defaults to current Post)' );
generic_fieldset( 'key', 'Key', '', 'What Post Meta to use' );
generic_fieldset( 'single', 'Single', '', 'Wether to show single Post Meta information or array' );
generic_fieldset( 'separator', 'Separator', '', 'Separator to use when single is false' );
generic_fieldset( 'filter', 'Filter', 'raw', 'What Filter to use' );
sanitize_fieldset();
?>
</form>
