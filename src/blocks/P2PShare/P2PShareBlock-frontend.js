import { parsePhoneNumber } from 'libphonenumber-js/mobile';
import apiFetch from '@wordpress/api-fetch';

const { __ } = wp.i18n;

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
function setParentHeight( upsizeOnly = false ) {
	let maxHeight = 0;
	const currentHeight = p2pShareElement.offsetHeight;

	p2pStepElements.forEach( ( item ) => {
		if ( item.offsetHeight > maxHeight ) {
			maxHeight = item.offsetHeight;
		}
	} );

	if ( ! upsizeOnly || maxHeight > currentHeight ) {
		p2pShareElement.style.minHeight = maxHeight + 'px';
	}
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
			event.target.innerText = __(
				'👍 Copied!',
				'planet4-gpch-plugin-blocks'
			);
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

		const sendButton = event.currentTarget;

		// Disable button
		sendButton.disabled = true;

		const defaultStateElements = sendButton.querySelectorAll(
			':scope .state-default'
		);
		const progressStateElements = sendButton.querySelectorAll(
			':scope .state-progress'
		);
		// Kept here for better readability
		// eslint-disable-next-line @wordpress/no-unused-vars-before-return
		const doneStateElements = sendButton.querySelectorAll(
			':scope .state-done'
		);

		defaultStateElements.forEach( ( item2 ) => {
			item2.classList.add( 'hidden' );
		} );
		progressStateElements.forEach( ( item2 ) => {
			item2.classList.remove( 'hidden' );
		} );

		const channel = sendButton.dataset.channel;
		const numberField = document.getElementById(
			sendButton.dataset.mobileNumberField
		);
		const statusElement = sendButton
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
			statusElement.innerText = __(
				'Please use a valid Swiss mobile number.',
				'planet4-gpch-plugin-blocks'
			);

			// Reenable button
			sendButton.disabled = false;

			// Change button state
			progressStateElements.forEach( ( item2 ) => {
				item2.classList.add( 'hidden' );
			} );
			defaultStateElements.forEach( ( item2 ) => {
				item2.classList.remove( 'hidden' );
			} );

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
					statusElement.innerText = __(
						'Your message was sent. Check your phone!',
						'planet4-gpch-plugin-blocks'
					);
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Change button state
					progressStateElements.forEach( ( item2 ) => {
						item2.classList.add( 'hidden' );
					} );
					doneStateElements.forEach( ( item2 ) => {
						item2.classList.remove( 'hidden' );
					} );

					setParentHeight( true );
				} else if ( result.status === 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );

					// Reenable button
					sendButton.disabled = false;

					// Change button state
					progressStateElements.forEach( ( item2 ) => {
						item2.classList.add( 'hidden' );
					} );
					defaultStateElements.forEach( ( item2 ) => {
						item2.classList.remove( 'hidden' );
					} );

					setParentHeight( true );
				}
			},
			() => {
				statusElement.innerText = __(
					'Application error. Please try again later.',
					'planet4-gpch-plugin-blocks'
				);
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );

				// Reenable button
				sendButton.disabled = false;

				// Change button state
				progressStateElements.forEach( ( item2 ) => {
					item2.classList.add( 'hidden' );
				} );
				defaultStateElements.forEach( ( item2 ) => {
					item2.classList.remove( 'hidden' );
				} );

				setParentHeight( true );
			}
		);
	} );
} );

// Listen to enter key press in sms fields
const smsInputFields = p2pShareElement.querySelectorAll(
	':scope .phone-number-field'
);

smsInputFields.forEach( ( item ) => {
	item.addEventListener( 'keyup', function ( event ) {
		event.preventDefault();

		// Enter key
		if ( event.keyCode === 13 ) {
			item.parentNode.querySelector( ':scope button.send-sms' ).click();
		}
	} );
} );

// Listen to enter key press in email fields
const emailInputFields = p2pShareElement.querySelectorAll(
	':scope .email-field'
);

emailInputFields.forEach( ( item ) => {
	item.addEventListener( 'keyup', function ( event ) {
		event.preventDefault();

		// Enter key
		if ( event.keyCode === 13 ) {
			item.parentNode.querySelector( ':scope button.send-email' ).click();
		}
	} );
} );

// Send by email
const emailButtons = p2pShareElement.querySelectorAll(
	':scope .controls .send-email'
);

emailButtons.forEach( ( item ) => {
	item.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		const sendButton = event.currentTarget;

		// Disable button
		sendButton.disabled = true;

		const defaultStateElements = sendButton.querySelectorAll(
			':scope .state-default'
		);
		const progressStateElements = sendButton.querySelectorAll(
			':scope .state-progress'
		);
		// Kept here for better readability
		// eslint-disable-next-line @wordpress/no-unused-vars-before-return
		const doneStateElements = sendButton.querySelectorAll(
			':scope .state-done'
		);

		defaultStateElements.forEach( ( item2 ) => {
			item2.classList.add( 'hidden' );
		} );
		progressStateElements.forEach( ( item2 ) => {
			item2.classList.remove( 'hidden' );
		} );

		const channel = sendButton.dataset.channel;
		const emailField = document.getElementById(
			sendButton.dataset.emailField
		);
		const statusElement = sendButton
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
					statusElement.innerText = __(
						'Your message was sent. Check your email!',
						'planet4-gpch-plugin-blocks'
					);
					statusElement.classList.remove( 'hidden', 'error' );
					statusElement.classList.add( 'success' );

					// Change button state
					progressStateElements.forEach( ( item2 ) => {
						item2.classList.add( 'hidden' );
					} );
					doneStateElements.forEach( ( item2 ) => {
						item2.classList.remove( 'hidden' );
					} );

					setParentHeight( true );
				} else if ( result.status === 'error' ) {
					statusElement.innerText = result.data.msg;
					statusElement.classList.remove( 'hidden', 'success' );
					statusElement.classList.add( 'error' );

					// Reenable button
					sendButton.disabled = false;

					// Change button state
					progressStateElements.forEach( ( item2 ) => {
						item2.classList.add( 'hidden' );
					} );
					defaultStateElements.forEach( ( item2 ) => {
						item2.classList.remove( 'hidden' );
					} );

					setParentHeight( true );
				}
			},
			() => {
				statusElement.innerText = __(
					'Application error. Please try again later.',
					'planet4-gpch-plugin-blocks'
				);
				statusElement.classList.remove( 'hidden', 'success' );
				statusElement.classList.add( 'error' );

				// Reenable button
				sendButton.disabled = false;

				// Change button state
				progressStateElements.forEach( ( item2 ) => {
					item2.classList.add( 'hidden' );
				} );
				defaultStateElements.forEach( ( item2 ) => {
					item2.classList.remove( 'hidden' );
				} );

				setParentHeight( true );
			}
		);
	} );
} );
