<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class FormCounterTextBlock extends BaseFormBlock {
	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/form_counter_text.twig';


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
				'key'                   => 'group_p4_gpch_blocks_form_counter_text',
				'title'                 => 'Form Counter Text',
				'fields'                => array(
					array(
						'key'               => 'field_p4_gpch_blocks_text_before',
						'label'             => __( 'Text before the number', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'text_before',
						'type'              => 'text',
						'instructions'      => '',
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
						'maxlength'         => 255,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_text_after',
						'label'             => __( 'Text after the number', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'text_after',
						'type'              => 'text',
						'instructions'      => '',
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
						'maxlength'         => 255,
					),
					array(
						'key'               => 'field_p4_gpch_blocks_add_number',
						'label'             => __( 'Add number', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'add_number',
						'type'              => 'number',
						'instructions'      => __( 'Add this number to the number of form entries', 'planet4-gpch-plugin-blocks' ),
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
						'key'               => 'field_p4_gpch_blocks_use_form_entry_counter',
						'label'             => __( 'Count Form entries', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'use_form_entry_counter',
						'type'              => 'true_false',
						'instructions'      => __( 'Would you like to count entries in a Gravity Form?', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Form IDs', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'form_ids',
						'type'              => 'text',
						'instructions'      => __( 'To include more than one form, enter the IDs separated by commas (no spaces). Example: 1,2,3', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Use Global Counter', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'use_global_counter',
						'type'              => 'true_false',
						'instructions'      => __( 'Would you like to add the number of a global counter?', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Global Counter URL', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'global_counter_url',
						'type'              => 'url',
						'instructions'      => __( 'The URL of a global petition counter', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Global Counter JSON key', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'global_counter_json_key',
						'type'              => 'text',
						'instructions'      => __( 'It\'s usually safe to keep the default to unique_count', 'planet4-gpch-plugin-blocks' ),
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
							'value'    => 'acf/p4-gpch-block-form-counter-text',
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
				'name'            => 'p4-gpch-block-form-counter-text',
				'title'           => __( 'Form/Petition Counter with Text', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'Counter for Gravity Forms (Petitions and other forms) with additional text.', 'planet4-gpch-plugin-blocks' ),
				'render_callback' => array( $this, 'render_block' ),
				'category'        => 'gpch',
				'icon'            => 'feedback',
				'keywords'        => array( 'form', 'progress', 'counter', 'petition' ),
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

		// Basic validation for added number
		if ( ! is_numeric( $fields['add_number'] ) ) {
			$this->render_error_message( __( 'Added number must be a numeric value', 'planet4-gpch-plugin-blocks' ) );
		}

		// get global counter and/or count form entries
		$counter = $this->get_numbers( $fields );

		// If a number is added to the calculated total, start out with that number
		if ( is_numeric( $fields['add_number'] ) ) {
			$sum = $fields['add_number'] + $counter;
		} else {
			$sum = $counter;
		}

		// Prepare parameters for template
		$params = array(
			'number'      => $sum,
			'text_before' => $fields['text_before'],
			'text_after'  => $fields['text_after'],
		);

		// Output template
		\Timber::render( $this->template_file, $params );
	}
}
