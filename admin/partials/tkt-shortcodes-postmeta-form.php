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

$this->text_fieldset( 'item', 'Item', '', 'Show Post Meta Information of this Post (Defaults to current Post)' );
$this->text_fieldset( 'key', 'Key', '', 'What Post Meta Key to use' );
$this->checkbox_fieldset( 'single', 'Single', 'true' );
$this->text_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
