<?php

require P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'includes/Planet4_GPCH_Blocks_Dictionary_Table.php';


function gpch_cloud_block_admin_menu() {
	add_menu_page( 'Cloud Block Dictionary', 'Cloud Block Dictionary', 'manage_options', 'gpch-cloud-block-dictionary', 'gpch_cloud_block_render_dictionary_list' );
}

function gpch_cloud_block_render_dictionary_list() {
	$myListTable = new \Greenpeace\Planet4GPCHBlocks\Planet4_GPCH_Blocks_Dictionary_Table();
	$myListTable->add_plugin_admin_menu();
	$myListTable->load_word_list_table();
	/*
	echo '<div class="wrap"><h2>Block Dictionary</h2>';
	$myListTable->prepare_items();
	$myListTable->display();
	echo '</div>';
	*/
}


//$gpchBlocksDictionaryTable = new Planet4_GPCH_Blocks_Dictionary_Table();


