<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Action_Divider' ) ) {
	class Planet4_GPCH_Action_Divider extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/action_divider.twig';

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
					'key'                   => 'group_p4_gpch_blocks_action_divider',
					'title'                 => 'Donation Devider',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_action_divider_text',
							'label'             => __( 'Text', 'planet4-gpch-blocks' ),
							'name'              => 'text',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 'Unsere Arbeit wird durch Spenden ermöglicht.',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => 255,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_action_divider_button_link',
							'label'             => __( 'Action Link', 'planet4-gpch-blocks' ),
							'name'              => 'action_link',
							'type'              => 'link',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 'https://www.greenpeace.ch/spenden/',
							'placeholder'       => '',
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-action-divider',
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
					'name'            => 'p4-gpch-block-action-divider',
					'title'           => __( 'Action Divider', 'planet4-gpch-blocks' ),
					'description'     => __( 'Divider Block with Donation Button', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'minus',
					'keywords'        => array( 'action', 'divider' ),
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

			// Prepare parameters for template
			$params = array();

			// print_r($fields);

			$params = array(
				'text'   => $fields['text'],
				'action_link'   => $fields['action_link'],
			);

			// Output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
