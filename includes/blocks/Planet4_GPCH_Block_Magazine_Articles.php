<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_Magazine_Articles' ) ) {
	class Planet4_GPCH_Block_Magazine_Articles extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/magazine-articles.twig';


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
					'key'                   => 'group_p4_gpch_blocks_magazine_articles',
					'title'                 => 'Magazine_Articles',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_magazine_articles_number',
							'label'             => __( 'Number', 'planet4-gpch-blocks' ),
							'name'              => 'number',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '4',
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
								'value'    => 'acf/p4-gpch-block-magazine-articles',
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
					'name'            => 'p4-gpch-block-magazine-articles',
					'title'           => __( 'Magazine Articles', 'planet4-gpch-blocks' ),
					'description'     => __( 'Magazine Articles', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'book-alt',
					'keywords'        => array( 'magazine', 'articles' ),
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
			$params = array(
				'number'       => $fields['number'],
			);

			// Output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
