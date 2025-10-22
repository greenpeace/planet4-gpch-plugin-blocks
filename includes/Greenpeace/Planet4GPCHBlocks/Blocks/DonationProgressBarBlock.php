<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Greenpeace\Planet4GPCHBlocks\RaiseNowAPI;
use NumberFormatter;
use Timber\Timber;

class DonationProgressBarBlock extends BaseBlock {
	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/donation_progress_bar.twig';


	public function __construct() {
		$this->register_acf_field_group();

		add_action( 'acf/init', array( $this, 'register_acf_block' ) );
	}


	/**
	 * Registers a field group with Advanced Custom Fields
	 */
	protected function register_acf_field_group() {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group( array(
				'key'                   => 'group_p4_gpch_blocks_donation_progress_bar',
				'title'                 => 'Form progress bar',
				'fields'                => array(
					array(
						'key'               => 'field_p4_gpch_blocks_show',
						'label'             => __( 'Use for progress', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'show',
						'type'              => 'select',
						'instructions'      => __( 'Use the donated amount or the numbers of donations for the progress bar.', 'planet4-gpch-plugin-blocks' ),
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'amount' => 'Amount donated',
							'count'  => 'Number of donations',
						),
						'default_value'     => 'amount',
						'allow_null'        => 0,
						'multiple'          => 0,
						'ui'                => 1,
						'ajax'              => 0,
						'return_format'     => 'value',
						'placeholder'       => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_goal',
						'label'             => __( 'Goal', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'goal',
						'type'              => 'number',
						'instructions'      => __( 'Donation amount in CHF needed to fill the progress bar', 'planet4-gpch-plugin-blocks' ),
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 1234,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => 1,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_add_number_amount',
						'label'             => __( 'Add number to donation amount', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'add_number_amount',
						'type'              => 'number',
						'instructions'      => __( 'Add this number to the amount we display', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 0,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => 1,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_add_number_count',
						'label'             => __( 'Add number to donations count', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'add_number_count',
						'type'              => 'number',
						'instructions'      => __( 'Add this number to the donations count we display', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 0,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => 1,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_sextant_id',
						'label'             => __( 'Salesforce Campaign ID', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'stored_campaign_id',
						'type'              => 'text',
						'instructions'      => __( 'The "stored_campaign_id" to include in results.', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_merchant_config_identifier',
						'label'             => __( 'Merchant config identifier', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'merchant_config_identifier',
						'type'              => 'text',
						'instructions'      => __( 'Merchant config identifier in RaiseNow.', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_date_from',
						'label'             => __( 'Date From', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'date_from',
						'type'              => 'date_picker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'display_format'    => 'F j, Y',
						'return_format'     => 'U',
						'first_day'         => 1,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_date_until',
						'label'             => __( 'Date until', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'date_until',
						'type'              => 'date_picker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'display_format'    => 'F j, Y',
						'return_format'     => 'U',
						'first_day'         => 1,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_show_text',
						'label'             => 'Show text',
						'name'              => 'show_text',
						'type'              => 'true_false',
						'instructions'      => __( 'Show a text below the progress bar?', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'message'           => '',
						'default_value'     => 0,
						'ui'                => 1,
						'ui_on_text'        => 'Yes',
						'ui_off_text'       => 'No',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_additional_text',
						'label'             => __( 'Additional Text', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'additional_text',
						'type'              => 'text',
						'instructions'      => __( 'You can use the placeholders AMOUNT (current donation amount), NUMBER (current number of donations), GOAL (for the goal), and AMOUNT_MULTIPLIED (for the amount multiplied by the value below) within your text.', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_p4_gpch_blocks_show_text',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '',
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_amount_multiplier',
						'label'             => __( 'Multiplier for the AMOUNT_MULTIPLIED placeholder in the text field.', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'amount_multiplier',
						'type'              => 'number',
						'instructions'      => __( 'AMOUNT * this number = AMOUNT_MULTIPLIED', 'planet4-gpch-plugin-blocks' ),
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_p4_gpch_blocks_show_text',
									'operator' => '==',
									'value'    => '1',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 1,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => 0.0001,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_bar_color',
						'label'             => __( 'Bar Color', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'bar_color',
						'type'              => 'color_picker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '#58b006',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_background_color',
						'label'             => __( 'Background Color', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'background_color',
						'type'              => 'color_picker',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => '#303133',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/p4-gpch-block-donation-progress-bar',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );

		}
	}


	/**
	 * Registers the Advanced Custom Fields block
	 */
	public function register_acf_block() {
		if ( function_exists( 'acf_register_block' ) ) {
			// register a block
			acf_register_block( array(
				'name'            => 'p4-gpch-block-donation-progress-bar',
				'title'           => __( 'Donation Progress Bar', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'Progress Bar for RaiseNow Donations', 'planet4-gpch-plugin-blocks' ),
				'render_callback' => array( $this, 'render_block' ),
				'category'        => 'gpch',
				'icon'            => 'feedback',
				'keywords'        => array( 'donation', 'progress', 'bar', 'raise' ),
			) );
		}
	}


	/**
	 * Callback function to render the content block
	 *
	 * @param $block
	 */
	public function render_block( $block ) {
		$fields = get_fields();

		if ( $fields !== false ) {
			// Basic validation for goal
			if ( ! is_numeric( $fields['goal'] ) ) {
				$this->render_error_message( __( 'Goal must be a numeric value', 'planet4-gpch-plugin-blocks' ) );

				return; // can't display anything without the goal, stop here
			}

			// Basic validation for added number
			if ( ! is_numeric( $fields['add_number_amount'] ) || ! is_numeric( $fields['add_number_count'] ) ) {
				$this->render_error_message( __( 'Added numbers must be numeric values', 'planet4-gpch-plugin-blocks' ) );
			}
		}

		// Get donation stats
		$donations = $this->get_numbers( [
			'stored_campaign_id'         => trim( $fields['stored_campaign_id'] ),
			'merchant_config_identifier' => trim( $fields['merchant_config_identifier'] ),
			'date_from'                  => trim( $fields['date_from'] ),
			'date_until'                 => trim( $fields['date_until'] ),
		] );

		if ( is_numeric( $fields['add_number_amount'] ) ) {
			$amount = $donations['amount'] + $fields['add_number_amount'];
		} else {
			$amount = $donations['amount'];
		}

		if ( is_numeric( $fields['add_number_count'] ) ) {
			$count = $donations['count'] + $fields['add_number_count'];
		} else {
			$count = $donations['count'];
		}

		if ( array_key_exists( 'amount_multiplier', $fields ) && is_numeric( $fields['amount_multiplier'] ) ) {
			$amount_multiplied = $amount * $fields['amount_multiplier'];
		} else {
			$amount_multiplied = $amount;
		}

		if ( $fields['show'] == 'count' ) {
			$percentage = $count / $fields['goal'] * 100;
		} else {
			$percentage = $amount / $fields['goal'] * 100;
		}

		// Additional Text
		if ( $fields['show_text'] ) {
			$text = str_replace( [ 'AMOUNT_MULTIPLIED', 'AMOUNT', 'NUMBER', 'GOAL' ], [
				number_format( $amount_multiplied, 0, '.', '\'' ),
				number_format( $amount, 0, '.', '\'' ),
				$count,
				number_format( $fields['goal'], 0, '.', '\'' ),
			], $fields['additional_text'] );
		}

		// Prepare parameters for template
		$params = array(
			'bg_color'   => $fields['background_color'],
			'bar_color'  => $fields['bar_color'],
			'percentage' => $percentage,
			'show_text'  => $fields['show_text'],
			'goal_text'  => isset( $text ) ? $text : '',
		);

		// Output template
		Timber::render( $this->template_file, $params );
	}

	protected function get_numbers( $searchTerms ) {
		$postID = get_the_ID();

		$lastUpdated             = get_post_meta( $postID, 'last_donations_progress_update', true );
		$existingSearchTermsHash = get_post_meta( $postID, 'last_donations_terms_hash', true );

		// When the hash changes we need to grab updated numbers from the API instead of from the page meta
		$searchTermsHash = hash( "md5", json_encode( $searchTerms ) );

		if ( is_numeric( $lastUpdated ) && ( $lastUpdated + 600 ) > time() && $existingSearchTermsHash == $searchTermsHash ) {
			$donationsAmount = get_post_meta( $postID, 'donations_progress_amount', true );
			$donationsCount  = get_post_meta( $postID, 'donations_progress_count', true );

			if ( is_numeric( $donationsAmount ) && is_numeric( $donationsCount ) ) {
				return [
					'amount' => $donationsAmount,
					'count'  => $donationsCount,
				];
			}
		}

		// If we get this far, we need to update the donation amount from the API.
		$raiseNowAPI = new RaiseNowAPI();

		$terms = [
			'merchant_config_identifier' => $searchTerms['merchant_config_identifier'],
			'stored_campaign_id'         => $searchTerms['stored_campaign_id'],
			'date_from'                  => $searchTerms['date_from'],
			'date_to'                    => $searchTerms['date_until']
		];

		$result = $raiseNowAPI->getStats( $terms );

		if ( $result !== false ) {
			update_post_meta( $postID, 'last_donations_progress_update', time() );
			update_post_meta( $postID, 'last_donations_terms_hash', $searchTermsHash );
			update_post_meta( $postID, 'donations_progress_amount', ( $result['total'] / 100 ) );
			update_post_meta( $postID, 'donations_progress_count', $result['count'] );
		}

		return [
			'amount' => ( $result['total'] / 100 ),
			'count'  => $result['count'],
		];
	}
}
