<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class BaseBlock {

	/**
	 * Block name.
	 *
	 * @const string BLOCK_NAME.
	 */
	const BLOCK_NAME = '';

	/**
	 * Block name including namespace.
	 *
	 * @const string FULL_BLOCK_NAME.
	 */
	const FULL_BLOCK_NAME = '';


	/**
	 * Outputs an error message
	 *
	 * @param $message
	 */
	public function render_error_message( $message ) {
		// ensure only editors see the error, not visitors to the website
		if ( current_user_can( 'edit_posts' ) ) {
			\Timber::render( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/block-error-message.twig', array(
				'category' => __( 'Error', 'planet4_gpch_blocks' ),
				'message'  => $message,
			) );
		}
	}


	/**
	 * Returns the first block of type $block_name in a post/page
	 *
	 * @param $block_name
	 * @param $postID
	 *
	 * @return false|mixed
	 */
	protected function get_first_block_in_post( $block_name, $postID ) {
		$post = get_post( $postID );

		if ( $post !== null && has_blocks( $post->post_content ) ) {
			$blocks = parse_blocks( $post->post_content );

			$found_blocks = self::find_block( $blocks, $block_name );

			if ( array_key_exists( 0, $found_blocks ) ) {
				return $found_blocks[0];
			}
		}

		return false;
	}

	/**
	 * Recursively finds blocks in parse_blocks output of page content.
	 *
	 * @param $blocks
	 *
	 * @return array
	 */
	static function find_block( $blocks, $block_name ) {
		$list = array();

		foreach ( $blocks as $block ) {
			if ( $block_name === $block['blockName'] ) {
				// add current item, if it's a heading block
				$list[] = $block;
			} elseif ( ! empty( $block['innerBlocks'] ) ) {
				// or call the function recursively, to find heading blocks in inner blocks
				$list = array_merge( $list, self::find_block( $block['innerBlocks'], $block_name ) );
			}
		}

		return $list;
	}



	/**
	 * Grab default values of parameters because Wordpress doesn't by default
	 */
	protected function fill_in_default_atrributes() {
		$block_registry = \WP_Block_Type_Registry::get_instance();
		$block          = $block_registry->get_registered( static::FULL_BLOCK_NAME );

		foreach ( $block->attributes as $name => $parameters ) {
			if ( array_key_exists( 'default', $parameters ) ) {
				if ( ! isset( $this->block_attributes[ $name ] ) ) {
					$this->block_attributes[ $name ] = $parameters['default'];
				}
			}
		}
	}
}
