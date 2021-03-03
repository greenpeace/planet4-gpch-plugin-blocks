import anime from 'animejs/lib/anime.es.js';

var bs_boxes_elements = document.getElementsByClassName( 'box' )
var bs_boxes = Array( 25 ).fill( false )

var blockStorage = window.localStorage

// Load stored game
var gpch_bs_bingo_load = function() {
	for (var i = 0; i < bs_boxes_elements.length; i++) {
		if (bs_boxes_elements[i].textContent.length > 30) {
			bs_boxes_elements[ i ].classList.add( 'text-long' )
		}
		else if (bs_boxes_elements[i].textContent.length < 12) {
			bs_boxes_elements[ i ].classList.add( 'text-short' )
		}
	}
	
	
	var stored_bingo_boxes = blockStorage.getItem( 'bsbingo' )
	
	if( typeof stored_bingo_boxes == 'string' ) {
		stored_bingo_boxes = stored_bingo_boxes.split( ',' )
		
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
	var full_rows = 0;
	
	// check for completed rows
	for( var i = 0; i < 5; i++ ) {
		var is_full = true
		
		for( var j = 0; j < 5; j++ ) {
			if( bs_boxes[ i * 5 + j ] == false ) {
				is_full = false
			}
		}
		
		if( is_full ) {
			full_rows += 1;
			
			var is_newly_won = false;
			
			for( var j = 0; j < 5; j++ ) {
				if ( !bs_boxes_elements[ i * 5 + j ].classList.contains('won')) {
					is_newly_won = true;
				}
				bs_boxes_elements[ i * 5 + j ].classList.add( 'won' )
			}
			
			if(is_newly_won) {
				gpch_bs_bingo_highlight_row(i);
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
			var is_newly_won = false;
			
			for( var j = 0; j < 5; j++ ) {
				if ( !bs_boxes_elements[ j * 5 + i ].classList.contains('won')) {
					is_newly_won = true;
				}
				bs_boxes_elements[ j * 5 + i ].classList.add( 'won' )
			}
			
			if(is_newly_won) {
				gpch_bs_bingo_highlight_column(i);
			}
		}
	}
	
	if (full_rows == 5) {
		const bsBingoWinEvent = new CustomEvent('bsBingoWin', {
			bubbles: true,
		});
	}
}

for( var i = 0; i < bs_boxes_elements.length; i++ ) {
	bs_boxes_elements[ i ].addEventListener( 'click',
	  gpch_bs_bingo_switch_boxes, false )
}

var gpch_bs_bingo_reset = function() {
	for (var i = 0; i < 25; i++) {
		bs_boxes_elements[ i ].classList.remove('won')
		bs_boxes_elements[ i ].classList.remove('on')
		bs_boxes_elements[ i ].classList.add('off')
	}
	
	bs_boxes = Array( 25 ).fill( false )
}

var resetButton = document.getElementsByClassName( 'bsbingo-reset' )
resetButton[0].addEventListener( 'click', gpch_bs_bingo_reset, false )

var gpch_bs_bingo_highlight_row = function(line) {
	var start = line * 5;
	var el = []
	
	for (var i = start; i < start + 5; i++) {
		el.push(bs_boxes_elements[i]);
	}
	
	anime({
		targets: [el],
		keyframes: [
			{scale: 1.1},
			{scale: 1},
		],
		duration: 200,
		delay: anime.stagger(70),
		loop: false
	});
}

var gpch_bs_bingo_highlight_column = function(col) {
	var start = col;
	var el = []
	
	
	for (var i = start; i < 25; i += 5) {
		el.push( bs_boxes_elements[ i ] );
	}
	
	
	anime({
		targets: [el],
		keyframes: [
			{scale: 1.1},
			{scale: 1},
		],
		duration: 200,
		delay: anime.stagger(70),
		loop: false
	});
}
