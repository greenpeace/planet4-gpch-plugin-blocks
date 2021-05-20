<?php

namespace Greenpeace\Planet4GPCHBlocks;

/**
 * Asset Enqueuer.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 */
class AssetEnqueuer {
	public static function enqueue_js( $handle, $filename, $dependencies = [], $in_footer = false, $load_translations = false ) {
		$js = 'build/js/' . $filename;
		wp_enqueue_script( $handle,
			P4_GPCH_PLUGIN_BLOCKS_BASE_URL . $js,
			$dependencies,
			filemtime( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . $js ),
			$in_footer );

		if ( $load_translations ) {
			wp_set_script_translations( $handle, 'planet4-gpch-plugin-blocks', P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'languages' );
		}
	}
}
