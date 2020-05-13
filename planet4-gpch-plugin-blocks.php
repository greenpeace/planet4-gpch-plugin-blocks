<?php
/**
 * Plugin Name: Planet4 GPCH Plugin Blocks
 * Plugin URI: https://github.com/greenpeace/planet4-gpch-plugin-blocks
 * Description: Provides Planet4 content blocks specific to Greenpeace Switzerland
 * Version: 0.1.27
 * License: MIT
 * Text Domain: planet4-gpch-blocks
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Constants
define( 'P4_GPCH_PLUGIN_BLOCKS_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'P4_GPCH_PLUGIN_BLOCKS_BASE_URL', plugin_dir_url( __FILE__ ) );

// Load translations
add_action( 'plugins_loaded', 'planet4_gpch_plugin_blocks_load_textdomain' );

function planet4_gpch_plugin_blocks_load_textdomain() {
	load_plugin_textdomain( 'planet4-gutenberg-blocks', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

// include the Composer autoload file
require P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'vendor/autoload.php';

// Initialize the actual plugin
$p4_gpch_plugin_blocks = Greenpeace\Planet4GPCHBlocks\Planet4_GPCH_Plugin_Blocks::get_instance();
