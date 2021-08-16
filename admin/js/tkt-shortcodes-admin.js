(function( $ ) {
	'use strict';
	
	/**
	 * Handle browser focus ring with consistency.
	 * Browsers are not capable of this, so we need to 
	 * do it for them.
	 */
	window.addEventListener('keydown', handle_focus_rings);

	var texteditor, shortcode, shortcodes_trigger, shortcodes, shortcodes_form_trigger, shortcodes_form, label, inputs, generated_shortcode, quote, shortcode_atts = [];
	var dialog_width = $( document ).width()/1.6;
	var dialog_height = dialog_width/1.6;
	var margins_gui = $( window ).height()/16;
	var dialog_height_operational = $( window ).height() - margins_gui;
	var dialog_width_operational = dialog_height_operational/1.6;
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
			},
			create: function (event) {
		    	$(event.target).parent().css('position', 'fixed'); 
		    },
		    resizeStart: function (event) {
		    	$(event.target).parent().css('position', 'fixed'); 
		    },
		    resizeStop: function (event) {
		    	$(event.target).parent().css('position', 'fixed'); 
		    },
		    open: function() {
		        $('.ui-widget-overlay').addClass('tkt-jquery-ui');
		    } 

		});

		shortcodes_form_trigger = $(".tkt-shortcode-buttons");

		shortcodes_form = $("#tkt-shortcode-form").dialog({
			autoOpen: false,
			modal: false,
			width: dialog_width_operational,
			height: dialog_height_operational,
			buttons: {
				"Return": function() {

					$(this).dialog("close");
					open_dialog_asynchroneus( shortcodes );

				},
				"Insert": function() {

					quote = '"'; // Reset the ShortCode atts.

					$( '[name="quotes"]' ).each(function(index){
						if( $(this).prop("checked") ){
							quote = '\'';
						}
					}); 

					shortcode_atts = []; // Reset the ShortCode atts.
					$(".tkt-shortcode-form :input:not([name='quotes']):not([name='combobox'])").each(function(index){
						if( this.checked ){
							this.value = 'true';
						}
						shortcode_atts.push( this.id + '=' + quote + this.value + quote );
					}); 

					if ( 'conditional' === shortcode || 'round' === shortcode || 'loop' === shortcode || 'searchtemplate' === shortcode ){
						generated_shortcode = '[tkt_scs_' + shortcode + ' ' + shortcode_atts.join(' ') + '][/tkt_scs_' + shortcode + ']';
					} else{
						generated_shortcode = '[tkt_scs_' + shortcode + ' ' + shortcode_atts.join(' ') + ']';
					}

					texteditor = $( '#wp-content-editor-container' ).find( 'textarea' );
					text_append( texteditor, generated_shortcode );

			        if( null != tinyMCE.activeEditor && null != tinyMCE.activeEditor ){
			         	tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, generated_shortcode );
				    }

				}
			},
			open: function (event) {
		    	$(event.target).parent().css('position', 'fixed').css('top', margins_gui/2).css('left', $( document ).width() - dialog_width_operational ); 
		    },
		    resizeStart: function (event) {
		    	$(event.target).parent().css('position', 'fixed'); 
		    },
		    resizeStop: function (event) {
		    	$(event.target).parent().css('position', 'fixed'); 
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
			  	open_dialog_asynchroneus( shortcodes_form );
				$(shortcodes).dialog("close");
				shortcodes_form.dialog("option", "title", label);
				shortcodes_form.html(response.data['form']);

				$( 'select' ).each(function(index){
					combo($);// init Custom autosuggest.
					$( this ).combobox();
				});
				
				hide_spinner();

			});
		});

		
	});

})( jQuery );

function open_dialog( trigger, instance ){

	trigger.on("click", function(e) {
		e.preventDefault();

		/**
		 * Compatibility. 
		 * 
		 * Some Plugins (like Toolset) like to force their class on the jQuery UI main node.
		 * Remove ANY non ui- class from those nodes, then add our own, to ensure our own Theme is laoded fine.
		 * Do this only when our buttons are clicked, not everywhere, like sme do.
		 */
		var cl =  instance.parent('.ui-dialog').attr("class").split(" ");
	    var newcl =[];
	    for(var i=0;i<cl.length;i++){
	    	if( !cl[i].startsWith("ui-")  ){
	    		instance.parent('.ui-dialog').removeClass(cl[i]);
	    	}
	    }
	    instance.parent('.ui-dialog').addClass('tkt-jquery-ui');

	    // open the dialog
		instance.dialog( "open" );

	});
}

function open_dialog_asynchroneus( instance ){

	/**
	 * Compatibility. 
	 * 
	 * Some Plugins (like Toolset) like to force their class on the jQuery UI main node.
	 * Remove ANY non ui- class from those nodes, then add our own, to ensure our own Theme is laoded fine.
	 * Do this only when our buttons are clicked, not everywhere, like sme do.
	 */
	var cl =  instance.parent('.ui-dialog').attr("class").split(" ");
    var newcl =[];
	for(var i=0;i<cl.length;i++){
    	if( !cl[i].startsWith("ui-")  ){
	    	instance.parent('.ui-dialog').removeClass(cl[i]);
	   	}
	}
	instance.parent('.ui-dialog').addClass('tkt-jquery-ui');
	    
	// open the dialog
	instance.dialog( "open" );

}

function show_spinner(){
	$('html').css('cursor','progress');
	$('a').css('cursor','progress');
}

function hide_spinner(){
	$('html').css('cursor','default');
	$('a').css('cursor','default');
}

function text_append( instance, text ){
    $( instance ).val( $( instance ).val() + text );
}

function handle_focus_rings( e ) {
	if ( e.keyCode === 9 ) {// The tab key.
    	document.body.classList.add('user-is-tabbing');
    
    	window.removeEventListener('keydown', handle_focus_rings);
    	window.addEventListener('mousedown', reset_focus_rings_handler);
  	}
}

function reset_focus_rings_handler() {
  	document.body.classList.remove('user-is-tabbing');
  
  	window.removeEventListener('mousedown', reset_focus_rings_handler);
  	window.addEventListener('keydown', handle_focus_rings);
}

/**
 * Custom autosuggest with search/select
 * @see https://jqueryui.com/autocomplete/#combobox
 */
function combo($){
	$.widget( "custom.combobox", {
		_create: function() {
	        this.wrapper = $( "<span>" )
	          .addClass( "custom-combobox" )
	          .insertAfter( this.element );
	 
	        this.element.hide();
	        this._createAutocomplete();
	        this._createShowAllButton();
      	},
 
      	_createAutocomplete: function() {
        	var selected = this.element.children( ":selected" ),
        	value = selected.val() ? selected.text() : "";
        	this.input = $( "<input>" )
        	.appendTo( this.wrapper )
          	.val( value )
          	.attr( "title", "" )
          	.attr( "name", "combobox" )
          	.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          	.autocomplete({
          		delay: 0,
            	minLength: 0,
            	source: $.proxy( this, "_source" )
          	});
 
        	this._on( this.input, {
          		autocompleteselect: function( event, ui ) {
            		ui.item.option.selected = true;
            		this._trigger( "select", event, {
              			item: ui.item.option
            		});
          		},
 
          		autocompletechange: "_removeIfInvalid"
        	});
      	},
 
      	_createShowAllButton: function() {
        	var input = this.input,
          	wasOpen = false;
 
        	$( "<a>" )
          	.attr( "tabIndex", -1 )
          	.attr( "title", "Show All Items" )
          	.appendTo( this.wrapper )
          	.button({
            	icons: {
              		primary: "ui-icon-triangle-1-s"
            	},
            	text: false
          	})
          	.removeClass( "ui-corner-all" )
          	.addClass( "custom-combobox-toggle ui-corner-right" )
          	.on( "mousedown", function() {
            	wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          	})
          	.on( "click", function() {
            	input.trigger( "focus" );
 
            	// Close if already visible
            	if ( wasOpen ) {
              		return;
            	}
 
            	// Pass empty string as value to search for, displaying all results
            	input.autocomplete( "search", "" );
          	});
      	},
 
      	_source: function( request, response ) {
        	var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        	response( this.element.children( "option" ).map(function() {
          		var text = $( this ).text();
          		if ( this.value && ( !request.term || matcher.test(text) ) )
            		return {
              			label: text,
              			value: text,
              			option: this
            		};
        	}) );
      	},
 
      	_removeIfInvalid: function( event, ui ) {
 
        	// Selected an item, nothing to do
        	if ( ui.item ) {
          		return;
        	}
 
        	// Search for a match (case-insensitive)
        	var value = this.input.val(),
          	valueLowerCase = value.toLowerCase(),
          	valid = false;
        	this.element.children( "option" ).each(function() {
          		if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            		this.selected = valid = true;
            		return false;
          		}
        	});
 
        	// Found a match, nothing to do
        	if ( valid ) {
          		return;
        	}
 
        	// Remove invalid value
        	this.input
          	.val( "" )
          	.attr( "title", value + " didn't match any item" );
        	this.element.val( "" );
        
        	this.input.autocomplete( "instance" ).term = "";
      	},
 
      	_destroy: function() {
        	this.wrapper.remove();
        	this.element.show();
      	}
    });
}
