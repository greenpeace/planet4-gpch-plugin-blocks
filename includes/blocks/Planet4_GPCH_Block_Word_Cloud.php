<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_Word_Cloud' ) ) {
	class Planet4_GPCH_Block_Word_Cloud extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/word_cloud.twig';

		/**
		 * @var Block options set in the backend
		 */
		protected $options;

		/**
		 * Default options for the block
		 *
		 * @var array
		 */
		protected $default_options = array(
			'data_source'                          => 'list',
			'words_list'                           => 'No_Words 1',
			'gravtiy_form_settings'                => array(
				'gravity_form_id'       => '',
				'gravity_form_field_id' => '',
				'show_entries_until'    => '2099-01-02 00:00:00',
				'use_dictionary'        => true,
				'dictionary_settings'   => array(
					'pos_to_show'          => array( [ 'NN' ] ),
					'new_words_dictionary' => true,
				),
			),
			'word_colors'                          => 'greenpeace',
			'use_detailed_cloud_rendering_options' => false,
			'cloud_rendering_options'              => array(
				'relative_scale' => '0.6',
				'color_split_1'  => '80',
				'color_split_1'  => '90',
				'grid_size'      => '18',
			),
			'use_advanced_options'                 => false,
			'advanced_options'                     => array(
				'max_words_to_show'    => 100,
				'max_use_form_entries' => 1000,
				'cache_lifetime'       => 864000,
				'max_reindex_rate'     => 10,
				'max_index_words'      => 30,
				'debug_output'         => false,
				'unique_identifier'    => 'default',
			),
		);

		/**
		 * @var array The list of words for the clouds including weights
		 */
		protected $words = array();

		/**
		 * @var int Minimum weight of a word in the list
		 */
		protected $minWeight;

		/**
		 * @var int Maximum weight of a word in the list
		 */
		protected $maxWeight;

		/**
		 * @var
		 */
		protected $debugMessages = array();

		protected $reindexCounter;

		public function __construct() {
			$this->register_acf_field_group();

			add_action( 'acf/init', array( $this, 'register_acf_block' ) );

			// Some starter values
			$this->minWeight      = 9999999;
			$this->maxWeight      = 0;
			$this->reindexCounter = 0;
		}

		/**
		 * Registers a field group with Advanced Custom Fields
		 */
		protected function register_acf_field_group() {
			if ( function_exists( 'acf_add_local_field_group' ) ) {
				acf_add_local_field_group( array(
					'key'                   => 'group_p4_gpch_blocks_word_cloud',
					'title'                 => 'Word Cloud',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_data_source',
							'label'             => 'Source for the words',
							'name'              => 'data_source',
							'type'              => 'select',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'list'        => 'I have a list of words',
								'gravityform' => 'User input (through Gravity Forms)',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_word_list',
							'label'             => 'Words List',
							'name'              => 'words_list',
							'type'              => 'textarea',
							'instructions'      => 'Paste your words list. Make sure it\'s formatted like this (each line contains a word followed by a number):<br>
Love 12<br>
Liebe 5<br>
ፍቅር 5<br>
Lufu 5<br>
Aimor 5<br>
Amor 2',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_data_source',
										'operator' => '==',
										'value'    => 'list',
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
							'maxlength'         => '',
							'rows'              => '',
							'new_lines'         => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_gravity_forms_settings',
							'label'             => 'Gravtiy Form Settings',
							'name'              => 'gravtiy_form_settings',
							'type'              => 'group',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_data_source',
										'operator' => '==',
										'value'    => 'gravityform',
									),
								),
							),
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'layout'            => 'block',
							'sub_fields'        => array(
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_gravity_form_id',
									'label'             => 'Gravity Form ID',
									'name'              => 'gravity_form_id',
									'type'              => 'number',
									'instructions'      => 'Enter the ID of the Gravity Form that contains the words',
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
									'max'               => 999999,
									'step'              => 0,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_gravity_form_field_id',
									'label'             => 'Gravity Form Field ID',
									'name'              => 'gravity_form_field_id',
									'type'              => 'text',
									'instructions'      => 'Which field(s) of your form would you like to use for the word cloud? Enter the field IDs (when you edit your form, each field has the ID in the title line). The cloud only works with fields of type "text" (for one word), "list" (multiple words), or "textarea" (multiline text). To use multiple fields in one form, enter multiple IDs separated by commas.',
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
									'key'               => 'field_p4_gpch_blocks_word_cloud_gravity_form_until',
									'label'             => 'show_entries_until',
									'name'              => 'show_entries_until',
									'type'              => 'date_time_picker',
									'instructions'      => 'The cloud will only use entries before this date/time. Please make sure all entries before this are moderated.',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'display_format'    => 'Y-m-d H:i:s',
									'return_format'     => 'Y-m-d H:i:s',
									'first_day'         => 1,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_use_dictionary',
									'label'             => 'Use the dictionary',
									'name'              => 'use_dictionary',
									'type'              => 'true_false',
									'instructions'      => 'Using the dictionary will
- only show words in the dictionary
- filter blacklisted words
- allow you to select to show only certain POS (part of speech, e.g. nouns, adjectives)
- add new words to the dictionary so they can bei either confirmed or blacklisted',
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
									'ui_on_text'        => 'Yes',
									'ui_off_text'       => 'No',
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_dictionary_settings',
									'label'             => 'Dictionary Settings',
									'name'              => 'dictionary_settings',
									'type'              => 'group',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => array(
										array(
											array(
												'field'    => 'field_p4_gpch_blocks_word_cloud_use_dictionary',
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
									'layout'            => 'block',
									'sub_fields'        => array(
										array(
											'key'               => 'field_p4_gpch_blocks_word_cloud_show_pos',
											'label'             => 'POS (part of speech) to show',
											'name'              => 'pos_to_show',
											'type'              => 'checkbox',
											'instructions'      => 'Usually you get the best results showing only nouns and names, but you can select other types of words.',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'choices'           => array(
												'NN'   => 'Nouns',
												'NE'   => 'Names',
												'ADJ'  => 'Adjectives',
												'VERB' => 'Verbs',
												'DEV'  => 'Other',
											),
											'allow_custom'      => 0,
											'default_value'     => array(),
											'layout'            => 'vertical',
											'toggle'            => 0,
											'return_format'     => 'value',
											'save_custom'       => 0,
										),
										array(
											'key'               => 'field_p4_gpch_blocks_word_cloud_dictionary_add_new_words',
											'label'             => 'Add new words to the dictionary',
											'name'              => 'new_words_dictionary',
											'type'              => 'true_false',
											'instructions'      => 'Add words that are not yet in the dictionary? They need to be moderated before they are shown in the word cloud.',
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
											'ui_on_text'        => 'Yes',
											'ui_off_text'       => 'No',
										),
									),
								),
							),
						),
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_word_colors',
							'label'             => 'Word cloud color scheme',
							'name'              => 'word_colors',
							'type'              => 'select',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'greenpeace' => 'Greenpeace',
								'climate'    => 'Climate',
								'plastics'   => 'Plastics',
								'random'     => 'Random',
							),
							'default_value'     => array(
								0 => 'greenpeace',
							),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_use_detailed_rendering_options',
							'label'             => 'Use detailed cloud rendering options',
							'name'              => 'use_detailed_cloud_rendering_options',
							'type'              => 'true_false',
							'instructions'      => 'Change some of the preset word cloud options to change its looks.',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_rendering_options',
							'label'             => 'Cloud rendering options',
							'name'              => 'cloud_rendering_options',
							'type'              => 'group',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_use_detailed_rendering_options',
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
							'layout'            => 'block',
							'sub_fields'        => array(
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_relative_scale',
									'label'             => 'Relative scale',
									'name'              => 'relative_scale',
									'type'              => 'range',
									'instructions'      => 'Changes the size difference between the largest and smallest word in the cloud. Values between 0.1 and 3 allowed, larger number means bigger difference. Default is 0.6.',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => '0.6',
									'min'               => '0.1',
									'max'               => 2,
									'step'              => '0.1',
									'prepend'           => '',
									'append'            => '',
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_color_split_1',
									'label'             => 'Color split 1',
									'name'              => 'color_split_1',
									'type'              => 'range',
									'instructions'      => 'Change this value to change how many words are color 1.',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 80,
									'min'               => 1,
									'max'               => 100,
									'step'              => '',
									'prepend'           => '',
									'append'            => '',
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_color_split_2',
									'label'             => 'Color split 2',
									'name'              => 'color_split_2',
									'type'              => 'range',
									'instructions'      => 'Change this value to change how many words are color 2.',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 90,
									'min'               => 1,
									'max'               => 100,
									'step'              => 1,
									'prepend'           => '',
									'append'            => '',
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_grid_size',
									'label'             => 'Grid size',
									'name'              => 'grid_size',
									'type'              => 'range',
									'instructions'      => 'Grid size determines how far apart words are from each other, but also how many fit into the cloud. Default is 18.',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 18,
									'min'               => 1,
									'max'               => 100,
									'step'              => 1,
									'prepend'           => '',
									'append'            => '',
								),
							),
						),
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_use_advanced_options',
							'label'             => 'Use advanced options',
							'name'              => 'use_advanced_options',
							'type'              => 'true_false',
							'instructions'      => '',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_advanced_options',
							'label'             => 'Advanced Options',
							'name'              => 'advanced_options',
							'type'              => 'group',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_use_advanced_options',
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
							'layout'            => 'block',
							'sub_fields'        => array(
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_max_words',
									'label'             => 'Max words to show',
									'name'              => 'max_words_to_show',
									'type'              => 'number',
									'instructions'      => 'The maximum number of words shown in the cloud.',
									'required'          => 0,
									'conditional_logic' => '',
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 100,
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'min'               => 1,
									'max'               => 10000,
									'step'              => 0,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_cache_lifetime',
									'label'             => 'Cache lifetime',
									'name'              => 'cache_lifetime',
									'type'              => 'number',
									'instructions'      => 'Cache lifetime in seconds',
									'required'          => 0,
									'conditional_logic' => '',
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
									'max'               => 9999999999,
									'step'              => 1,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_reindex_rate',
									'label'             => 'Max reindex rate',
									'name'              => 'max_reindex_rate',
									'type'              => 'number',
									'instructions'      => 'The rate at which entries are re-indexed.',
									'required'          => 0,
									'conditional_logic' => '',
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 10,
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'min'               => 1,
									'max'               => 9999999999,
									'step'              => 1,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_max_index_words',
									'label'             => 'Max number of words to index',
									'name'              => 'max_index_words',
									'type'              => 'number',
									'instructions'      => 'The maximum number of words in each field that gets indexed',
									'required'          => 0,
									'conditional_logic' => '',
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 30,
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'min'               => 1,
									'max'               => 9999999999,
									'step'              => 1,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_max_use_formn_entries',
									'label'             => 'Max number of form entries to use in the cloud',
									'name'              => 'max_use_form_entries',
									'type'              => 'number',
									'instructions'      => 'The maximum number of form entries to be used in the word cloud.',
									'required'          => 0,
									'conditional_logic' => '',
									'wrapper'           => array(
										'width' => '',
										'class' => '',
										'id'    => '',
									),
									'default_value'     => 1000,
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'min'               => 1,
									'max'               => 9999999999,
									'step'              => 1,
								),
								array(
									'key'               => 'field_p4_gpch_blocks_word_cloud_debug_output',
									'label'             => 'Debug Output',
									'name'              => 'debug_output',
									'type'              => 'true_false',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => '',
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
									'key'               => 'field_p4_gpch_blocks_word_cloud_unique_identifier',
									'label'             => 'Unique Identifier',
									'name'              => 'unique_identifier',
									'type'              => 'text',
									'instructions'      => 'The unique identifier for this cloud. Used in caching.',
									'required'          => 0,
									'conditional_logic' => '',
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
						),

					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-word-cloud',
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
					'name'            => 'p4-gpch-block-word-cloud',
					'title'           => __( 'Word Cloud', 'planet4-gpch-blocks' ),
					'description'     => __( 'Word Cloud', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'cloud',
					'keywords'        => array( 'word', 'tag', 'cloud' ),
				) );
			}
		}


		/**
		 * Callback function to render the content block
		 *
		 * @param $block
		 */
		public function render_block( $block ) {
			$this->addDebugMessage( 'Rendering started' );

			// Get options and merge with defaults
			$this->options = array_replace_recursive( $this->default_options, get_fields() );

			// Even if debug is on, we only show debug messages for certain user roles
			$user = \wp_get_current_user();
			if ( in_array( 'administrator', $user->roles ) || in_array( 'editor', $user->roles ) ) {
				$showDebugMessages = true;
			} else {
				$showDebugMessages = false;
			}

			// Parameters for the template that don't need any further work
			$params = array(
				'script'              => P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'assets/js/wordcloud2.js',
				'dom_id'              => uniqid( 'word-cloud-' ),
				'relative_scale'      => $this->options['cloud_rendering_options']['relative_scale'],
				'grid_size'           => $this->options['cloud_rendering_options']['grid_size'],
				'show_debug_messages' => $showDebugMessages,
			);

			// Get a list of words, either from a list or a gravity form
			if ( $this->options['data_source'] == 'list' ) {
				$this->getWordsFromList();
			} elseif ( $this->options['data_source'] == 'gravityform' ) {
				$this->getWordsFromGravityForm();
			}

			// The cloud looks best when the words with biggest weight are drawn first, so it's best to sort.
			usort( $this->words, array( $this, "sortWords" ) );

			// There's a limit on how many words we want to show in the cloud. Remove the words from the end of the
			// array (those with least weight)
			$params['word_list'] = json_encode( array_slice( $this->words, 0, $this->options['advanced_options']['max_words_to_show'] ) );

			// We need to know the min max weight of words in the list to calulate their size in the map
			$this->calculateMinMaxWeight();
			$params['max_word_size'] = $this->maxWeight;
			$params['min_word_size'] = $this->minWeight;

			// Colors schemes
			if ( $this->options['word_colors'] == 'random' ) {
				$params['random_colors'] = 1;
			} else if ( $this->options['word_colors'] == 'greenpeace' ) {
				$params['word_colors'][0] = '#73BE1E';
				$params['word_colors'][1] = '#00573a';
				$params['word_colors'][2] = '#dbebbe';
			} else if ( $this->options['word_colors'] == 'climate' ) {
				$params['word_colors'][0] = '#cd1719';
				$params['word_colors'][1] = '#eaccbb';
				$params['word_colors'][2] = '#cccccc';
			} else if ( $this->options['word_colors'] == 'plastics' ) {
				$params['word_colors'][0] = '#e94e28';
				$params['word_colors'][1] = '#69c2be';
				$params['word_colors'][2] = '#c4e3e1';
			}

			// Some color schemes rely on a value where to split between colors
			$params['color_split_1'] = $this->findWeightAtPercentile( $this->options['cloud_rendering_options']['color_split_1'] );
			$params['color_split_2'] = $this->findWeightAtPercentile( $this->options['cloud_rendering_options']['color_split_2'] );

			// Some help debugging
			$this->addDebugMessage( 'min_word_size: ' . $params['min_word_size'] );
			$this->addDebugMessage( 'max_word_size: ' . $params['max_word_size'] );
			$this->addDebugMessage( 'Color Split 1: ' . $params['color_split_1'] );
			$this->addDebugMessage( 'Color Split 2: ' . $params['color_split_2'] );
			$this->addDebugMessage( 'Output started' );

			if ( $this->options['advanced_options']['debug_output'] ) {
				$params['debug_messages'] = $this->debugMessages;
			}

			// Output template
			\Timber::render( $this->template_file, $params );
		}

		/**
		 * Retrieves a list of words and their weight from a text
		 */
		protected function getWordsFromList() {
			if ( ! empty( $this->options['words_list'] ) ) {
				$words = explode( "\n", $this->options['words_list'] );

				for ( $i = 0; $i < count( $words ); $i ++ ) {
					$words[ $i ] = trim( $words[ $i ] );
					$words[ $i ] = explode( ' ', $words[ $i ] );
				}

				$this->words = $words;
			}
		}

		/**
		 * Retrieves a list of words from a Gravity Form
		 */
		protected function getWordsFromGravityForm() {
			// Find the field IDs
			$fieldIds = explode( ',', $this->options['gravtiy_form_settings']['gravity_form_field_id'] );

			// Make sure there are no spaces in field IDs
			for ( $i = 0; $i < count( $fieldIds ); $i ++ ) {
				$fieldIds[ $i ] = trim( $fieldIds[ $i ] );
			}

			// Get form entries until the set time and date in the block settings
			$search_criteria['end_date'] = $this->options['gravtiy_form_settings']['show_entries_until'];
			$entries                     = \GFAPI::get_entries( $this->options['gravtiy_form_settings']['gravity_form_id'], $search_criteria );

			$limitCountdown        = $this->options['advanced_options']['max_use_form_entries'];
			$this->debugMessages[] = 'Form entries limited to ' . $limitCountdown;

			foreach ( $entries as $entry ) {
				// If the words are already indexed, we can get them from the index
				$success = $this->addFromIndex( $entry );

				// If the index is either nonexistent or stale, we need to (re-)index
				if ( ! $success ) {
					$this->reindexCounter = $this->reindexCounter + 1;

					// Check if we've hit the limit of entries to limit this run yet
					if ( $this->reindexCounter > $this->options['advanced_options']['max_reindex_rate'] ) {
						break;
					}

					// Index the words in this entry
					$this->indexEntry( $entry, $fieldIds );
				}

				// When we hit the limit, stop indexing entries
				$limitCountdown --;

				if ( $limitCountdown < 0 ) {
					break;
				}
			}
		}

		/**
		 * Callback function for usort for sorting our words with the most mentioned word first
		 *
		 * @param $a
		 * @param $b
		 *
		 * @return int
		 */
		public function sortWords( $a, $b ) {
			if ( $a[1] > $b[1] ) {
				return - 1;
			} else {
				return 1;
			}
		}


		/**
		 * Adds a word to the word cloud if it doesn't exist yet. If it does exist, it increases the weight of the word.
		 *
		 * @param $word
		 */
		protected function addWordToCloud( $word ) {
			$word = ucfirst( $word );

			for ( $i = 0; $i < count( $this->words ); $i ++ ) {
				if ( $this->words[ $i ][0] == $word ) {
					// Increment the counter for the word
					$this->words[ $i ][1] = $this->words[ $i ][1] + 1;

					return;
				}
			}

			// If not found, add as new word
			$this->words[] = array( $word, 1 );
		}


		/**
		 * Finds the min and max weight we use in our word cloud.
		 */
		protected function calculateMinMaxWeight() {
			if ( count( $this->words ) > 0 ) {
				foreach ( $this->words as $word ) {
					if ( $word[1] < $this->minWeight ) {
						$this->minWeight = $word[1];
					}
					if ( $word[1] > $this->maxWeight ) {
						$this->maxWeight = $word[1];
					}
				}
			}
		}


		/**
		 * Returns the weight of the word at a percentile of all weights in the words list
		 *
		 * @param $percentile
		 *
		 * @return int Index
		 */
		protected function findWeightAtPercentile( $percentile ) {
			if ( count( $this->words ) > 0 ) {
				$factor = 1 / ( $percentile / 100 );

				$weights = array();
				foreach ( $this->words as $word ) {
					$weights[] = $word[1];
				}

				sort( $weights );

				// The array index of the percentile we're looking for
				$index = ( floor( count( $weights ) / $factor ) ) - 1;

				// index can't be below 0
				if ( $index < 0 ) {
					$index = 0;
				}

				return $weights[ $index ];
			} else {
				return 0;
			}
		}


		/**
		 * Checks if a word is in the dictionary and is the required POS (part of speech).
		 *
		 * @param $word
		 * @param $pos POS, part of speech
		 * @param bool $addNewWord
		 *
		 * @return bool True if word was found and belongs to the listed $pos
		 */
		protected function checkDictionary( $word, $pos, $addNewWord = true ) {
			global $wpdb;

			$tableName = $wpdb->prefix . P4_GPCH_PLUGIN_WORD_DICT_TABLE_NAME;
			$sql       = "SELECT type, blacklisted, confirmed FROM {$tableName} WHERE word = '{$word}' AND language = '" . ICL_LANGUAGE_CODE . "'";

			$results = $wpdb->get_results( $sql, OBJECT );

			if ( count( $results ) > 0 ) {
				foreach ( $results as $result ) {
					if ( $result->blacklisted == 0 && $result->confirmed == 1 ) {
						if ( in_array( $result->type, $pos ) ) {
							return true;
							break;
						}
					}
				}
			} else {
				$this->addWordToDictionary( $word );
			}

			return false;
		}

		/**
		 * Adds a word to the dictionary
		 *
		 * @param $word
		 */
		protected function addWordToDictionary( $word ) {
			global $wpdb;

			$tableName = $wpdb->prefix . P4_GPCH_PLUGIN_WORD_DICT_TABLE_NAME;

			$wpdb->insert( $tableName,
				array(
					'language'    => ICL_LANGUAGE_CODE,
					'confirmed'   => 0,
					'blacklisted' => 0,
					'word'        => $word
				),
				array(
					'%s',
					'%d',
					'%d',
					'%s'
				) );
		}

		/**
		 * Adds a debug message
		 */
		protected function addDebugMessage( $message ) {
			$t     = microtime( true );
			$micro = sprintf( "%06d", ( $t - floor( $t ) ) * 1000000 );
			$d     = new \DateTime( date( 'Y-m-d H:i:s.' . $micro, $t ) );

			$this->debugMessages[] = $d->format( "H:i:s.u" ) . " " . $message;
		}

		/**
		 * Add to word cloud from index of a Gravity Form Entry.
		 * The index is a meta field that contains a list of words extracted from the fields.
		 *
		 * @param $entry
		 *
		 * @return bool
		 */
		protected function addFromIndex( $entry ) {
			// Get entry metadata
			$updated      = gform_get_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words_updated' );
			$options_hash = gform_get_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words_options_hash' );
			$words        = gform_get_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words' );


			$thresold             = time() - $this->options['advanced_options']['cache_lifetime'];
			$current_options_hash = $this->getCurrentOptionsHash();


			// There are multiple reasons why a cached index shouldn't be loaded:
			// - Index doesn't exist
			// - Index is too old
			// - Word cloud options have changed in the meantime (using $options_hash)
			if ( $updated === false || $updated < $thresold || $options_hash != $current_options_hash ) {
				return false;
			} else {
				foreach ( $words as $word ) {
					$this->addWordToCloud( $word );
				}

				return true;
			}
		}

		/**
		 * Returns a hash value of all the options that affect the cloud content
		 *
		 * @return Block
		 */
		protected function getCurrentOptionsHash() {
			// All the options that have an effect on what words are shown in the cloud
			$relevantOptions = array(
				$this->options['gravtiy_form_settings']['gravity_form_field_id'],
				$this->options['gravtiy_form_settings']['use_dictionary'],
				$this->options['gravtiy_form_settings']['dictionary_settings']['pos_to_show'],
				$this->options['advanced_options']['max_index_words'],
			);

			return md5( serialize( $relevantOptions ) );
		}

		/**
		 * Index a Gravity Form entry and save the indexed words to a meta field.
		 *
		 * @param $entry
		 * @param $fieldIds
		 */
		protected function indexEntry( $entry, $fieldIds ) {
			$this->addDebugMessage( 'Indexing Entry #' . $entry['id'] );
			$wordsToAdd = array();

			foreach ( $fieldIds as $fieldId ) {
				// Get field metadata. Most important is the type of field we're dealing with
				// Should be either "text", "list" or textarea
				$field = \GFAPI::get_field( $this->options['gravtiy_form_settings']['gravity_form_id'], $fieldId );

				if ( $field === false ) {
					$params['error_message'] = 'Error: At least one of your field IDs doesn\'t match a field.';
					break;
				}

				if ( $field->type == "text" ) {
					$word = rgar( $entry, $fieldId );

					if ( ! empty( $word ) ) {
						$wordsToAdd[] = $word;
					}
				} elseif ( $field->type == 'list' ) {
					$listFieldWords = unserialize( rgar( $entry, $fieldId ) );

					// Only add if there are words in the field
					if ( $listFieldWords !== false ) {
						foreach ( $listFieldWords as $listFieldWord ) {
							// Some of the fields can be empty, we don't want those
							if ( ! empty( $listFieldWord ) ) {
								$wordsToAdd[] = $listFieldWord;
							}
						}
					}
				} elseif ( $field->type == 'textarea' ) {
					$text = rgar( $entry, $fieldId );

					// Separate each word in the text
					preg_match_all( '((\b[^\s]+\b)((?<=\.\w).)?)', $text, $matches );

					$wordsIndexedCount = 0;
					foreach ( $matches[0] as $match ) {
						// Stop indexing long entries after a certain amount of words
						if ( $wordsIndexedCount < $this->options['advanced_options']['max_index_words'] ) {
							$wordsToAdd[] = $match;
						} else {
							break;
						}

						$wordsIndexedCount ++;
					}
				} else {
					// Error message if field type is not supported
					$params['error_message'] = 'Error: At least one of your fields is not of the required type. Make sure to only add text, list or textarea fields.';
				}
			}

			// Dictionary check
			if ( $this->options['gravtiy_form_settings']['use_dictionary'] === true ) {
				// The POS (part of speech) of the words we'd like to use
				// Array values might contain comma separated values. Imploding and exploding ensures all
				// comma separated values are separated in the array
				$pos = explode( ',', implode( ',', $this->options['gravtiy_form_settings']['dictionary_settings']['pos_to_show'] ) );

				if ( $this->options['gravtiy_form_settings']['dictionary_settings']['new_words_dictionary'] ) {
					$addNewWords = true;
				} else {
					$addNewWords = false;
				}

				// We're going to unset some values and confuse count() in this loop, better safe the count.
				$count = count( $wordsToAdd );

				// Check all the words against the dictionary
				for ( $i = 0; $i < $count; $i ++ ) {
					$isInDictionary = $this->checkDictionary( $wordsToAdd[ $i ], $pos, $addNewWords );

					if ( ! $isInDictionary ) {
						// Remove the word if it's not in the dictionary
						unset( $wordsToAdd[ $i ] );
					}
				}

				// Reindex the array
				$wordsToAdd = array_values( $wordsToAdd );
			}

			// Write the words list to the form entry meta data
			$this->saveFieldMetadata( $wordsToAdd, $entry );

			// Now add all the words we found
			foreach ( $wordsToAdd as $word ) {
				$this->addWordToCloud( $word );
			}
		}

		/**
		 * Save the meta data
		 *
		 * @param $words
		 * @param $entry
		 */
		protected function saveFieldMetadata( $words, $entry ) {
			gform_update_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words', $words );
			gform_update_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words_updated', time() );
			gform_update_meta( $entry['id'], $this->options['advanced_options']['unique_identifier'] . '-cloud_words_options_hash', $this->getCurrentOptionsHash() );
		}
	}
}
