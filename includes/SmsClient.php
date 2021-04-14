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

		if ($child_options !== false) {
			$this->account_sid = $child_options['gpch_child_field_twilio_sid'];
			$this->auth_token = $child_options['gpch_child_field_twilio_auth'];
			$this->sender_number = $child_options['gpch_child_field_twilio_number'];
		}
	}

	public function sendSMS($number, $message) {
		$client = new Client($this->account_sid, $this->auth_token);
	}


}