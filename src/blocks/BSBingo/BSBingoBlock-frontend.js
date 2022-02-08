import anime from 'animejs/lib/anime.es.js';

/* global Event */
const bsBoxesElements = document.getElementsByClassName('box');
let bsBoxes = Array(25).fill(false);
const bsFirewoks = document.querySelector('.fireworks');
let bsScore = 0;

const blockStorage = window.localStorage;

// Load stored game
const gpchBsBingoLoad = function () {
	// Load state from local storage
	let storedBingoBoxes = blockStorage.getItem('bsbingo');

	if (typeof storedBingoBoxes === 'string') {
		storedBingoBoxes = storedBingoBoxes.split(',');

		for (let i = 0; i < storedBingoBoxes.length; i++) {
			storedBingoBoxes[i] = storedBingoBoxes[i] === 'true';

			if (storedBingoBoxes[i] === true) {
				bsBoxesElements[i].classList.add('on');
				bsBoxesElements[i].classList.remove('off');
			}
		}

		bsBoxes = storedBingoBoxes;

		gpchBsBingoCheckWins();
	}

	// Resize text to fit the boxes
	for (let i = 0; i < bsBoxesElements.length; i++) {
		// Initiall set a large font size, then decrease until text fits the
		// box.
		bsBoxesElements[i].childNodes[0].style.fontSize = '22px';
		let fontSize = 22;

		while (
			bsBoxesElements[i].childNodes[0].offsetWidth > bsBoxesElements[i].offsetWidth ||
			bsBoxesElements[i].childNodes[0].offsetHeight > bsBoxesElements[i].offsetHeight
		) {
			const style = window.getComputedStyle(bsBoxesElements[i].childNodes[0]).getPropertyValue('font-size');
			fontSize = parseFloat(style);

			bsBoxesElements[i].childNodes[0].style.fontSize = fontSize - 1 + 'px';
		}
	}

	bsFirewoks.style.display = 'none';
};

window.addEventListener('load', gpchBsBingoLoad);

window.addEventListener('resize', gpchBsBingoLoad);

const gpchBsBingoSwitchBoxes = function () {
	if (!this.classList.contains('won')) {
		this.classList.toggle('off');
		this.classList.toggle('on');

		const index = this.getAttribute('data-index');

		bsBoxes[index] = this.classList.contains('on');

		blockStorage.setItem('bsbingo', bsBoxes);
		gpchBsBingoCheckWins();
	}
};

const gpchBsBingoCheckWins = function () {
	let fullRows = 0;
	bsScore = 0;

	// check for completed rows
	for (let i = 0; i < 5; i++) {
		let isFull = true;

		for (let j = 0; j < 5; j++) {
			if (bsBoxes[i * 5 + j] === false) {
				isFull = false;
			} else {
				// a field is worth 1 point
				bsScore = bsScore + 1;
			}
		}

		if (isFull) {
			// a full row is worth 10 points
			bsScore = bsScore + 10;

			fullRows += 1;

			let isNewlyWon = false;

			for (let j = 0; j < 5; j++) {
				if (!bsBoxesElements[i * 5 + j].classList.contains('won')) {
					isNewlyWon = true;
				}
				bsBoxesElements[i * 5 + j].classList.add('won');
			}

			if (isNewlyWon) {
				gpchBsBingoHighlightRow(i);
			}
		}
	}

	// check for completed columns
	for (let i = 0; i < 5; i++) {
		let isFull = true;

		for (let j = 0; j < 5; j++) {
			if (bsBoxes[j * 5 + i] === false) {
				isFull = false;
			}
		}

		if (isFull) {
			// a full column is worth 10 points
			bsScore = bsScore + 10;

			let isNewlyWon = false;

			for (let j = 0; j < 5; j++) {
				if (!bsBoxesElements[j * 5 + i].classList.contains('won')) {
					isNewlyWon = true;
				}
				bsBoxesElements[j * 5 + i].classList.add('won');
			}

			if (isNewlyWon) {
				gpchBsBingoHighlightColumn(i);
			}
		}
	}

	// Overall win?
	if (fullRows === 5) {
		// a win is worth 100 points
		bsScore = bsScore + 100;

		// Dispatch ein event that can be used to extend funcitonality
		const bsBingoWinEvent = new Event('bsBingoWin', {
			bubbles: true,
			cancelable: true,
			composed: false,
		});

		const bsBingoBlock = document.querySelector('.wp-block-planet4-gpch-plugin-blocks-bs-bingo');

		bsBingoBlock.dispatchEvent(bsBingoWinEvent);

		// Show win animation
		bsFirewoks.style.display = 'block';
		gpchBsBingoWinAnimation();
	}

	// Update score
	document.getElementById('bs-bingo-score').innerText = bsScore;
};

for (let i = 0; i < bsBoxesElements.length; i++) {
	bsBoxesElements[i].addEventListener('click', gpchBsBingoSwitchBoxes, false);
}

const gpchBsBingoReset = function () {
	for (let i = 0; i < 25; i++) {
		bsBoxesElements[i].classList.remove('won');
		bsBoxesElements[i].classList.remove('on');
		bsBoxesElements[i].classList.add('off');
	}

	bsBoxes = Array(25).fill(false);

	blockStorage.setItem('bsbingo', bsBoxes);
};

const resetButton = document.getElementsByClassName('bsbingo-reset');
resetButton[0].addEventListener('click', gpchBsBingoReset, false);

const gpchBsBingoHighlightRow = function (line) {
	const start = line * 5;
	const el = [];

	for (let i = start; i < start + 5; i++) {
		el.push(bsBoxesElements[i]);
	}

	anime({
		targets: [el],
		keyframes: [{ scale: 1.1 }, { scale: 1 }],
		duration: 200,
		delay: anime.stagger(70),
		loop: false,
	});
};

const gpchBsBingoHighlightColumn = function (col) {
	const start = col;
	const el = [];

	for (let i = start; i < 25; i += 5) {
		el.push(bsBoxesElements[i]);
	}

	anime({
		targets: [el],
		keyframes: [{ scale: 1.1 }, { scale: 1 }],
		duration: 200,
		delay: anime.stagger(70),
		loop: false,
	});
};

const gpchBsBingoWinAnimation = function () {
	window.human = false;

	const canvasEl = document.querySelector('.fireworks');
	const ctx = canvasEl.getContext('2d');
	const numberOfParticules = 15;

	const colors = ['#FF0000', '#FF7F00', '#FFFF00', '#00FF00', '#0000FF', '#2E2B5F', '#8B00FF'];

	function setCanvasSize() {
		canvasEl.width = window.innerWidth * 2;
		canvasEl.height = window.innerHeight * 2;
		canvasEl.style.height = canvasEl.offsetWidth + 'px';

		canvasEl.getContext('2d').scale(2, 2);
	}

	function setParticuleDirection(p) {
		const angle = (anime.random(0, 360) * Math.PI) / 180;
		const value = anime.random(canvasEl.offsetWidth / 6, canvasEl.offsetWidth / 2);
		const radius = [-1, 1][anime.random(0, 1)] * value;
		return {
			x: p.x + radius * Math.cos(angle),
			y: p.y + radius * Math.sin(angle),
		};
	}

	function createParticule(x, y) {
		const p = {};
		p.x = x;
		p.y = y;
		p.color = colors[anime.random(0, colors.length - 1)];
		p.radius = anime.random(16, 32);
		p.endPos = setParticuleDirection(p);
		p.draw = function () {
			ctx.beginPath();
			ctx.arc(p.x, p.y, p.radius, 0, 2 * Math.PI, true);
			ctx.fillStyle = p.color;
			ctx.fill();
		};
		return p;
	}

	function renderParticule(anim) {
		for (let i = 0; i < anim.animatables.length; i++) {
			anim.animatables[i].target.draw();
		}
	}

	function animateParticules(x, y) {
		const particules = [];
		for (let i = 0; i < numberOfParticules; i++) {
			particules.push(createParticule(x, y));
		}
		anime.timeline().add({
			targets: particules,
			x(p) {
				return p.endPos.x;
			},
			y(p) {
				return p.endPos.y;
			},
			radius: 0.1,
			duration: anime.random(1200, 1800),
			easing: 'easeOutExpo',
			update: renderParticule,
		});
	}

	// render is used by anime.js
	// eslint-disable-next-line no-unused-vars
	const render = anime({
		duration: Infinity,
		update() {
			ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);
		},
	});

	const centerX = window.innerWidth / 2;
	const centerY = window.innerHeight / 2;

	let repeatFor = 20;

	function autoClick() {
		if (window.human) {
			return;
		}
		animateParticules(anime.random(centerX - 50, centerX + 50), anime.random(centerY - 50, centerY + 50));

		repeatFor--;
		if (repeatFor > 0) {
			anime({ duration: 200 }).finished.then(autoClick);
		} else {
			canvasEl.style.display = 'none';
		}
	}

	autoClick();
	setCanvasSize();
	window.addEventListener('resize', setCanvasSize, false);
};
