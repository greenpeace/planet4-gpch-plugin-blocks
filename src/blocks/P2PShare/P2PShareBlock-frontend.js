//const validate = require( 'validate.js' );
import { parsePhoneNumber } from 'libphonenumber-js/mobile';
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

		const channel = event.target.dataset.channel;
		const numberField = document.getElementById(
			event.target.dataset.mobileNumberField
		);
		const statusElement = event.target
			.closest( '.option' )
			.querySelector( ':scope .status' );

		let phoneNumber;

		try {
			phoneNumber = parsePhoneNumber( numberField.value, 'CH' );

			if ( phoneNumber === undefined || ! phoneNumber.isValid() ) {
				throw 'Invalid phone number.';
			}
		} catch ( e ) {
			statusElement.classList.remove( 'hidden', 'success' );
			statusElement.classList.add( 'error' );
			statusElement.innerText = 'Please use a valid Swiss mobile number.';

			return;
		}

		// Hide error message
		statusElement.classList.add( 'hidden' );

		// Send SMS
		apiFetch.use( apiFetch.createNonceMiddleware( gpchBlocks.restNonce ) );
		apiFetch( {
			path: gpchBlocks.restURL + 'gpchblockP2p/v1/sendSMS',
			method: 'POST',
			data: {
				phone: phoneNumber.number,
				channel: channel,
				postId: gpchBlocks.postID,
			},
		} ).then(
			( result ) => {
				if ( result.status == 'success' ) {
					statusElement.innerText =
						'Your message was sent. Check your phone!';
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Disable button to prevent multiple messages to be sent.
					// event.target.classList.add( 'hidden' );
				} else if ( result.status == 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );
				}
			},
			( result ) => {
				statusElement.innerText =
					'Application error. Please try again later.';
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );
			}
		);
	} );
} );

// Send by email
const emailButtons = p2pShareElement.querySelectorAll(
	':scope .controls .send-email'
);

emailButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const channel = event.target.dataset.channel;
		const emailField = document.getElementById(
			event.target.dataset.emailField
		);
		const statusElement = event.target
			.closest( '.option' )
			.querySelector( ':scope .status' );

		let emailAddress = emailField.value;

		// Hide error message
		statusElement.classList.add( 'hidden' );

		// Send Email
		apiFetch.use( apiFetch.createNonceMiddleware( gpchBlocks.restNonce ) );
		apiFetch( {
			path: gpchBlocks.restURL + 'gpchblockP2p/v1/sendEmail',
			method: 'POST',
			data: {
				email: emailAddress,
				channel: channel,
				postId: gpchBlocks.postID,
			},
		} ).then(
			( result ) => {
				if ( result.status == 'success' ) {
					statusElement.innerText =
						'Your message was sent. Check your email!';
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Disable button to prevent multiple messages to be sent.
					// event.target.classList.add( 'hidden' );
				} else if ( result.status == 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );
				}
			},
			( result ) => {
				statusElement.innerText =
					'Application error. Please try again later.';
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );
			}
		);
	} );
} );
