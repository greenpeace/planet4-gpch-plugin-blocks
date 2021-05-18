//const validate = require( 'validate.js' );
import { parsePhoneNumber } from 'libphonenumber-js/mobile';
import apiFetch from '@wordpress/api-fetch';

const p2pShareElement = document.querySelector(
	'.wp-block-planet4-gpch-plugin-blocks-p2p-share'
);

const p2pStepElements = p2pShareElement.querySelectorAll(
	':scope .p2p-share-step'
);

// Hide form steps
p2pStepElements.forEach( ( item ) => {
	item.classList.add( 'hidden' );
} );
document.querySelector( '.p2p-share-step-1' ).classList.remove( 'hidden' );

// Resize parent element to max child height
function setParentHeight() {
	let maxHeight = 0;

	p2pStepElements.forEach( ( item ) => {
		if ( item.offsetHeight > maxHeight ) {
			maxHeight = item.offsetHeight;
		}
	} );

	p2pShareElement.style.height = maxHeight;
}
window.onresize = setParentHeight;
window.onload = setParentHeight;

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

			const elementToShow = document.querySelector( nextElementSelector );

			event.target
				.closest( '.p2p-share-step' )
				.classList.add( 'hidden', 'prev' );
			elementToShow.style.visibility = 'visible';
			elementToShow.classList.remove( 'hidden' );
		} catch ( e ) {}
	} );
} );

// Radio fields auto forward to next step
const radioForwardFields = p2pShareElement.querySelectorAll(
	':scope input.autoforward'
);

radioForwardFields.forEach( ( item ) => {
	item.addEventListener( 'change', ( event ) => {
		const nextElementSelector = event.target.getAttribute(
			'data-next-element'
		);

		if ( nextElementSelector !== null ) {
			const elementToShow = document.querySelector( nextElementSelector );

			event.target
				.closest( '.p2p-share-step' )
				.classList.add( 'hidden', 'prev' );
			elementToShow.style.visibility = 'visible';
			elementToShow.classList.remove( 'hidden' );
		}
	} );
	// Add the same functionality to the label
	item.nextElementSibling.addEventListener( 'click', ( event ) => {
		const nextElementSelector = event.currentTarget.previousElementSibling.getAttribute(
			'data-next-element'
		);

		if ( nextElementSelector !== null ) {
			const elementToShow = document.querySelector( nextElementSelector );

			event.currentTarget.previousElementSibling
				.closest( '.p2p-share-step' )
				.classList.add( 'hidden', 'prev' );
			elementToShow.style.visibility = 'visible';
			elementToShow.classList.remove( 'hidden' );
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
		prevStep[ 0 ].classList.remove( 'hidden', 'prev' );
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

		event.target.disabled = true;

		const defaultStateElements = event.target.querySelectorAll(
			':scope .state-default'
		);
		const progressStateElements = event.target.querySelectorAll(
			':scope .state-progress'
		);
		const doneStateElements = event.target.querySelectorAll(
			':scope .state-done'
		);

		defaultStateElements.forEach( ( item ) => {
			item.classList.add( 'hidden' );
		} );
		progressStateElements.forEach( ( item ) => {
			item.classList.remove( 'hidden' );
		} );

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
		/* global gpchBlocks */
		apiFetch.use( apiFetch.createNonceMiddleware( gpchBlocks.restNonce ) );
		apiFetch( {
			path: gpchBlocks.restURL + 'gpchblockP2p/v1/sendSMS',
			method: 'POST',
			data: {
				phone: phoneNumber.number,
				channel,
				postId: gpchBlocks.postID,
			},
		} ).then(
			( result ) => {
				if ( result.status === 'success' ) {
					statusElement.innerText =
						'Your message was sent. Check your phone!';
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Disable button to prevent multiple messages to be sent.
					event.target.disabled = true;

					// Change button state
					progressStateElements.forEach( ( item ) => {
						item.classList.add( 'hidden' );
					} );
					doneStateElements.forEach( ( item ) => {
						item.classList.remove( 'hidden' );
					} );
				} else if ( result.status === 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );

					// Change button state
					progressStateElements.forEach( ( item ) => {
						item.classList.add( 'hidden' );
					} );
					defaultStateElements.forEach( ( item ) => {
						item.classList.remove( 'hidden' );
					} );
				}
			},
			() => {
				statusElement.innerText =
					'Application error. Please try again later.';
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );

				// Change button state
				progressStateElements.forEach( ( item ) => {
					item.classList.add( 'hidden' );
				} );
				defaultStateElements.forEach( ( item ) => {
					item.classList.remove( 'hidden' );
				} );
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

		const emailAddress = emailField.value;

		// Hide error message
		statusElement.classList.add( 'hidden' );

		// Send Email
		apiFetch.use( apiFetch.createNonceMiddleware( gpchBlocks.restNonce ) );
		apiFetch( {
			path: gpchBlocks.restURL + 'gpchblockP2p/v1/sendEmail',
			method: 'POST',
			data: {
				email: emailAddress,
				channel,
				postId: gpchBlocks.postID,
			},
		} ).then(
			( result ) => {
				if ( result.status === 'success' ) {
					statusElement.innerText =
						'Your message was sent. Check your email!';
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Disable button to prevent multiple messages to be sent.
					// event.target.classList.add( 'hidden' );
				} else if ( result.status === 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );
				}
			},
			() => {
				statusElement.innerText =
					'Application error. Please try again later.';
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );
			}
		);
	} );
} );
