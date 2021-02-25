<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;

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

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );
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

	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( 'planet4-gpch-plugin-blocks/bs-bingo' ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-bs-bingo',
				'blocks/bsBingo.js',
				array(),
				true
			);
		}
	}
}