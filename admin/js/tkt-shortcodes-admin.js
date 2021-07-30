(function( $ ) {
	'use strict';
	
	var shortcode, shortcodes_trigger, shortcodes, shortcodes_form_trigger, shortcodes_form, label, inputs, generated_shortcode, shortcode_atts = [];
	var dialog_width = 625;
	var dialog_height = dialog_width/1.6;

	$( window ).on('load', function() {

		shortcodes_trigger = $("#tkt-shortcodes-dialog-trigger");

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

		shortcodes_form_trigger = $(".tkt-shortcode-buttons");

		shortcodes_form = $("#tkt-shortcode-form").dialog({
			autoOpen: false,
			modal: true,
			width: dialog_width,
			height: dialog_height,
			buttons: {
				"Return": function() {

					$(this).dialog("close");

				},
				"Insert": function() {

					shortcode_atts = []; // Reset the ShortCode atts.
					$(".tkt-shortcode-form :input").each(function(index){

						shortcode_atts.push( this.id + '="' + this.value + '"' );

					}); 

					generated_shortcode = '[tkt_scs_' + shortcode + ' ' + shortcode_atts.join(' ') + ']';

			        $( '#wp-content-editor-container' ).find( 'textarea' ).val( generated_shortcode );
			        if( typeof(tinyMCE.activeEditor) !== null ){
			         	tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, generated_shortcode );
				    }

				}
			}
		});

		open_dialog( shortcodes_trigger, shortcodes );

		shortcodes_form_trigger.on("click", function(e) {

			e.preventDefault();

			shortcode = this.id;
			label = this.title;

			show_spinner();
			
			$.get( tkt_scs_ajax_object.ajax_url, {

			    action: 'tkt_scs_get_shortcode_form',
			    security: tkt_scs_ajax_object.security,
			    shortcode: shortcode,

			}, function( response ) {

				if ( undefined !== response.success && false === response.success ) {
					hide_spinner();
			  		return;
			  	}

			  	shortcodes_form.html("");
				shortcodes_form.dialog("open");
				shortcodes_form.dialog("option", "title", label);
				shortcodes_form.html(response['form']);

				hide_spinner();

			});
		});
		
	});

})( jQuery );

function open_dialog( trigger, instance ){
	trigger.on("click", function(e) {
		e.preventDefault();
		instance.dialog( "open" );
	});
}

function show_spinner(){
	$('html').css('cursor','progress');
	$('a').css('cursor','progress');
}

function hide_spinner(){
	$('html').css('cursor','default');
	$('a').css('cursor','default');
}