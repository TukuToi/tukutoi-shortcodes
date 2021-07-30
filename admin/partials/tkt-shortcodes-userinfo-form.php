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

$this->text_fieldset( 'item', 'Item', '', 'Show User Information of this User (Defaults to current User). Use ID if Field is ID, or else value for that field' );
$this->select_fieldset( 'field', 'Get User By', 'id', 'usergetby_options' );
$this->text_fieldset( 'value', 'Field Value', '', 'The value of the field to retriever the user by, if other than ID' );
$this->select_fieldset( 'show', 'Show', 'display_name', 'usershow_options' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
