<?php
/**
 * Provide a Form view for the Attachment ShortCode ShortCode.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Shortcodes
 * @subpackage Tkt_Shortcodes/admin/partials
 */

?>
<form class="tkt-shortcode-form">
	<?php
	$this->text_fieldset( 'item', 'Item', '', 'Show Image URL of this Post (Featured Image) or Attachment' );
	$this->text_fieldset( 'url', 'Attachment URL', '', 'The URL of the Attachment (For Attachments other than Featured Image)' );
	$this->select_fieldset( 'show', 'Show', 'featured_image', 'attachment_options' );
	$this->text_fieldset( 'width', 'Image width', '', 'The Image width in Pixels (Only registered size accepted)' );
	$this->text_fieldset( 'height', 'Image height', '', 'The Image height in Pixels (Only registered size accepted)' );
	$this->select_fieldset( 'size', 'Size', '', 'imagesize_options' );
	$this->checkbox_fieldset( 'icon', 'Icon', '', 'If the image should be treated as an Icon', '' );
	$this->text_fieldset( 'filter', 'Filter', 'raw', 'What Filter to apply' );
	$this->select_fieldset( 'sanitize', 'Sanitize', 'text_field', 'sanitize_options' );
	$this->checkbox_fieldset( 'quotes', 'Quotes', '"', 'What Quotes to use in ShortCodes (Useful when using ShortCodes in other ShortCodes attributes, or in HTML attributes)', '' );
	?>
</form>
