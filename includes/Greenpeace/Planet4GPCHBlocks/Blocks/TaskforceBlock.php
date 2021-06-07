<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class TaskforceBlock extends BaseBlock {
	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/taskforce.twig';


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
				'key'                   => 'group_p4_gpch_blocks_taskforce',
				'title'                 => 'Taskforce',
				'fields'                => array(
					array(
						'key'               => 'field_p4_gpch_blocks_taskforce_title',
						'label'             => __( 'Title', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'title',
						'type'              => 'text',
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
						'maxlength'         => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_taskforce_description',
						'label'             => __( 'Description', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'description',
						'type'              => 'wysiwyg',
						'instructions'      => '',
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
					array(
						'key'               => 'field_p4_gpch_blocks_taskforce_image',
						'label'             => 'Background Image',
						'name'              => 'background_image',
						'type'              => 'image',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'id',
						'preview_size'      => 'thumbnail',
						'library'           => 'all',
						'min_width'         => '',
						'min_height'        => '',
						'min_size'          => '',
						'max_width'         => '',
						'max_height'        => '',
						'max_size'          => '',
						'mime_types'        => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_taskforce_link',
						'label'             => __( 'Button', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'button',
						'type'              => 'link',
						'instructions'      => '',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_taskforce_tag',
						'label'             => 'Tag',
						'name'              => 'tag',
						'type'              => 'taxonomy',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'taxonomy'          => 'post_tag',
						'field_type'        => 'select',
						'allow_null'        => 0,
						'add_term'          => 0,
						'save_terms'        => 0,
						'load_terms'        => 0,
						'return_format'     => 'object',
						'multiple'          => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/p4-gpch-block-taskforce',
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
				'name'            => 'p4-gpch-block-taskforce',
				'title'           => __( 'Taskforce', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'Taskforce', 'planet4-gpch-plugin-blocks' ),
				'render_callback' => array( $this, 'render_block' ),
				'category'        => 'gpch',
				'icon'            => 'editor-table',
				'keywords'        => array( 'taskforce', 'basket' ),
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
			'title'       => $fields['title'],
			'description' => $fields['description'],
			'image'       => new \Timber\Image( $fields['background_image'] ),
			'button'      => ( isset( $fields['button'] ) ) ? $fields['button'] : false,
			'tag'         => $fields['tag'],
		);

		// Output template
		\Timber::render( $this->template_file, $params );
	}
}
