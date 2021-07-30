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

$this->text_fieldset( 'item', 'Item', '', 'Show Terms Meta Data  of this Term (Defaults to current Term)' );
$this->text_fieldset( 'key', 'Meta Key', '', 'What Term Meta to use' );
$this->text_fieldset( 'single', 'Single', '', 'Wether to return a single value or array' );
$this->text_fieldset( 'delimiter', 'Delimiter', '', 'Delimiter to use if single is false' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
