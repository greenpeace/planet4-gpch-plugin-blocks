<?php

namespace Greenpeace\Planet4GPCHBlocks;

/**
 * BS Bingo Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 */
class AssetEnqueuer {
	public static function enqueue_js( $handle, $filename, $dependencies = [], $in_footer = false ) {
		$js = 'assets/js/' . $filename;

		wp_enqueue_script( $handle,
			P4_GPCH_PLUGIN_BLOCKS_BASE_URL . $js,
			$dependencies,
			filemtime( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . $js ),
			$in_footer );
	}
}
