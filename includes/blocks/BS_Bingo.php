<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

/**
 * BS Bingo Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class BS_Bingo_Block extends Planet4_GPCH_Base_Block {

	/**
	 * Block name.
	 *
	 * @const string BLOCK_NAME.
	 */
	const BLOCK_NAME = 'bs_bingo';

	/**
	 * BS Bingo constructor.
	 */
	public function __construct() {
		$this->register_block();
	}

	/**
	 * Register Block.
	 */
	function register_block() {
		register_block_type( 'planet4-gpch-plugin-blocks/bs-bingo', [
			'apiVersion'    => 2,
			'editor_script' => 'planet4-gpch-plugin-blocks',
		] );

	}
}