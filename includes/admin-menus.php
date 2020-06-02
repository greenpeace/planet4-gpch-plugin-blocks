<?php

// Dictionary table for the word cloud
require P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'includes/admin-pages/Planet4_GPCH_Blocks_Dictionary_Table.php';

function gpch_cloud_block_admin_menu() {
	add_menu_page( 'Cloud Block Dictionary', 'Cloud Block Dictionary', 'edit_pages', 'gpch-cloud-block-dictionary', 'gpch_cloud_block_render_dictionary_list', 'dashicons-cloud' );
}

function gpch_cloud_block_render_dictionary_list() {
	$myListTable = new \Greenpeace\Planet4GPCHBlocks\Planet4_GPCH_Blocks_Dictionary_Table();
	$myListTable->add_plugin_admin_menu();
	$myListTable->load_word_list_table();
}


