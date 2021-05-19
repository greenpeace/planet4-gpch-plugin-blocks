<?php

namespace Greenpeace\Planet4GPCHBlocks;

use Twilio\Rest\Client;

class Sms_Client {
	private $account_sid;
	private $auth_token;
	private $sender_number;

	/**
	 * Sms_Client constructor.
	 */
	public function __construct() {
		$child_options = get_option( 'gpch_child_options' );

		if ( $child_options !== false ) {
			$this->account_sid   = $child_options['gpch_child_field_twilio_sid'];
			$this->auth_token    = $child_options['gpch_child_field_twilio_auth'];
			$this->sender_number = $child_options['gpch_child_field_twilio_number'];
		}
	}

	public function sendSMS( $number, $message ) {
		// Validate the phone number
		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

		try {
			$swissNumberProto = $phoneUtil->parse( $number, "CH" );

			// Valid phone number?
			$isValid = $phoneUtil->isValidNumber( $swissNumberProto );
			if ( ! $isValid ) {
				throw new \Exception( __( 'Invalid phone number.', 'planet4-gpch-plugin-blocks' ) );
			}

			// Make sure it's a mobile number.
			$numberType = $phoneUtil->getNumberType( $swissNumberProto );
			if ( $numberType != \libphonenumber\PhoneNumberType::MOBILE ) {
				throw new \Exception( __( 'Only mobile numbers allowed.', 'planet4-gpch-plugin-blocks' ) );
			}

			// Only allow CH numbers
			$regionCode = $phoneUtil->getRegionCodeForNumber( $swissNumberProto );
			if ( $regionCode != 'CH' ) {
				throw new \Exception( __( 'Only Swiss phone number allowed.', 'planet4-gpch-plugin-blocks' ) );
			}

			// Format number
			$number = $phoneUtil->format( $swissNumberProto, \libphonenumber\PhoneNumberFormat::E164 );
		} catch ( \libphonenumber\NumberParseException $e ) {
			\Sentry\captureException( $e );

			return [
				'status' => 'error',
				'msg'    => $e->getMessage()
			];
		} catch ( \Exception $e ) {
			\Sentry\captureException( $e );

			return [
				'status' => 'error',
				'msg'    => $e->getMessage()
			];
		}

		// Validate the message
		// Max length 3 x 67 UCS-2 Characters = 201
		// See https://www.twilio.com/docs/glossary/what-is-gsm-7-character-encoding
		try {
			if ( strlen( $message ) > 201 ) {
				throw new \Exception( __( 'Text message is too long.', 'planet4-gpch-plugin-blocks' ) );
			}
		} catch ( \Exception $e ) {
			\Sentry\captureException( $e );

			return [
				'status' => 'error',
				'msg'    => $e->getMessage()
			];
		}

		$client = new Client( $this->account_sid, $this->auth_token );

		try {
			$message = $client->messages->create(
				$number,
				array(
					'from' => $this->sender_number,
					'body' => $message,
				)
			);
		} catch ( \Twilio\Exceptions\RestException $e ) {
			\Sentry\captureException( $e );

			return [
				'status' => 'error',
				'msg'    => __( 'SMS could not be sent. Try again later.', 'planet4-gpch-plugin-blocks' ),
			];
		}

		return [
			'status'        => 'success',
			'twilio_status' => $message->status
		];
	}
}
