<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;
use Greenpeace\Planet4GPCHBlocks\Sms_Client;

/**
 * P2P Share Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class P2P_Share_Block extends Planet4_GPCH_Base_Block {

	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/p2p-share.twig';


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

		add_action( 'rest_api_init', function () {
			register_rest_route( 'gpchblockP2p/v1', '/sendSms', array(
				'methods'             => 'POST',
				'callback'            => [ $this, 'restAPI_send_sms' ],
				'permission_callback' => '__return_true',
			) );
		} );

	}

	/**
	 * Register Block.
	 */
	function register_block() {
		register_block_type( 'planet4-gpch-plugin-blocks/p2p-share', [
			'apiVersion'      => 2,
			'editor_script'   => 'planet4-gpch-plugin-blocks',
			'render_callback' => [ $this, 'dynamic_render_callback' ],
		] );
	}

	function dynamic_render_callback( $block_attributes, $content ) {
		// Prepare parameters for template
		$params = array(
			'base_url' => P4_GPCH_PLUGIN_BLOCKS_BASE_URL,
		);

		// Output template
		return \Timber::fetch( $this->template_file, $params );


		return sprintf(
			'<div class="wp-block-planet4-gpch-plugin-blocks-p2p-share">%1$s</div>',
			esc_html( get_the_title() )
		);
	}

	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( 'planet4-gpch-plugin-blocks/p2p-share' ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-p2p-share',
				'blocks/p2pShare.js',
				[ 'wp-element' ],
				true
			);
		}
	}

	public function restAPI_send_sms( $data ) {
		// Validate phone number
		$sms    = new Sms_Client();
		$result = $sms->sendSMS( $data['phone'], 'This is a test.' );

		$response = array(
			'status' => $result['status'],
			'data'   => array(
				'number_sent' => $data['phone'],
			)
		);

		if ( isset ( $result['msg'] ) ) {
			$response['msg'] = $result['msg'];
		}

		echo json_encode( $response );
		die;
	}
}