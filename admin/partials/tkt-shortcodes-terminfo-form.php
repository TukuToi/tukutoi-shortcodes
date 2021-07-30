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

$this->text_fieldset( 'item', 'Item', '', 'Show Term Information of this Term (Defaults to current Term)' );
$this->select_fieldset( 'show', 'Show', 'name', 'termshow_options' );
$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );

