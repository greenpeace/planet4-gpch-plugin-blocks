jQuery( document ).ready( function() {
	// Action Divider Block
	( function( jQuery ) {
		var yesButton = jQuery(
		  '.action-divider .action-divider-question-button-yes' )
		var noButton = jQuery(
		  '.action-divider .action-divider-question-button-no' )
		
		jQuery( yesButton ).click( function() {
			var actionDividerBlock = jQuery( this ).
			  closest( '.action-divider' )
			
			actionDividerBlock.find( '.action-divider-question-wrapper' ).
			  slideUp()
			actionDividerBlock.find( '.action-divider-step2-yes' ).slideDown()
			
			return false
		} )
		
		jQuery( noButton ).click( function() {
			var actionDividerBlock = jQuery( this ).
			  closest( '.action-divider' )
			
			actionDividerBlock.find( '.action-divider-question-wrapper' ).
			  slideUp()
			actionDividerBlock.find( '.action-divider-step2-no' ).slideDown()
			
			return false
		} )
	} )( jQuery )
} )