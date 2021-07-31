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

$this->text_fieldset( 'operand_one', 'Operand One', '', 'The base value (as in The Dividend)' );
$this->text_fieldset( 'operand_two', 'Operand Two', '', 'The manipulating value (as in The Divisor)' );
$this->select_fieldset( 'operator', 'Operator', '+', 'math_options' );
$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
