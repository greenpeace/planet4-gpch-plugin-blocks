const { render } = wp.element;

const p2pElements = document.querySelectorAll(
	'.wp-block-planet4-gpch-plugin-blocks-p2p-share'
);

p2pElements.forEach( ( p2pElement, index ) => {
	const gpchP2PShareStep1 = function () {};

	render( <div className="test1">Das ist ein Test</div>, p2pElement );
} );

/*
const gpch_p2p_share_step1 = function () {

};

*/
