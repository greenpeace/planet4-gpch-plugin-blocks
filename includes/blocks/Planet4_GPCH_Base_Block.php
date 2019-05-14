<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Base_Block' ) ) {
	class Planet4_GPCH_Base_Block {
		/**
		 * Outputs an error message
		 *
		 * @param $message
		 */
		public function render_error_message( $message ) {
			// ensure only editors see the error, not visitors to the website
			if ( current_user_can( 'edit_posts' ) ) {
				\Timber::render( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/block-error-message.twig', array(
					'category' => __('Error', 'planet4_gpch_blocks'),
					'message' => $message,
				) );
			}
		}
	}
}