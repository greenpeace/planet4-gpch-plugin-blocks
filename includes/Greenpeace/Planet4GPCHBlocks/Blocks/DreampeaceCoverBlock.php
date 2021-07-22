<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;

/**
 * Dreampeace Cover Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class DreampeaceCoverBlock extends BaseBlock {

	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/dreampeace-cover.twig';


	/**
	 * Block name.
	 *
	 * @const string BLOCK_NAME.
	 */
	const BLOCK_NAME = 'dreampeace_cover';

	/**
	 * Block name including namespace.
	 *
	 * @const string FULL_BLOCK_NAME.
	 */
	const FULL_BLOCK_NAME = 'planet4-gpch-plugin-blocks/dreampeace-cover';


	public $block_attributes;


	/**
	 * Form Entries constructor.
	 */
	public function __construct() {
		$this->register_block();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );
	}


	/**
	 * Register Block.
	 */
	public function register_block() {
		register_block_type( self::FULL_BLOCK_NAME, [
			'apiVersion'      => 2,
			'editor_script'   => 'planet4-gpch-plugin-blocks',
			'render_callback' => [ $this, 'dynamic_render_callback' ],
			'attributes'      => [
				'text'          => [
					'type' => 'string',
				],
				'title'         => [
					'type' => 'string',
				],
				'noYear' => [
				    'type' => 'string',
				]
			]
		] );
	}


	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( self::FULL_BLOCK_NAME ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-dreampeace-cover',
				'blocks/dreampeaceCover.js',
				[ 'wp-element', 'wp-i18n' ],
				true,
				true
			);
		}
	}


	public function dynamic_render_callback( $block_attributes, $content ) {
		$this->block_attributes = $block_attributes;

		return \Timber::fetch( $this->template_file, $this->block_attributes );
	}
}
