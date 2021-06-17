<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;
use Greenpeace\Planet4GPCHBlocks\SmsClient;
use PHPLicengine\Api\Api;
use PHPLicengine\Service\Bitlink;

/**
 * P2P Share Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class P2PShareBlock extends BaseBlock {
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
	 * Block name including namespace.
	 *
	 * @const string FULL_BLOCK_NAME.
	 */
	const FULL_BLOCK_NAME = 'planet4-gpch-plugin-blocks/p2p-share';

	private $bitly_token;

	public $block_attributes;

	private $postID;

	/**
	 * P2P Share constructor.
	 */
	public function __construct() {
		$this->register_block();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );

		$child_options = get_option( 'gpch_child_options' );

		if ( $child_options !== false && array_key_exists( 'gpch_child_field_bitly_token', $child_options ) ) {
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
				'step1Title'     => [
					'type'    => 'string',
					'default' => __(
						'How many people can you motivate to also sign the petition?',
						'planet4-gpch-plugin-blocks'
					),
				],
				'step2Title'     => [
					'type'    => 'string',
					'default' => __(
						'How will you be able to reach your friends best?',
						'planet4-gpch-plugin-blocks'
					),
				],
				'shareText'      => [
					'type'    => 'string',
					'default' => __(
						'I just signed this petition, it\'s a very important topic. Click here to sign it also: ',
						'planet4-gpch-plugin-blocks'
					),
				],
				'whatsAppSmsCTA' => [
					'type'    => 'string',
					'default' => __(
						'Thank you for sharing on WhatsApp! Click this link, you will be able to edit the message before sending it: ',
						'planet4-gpch-plugin-blocks'
					),
				],
				'telegramSmsCTA' => [
					'type'    => 'string',
					'default' => __(
						'Thank you for sharing on Telegram! Click this link, you will be able to edit the message before sending it: ',
						'planet4-gpch-plugin-blocks'
					),
				],
				'emailSubject'   => [
					'type'    => 'string',
					'default' => __(
						'Help by also signing this petition!',
						'planet4-gpch-plugin-blocks'
					),
				],
				'emailText'      => [
					'type'    => 'string',
					'default' => __(
						'Hi, I just signed this petition. Can I ask you to sign it too? CTA_LINK',
						'planet4-gpch-plugin-blocks'
					),
				],
				'smsMessage'     => [
					'type'    => 'string',
					'default' => __(
						'Thank you for sharing by SMS! Please copy the following message and send it to your friends.',
						'planet4-gpch-plugin-blocks'
					),
				],
				'signalMessage'  => [
					'type'    => 'string',
					'default' => __(
						'Thank you for sharing on Signal! Please copy the following message and send it to your friends.',
						'planet4-gpch-plugin-blocks'
					),
				],
				'threemaMessage' => [
					'type'    => 'string',
					'default' => __(
						'Thank you for sharing on Threema! Please copy the following message and send it to your friends.',
						'planet4-gpch-plugin-blocks'
					),
				],
				'utmMedium'      => [
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
			'telegramLink'    => $this->generate_telegram_share_link( $this->get_shortened_link( $block_attributes['shareLink']['url'], 'telegram', true ), $this->get_share_message( 'telegram' ) ),
			'smsMessage'      => $this->get_share_message( 'sms' ),
			'signalMessage'   => $this->get_share_message( 'signal' ),
			'threemaMessage'  => $this->get_share_message( 'threema' ),
			'threemaAppLink'  => $this->generate_threema_share_link( $this->get_share_message( 'threema' ) ),
		);

		// Output template
		return \Timber::fetch( $this->template_file, $params );
	}

	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( 'planet4-gpch-plugin-blocks/p2p-share' ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-p2p-share',
				'blocks/p2pShare.js',
				[ 'wp-element', 'wp-i18n' ],
				true,
				true
			);
		}
	}

	/**
	 * Rest API endpoint to send CTA SMS
	 *
	 * @param $data
	 */
	public function restAPI_send_sms( $data ) {
		$channel = $data['channel'];

		$block = $this->get_first_block_in_post( self::FULL_BLOCK_NAME, $data['postId'] );

		$this->block_attributes = $block['attrs'];
		$this->fill_in_default_atrributes();

		try {
			if ( $channel == 'sms' || $channel == 'signal' || $channel == 'threema' ) { // Channels that need two separate SMS
				$relatedBlockAttributes = [
					'sms'     => 'smsMessage',
					'signal'  => 'signalMessage',
					'threema' => 'threemaMessage',
				];

				// Get messages
				if ( isset( $this->block_attributes[ $relatedBlockAttributes[ $channel ] ] ) && $this->block_attributes[ $relatedBlockAttributes[ $channel ] ] != null ) {
					$message_sms_1 = __( $this->block_attributes[ $relatedBlockAttributes[ $channel ] ], 'planet4-gpch-plugin-blocks' );
				}

				$message_sms_2 = $this->get_share_message( $channel, true );

				if ( ! isset( $message_sms_1 ) || ! isset( $message_sms_2 ) ) {
					throw new \Exception( 'Text messages are not defined.' );
				}

				// Send first message
				$sms1   = new SmsClient();
				$result = $sms1->sendSMS( $data['phone'], $message_sms_1 );

				if ( $result['status'] == 'error' ) {
					throw new \Exception( $result['msg'] );
				}

				// Send second message
				$sms2   = new SmsClient();
				$result = $sms2->sendSMS( $data['phone'], $message_sms_2 );

				if ( $result['status'] == 'error' ) {
					throw new \Exception( $result['msg'] );
				}
			} elseif ( ( $channel == 'whatsapp' || $channel == 'telegram' ) ) { // Channels that get sent a CTA link in a single SMS
				$relatedBlockAttributes = [
					'whatsapp' => 'whatsAppSmsCTA',
					'telegram' => 'telegramSmsCTA',
				];

				// Get messages
				if ( isset( $this->block_attributes[ $relatedBlockAttributes[ $channel ] ] ) && $this->block_attributes[ $relatedBlockAttributes[ $channel ] ] != null ) {

					if ( $channel == 'whatsapp' ) {
						$share_link = $this->generate_whatsapp_share_link( $this->get_share_message( $channel ) );
					} elseif ( $channel == 'telegram' ) {
						$share_link = $this->generate_telegram_share_link( $this->block_attributes['shareLink']['url'], $this->get_share_message( $channel ) );
					}

					$share_link_shortened = $this->get_shortened_link( $share_link, $channel, false );

					$message = __( $this->block_attributes[ $relatedBlockAttributes[ $channel ] ], 'planet4-gpch-plugin-blocks' ) . ' ' . $share_link_shortened;

					if ( ! isset( $message ) ) {
						throw new \Exception( 'Text message for ' . $channel . ' is not defined.' );
					}

					// Send SMS
					$sms    = new SmsClient();
					$result = $sms->sendSMS( $data['phone'], $message );

					if ( $result['status'] == 'error' ) {
						throw new \Exception( $result['msg'] );
					}
				}
			} else {
				throw new \Exception( 'Unknown channel.' );
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

	/**
	 * Rest API endpoint to send CTA email
	 *
	 * @param $data
	 */
	public function restAPI_send_email( $data ) {
		$block = $this->get_first_block_in_post( self::FULL_BLOCK_NAME, $data['postId'] );

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
				throw new \Exception( __( 'Invalid email address', 'planet4-gpch-plugin-blocks' ) );
			}

			// Replace CTA_LINK in email text
			$link = $this->block_attributes['shareLink'];
			if ( $link !== null ) {
				$cta_link = $this->get_shortened_link( $link['url'], 'email' );
			} else {
				$cta_link = '';
			}

			$email_text = str_replace( 'CTA_LINK', $cta_link, $email_text );

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

	/**
	 * Get the share message including the link with appropriate UTM tags for the channel.
	 *
	 * @param $channel
	 *
	 * @return string
	 * @throws \Exception
	 */
	private function get_share_message( $channel, $shortVersion = false ) {
		if ( $shortVersion ) {
			$text = $this->block_attributes['shareTextShort'];
		} else {
			$text = $this->block_attributes['shareText'];
		}

		if ( array_key_exists( 'shareLink', $this->block_attributes ) ) {
			$link = $this->block_attributes['shareLink'];
		} else {
			$link = null;
		}

		if ( $link !== null ) {
			$link = $this->get_shortened_link( $link['url'], $channel );
		} else {
			$link = '';
		}

		return $text . ' ' . $link;
	}

	/**
	 * Generates a share link for WhatsApp
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private function generate_whatsapp_share_link( $text ) {
		// See https://faq.whatsapp.com/general/chats/how-to-use-click-to-chat
		return 'https://wa.me/?text=' . urlencode( $text );
	}

	/**
	 * Generates a share link for Threema
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private function generate_threema_share_link( $text ) {
		return 'threema://compose?text=' . urlencode( $text );
	}


	/**
	 * Generates a share link for Telegram
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private function generate_telegram_share_link( $url, $text ) {
		return 'https://t.me/share/url?url=' . rawurlencode( $this->get_shortened_link( $url, 'telegram', false ) ) . '&text=' . rawurlencode( $text );
	}

	/**
	 * Adds UTM parameters to a link
	 *
	 * @param $url
	 * @param $channel
	 *
	 * @return string
	 */
	private function create_utm_link( $url, $channel ) {
		$parameters = [
			'utm_medium'   => $this->block_attributes['utmMedium'],
			'utm_campaign' => ( isset( $this->block_attributes['utmCampaign'] ) ) ? $this->block_attributes['utmCampaign'] : 'GreenpeaceWebsite',
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
}
