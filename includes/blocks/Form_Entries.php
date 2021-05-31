<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\AssetEnqueuer;

/**
 * Form Entries Block Class.
 *
 * @package Greenpeace\Planet4GPCHBlocks
 * @since 1.0
 */
class Form_Entries_Block extends Planet4_GPCH_Base_Block {

	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/form_entries.twig';


	/**
	 * Block name.
	 *
	 * @const string BLOCK_NAME.
	 */
	const BLOCK_NAME = 'form_entries';

	/**
	 * Block name including namespace.
	 *
	 * @const string FULL_BLOCK_NAME.
	 */
	const FULL_BLOCK_NAME = 'planet4-gpch-plugin-blocks/form-entries';


	public $block_attributes;


	/**
	 * Form Entries constructor.
	 */
	public function __construct() {
		$this->register_block();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_if_block_is_present' ] );

		add_action( 'rest_api_init', function () {
			register_rest_route( 'gpchblockFormEntries/v1', '/update', array(
				'methods'             => 'POST',
				'callback'            => [ $this, 'restAPI_get_update' ],
				'permission_callback' => '__return_true',
			) );
		} );
	}


	/**
	 * Register Block.
	 */
	function register_block() {
		register_block_type( self::FULL_BLOCK_NAME, [
			'apiVersion'      => 2,
			'editor_script'   => 'planet4-gpch-plugin-blocks',
			'render_callback' => [ $this, 'dynamic_render_callback' ],
			'attributes'      => [
				'formId'          => [
					'type' => 'integer',
				],
				'fieldId'         => [
					'type' => 'integer',
				],
				'numberOfEntries' => [
					'type'    => 'integer',
					'default' => 4,
				],
				'text'            => [
					'type'    => 'string',
					'default' => __(
						'FIELD_VALUE has signed TIME_AGO.',
						'planet4-gpch-plugin-blocks'
					),
				],
			]
		] );
	}


	function dynamic_render_callback( $block_attributes, $content ) {
		$this->block_attributes = $block_attributes;

		if ( array_key_exists( 'formId', $block_attributes ) && array_key_exists( 'fieldId', $block_attributes ) ) {
			$form_entries = $this->get_entries( $block_attributes['formId'], $block_attributes['fieldId'], $block_attributes['numberOfEntries'] );

			$lines = $this->prepareLines( $block_attributes['text'], $form_entries );

			$lastUpdate = $form_entries[0]['timestamp'];

			// Prepare parameters for template
			$params = array(
				'attributes'  => $block_attributes,
				'lines'       => $lines,
				'lastUpdate'  => $lastUpdate,
				'styleHeight' => $block_attributes['numberOfEntries'] * 1.5,
			);

			// Output template
			return \Timber::fetch( $this->template_file, $params );
		} else {
			return '<p style="color: red;">Missing content block configuration</p>';
		}
	}


	/**
	 * Prepare one line of text to output
	 *
	 * @param $text
	 * @param $form_entries
	 *
	 * @return array
	 */
	private function prepareLines( $text, $form_entries ) {
		$lines = [];

		foreach ( $form_entries as $form_entry ) {
			$line = $text;

			// Replace placeholders
			$line = $email_text = str_replace( 'TIME_AGO', $form_entry['date'], $line );
			$line = $email_text = str_replace( 'FIELD_VALUE', $form_entry['field'], $line );

			$lines[] = ucfirst( $line );
		}

		return $lines;
	}


	/**
	 * Enqueue assets
	 */
	public function enqueue_if_block_is_present() {
		if ( has_block( self::FULL_BLOCK_NAME ) ) {
			AssetEnqueuer::enqueue_js(
				'planet4-gpch-blocks-form-entries',
				'blocks/formEntries.js',
				[ 'wp-element', 'wp-i18n' ],
				true,
				false
			);
		}
	}

	/**
	 * Get entries from the specified forms
	 *
	 * @param $form_id
	 * @param $form_field
	 * @param $number
	 *
	 * @return array
	 */
	public function get_entries( $form_id, $form_field, $number ) {
		$search_criteria['status'] = 'active';
		$paging                    = array( 'offset' => 0, 'page_size' => $number );

		$entries = \GFAPI::get_entries( $form_id, $search_criteria, null, $paging );

		$results = [];
		foreach ( $entries as $entry ) {
			$results[] = [
				'date'      => $this->time_elapsed_string( $entry['date_created'] ),
				'timestamp' => strtotime( $entry['date_created'] ),
				'field'     => $entry[ $form_field ]
			];
		}

		return $results;
	}

	/**
	 * Print a string in "2 minutes ago" format
	 *
	 * @param $datetime
	 * @param false $full
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function time_elapsed_string( $datetime, $full = false ) {
		$now  = new \DateTime;
		$ago  = new \DateTime( $datetime );
		$diff = $now->diff( $ago );

		$diff->w = floor( $diff->d / 7 );
		$diff->d -= $diff->w * 7;

		// Strings
		$strings       = [
			'y' => __( 'year', 'planet4-gpch-plugin-blocks' ),
			'm' => __( 'month', 'planet4-gpch-plugin-blocks' ),
			'w' => __( 'week', 'planet4-gpch-plugin-blocks' ),
			'd' => __( 'day', 'planet4-gpch-plugin-blocks' ),
			'h' => __( 'hour', 'planet4-gpch-plugin-blocks' ),
			'i' => __( 'minute', 'planet4-gpch-plugin-blocks' ),
			's' => __( 'second', 'planet4-gpch-plugin-blocks' ),
		];
		$pluralStrings = [
			'y' => __( 'years', 'planet4-gpch-plugin-blocks' ),
			'm' => __( 'months', 'planet4-gpch-plugin-blocks' ),
			'w' => __( 'weeks', 'planet4-gpch-plugin-blocks' ),
			'd' => __( 'days', 'planet4-gpch-plugin-blocks' ),
			'h' => __( 'hours', 'planet4-gpch-plugin-blocks' ),
			'i' => __( 'minutes', 'planet4-gpch-plugin-blocks' ),
			's' => __( 'seconds', 'planet4-gpch-plugin-blocks' ),
		];
		$preText       = __( 'PRE_TEXT', 'planet4-gpch-plugin-blocks' );
		$postText      = __( 'ago', 'planet4-gpch-plugin-blocks' );

		// PRE_TEXT is only a placeholder for translation. Remove it if it isn't translated
		if ( $preText == 'PRE_TEXT' ) {
			$preText = '';
		}

		foreach ( $strings as $k => &$v ) {
			if ( $diff->$k ) {
				$v = $diff->$k . ' ' . ( $diff->$k > 1 ? $pluralStrings[ $k ] : $v );
			} else {
				unset( $strings[ $k ] );
			}
		}

		if ( ! $full ) {
			$strings = array_slice( $strings, 0, 1 );
		}

		return $strings ? $preText . ' ' . implode( ', ', $strings ) . ' ' . $postText : __( 'just now', 'planet4-gpch-plugin-blocks' );
	}


	/**
	 * Rest API endpoint to get updated form entries
	 *
	 * @param $data
	 */
	public function restAPI_get_update( $data ) {
		$channel = $data['channel'];

		$block = $this->get_first_block_in_post( self::FULL_BLOCK_NAME, $data['postId'] );

		$this->block_attributes = $block['attrs'];
		$this->fill_in_default_atrributes();

		$form_entries = $this->get_entries( $this->block_attributes['formId'], $this->block_attributes['fieldId'], 1 );

		// Remove entries that were already retrieved
		for ( $i = 0; $i < sizeof( $form_entries ); $i ++ ) {
			if ( $form_entries[ $i ]['timestamp'] <= $data['lastUpdate'] ) {
				unset( $form_entries[ $i ] );
			}
		}

		$data = [];
		foreach ( $form_entries as $entry ) {
			$lines  = $this->prepareLines( $this->block_attributes['text'], array( $entry ) );
			$data[] = [
				'line'      => $lines[0],
				'timestamp' => $entry['timestamp'],
			];
		}

		$response = [
			'status' => 'success',
			'data'   => $data,
		];

		echo json_encode( $response );
		die;
	}

}
