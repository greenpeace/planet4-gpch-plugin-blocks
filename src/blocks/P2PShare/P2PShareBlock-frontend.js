const validate = require( 'validate.js' );

const constraints = {};

const p2pShareElement = document.querySelector(
	'.wp-block-planet4-gpch-plugin-blocks-p2p-share'
);

const p2pStepElements = p2pShareElement.querySelectorAll(
	':scope .p2p-share-step'
);

/*
Temporary hide
 */
p2pStepElements.forEach( ( item ) => {
	item.classList.add( 'hidden' );
} );
document.querySelector( '.p2p-share-step-1' ).classList.remove( 'hidden' );
/*
End temporary hide
 */

// Next button events
const nextButtons = p2pShareElement.querySelectorAll(
	':scope .controls .next'
);

nextButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const fieldToValidate = event.target.getAttribute(
			'data-next-step-field'
		);

		try {
			const selectedField = document.querySelector(
				'input[name="' + fieldToValidate + '"]:checked'
			);

			const nextElementSelector = selectedField.getAttribute(
				'data-next-element'
			);
			const nextFieldValue = selectedField.value;

			const elementToShow = document.querySelector( nextElementSelector );

			event.target.closest( '.p2p-share-step' ).classList.add( 'hidden' );
			elementToShow.classList.remove( 'hidden' );
		} catch ( e ) {
			console.log( e );
			return;
		}
	} );
} );

// Back button events
const backButtons = p2pShareElement.querySelectorAll(
	':scope .controls .previous'
);

backButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const previousElementSelector = event.target.getAttribute(
			'data-previous-element'
		);

		const prevStep = p2pShareElement.querySelectorAll(
			':scope ' + previousElementSelector
		);

		event.target.closest( '.p2p-share-step' ).classList.add( 'hidden' );
		prevStep[ 0 ].classList.remove( 'hidden' );
	} );
} );

/*
import { P2PShare } from './P2PShareComponent';

const { render } = wp.element;

const p2pElements = document.querySelectorAll(
	'.wp-block-planet4-gpch-plugin-blocks-p2p-share'
);

p2pElements.forEach( ( p2pElement ) => {
	const texts = {
		text1: 'This is text 1',
	};

	render( <P2PShare attributes={ texts } />, p2pElement );
} );
*/
