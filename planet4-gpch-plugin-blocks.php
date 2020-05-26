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

// Include Admin Menu
require P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'includes/admin-menus.php';

// Initialize the actual plugin
$p4_gpch_plugin_blocks = Greenpeace\Planet4GPCHBlocks\Planet4_GPCH_Plugin_Blocks::get_instance();

// Activation hooks
register_activation_hook( __FILE__, 'gpch_plugin_blocks_db_install' );

// Other Hooks
add_action( 'admin_menu', 'gpch_cloud_block_admin_menu' );

/**
 * Installs the database tables needed
 */
function gpch_plugin_blocks_db_install() {
	global $wpdb;
	$gpchdict_db_version = '1.0';

	// Schema used for the dictionary of the word cloud block
	$table_name = $wpdb->prefix . "gpch_wordcloud_dictionary";

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
				id int(11) NOT NULL,
				language varchar(5) NOT NULL,
				confirmed tinyint(1) NOT NULL DEFAULT 0,
				blacklisted tinyint(1) NOT NULL DEFAULT 0,
				word varchar(32) NOT NULL,
				type varchar(8) NOT NULL
			) $charset_collate;
			ALTER TABLE $table_name
				ADD PRIMARY KEY (id),
				ADD KEY word (word);
			ALTER TABLE $table_name
				MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";

	// Apply DB Schema
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'gpchdict_db_version', $gpchdict_db_version );
}
