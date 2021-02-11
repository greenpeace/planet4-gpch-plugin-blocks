jQuery( document ).ready( function() {
	// Accordion Block
	( function( jQuery ) {
		
		var allPanels = jQuery( '.accordion > dd' ).hide()
		var allLinks = jQuery( '.accordion > dt > a' )
		
		jQuery( '.accordion > dt > a' ).click( function() {
			$this = jQuery( this )
			$target = $this.parent().next()
			
			if( !$target.hasClass( 'active' ) ) {
				allPanels.removeClass( 'active' ).slideUp( 200 )
				allLinks.removeClass( 'active' )
				$target.addClass( 'active' ).slideDown( 200 )
				$this.addClass( 'active' )
			}
			
			return false
		} )
		
	} )( jQuery );
	
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
	
	// Hide the form until needed
	var bannerField = jQuery( 'input[value="banner"]' )
	var formWrapper = jQuery( '.gpch-block-banner-tool .banner-submit-form' )
	formWrapper.hide()
	
	// Hide step 1
	jQuery( '#bm-step_start' ).on( 'click', function() {
		jQuery( '#banner_maker_intro-component' ).hide()
	} )
	
	// After banner creation, show the submit form
	jQuery( '#bm-step_generate' ).on( 'click', function() {
		formWrapper.show()
		//jQuery('.bm-app').hide();
		jQuery( '.bm-app .gui-col' ).remove()
		jQuery( '.gpch-block-banner-tool .actions-col' ).remove()
		
		jQuery( '.banner_maker-component-container' ).css( 'padding', 0 )
		
		jQuery( '#banner_maker-component-wrap' ).
		  height( jQuery( '#preview-col' ).height() + 20 )
		
		document.querySelector( '.gpch-block-banner-tool .bm-gui-preview' ).
		  scrollIntoView( {
			  behavior: 'smooth',
		  } )
		
		jQuery( '.gform_wrapper :input' ).change( function() {
			getBanner()
		} )
	} )
	
	// Get resulting banner and insert it into a form field
	function getBanner() {
		var banner = jQuery( '#bm-download_vector' ).attr( 'href' )
		
		// Base64 encode the banner
		banner = btoa( banner )
		
		// Insert banner into the hidden field with the default value "banner"
		var bannerField = jQuery( 'input[value="banner"]' ).val( banner )
		
	}
	
} )

// BS Bingo Block
var bs_boxes_elements = document.getElementsByClassName( 'box' )
var bs_boxes = Array( 25 ).fill( false )

var blockStorage = window.localStorage

// Load stored game
var gpch_bs_bingo_load = function() {
	var stored_bingo_boxes = blockStorage.getItem( 'bsbingo' )
	
	if( typeof stored_bingo_boxes == 'string' ) {
		stored_bingo_boxes = stored_bingo_boxes.split( ',' )
		
		console.log( stored_bingo_boxes )
		
		for( var i = 0; i < stored_bingo_boxes.length; i++ ) {
			stored_bingo_boxes[i] = (stored_bingo_boxes[i] == 'true');
			
			if( stored_bingo_boxes[ i ] == true ) {
				bs_boxes_elements[ i ].classList.add( 'on' )
				bs_boxes_elements[ i ].classList.remove( 'off' )
			}
		}
		
		bs_boxes = stored_bingo_boxes;
		
		gpch_bs_bingo_check_wins();
	}
}

window.addEventListener( 'load', function() {
	gpch_bs_bingo_load()
} )

var gpch_bs_bingo_switch_boxes = function() {
	if( !this.classList.contains( 'won' ) ) {
		this.classList.toggle( 'off' )
		this.classList.toggle( 'on' )
		
		var index = this.getAttribute( 'data-index' )
		
		if( this.classList.contains( 'on' ) ) {
			bs_boxes[ index ] = true
		}
		else {
			bs_boxes[ index ] = false
		}
		
		blockStorage.setItem( 'bsbingo', bs_boxes )
		
		gpch_bs_bingo_check_wins();
	}
}

var gpch_bs_bingo_check_wins = function () {
	// check for completed rows
	for( var i = 0; i < 5; i++ ) {
		var is_full = true
		
		for( var j = 0; j < 5; j++ ) {
			if( bs_boxes[ i * 5 + j ] == false ) {
				is_full = false
			}
		}
		
		if( is_full ) {
			for( var j = 0; j < 5; j++ ) {
				bs_boxes_elements[ i * 5 + j ].classList.add( 'won' )
			}
		}
	}
	
	// check for completed columns
	for( var i = 0; i < 5; i++ ) {
		var is_full = true
		
		for( var j = 0; j < 5; j++ ) {
			if( bs_boxes[ j * 5 + i ] == false ) {
				is_full = false
			}
		}
		
		if( is_full ) {
			for( var j = 0; j < 5; j++ ) {
				bs_boxes_elements[ j * 5 + i ].classList.add( 'won' )
			}
		}
	}
}

for( var i = 0; i < bs_boxes_elements.length; i++ ) {
	bs_boxes_elements[ i ].addEventListener( 'click',
	  gpch_bs_bingo_switch_boxes, false )
}

var gpch_bs_bingo_reset = function() {
	console.log('reset');
	
	for (var i = 0; i < 25; i++) {
		bs_boxes_elements[ i ].classList.remove('won')
		bs_boxes_elements[ i ].classList.remove('on')
		bs_boxes_elements[ i ].classList.add('off')
	}
	
	bs_boxes = Array( 25 ).fill( false )
}

var resetButton = document.getElementsByClassName( 'bsbingo-reset' )
resetButton[0].addEventListener( 'click', gpch_bs_bingo_reset, false )
