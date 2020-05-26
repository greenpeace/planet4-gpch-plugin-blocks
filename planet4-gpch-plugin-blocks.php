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
register_activation_hook( __FILE__, 'gpch_plugin_blocks_db_insert_data' );

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

/**
 * Installs the base dictionary used for the cloud.
 */
function gpch_plugin_blocks_db_insert_data() {
	global $wpdb;

	$table_name = $wpdb->prefix . "gpch_wordcloud_dictionary";

	// Only run if the table is empty
	$dictionary_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
	var_dump($dictionary_count);

	if ( $dictionary_count == 0 ) {
		$file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . "/data/wordcloud-dictionary-de.csv";

		$file_handler = fopen( $file, "r" );
		$j = 0;

		// The file might be too big to import all at once. Let's read 1000 lines at a time.
		while ( ! feof( $file_handler ) ) {
			$format = '(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\')';
			$sql    = 'INSERT INTO ' . $table_name . ' (language, confirmed, blacklisted, word, type) VALUES ';

			// Combine 1000 lines, because using wpdb->insert() for each line separately takes too much time
			for ( $i = 0; $i < 1000 && ! feof( $file_handler ); $i ++ ) {
				$entry = fgetcsv( $file_handler );

				$sql .= sprintf( $format, addslashes($entry[0]), addslashes($entry[1]), addslashes($entry[2]), addslashes($entry[3]), addslashes($entry[4]) ) . ", ";
			}

			// cleanup trailing comma
			$sql = rtrim( $sql, ", " ) . ';';

			$wpdb->query( $sql );
		}

		fclose( $file_handler );
	}
}