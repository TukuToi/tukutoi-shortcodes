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
generic_fieldset( 'item', 'Item', '', 'Show Post Terms Informations of this Post (Defaults to current post)' );
generic_fieldset( 'taxonomy', 'Taxonomy', '', 'Show Post Terms Information of this Taxonomy' );
termshow_fieldset();
generic_fieldset( 'delimiter', 'Delimiter', '', 'Separator between the values' );
sanitize_fieldset();
?>
</form>
