import waitForElementTransition from 'wait-for-element-transition';
import 'swiped-events';

const dreampeaceSlideElements = document.querySelectorAll(
	'.gpch-plugin-blocks-dreampeace-slide'
);

dreampeaceSlideElements.forEach( ( item ) => {
	item.classList.add( 'hidden', 'opacity0' );
} );

for ( let i = 0; i < dreampeaceSlideElements.length; i++ ) {
	const prevButton = dreampeaceSlideElements[ i ].querySelector(
		':scope .prev-button'
	);
	const nextButton = dreampeaceSlideElements[ i ].querySelector(
		':scope .next-button'
	);

	// Previous slide
	if ( dreampeaceSlideElements[ i - 1 ] !== undefined ) {
		prevButton.addEventListener( 'click', () => {
			changeDreampeaceSlide(
				dreampeaceSlideElements[ i ],
				dreampeaceSlideElements[ i - 1 ]
			);
		} );

		dreampeaceSlideElements[ i ].addEventListener(
			'swiped-right',
			function () {
				changeDreampeaceSlide(
					dreampeaceSlideElements[ i ],
					dreampeaceSlideElements[ i - 1 ]
				);
			}
		);
	} else {
		prevButton.style.visibility = 'hidden';
	}

	// Next slide
	if ( dreampeaceSlideElements[ i + 1 ] !== undefined ) {
		nextButton.addEventListener( 'click', () => {
			changeDreampeaceSlide(
				dreampeaceSlideElements[ i ],
				dreampeaceSlideElements[ i + 1 ]
			);
		} );

		dreampeaceSlideElements[ i ].addEventListener(
			'swiped-left',
			function () {
				changeDreampeaceSlide(
					dreampeaceSlideElements[ i ],
					dreampeaceSlideElements[ i + 1 ]
				);
			}
		);
	} else {
		nextButton.style.display = 'none';
	}
}

function changeDreampeaceSlide( currentSlide, nextSlide ) {
	currentSlide.classList.add( 'opacity0' );
	waitForElementTransition( currentSlide ).then( () => {
		currentSlide.classList.add( 'hidden' );

		nextSlide.classList.remove( 'hidden' );
		nextSlide.classList.remove( 'opacity0' );
	} );
}
