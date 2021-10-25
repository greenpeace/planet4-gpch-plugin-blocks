<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class BaseFormBlock extends BaseBlock {
	/**
	 * Get the form entries count and/or number from global counter
	 *
	 * @param $fields
	 * @param false $count_actual_entries Count actual entries instead of using the entries count setting from the child theme.
	 *
	 * @return int
	 */
	public function get_numbers( $fields, $count_actual_entries = false ) {
		$sum = 0;

		// Global Counter
		if ( $fields['use_global_counter'] === true ) {
			$sum += $this->get_global_petition_counter_number( $fields['global_counter_url'], $fields['global_counter_json_key'] );
		}


		// Form Entry Counter
		if ( $fields['use_form_entry_counter'] === true ) {
			// IDs of forms to count entries
			$ids = explode( ',', $fields['form_ids'] );

			if ( $count_actual_entries ) {
				// Count form entries
				foreach ( $ids as $id ) {
					if ( is_numeric( $id ) ) {
						$counts = \GFFormsModel::get_form_counts( $id );

						$sum += $counts['total'] - $counts['trash'] - $counts['spam'];
					}
				}
			} else {
				// Use the counter field in the forms
				foreach ( $ids as $id ) {
					if ( is_numeric( $id ) ) {
						$form = \GFAPI::get_form( $id );

						if ( $form != false && array_key_exists( 'gpch_entry_counter', $form ) ) {
							$sum += $form['gpch_entry_counter'];
						}
					}
				}
			}
		}

		return $sum;
	}


	/**
	 * Retrieves the number of signatures from a global petition counter.
	 * Expects a JSON result
	 *
	 * @param $globalcounter_url
	 * @param $globalcounter_jsonkey
	 *
	 * @return int
	 */
	protected function get_global_petition_counter_number( $globalcounter_url, $globalcounter_jsonkey ) {
		// try cached value
		$counterResult = wp_cache_get( md5( $globalcounter_url ), 'global_counters' );

		// not in cache? get it from URL and write to cache
		if ( $counterResult === false ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_URL, $globalcounter_url );
			$result = curl_exec( $ch );
			curl_close( $ch );

			$obj           = json_decode( $result );
			$counterResult = (int) $obj->$globalcounter_jsonkey;

			// set the cache and define a timeout of 600 seconds
			wp_cache_set( md5( $globalcounter_url ), $counterResult, 'global_counters', 600 );
		}

		return $counterResult;
	}
}
