<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class NewsletterBlock extends BaseBlock {
	/**
	 * @var string Template file path
	 */
	protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/newsletter-de.twig';


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
				'key'                   => 'group_p4_gpch_blocks_newsletter',
				'title'                 => 'Newsletter',
				'fields'                => array(
					array(
						'key'               => 'field_p4_gpch_blocks_newsletter_language',
						'label'             => __( 'Language', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'language',
						'type'              => 'select',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'de' => 'de',
							'fr' => 'fr',
						),
						'default_value'     => array(),
						'allow_null'        => 0,
						'multiple'          => 0,
						'ui'                => 0,
						'return_format'     => 'value',
						'ajax'              => 0,
						'placeholder'       => '',
					),
					array(
						'key'               => 'field_p4_gpch_blocks_newsletter_title',
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
				),
				'location'              => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/p4-gpch-block-newsletter',
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
				'name'            => 'p4-gpch-block-newsletter',
				'title'           => __( 'Newsletter', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'Newsletter-Form', 'planet4-gpch-plugin-blocks' ),
				'render_callback' => array( $this, 'render_block' ),
				'category'        => 'gpch',
				'icon'            => 'email',
				'keywords'        => array( 'newsletter', 'signup' ),
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
			'title' => $fields['title'],
		);

		// Change the template file if not default (other languages than German)
		if ( $fields['language'] == 'fr' ) {
			$this->template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/newsletter-fr.twig';

		}

		// Output template
		\Timber::render( $this->template_file, $params );
	}
}
