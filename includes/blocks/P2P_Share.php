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
			'base_url'   => P4_GPCH_PLUGIN_BLOCKS_BASE_URL,
			'attributes' => $block_attributes,
			'whatsAppLink' => $this->generate_whats_app_share_link($block_attributes['whatsAppShareText'])
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
		$post = get_post( $data['postId'] );
		$channel = $data['channel'];

		if ( has_blocks( $post->post_content ) ) {
			$blocks = parse_blocks( $post->post_content );

			try {
				foreach ( $blocks as $block ) {
					if ( $block['blockName'] == 'planet4-gpch-plugin-blocks/p2p-share' ) {
						if ( isset( $block['attrs']['smsMessage'] ) && $block['attrs']['smsMessage'] != null ) {
							$message_sms_1 = $block['attrs']['smsMessage'];
						}

						if ( isset( $block['attrs']['smsShareText'] ) && $block['attrs']['smsShareText'] != null ) {
							$message_sms_2 = $block['attrs']['smsShareText'];
						}

						if ( isset( $block['attrs']['whatsAppSmsText'] ) && $block['attrs']['whatsAppSmsText'] != null ) {
							$message_whatsapp = $block['attrs']['whatsAppSmsText'];
						}

						break;
					}
				}

				if ($channel == 'sms') {
					if ( ! isset( $message_sms_1 ) || ! isset( $message_sms_2 ) ) {
						throw new \Exception( 'Text messages are not defined.' );
					}

					// Send first message
					$sms1   = new Sms_Client();
					$result = $sms1->sendSMS( $data['phone'], $message_sms_1 );

					if ( $result['status'] == 'error' ) {
						throw new \Exception( $result['msg'] );
					}

					// Send second message
					$sms2   = new Sms_Client();
					$result = $sms2->sendSMS( $data['phone'], $message_sms_2 );


					if ( $result['status'] == 'error' ) {
						throw new \Exception( $result['msg'] );
					}
				}
				elseif ($channel == 'whatsapp') {
					if ( ! isset( $message_whatsapp ) ) {
						throw new \Exception( 'Text message for WhatsApp is not defined.' );
					}

					// Send first message
					$sms   = new Sms_Client();
					$result = $sms->sendSMS( $data['phone'], $message_whatsapp );

					if ( $result['status'] == 'error' ) {
						throw new \Exception( $result['msg'] );
					}
				}
			} catch ( \Exception $e ) {
				$response = array(
					'status' => 'error',
					'data'   => array(
						'msg' => $e->getMessage(),
					)
				);

				echo json_encode( $response );
				die;
			}
		}

		$response = [ 'status' => 'success' ];

		echo json_encode( $response );
		die;
	}

	private function generate_whats_app_share_link($text) {
		// See https://faq.whatsapp.com/general/chats/how-to-use-click-to-chat
		return 'https://wa.me/?text=' . urlencode($text);
	}
}