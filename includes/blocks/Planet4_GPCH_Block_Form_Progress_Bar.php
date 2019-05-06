<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_Form_Progress_Bar' ) ) {
	class Planet4_GPCH_Block_Form_Progress_Bar extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/form_progress_bar.twig';

		// [Christoph Arndt] -> [just a comment]
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
					'key'                   => 'group_p4_gpch_blocks_form_progress_bar',
					'title'                 => 'Form progress bar',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_goal',
							'label'             => __( 'Goal', 'planet4-gpch-blocks' ),
							'name'              => 'goal',
							'type'              => 'number',
							'instructions'      => __( 'Number of form entries needed to fill the progress bar', 'planet4-gpch-blocks' ),
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 1000,
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => '',
							'max'               => '',
							'step'              => 1,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_add_number',
							'label'             => __( 'Add number', 'planet4-gpch-blocks' ),
							'name'              => 'add_number',
							'type'              => 'number',
							'instructions'      => __( 'Add this number to the number of form entries', 'planet4-gpch-blocks' ),
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
							'key'               => 'field_p4_gpch_blocks_bar_color',
							'label'             => __( 'Bar Color', 'planet4-gpch-blocks' ),
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
							'label'             => __( 'Background Color', 'planet4-gpch-blocks' ),
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
						array(
							'key'               => 'field_p4_gpch_blocks_use_form_entry_counter',
							'label'             => __( 'Count Form entries', 'planet4-gpch-blocks' ),
							'name'              => 'use_form_entry_counter',
							'type'              => 'true_false',
							'instructions'      => __( 'Would you like to count entries in a Gravity Form?', 'planet4-gpch-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'message'           => '',
							'default_value'     => 1,
							'ui'                => 1,
							'ui_on_text'        => '',
							'ui_off_text'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_form_ids',
							'label'             => __( 'Form IDs', 'planet4-gpch-blocks' ),
							'name'              => 'form_ids',
							'type'              => 'text',
							'instructions'      => __( 'To include more than one form, enter the IDs separated by commas (no spaces). Example: 1,2,3', 'planet4-gpch-blocks' ),
							'required'          => 1,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_use_form_entry_counter',
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
							'key'               => 'field_p4_gpch_blocks_use_global_counter',
							'label'             => __( 'Use Global Counter', 'planet4-gpch-blocks' ),
							'name'              => 'use_global_counter',
							'type'              => 'true_false',
							'instructions'      => __( 'Would you like to add the number of a global counter?', 'planet4-gpch-blocks' ),
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
							'ui_on_text'        => '',
							'ui_off_text'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_global_counter_url',
							'label'             => __( 'Global Counter URL', 'planet4-gpch-blocks' ),
							'name'              => 'global_counter_url',
							'type'              => 'url',
							'instructions'      => __( 'The URL of a global petition counter', 'planet4-gpch-blocks' ),
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_use_global_counter',
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
						),
						array(
							'key'               => 'field_p4_gpch_blocks_global_counter_json_key',
							'label'             => __( 'Global Counter JSON key', 'planet4-gpch-blocks' ),
							'name'              => 'global_counter_json_key',
							'type'              => 'text',
							'instructions'      => __( 'It\'s usually safe to keep the default to unique_count', 'planet4-gpch-blocks' ),
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_use_global_counter',
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
							'default_value'     => 'unique_count',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-form-progress-bar',
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
					'name'            => 'p4-gpch-block-form-progress-bar',
					'title'           => __( 'Form Progress Bar', 'planet4-gpch-blocks' ),
					'description'     => __( 'Progress Bar for Gravity Forms (Petitions and other forms)', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'feedback',
					'keywords'        => array( 'form', 'progress', 'bar', 'petition' ),
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

			// Basic validation for goal
			if ( ! is_numeric( $fields['goal'] ) ) {
				$this->render_error_message( __( 'Goal must be a numeric value', 'planet4-gpch-blocks' ) );

				return; // can't display anything without the goal, stop here
			}

			// Basic validation for added number
			if ( ! is_numeric( $fields['add_number'] ) ) {
				$this->render_error_message( __( 'Added number must be a numeric value', 'planet4-gpch-blocks' ) );
			}


			// If a number is added to the calculated total, start out with that number
			if ( is_numeric( $fields['add_number'] ) ) {
				$sum = $fields['add_number'];
			} else {
				$sum = 0;
			}


			// Global Counter
			if ( $fields['use_global_counter'] === true ) {
				$sum += $this->get_global_petition_counter_number( $fields['global_counter_url'], $fields['global_counter_json_key'] );
			}


			// Form Entry Counter
			if ( $fields['use_form_entry_counter'] === true) {
				// IDs of forms to count entries
				$ids = explode( ',', $fields['form_ids'] );

				foreach ( $ids as $id ) {
					if ( is_numeric( $id ) ) {
						$counts = \GFFormsModel::get_form_counts( $id );

						$sum += $counts['total'] - $counts['trash'] - $counts['spam'];
					}
				}
			}

			// Prepare parameters for template
			$params = array(
				'bg_color'   => $fields['background_color'],
				'bar_color'  => $fields['bar_color'],
				'percentage' => $sum / $fields['goal'] * 100,
			);

			// Output template
			\Timber::render( $this->template_file, $params );
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
}
