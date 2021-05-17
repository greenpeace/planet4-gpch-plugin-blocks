<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;
use Greenpeace\Planet4GPCHBlocks\Sms_Client;
use PHPLicengine\Api\Api;
use PHPLicengine\Service\Bitlink;

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

	private $bitly_token;

	private $block_attributes;

	private $postID;

	/**
	 * P2P Share constructor.
	 */
	public function __construct() {
		$this->register_block();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );

		$child_options = get_option( 'gpch_child_options' );

		if ( $child_options !== false ) {
			$this->bitly_token = $child_options['gpch_child_field_bitly_token'];
		}

		add_action( 'rest_api_init', function () {
			register_rest_route( 'gpchblockP2p/v1', '/sendSms', array(
				'methods'             => 'POST',
				'callback'            => [ $this, 'restAPI_send_sms' ],
				'permission_callback' => '__return_true',
			) );
		} );

		add_action( 'rest_api_init', function () {
			register_rest_route( 'gpchblockP2p/v1', '/sendEmail', array(
				'methods'             => 'POST',
				'callback'            => [ $this, 'restAPI_send_email' ],
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
			// Attributes with default values need to have them set server side
			'attributes'      => [
				'step1Title' => [
					'type'    => 'string',
					'default' => __(
						'How many people can you motivate to also sign the petition?',
						'planet4-gpch-blocks'
					),
				],
				'step2Title' => [
					'type'    => 'string',
					'default' => __(
						'How will you be able to reach your friends best?',
						'planet4-gpch-blocks'
					),
				],
				'utmMedium'  => [
					'type'    => 'string',
					'default' => 'p2p',
				],
			]
		] );
	}

	function dynamic_render_callback( $block_attributes, $content ) {
		$this->block_attributes = $block_attributes;

		// Prepare parameters for template
		$params = array(
			'base_url'        => P4_GPCH_PLUGIN_BLOCKS_BASE_URL,
			'attributes'      => $block_attributes,
			'whatsAppMessage' => $this->get_share_message( 'whatsapp' ),
			'whatsAppLink'    => $this->generate_whatsapp_share_link( $this->get_share_message( 'whatsapp' ) ),
			'smsMessage'      => $this->get_share_message( 'sms' ),
			'signalMessage'   => $this->get_share_message( 'signal' ),
			'threemaMessage'  => $this->get_share_message( 'threema' ),
			'threemaAppLink'  => $this->generate_threeema_share_link( $this->get_share_message( 'threema' ) ),
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
		$channel = $data['channel'];

		$block                  = $this->get_first_p2p_block_in_post( $data['postId'] );
		$this->block_attributes = $block['attrs'];
		$this->fill_in_default_atrributes();

		try {
			if ( $channel == 'sms' ) {
				// Get messages
				if ( isset( $this->block_attributes['smsMessage'] ) && $this->block_attributes['smsMessage'] != null ) {
					$message_sms_1 = $this->block_attributes['smsMessage'];
				}

				$message_sms_2 = $this->get_share_message( 'sms' );

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
			} elseif ( $channel == 'whatsapp' ) {
				// Get messages
				if ( isset( $this->block_attributes['whatsAppSmsCTA'] ) && $this->block_attributes['whatsAppSmsCTA'] != null ) {
					$whatsapp_share_link = $this->generate_whatsapp_share_link(
						$this->get_share_message( 'whatsapp' ),
						'whatsapp-sms',
						false );

					$whatsapp_share_link_shortened = $this->get_shortened_link( $whatsapp_share_link, 'whatsapp', false );

					$message_whatsapp = $this->block_attributes['whatsAppSmsCTA'] . ' ' . $whatsapp_share_link_shortened;
				}

				if ( ! isset( $message_whatsapp ) ) {
					throw new \Exception( 'Text message for WhatsApp is not defined.' );
				}

				// Send SMS
				$sms    = new Sms_Client();
				$result = $sms->sendSMS( $data['phone'], $message_whatsapp );

				if ( $result['status'] == 'error' ) {
					throw new \Exception( $result['msg'] );
				}
			} elseif ( $channel == 'signal' ) {
				// Get messages
				if ( isset( $this->block_attributes['signalMessage'] ) && $this->block_attributes['signalMessage'] != null ) {
					$message_signal_1 = $this->block_attributes['signalMessage'];
				}

				$message_signal_2 = $this->get_share_message( 'signal' );

				if ( ! isset( $message_signal_1 ) || ! isset( $message_signal_2 ) ) {
					throw new \Exception( 'Signal messages are not defined.' );
				}

				// Send first message
				$sms1   = new Sms_Client();
				$result = $sms1->sendSMS( $data['phone'], $message_signal_1 );

				if ( $result['status'] == 'error' ) {
					throw new \Exception( $result['msg'] );
				}

				// Send second message
				$sms2   = new Sms_Client();
				$result = $sms2->sendSMS( $data['phone'], $message_signal_2 );


				if ( $result['status'] == 'error' ) {
					throw new \Exception( $result['msg'] );
				}
			}
		} catch ( \Exception $e ) {
			\Sentry\captureException( $e );

			$response = array(
				'status' => 'error',
				'data'   => array(
					'msg' => $e->getMessage(),
				)
			);

			echo json_encode( $response );
			die;
		}


		$response = [ 'status' => 'success' ];

		echo json_encode( $response );
		die;
	}


	public function restAPI_send_email( $data ) {
		$block                  = $this->get_first_p2p_block_in_post( $data['postId'] );
		$this->block_attributes = $block['attrs'];
		$this->fill_in_default_atrributes();

		try {
			if ( isset( $this->block_attributes['emailText'] ) && $this->block_attributes['emailText'] != null ) {
				$email_text = $this->block_attributes['emailText'];
			}

			if ( isset( $this->block_attributes['emailSubject'] ) && $this->block_attributes['emailSubject'] != null ) {
				$email_subject = $this->block_attributes['emailSubject'];
			}

			if ( ! isset( $email_text ) || ! isset( $email_subject ) ) {
				throw new \Exception( 'Email text and/or subject is not defined' );
			}

			if ( ! filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) ) {
				throw new \Exception( 'Invalid email address' );
			}

			// Send email
			$result = wp_mail( $data['email'], $email_subject, $email_text );
			if ( $result === false ) {
				throw new \Exception( 'Email could not be sent.' );
			}
		} catch ( \Exception $e ) {
			\Sentry\captureException( $e );

			$response = array(
				'status' => 'error',
				'data'   => array(
					'msg' => $e->getMessage(),
				)
			);

			echo json_encode( $response );
			die;
		}

		$response = [ 'status' => 'success' ];

		echo json_encode( $response );
		die;
	}

	private function get_share_message( $channel ) {
		$text = $this->block_attributes['shareText'];
		$link = $this->block_attributes['shareLink'];

		$link = $this->get_shortened_link( $link['url'], $channel );

		return $text . ' ' . $link;
	}

	private function generate_whatsapp_share_link( $text ) {
		// See https://faq.whatsapp.com/general/chats/how-to-use-click-to-chat
		return 'https://wa.me/?text=' . urlencode( $text );
	}

	private function generate_threeema_share_link( $text ) {
		return 'threema://compose?text=' . urlencode( $text );
	}

	/**
	 * Creates a link with UTM parameters
	 *
	 * @param $url
	 * @param $channel
	 * @param $postID
	 *
	 * @return string
	 */
	private function create_utm_link( $url, $channel ) {
		$parameters = [
			'utm_medium'   => $this->block_attributes['utmMedium'],
			'utm_campaign' => $this->block_attributes['utmCampaign'],
			'utm_source'   => $channel,
		];

		return $url . "?" . http_build_query( $parameters );
	}

	/**
	 * Getter for shortened links. Checks page meta for already generated shortlinks, otherwise shortens link.
	 *
	 * @param $url
	 * @param $channel
	 * @param $postID
	 * @param bool $use_utm_tags
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	private function get_shortened_link( $url, $channel, $use_utm_tags = true ) {
		if ( $use_utm_tags ) {
			$url = $this->create_utm_link( $url, $channel );
		}

		$postID = get_the_ID();

		$meta_key = 'gpch_p2p_shortlink_' . md5( $url . $channel . $postID );

		$link = get_post_meta( $postID, $meta_key, true );

		if ( empty( $link ) || $link === false ) {
			$link = $this->shorten_link( $url );

			update_post_meta( $postID, $meta_key, $link );

			return $link;
		} else {
			return $link;
		}
	}


	/**
	 * Uses Bitly to shorten links
	 *
	 * @param $link
	 *
	 * @return mixed
	 */
	private function shorten_link( $link ) {
		try {
			$api     = new Api( $this->bitly_token );
			$bitlink = new Bitlink( $api );
			$result  = $bitlink->createBitlink( [ 'long_url' => $link ] );

			if ( $api->isCurlError() ) {
				print( $api->getCurlErrno() . ': ' . $api->getCurlError() );
			} else {
				// if Bitly response contains error message.
				if ( $result->isError() ) {
					throw new \Exception( $result->getResponse() . ': ' . $result->getDescription() );
				} else {
					// if Bitly response is 200 or 201
					if ( $result->isSuccess() ) {
						$response = $result->getResponseArray();

						return $response['link'];
					} else {
						throw new \Exception( $result->getResponse() );
					}
				}
			}
		} catch ( \Exception $e ) {
			\Sentry\captureException( $e );

			return $link;
		}
	}

	/**
	 * Returns the first P2P block in a post/page
	 *
	 * @param $postID
	 *
	 * @return false|mixed
	 */
	private function get_first_p2p_block_in_post( $postID ) {
		$post = get_post( $postID );

		if ( has_blocks( $post->post_content ) ) {
			$blocks = parse_blocks( $post->post_content );
			foreach ( $blocks as $block ) {
				if ( $block['blockName'] == 'planet4-gpch-plugin-blocks/p2p-share' ) {
					return $block;
				}
			}
		}

		return false;
	}

	/**
	 * Grab default values of parameters because Wordpress doesn't
	 */
	private function fill_in_default_atrributes() {
		$block_registry = \WP_Block_Type_Registry::get_instance();
		$p2pBlock       = $block_registry->get_registered( 'planet4-gpch-plugin-blocks/p2p-share' );


		foreach ( $p2pBlock->attributes as $name => $parameters ) {
			if ( array_key_exists( 'default', $parameters ) ) {
				if ( ! isset( $this->block_attributes[ $name ] ) ) {
					$this->block_attributes[ $name ] = $parameters['default'];
				}
			}
		}
	}
}