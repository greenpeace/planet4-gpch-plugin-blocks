//const validate = require( 'validate.js' );
import {
	parsePhoneNumber,
	AsYouType,
	isPossiblePhoneNumber,
	isValidPhoneNumber,
} from 'libphonenumber-js/mobile';
import apiFetch from '@wordpress/api-fetch';

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

// Copy to clipboard buttons
const clipboardButtons = p2pShareElement.querySelectorAll(
	':scope .controls .copy-to-clipboard'
);

clipboardButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const textField = document.getElementById(
			event.target.dataset.copyField
		);

		textField.select();
		const result = document.execCommand( 'copy' );

		if ( result !== false ) {
			event.target.innerText = '👍 Copied!';
		}
	} );
} );

// Send by SMS
const smsButtons = p2pShareElement.querySelectorAll(
	':scope .controls .send-sms'
);

smsButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const numberField = document.getElementById(
			event.target.dataset.mobileNumberField
		);

		let phoneNumber;

		try {
			phoneNumber = parsePhoneNumber( numberField.value, 'CH' );

			if ( phoneNumber === undefined || ! phoneNumber.isValid() ) {
				throw 'Invalid phone number.';
			}
		} catch ( e ) {
			event.target
				.closest( '.option' )
				.querySelector( ':scope .status.error' )
				.classList.remove( 'hidden' );

			return;
		}

		console.log( phoneNumber.number );

		// Hide error message
		event.target
			.closest( '.option' )
			.querySelector( ':scope .status.error' )
			.classList.add( 'hidden' );

		// Send SMS
		apiFetch.use( apiFetch.createNonceMiddleware( gpchBlocks.restNonce ) );
		apiFetch( {
			path: gpchBlocks.restURL + 'gpchblockP2p/v1/sendSMS',
			method: 'POST',
			data: {
				phone: phoneNumber.number,
			},
		} ).then( ( res ) => {
			console.log( res );
		} );
	} );
} );
