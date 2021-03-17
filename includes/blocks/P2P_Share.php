<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;

/**
 * P2P Share Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class P2P_Share_Block extends Planet4_GPCH_Base_Block {

	/**
	 * Block name.
	 *
	 * @const string BLOCK_NAME.
	 */
	const BLOCK_NAME = 'p2p_share';

	/**
	 * P2P Share constructor.
	 */
	public function __construct() {
		$this->register_block();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );
	}

	/**
	 * Register Block.
	 */
	function register_block() {
		register_block_type( 'planet4-gpch-plugin-blocks/p2p-share', [
			'apiVersion'    => 2,
			'editor_script' => 'planet4-gpch-plugin-blocks',
		] );
	}

	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( 'planet4-gpch-plugin-blocks/p2p-share' ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-p2p-share',
				'blocks/p2pShare.js',
				array(),
				true
			);
		}
	}
}