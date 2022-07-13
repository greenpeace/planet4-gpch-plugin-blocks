<?php

namespace Greenpeace\Planet4GPCHBlocks;

class RaiseNowAPI {
	private $user;
	private $pass;
	private $apiUrl;

	public function __construct() {
		$child_options = get_option( 'gpch_child_options' );

		if ( $child_options !== false ) {
			$this->user   = $child_options['gpch_child_field_raisenow_user'];
			$this->pass   = $child_options['gpch_child_field_raisenow_pass'];
			$this->apiUrl = $child_options['gpch_child_field_raisenow_url'];
		}
	}

	public function getStats( $terms ) {
		$parameters = [
			'lang'             => 'en',
			'records_per_page' => 1,
			'filters'          => [
				[
					'field_name' => 'last_status',
					'type'       => 'term',
					'value'      => 'final_success',
				],
				[
					'field_name' => 'test_mode',
					'type'       => 'term',
					'value'      => 'production',
				],
				[
					'field_name' => 'refund',
					'type'       => 'term',
					'value'      => 'false',
				]
			],
			'facets'           => [
				[
					'name'       => 'amounts',
					'field_name' => 'amount',
					'type'       => 'stats',
				]
			],
		];

		if ( array_key_exists( 'purpose', $terms ) && ! empty( $terms['purpose'] ) ) {
			$parameters['filters'][] = [
				'field_name' => 'stored_rnw_purpose_text',
				'type'       => 'fulltext',
				'value'      => $terms['purpose'],
			];
		}

		if ( array_key_exists( 'merchant_config_identifier', $terms ) && ! empty( $terms['merchant_config_identifier'] ) ) {
			$parameters['filters'][] = [
				'field_name' => 'merchant_config_identifier',
				'type'       => 'term',
				'value'      => $terms['merchant_config_identifier'],
			];
		}

		if ( array_key_exists( 'stored_campaign_id', $terms ) && ! empty( $terms['stored_campaign_id'] ) ) {
			$parameters['filters'][] = [
				'field_name' => 'stored_campaign_id',
				'type'       => 'term',
				'value'      => $terms['stored_campaign_id'],
			];
		}

		if ( array_key_exists( 'date_from', $terms ) && array_key_exists( 'date_to', $terms ) && ! empty( $terms['date_from'] ) && ! empty( $terms['date_to'] ) ) {
			$parameters['filters'][] = [
				'field_name' => 'created',
				'type'       => 'date_range',
				'from'       => $terms['date_from'],
				'to'         => $terms['date_to'],
			];
		}

		$url = $this->apiUrl . "?" . http_build_query( $parameters );

		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $curl, CURLOPT_USERPWD, $this->user . ":" . $this->pass );

		curl_setopt( $curl, CURLOPT_URL, $url );

		$result = curl_exec( $curl );

		$httpcode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

		curl_close( $curl );


		if ( $httpcode == 200 && $result !== false ) {
			$result = json_decode( $result );

			return [
				'total' => $result->result->facets[0]->stats->total,
				'count' => $result->result->facets[0]->stats->count,
				'min'   => $result->result->facets[0]->stats->min,
				'max'   => $result->result->facets[0]->stats->max,
				'mean'  => $result->result->facets[0]->stats->mean,
			];
		} else {
			return false;
		}
	}
}
