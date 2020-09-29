<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_Banner_Tool' ) ) {
	class Planet4_GPCH_Block_Banner_Tool extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/banner_tool.twig';

		/**
		 * @var Block options set in the backend
		 */
		protected $options;

		/**
		 * Default options for the block
		 *
		 * @var array
		 */
		protected $default_options = array();

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
					'key'                   => 'group_p4_gpch_blocks_banner_tool',
					'title'                 => 'Word Cloud',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_banner_tool_gravity_form_id',
							'label'             => __( 'Gravity Form ID', 'planet4-gpch-blocks' ),
							'name'              => 'gravity_form_id',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 1,
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
							'min'               => 1,
							'max'               => 99999999,
							'step'              => 1,
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-banner-tool',
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
					'name'            => 'p4-gpch-block-banner-tool',
					'title'           => __( 'Banner Tool', 'planet4-gpch-blocks' ),
					'description'     => __( 'Climate Justice Banner Tool', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'flag',
					'keywords'        => array( 'banner', 'flag' ),
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

			// Parameters for the template
			$params = array(
				'gravity_form_id' => $fields['gravity_form_id'],
				'assets_url' => P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'assets/blocks/banner-maker/',
			);

			// Output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
