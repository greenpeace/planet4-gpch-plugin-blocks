const defaultConfig = require('./node_modules/@wordpress/scripts/config/webpack.config');    // Require default Webpack config
const path = require( 'path' )

const config = {}

var backendConfig = {
	...defaultConfig,
	
	entry: {
		// Gutenberg blocks
		index: './src/index.js',
	},
	
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: '[name].js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'build/js/admin' ),
	},
}


const frontendConfig = Object.assign({}, config, {
	entry: {
		// Frontend JS for blocks
		bsBingo: './src/blocks/BSBingo/BSBingoBlock-frontend.js'
	},
	
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: '[name].js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'build/js/blocks' ),
	},
});


// Export the config object.
module.exports = [backendConfig, frontendConfig]

