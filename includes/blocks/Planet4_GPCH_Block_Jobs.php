<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_GPCH_Jobs' ) ) {
	class Planet4_GPCH_Block_GPCH_Jobs extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/gpch_jobs.twig';


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
					'key'                   => 'group_p4_gpch_blocks_gpch_jobs',
					'title'                 => 'GPCH Jobs',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_jobs_description',
							'label'             => __( 'No Jobs Text', 'planet4-gpch-plugin-blocks' ),
							'name'              => 'no_jobs_text',
							'type'              => 'wysiwyg',
							'instructions'      => __( 'This text will be shown when no jobs are available', 'planet4-gpch-plugin-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'tabs'              => 'all',
							'toolbar'           => 'basic',
							'media_upload'      => 0,
							'delay'             => 0,
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-gpch-jobs',
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
					'name'            => 'p4-gpch-block-gpch-jobs',
					'title'           => __( 'GPCH Jobs', 'planet4-gpch-plugin-blocks' ),
					'description'     => __( 'GPCH Jobs', 'planet4-gpch-plugin-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'admin-users',
					'keywords'        => array( 'jobs', 'stellen' ),
				) );
			}
		}


		/**
		 * Callback function to render the content block
		 *
		 * @param $block
		 */
		public function render_block( $block ) {
			// Get Jobs
			$args = array(
				'post_type'   => array( 'gpch_job' ),
				'post_status' => array( 'publish' ),
				'nopaging'    => true,
				'order'       => 'ASC',
				'orderby'     => 'menu_order',
			);

			$jobs = new \WP_Query( $args );

			// Restore original Post Data
			wp_reset_postdata();


			$fields = get_fields();

			// Prepare parameters for template
			$params = array(
				'jobs'         => $jobs->posts,
				'no_jobs_text' => $fields['no_jobs_text'],
			);

			// Output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
