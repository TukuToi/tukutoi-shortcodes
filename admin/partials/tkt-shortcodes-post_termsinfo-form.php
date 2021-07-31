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

$this->text_fieldset( 'item', 'Item', '', 'Show Post Terms Information of this Post (Defaults to current post)' );
$this->select_fieldset( 'taxonomy', 'Taxonomy', null, 'taxonomy_options' );
$this->select_fieldset( 'show', 'Show', 'term_id', 'termshow_options' );
$this->text_fieldset( 'delimiter', 'Delimiter', ', ', 'Delimiter to use between the values' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
