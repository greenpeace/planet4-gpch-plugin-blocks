<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

class BannerToolBlock extends BaseBlock {
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
						'label'             => __( 'Gravity Form ID', 'planet4-gpch-plugin-blocks' ),
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
				'title'           => __( 'Banner Tool', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'Climate Justice Banner Tool', 'planet4-gpch-plugin-blocks' ),
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
			'gravity_form_id'            => $fields['gravity_form_id'],
			'assets_url'                 => P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'assets/blocks/banner-maker/',

			// WPML doesn't scan twig templates for strings to translate
			// This is a qworkaround so we can make fast changes without generating a po file every time
			'lang_create'                => __( 'Create', 'planet4-gpch-plugin-blocks' ),
			'lang_step'                  => __( 'Step', 'planet4-gpch-plugin-blocks' ),
			'lang_background'            => __( 'Background', 'planet4-gpch-plugin-blocks' ),
			'lang_background_desc'       => __( 'Choose your preferred background between solid or pattern.', 'planet4-gpch-plugin-blocks' ),
			'lang_background_color'      => __( 'Background Colour', 'planet4-gpch-plugin-blocks' ),
			'lang_background_color_desc' => __( 'Then choose background/pattern colour(s) based on the campaign’s colour palette.', 'planet4-gpch-plugin-blocks' ),
			'lang_error_deselect'        => __( 'Deselect a colour first!', 'planet4-gpch-plugin-blocks' ),
			'lang_icons'                 => __( 'Icons', 'planet4-gpch-plugin-blocks' ),
			'lang_icons_desc'            => __( 'Now choose your preferred icon between problems or feelings. Don\'t forget to chose a colour.', 'planet4-gpch-plugin-blocks' ),
			'lang_problems'              => __( 'Problems', 'planet4-gpch-plugin-blocks' ),
			'lang_feelings'              => __( 'Feelings', 'planet4-gpch-plugin-blocks' ),
			'lang_wildfires'             => __( 'Wildfires', 'planet4-gpch-plugin-blocks' ),
			'lang_floods'                => __( 'Floods', 'planet4-gpch-plugin-blocks' ),
			'lang_tropical_cyclones'     => __( 'Tropical cyclones', 'planet4-gpch-plugin-blocks' ),
			'lang_rising_sea'            => __( 'Rising sea levels', 'planet4-gpch-plugin-blocks' ),
			'lang_droughts'              => __( 'Droughts', 'planet4-gpch-plugin-blocks' ),
			'lang_heatwaves'             => __( 'Heatwaves', 'planet4-gpch-plugin-blocks' ),
			'lang_empowered'             => __( 'Empowered', 'planet4-gpch-plugin-blocks' ),
			'lang_empathy'               => __( 'Empathy', 'planet4-gpch-plugin-blocks' ),
			'lang_encouraged'            => __( 'Encouraged/Inspired', 'planet4-gpch-plugin-blocks' ),
			'lang_belonging'             => __( 'Belonging', 'planet4-gpch-plugin-blocks' ),
			'lang_message'               => __( 'Message', 'planet4-gpch-plugin-blocks' ),
			'lang_message_desc'          => __( 'Finally choose from existing messages or type your own. Don\'t forget to chose a colour.', 'planet4-gpch-plugin-blocks' ),
			'lang_slogan1'               => __( 'VOICES FOR<br>CLIMATE<br>ACTION.<br>JUSTICE FOR<br>THE PEOPLE', 'planet4-gpch-plugin-blocks' ),
			'lang_slogan2'               => __( 'RAISE YOUR<br>VOICE FOR<br>CLIMATE<br>JUSTICE', 'planet4-gpch-plugin-blocks' ),
			'lang_slogan3'               => __( 'THE CLIMATE<br>CRISIS IS A<br>HUMAN RIGHTS<br>CRISIS', 'planet4-gpch-plugin-blocks' ),
			'lang_slogan1_c'             => str_replace( '<br>', '&#10;', __( 'VOICES FOR<br>CLIMATE<br>ACTION.<br>JUSTICE FOR<br>THE PEOPLE', 'planet4-gpch-plugin-blocks' ) ),
			'lang_slogan2_c'             => str_replace( '<br>', '&#10;', __( 'RAISE YOUR<br>VOICE FOR<br>CLIMATE<br>JUSTICE', 'planet4-gpch-plugin-blocks' ) ),
			'lang_slogan3_c'             => str_replace( '<br>', '&#10;', __( 'THE CLIMATE<br>CRISIS IS A<br>HUMAN RIGHTS<br>CRISIS', 'planet4-gpch-plugin-blocks' ) ),

			'lang_err_submit_message' => __( 'Select or submit a message first!', 'planet4-gpch-plugin-blocks' ),
			'lang_no_words'           => __( 'Feelings need no words', 'planet4-gpch-plugin-blocks' ),
			'lang_reset'              => __( 'Reset', 'planet4-gpch-plugin-blocks' ),
			'lang_generate'           => __( 'Generate', 'planet4-gpch-plugin-blocks' ),
			'lang_video_mode'         => __( 'Video mode', 'planet4-gpch-plugin-blocks' ),
			'lang_video_mode_desc'    => __( 'Confirm video mode for full Experience. This may couse performance issues to your device.', 'planet4-gpch-plugin-blocks' ),
			'lang_dismiss'            => __( 'Dismiss', 'planet4-gpch-plugin-blocks' ),
			'lang_confirm'            => __( 'Confirm', 'planet4-gpch-plugin-blocks' ),
			'lang_own_message'        => __( 'Type your own message', 'planet4-gpch-plugin-blocks' ),
			'lang_submit'             => __( 'Submit', 'planet4-gpch-plugin-blocks' ),
			'lang_delete'             => __( 'Delete', 'planet4-gpch-plugin-blocks' ),
			'lang_'                   => __( '', 'planet4-gpch-plugin-blocks' ),
		);

		// Output template
		\Timber::render( $this->template_file, $params );
	}
}
