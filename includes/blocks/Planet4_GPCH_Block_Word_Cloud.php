<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_Word_Cloud' ) ) {
	class Planet4_GPCH_Block_Word_Cloud extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/word_cloud.twig';

		/**
		 * @var array The list of words for the clouds including weights
		 */
		protected $words;

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
		protected $debugMessages;

		protected $reindexCounter;

		public function __construct() {
			$this->register_acf_field_group();

			add_action( 'acf/init', array( $this, 'register_acf_block' ) );

			$this->words     = array();
			$this->minWeight = 9999999;
			$this->maxWeight = 0;
			$this->debugMessages = array();
			$reindexCounter  = 0;
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
							),
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
										'NN'                     => 'Nouns',
										'NE'                     => 'Names',
										'ADJA'                   => 'Adjectives',
										'VVINF,VVPP,VVFIN,VVIZU' => 'Verbs',
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
						array(
							'key'               => 'field_p4_gpch_blocks_word_cloud_word_colors',
							'label'             => 'Word colors',
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
								'function'   => 'Use your own function',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_word_colors_function',
							'label'             => 'word_colors_function',
							'name'              => 'word_colors_function',
							'type'              => 'textarea',
							'instructions'      => 'You can create your own color function and paste it into this field. See the examples here:
https://wordcloud2-js.timdream.org/',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_word_colors',
										'operator' => '==',
										'value'    => 'function',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_advanced_options',
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
							'key'               => 'field_p4_gpch_blocks_word_cloud_max_words',
							'label'             => 'Max words to show',
							'name'              => 'max_words_to_show',
							'type'              => 'number',
							'instructions'      => 'The maximum number of words shown in the cloud.',
							'required'          => 0,
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_advanced_options',
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
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_advanced_options',
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
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_advanced_options',
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
							'default_value'     => 10,
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
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_p4_gpch_blocks_word_cloud_advanced_options',
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
							'message'           => '',
							'default_value'     => 0,
							'ui'                => 1,
							'ui_on_text'        => '',
							'ui_off_text'       => '',
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
			$this->addDebugMessage('Rendering started');

			$fields = get_fields();

			// General parameters
			$params = array(
				'script' => P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'assets/js/wordcloud2.js',
				'dom_id' => uniqid( 'word-cloud-' )
			);

			// Get a list of words, either from a list or a gravity form
			if ( $fields['data_source'] == 'list' ) {
				$words = explode( "\n", $fields['words_list'] );

				for ( $i = 0; $i < count( $words ); $i ++ ) {
					$words[ $i ] = trim( $words[ $i ] );
					$words[ $i ] = explode( ' ', $words[ $i ] );
				}

				$this->words = $words;
			} elseif ( $fields['data_source'] == 'gravityform' ) {
				// Find the field IDs
				$fieldIds = explode( ',', $fields['gravtiy_form_settings']['gravity_form_field_id'] );

				// Make sure there are no spaces
				for ( $i = 0; $i < count( $fieldIds ); $i ++ ) {
					$fieldIds[ $i ] = trim( $fieldIds[ $i ] );
				}

				foreach ( $fieldIds as $fieldId ) {
					// Get field metadata. Most important is the type of field we're dealing with
					// Should be either "text", "list" or textarea
					$field = \GFAPI::get_field( $fields['gravtiy_form_settings']['gravity_form_id'], $fieldId );

					if ( $field === false ) {
						$params['error_message'] = 'Error: At least one of your field IDs doesn\'t match a field.';
						break;
					}

					// Get form entries until the set time and date in the block settings
					$search_criteria['end_date'] = $fields['gravtiy_form_settings']['show_entries_until'];
					$entries                     = \GFAPI::get_entries( $fields['gravtiy_form_settings']['gravity_form_id'], $search_criteria );

					// Find the words in entries
					foreach ( $entries as $entry ) {
						$this->reindexCounter = $this->reindexCounter + 1;
						var_dump($this->reindexCounter);
						var_dump($fields['max_reindex_rate']);
						if ( $this->reindexCounter <= $fields['max_reindex_rate'] ) {
							var_dump('indexing entry');
							$wordsToAdd = array();

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

								foreach ( $matches[0] as $match ) {
									$wordsToAdd[] = $match;
								}
							} else {
								// Error message if field type is not supported
								$params['error_message'] = 'Error: At least one of your fields is not of the required type. Make sure to only add text, list or textarea fields.';
							}

							// Add the fields to the cloud, either using the dictionary or not
							if ( $fields['use_dictionary'] === true ) {
								// The POS (part of speech) of the words we'd like to use
								// Array values might contain comma separated values. Imploding and exploding ensures all
								// comma separated values are separated in the array
								$pos = explode( ',', implode( ',', $fields['dictionary_settings']['pos_to_show'] ) );

								if ( $fields['dictionary_settings']['new_words_dictionary'] ) {
									$addNewWords = true;
								} else {
									$addNewWords = false;
								}

								foreach ( $wordsToAdd as $word ) {
									$this->addWord( $word, true, $pos, $addNewWords );
								}
							} else {
								foreach ( $wordsToAdd as $word ) {
									$this->addWord( $word, false );
								}
							}
						}
					}
				}
			}

			// The cloud looks best when the words with biggest weight are drawn first. Sorting for weight.
			usort( $this->words, array( $this, "sortWords" ) );

			if (isset($fields['max_words_to_show'])) {
				$params['word_list'] = json_encode( array_slice($this->words, 0, $fields['max_words_to_show']));
			}
			else {
				$params['word_list'] = json_encode( $this->words );
			}

			// We need to know the min max weight of words in the list to calulate their size in the map
			$this->calculateMinMaxWeight();
			$params['max_word_size'] = $this->maxWeight;
			$params['min_word_size'] = $this->minWeight;

			// Colors schemes
			if ( $fields['word_colors'] == 'random' ) {
				$params['random_colors'] = 1;
			} else if ( $fields['word_colors'] == 'greenpeace' ) {
				$params['word_colors'][0] = '#73BE1E';
				$params['word_colors'][1] = '#00573a';
				$params['word_colors'][2] = '#dbebbe';
			} else if ( $fields['word_colors'] == 'climate' ) {
				$params['word_colors'][0] = '#cd1719';
				$params['word_colors'][1] = '#eaccbb';
				$params['word_colors'][2] = '#cccccc';
			} else if ( $fields['word_colors'] == 'plastics' ) {
				$params['word_colors'][0] = '#e94e28';
				$params['word_colors'][1] = '#69c2be';
				$params['word_colors'][2] = '#c4e3e1';
			}

			// Find out where to split between colors in the cloud
			$params['color_split_1'] = $this->findWeightAtPercentile( 10 );
			$params['color_split_2'] = $this->findWeightAtPercentile( 70 );

			$this->addDebugMessage('Output started');

			if ($fields['debug_output']) {
				$params['debug_messages'] = $this->debugMessages;
			}

			// output template
			\Timber::render( $this->template_file, $params );
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
		 * @param bool $useDictionary
		 * @param array $pos
		 * @param bool $addNewWords
		 */
		protected function addWord( $word, $useDictionary = false, $pos = array(), $addNewWords = true ) {
			$word = ucfirst( $word );

			// Check dictionary
			if ( $useDictionary ) {
				$dictionaryCheck = $this->checkDictionary( $word, $pos, $addNewWords );

				// Return when dictionary check fails
				if ( $dictionaryCheck === false ) {
					return;
				}
			}

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
			foreach ( $this->words as $word ) {
				if ( $word[1] < $this->minWeight ) {
					$this->minWeight = $word[1];
				}
				if ( $word[1] > $this->maxWeight ) {
					$this->maxWeight = $word[1];
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
		}

		/**
		 * Checks if a word is in the dictionary and the POS.
		 *
		 * @param $word
		 * @param $pos POS, part of speech
		 * @param bool $addNewWord
		 *
		 * @return bool True if word was found and belongs to the listed $pos
		 */
		protected function checkDictionary( $word, $pos, $addNewWord = true ) {
			global $wpdb;

			$tableName = $wpdb->prefix . "gpch_wordcloud_dictionary";

			$sql     = "SELECT type, blacklisted, confirmed FROM {$tableName} WHERE word = '{$word}' AND language = '" . ICL_LANGUAGE_CODE . "'";
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

			$tableName = $wpdb->prefix . "gpch_wordcloud_dictionary";

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

		protected function addDebugMessage($message) {
			$t = microtime(true);
			$micro = sprintf("%06d",($t - floor($t)) * 1000000);
			$d = new \DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

			$this->debugMessages[] = $d->format("H:i:s.u") . " " . $message;
		}
	}
}
