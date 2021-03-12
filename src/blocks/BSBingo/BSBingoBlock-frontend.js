import anime from 'animejs/lib/anime.es.js';

var bs_boxes_elements = document.getElementsByClassName( 'box' )
var bs_boxes = Array( 25 ).fill( false )
var bs_fireworks = document.querySelector( '.fireworks' )
var bs_score = 0;

var blockStorage = window.localStorage

// Load stored game
var gpch_bs_bingo_load = function() {
	// Load state from local storage
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
	
	// Resize text to fit the boxes
	for (var i = 0; i < bs_boxes_elements.length; i++) {
		// Initiall set a large font size, then decrease until text fits the box.
		bs_boxes_elements[i].childNodes[0].style.fontSize = '22px';
		
		while (bs_boxes_elements[i].childNodes[0].offsetWidth > bs_boxes_elements[i].offsetWidth
		  || bs_boxes_elements[i].childNodes[0].offsetHeight > bs_boxes_elements[i].offsetHeight) {
			var style = window.getComputedStyle(bs_boxes_elements[i].childNodes[0], null).getPropertyValue('font-size');
			var fontSize = parseFloat(style);
			
			bs_boxes_elements[i].childNodes[0].style.fontSize = (fontSize - 1) + 'px';
		}
	}
	
	bs_fireworks.style.display = "none"
}

window.addEventListener( 'load', gpch_bs_bingo_load )

window.addEventListener( 'resize', gpch_bs_bingo_load)

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
	bs_score = 0;
	
	// check for completed rows
	for( var i = 0; i < 5; i++ ) {
		var is_full = true
		
		for( var j = 0; j < 5; j++ ) {
			if( bs_boxes[ i * 5 + j ] == false ) {
				is_full = false
			}
			else {
				// a field is worth 1 point
				bs_score = bs_score + 1;
			}
		}
		
		if( is_full ) {
			// a full row is worth 10 points
			bs_score = bs_score + 10;
			
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
			// a full column is worth 10 points
			bs_score = bs_score + 10;
			
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
	
	// Overall win?
	if (full_rows == 5) {
		// a win is worth 100 points
		bs_score = bs_score + 100;
		
		const bsBingoWinEvent = new CustomEvent('bsBingoWin', {
			bubbles: true,
		});
		
		bs_fireworks.style.display = "block"
		gpch_bs_bingo_win_animation();
	}
	
	// Update score
	document.getElementById("bs-bingo-score").innerText = bs_score;
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
	
	blockStorage.setItem( 'bsbingo', bs_boxes )
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

var gpch_bs_bingo_win_animation = function() {
	window.human = false;
	
	var canvasEl = document.querySelector( '.fireworks' );
	var ctx = canvasEl.getContext( '2d' );
	var numberOfParticules = 15;
	var pointerX = 0;
	var pointerY = 0;

	var colors = ['#FF0000', '#FF7F00', '#FFFF00', '#00FF00', '#0000FF', '#2E2B5F', '#8B00FF'];
	
	function setCanvasSize() {
		canvasEl.width = window.innerWidth * 2;
		canvasEl.height = window.innerHeight * 2;
		canvasEl.style.height = canvasEl.offsetWidth + "px";

		canvasEl.getContext( '2d' ).scale( 2, 2 );
	}
	
	function updateCoords( e ) {
		pointerX = e.clientX || e.touches[ 0 ].clientX;
		pointerY = e.clientY || e.touches[ 0 ].clientY;
	}
	
	function setParticuleDirection( p ) {
		var angle = anime.random( 0, 360 ) * Math.PI / 180;
		var value = anime.random( canvasEl.offsetWidth / 6, canvasEl.offsetWidth / 2 );
		var radius = [-1, 1][ anime.random( 0, 1 ) ] * value;
		return {
			x: p.x + radius * Math.cos( angle ),
			y: p.y + radius * Math.sin( angle )
		}
	}
	
	function createParticule( x, y ) {
		var p = {};
		p.x = x;
		p.y = y;
		p.color = colors[ anime.random( 0, colors.length - 1 ) ];
		p.radius = anime.random( 16, 32 );
		p.endPos = setParticuleDirection( p );
		p.draw = function() {
			ctx.beginPath();
			ctx.arc( p.x, p.y, p.radius, 0, 2 * Math.PI, true );
			ctx.fillStyle = p.color;
			ctx.fill();
		}
		return p;
	}
	
	function renderParticule( anim ) {
		for( var i = 0; i < anim.animatables.length; i++ ) {
			anim.animatables[ i ].target.draw();
		}
	}
	
	function animateParticules( x, y ) {
		var particules = [];
		for( var i = 0; i < numberOfParticules; i++ ) {
			particules.push( createParticule( x, y ) );
		}
		anime.timeline().add( {
			targets: particules,
			x: function( p ) { return p.endPos.x; },
			y: function( p ) { return p.endPos.y; },
			radius: 0.1,
			duration: anime.random( 1200, 1800 ),
			easing: 'easeOutExpo',
			update: renderParticule
		} )
	}
	
	var render = anime( {
		duration: Infinity,
		update: function() {
			ctx.clearRect( 0, 0, canvasEl.width, canvasEl.height );
		}
	} );
	
	var centerX = window.innerWidth / 2;
	var centerY = window.innerHeight / 2;
	
	var repeatFor = 20;
	
	function autoClick() {
		if( window.human ) return;
		animateParticules(
		  anime.random( centerX - 50, centerX + 50 ),
		  anime.random( centerY - 50, centerY + 50 )
		);
		
		repeatFor--;
		if (repeatFor > 0) {
			anime( { duration: 200 } ).finished.then( autoClick );
		}
		else {
			canvasEl.style.display = "none"
		}
	}
	
	autoClick();
	setCanvasSize();
	window.addEventListener( 'resize', setCanvasSize, false );
}