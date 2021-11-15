import apiFetch from '@wordpress/api-fetch';

/* global gpchBlocks */

const formEntriesElement = document.querySelector(
	'.wp-block-planet4-gpch-plugin-blocks-form_entries'
);

const formEntriesList = formEntriesElement.querySelector( ':scope ul' );

let inProgress = false;
let lastUpdate = formEntriesList.dataset.lastUpdate;

if ( formEntriesElement !== null ) {
	/* // Deactivated for now, needs optimization to ensure it doesn't cause a lot of load on the server
	window.setInterval( function () {
		if ( inProgress === false ) {
			inProgress = true;
			updateFormEntries();
			inProgress = false;
		}
	}, 5000 );
	 */
}

function flushCss( element ) {
	// By reading the offsetHeight property, we are forcing
	// the browser to flush the pending CSS changes (which it
	// does to ensure the value obtained is accurate).
	// eslint-disable-next-line no-unused-expressions
	element.offsetHeight;
}

function updateFormEntries() {
	// Remove old entries from the list
	const existingLines = formEntriesList.querySelectorAll( ':scope li' );
	const numberOfLines = formEntriesList.dataset.numberOfLines;

	for ( let i = 0; i < existingLines.length; i++ ) {
		if ( i >= numberOfLines ) {
			existingLines[ i ].remove();
		}
	}

	apiFetch( {
		path: gpchBlocks.restURL + 'gpchblockFormEntries/v1/update',
		method: 'POST',
		data: {
			postId: gpchBlocks.postID,
			lastUpdate,
		},
	} ).then( ( result ) => {
		if ( result.status === 'success' ) {
			for ( let i = 0; i < result.data.length; i++ ) {
				if ( i === 0 ) {
					lastUpdate = result.data[ i ].timestamp;
				}
				// Add the new line to the top of the list
				const newLine = result.data[ i ];

				const newLineElement = document.createElement( 'li' );
				newLineElement.innerHTML = newLine.line;

				formEntriesList.style.transition = 'top 0s';
				formEntriesList.style.top = '-1.5rem';
				flushCss( formEntriesList );

				formEntriesList.prepend( newLineElement );

				formEntriesList.style.transition = 'top .5s';
				formEntriesList.style.top = '0rem';
			}
		}
	} );
}
