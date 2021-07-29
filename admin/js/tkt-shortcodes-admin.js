(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).on('load', function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practice to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var shortcode, shortcodes, label, inputs, generated_shortcode, shortcode_atts = [];
	var dialog_width = 625;
	var dialog_height = dialog_width/1.6;
	$( window ).on('load', function() {

		shortcodes = $("#tkt-shortcodes-dialog").dialog({
		    autoOpen: false,
			modal: true,
			width: dialog_width,
			height: dialog_height,
		    buttons: {
				"Close": function() {
					$(this).dialog("close");
				}
			}
		});

		$("#tkt-shortcode-form").dialog({
			autoOpen: false,
			modal: true,
			width: dialog_width,
			height: dialog_height,
			buttons: {
				"Return": function() {
					$(this).dialog("close");
				},
				"Insert": function() {
					$(".tkt-shortcode-form :input").each(function(index){
						shortcode_atts.push( this.id + '="' + this.value + '"' );
					}); 
					console.log(shortcode_atts);
					generated_shortcode = '[tkt_scs_' + shortcode + ' ' + shortcode_atts.join(' ') + ']';
			        $( '#wp-content-editor-container' ).find( 'textarea' ).val( generated_shortcode );
			        if( typeof(tinyMCE.activeEditor) !== null ){
			         	tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, generated_shortcode );
				    }
				}
			}
		});
		$("#tkt-shortcodes-dialog-trigger").on("click", function(e) {
			e.preventDefault();
			shortcodes.dialog( "open" );
		});
		$(".tkt-shortcode-buttons").on("click", function(e) {
			e.preventDefault();
			shortcode = this.id;
			label = this.title;
			$.get( tkt_scs_ajax_object.ajax_url, {

			    action:   'tkt_scs_get_shortcode_form',
			    security: tkt_scs_ajax_object.security,
			    shortcode: shortcode,

			}, function( response ) {

			  if ( undefined !== response.success && false === response.success ) {
			  	return;
			  }

			  	$("#tkt-shortcode-form").html("");
				$("#tkt-shortcode-form").dialog("option", "title", "Loading...").dialog("open");
				$("#tkt-shortcode-form").dialog("option", "title", label);
				$("#tkt-shortcode-form").html(response['form']);

			});
		});
		
		
	});

})( jQuery );