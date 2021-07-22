const dreampeaceCoverBlockElement = document.querySelector(
	'.gpch-plugin-blocks-dreampeace-cover'
);

const inputElement = dreampeaceCoverBlockElement.querySelector(
	':scope .cover-input'
);

const buttonElement = dreampeaceCoverBlockElement.querySelector(
	':scope .cover-search-button'
);

buttonElement.addEventListener( 'click', () => {
	openSlide( inputElement.value );
} );

inputElement.addEventListener( 'keyup', function ( event ) {
	event.preventDefault();

	// Enter key
	if ( event.keyCode === 13 ) {
		openSlide( inputElement.value );
	}
} );

const slideElements = document.querySelectorAll(
	'.gpch-plugin-blocks-dreampeace-slide'
);

const slideNotFoundElement = dreampeaceCoverBlockElement.querySelector(
	'.error-no-slide'
);
const slideNotFoundYearElement = slideNotFoundElement.querySelector(
	'.error-year'
);

function openSlide( year ) {
	let slideFound = false;

	slideElements.forEach( function ( item ) {
		if ( item.dataset.year === year ) {
			item.classList.remove( 'hidden', 'opacity0' );
			slideNotFoundElement.style.display = 'none';
			item.scrollIntoView( true );
			slideFound = true;
		} else {
			item.classList.add( 'hidden', 'opacity0' );
		}
	} );

	if ( ! slideFound ) {
		slideNotFoundYearElement.innerHTML = year;
		slideNotFoundElement.style.display = 'block';
		slideNotFoundElement.scrollIntoView( true );
	}
}
