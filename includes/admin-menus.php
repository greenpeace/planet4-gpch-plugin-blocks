<?php

function gpch_cloud_block_admin_menu() {
	add_menu_page( 'Cloud Block Dictionary', 'Cloud Block Dictionary', 'edit_pages', 'gpch-cloud-block-dictionary', 'gpch_cloud_block_render_dictionary_list', 'dashicons-cloud' );
}

function gpch_cloud_block_render_dictionary_list() {
	$myListTable = new \Greenpeace\Planet4GPCHBlocks\DictionaryTable();
	$myListTable->add_plugin_admin_menu();
	$myListTable->load_word_list_table();
}


