<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Block_GPCH_Events' ) ) {
	class Planet4_GPCH_Block_GPCH_Events extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/gpch_events.twig';


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
					'key'                   => 'group_p4_gpch_blocks_gpch_events',
					'title'                 => 'GPCH Events',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_title',
							'label'             => __( 'Title', 'planet4-gpch-blocks' ),
							'name'              => 'title',
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
							'maxlength'         => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_count',
							'label'             => __( 'Number of events', 'planet4-gpch-blocks' ),
							'name'              => 'event_count',
							'type'              => 'number',
							'instructions'      => __( 'The maximum number of events to display', 'planet4-gpch-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 4,
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => 1,
							'max'               => '',
							'step'              => 1,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_display',
							'label'             => __( 'Display', 'planet4-gpch-blocks' ),
							'name'              => 'display',
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
								'upcoming' => __( 'Upcoming Events', 'planet4-gpch-blocks' ),
								'past'     => __( 'Past Events', 'planet4-gpch-blocks' ),
								'all'      => __( 'All Events', 'planet4-gpch-blocks' ),
							),
							'default_value'     => array(
								0 => 'upcoming',
							),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_order',
							'label'             => __( 'Order', 'planet4-gpch-blocks' ),
							'name'              => 'order',
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
								'asc'  => __( 'Date Ascending', 'planet4-gpch-blocks' ),
								'desc' => __( 'Date Descending', 'planet4-gpch-blocks' ),
							),
							'default_value'     => array(
								0 => 'asc',
							),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_tags',
							'label'             => __( 'Tags', 'planet4-gpch-blocks' ),
							'name'              => 'tags',
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
							'field_type'        => 'multi_select',
							'allow_null'        => 0,
							'add_term'          => 0,
							'save_terms'        => 0,
							'load_terms'        => 0,
							'return_format'     => 'id',
							'multiple'          => 0,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_ignore_tags',
							'label'             => __( 'Ignore Tags', 'planet4-gpch-blocks' ),
							'name'              => 'ignore_tags',
							'type'              => 'select',
							'instructions'      => __( 'Ignore tags and show events of all tags', 'planet4-gpch-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'false' => 'No',
								'true'  => 'Yes',
							),
							'default_value'     => array(
								0 => 'false',
							),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_select_posts',
							'label'             => __( 'Select posts', 'planet4-gpch-blocks' ),
							'name'              => 'select_posts',
							'type'              => 'post_object',
							'instructions'      => __( 'Select posts to show manually and override the tag / post type selection', 'planet4-gutenberg-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'post_type'         => 'gpch_event',
							'taxonomy'          => '',
							'allow_null'        => 0,
							'multiple'          => 1,
							'return_format'     => 'id',
							'ui'                => 1,
						),

						array(
							'key'               => 'field_p4_gpch_blocks_gpch_events_description',
							'label'             => __( 'No Events Text', 'planet4-gpch-blocks' ),
							'name'              => 'no_events_text',
							'type'              => 'wysiwyg',
							'instructions'      => __( 'This text will be shown when no events are available', 'planet4-gpch-blocks' ),
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'tabs'              => 'all',
							'toolbar'           => 'full',
							'media_upload'      => 0,
							'delay'             => 0,
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-gpch-events',
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
					'name'            => 'p4-gpch-block-gpch-events',
					'title'           => __( 'GPCH Events', 'planet4-gpch-blocks' ),
					'description'     => __( 'GPCH Events', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'calendar',
					'keywords'        => array( 'events', 'agenda' ),
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

			// Events filter
			$args = array(
				'post_type'      => array( 'gpch_event' ),
				'post_status'    => array( 'publish' ),
				//'nopaging'       => true,
				'order'          => $fields['order'],
				'orderby'        => 'meta_value_num',
				'posts_per_page' => $fields['event_count'],
				'meta_key'       => 'event_date',
			);

			// Filter by date if either 'past' or 'upcoming' are selected
			if ( $fields['display'] == 'upcoming' ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'event_date',
						'value'   => date( 'Ymd' ),
						'type'    => 'DATE',
						'compare' => '>=',
					),
				);
			} else if ( $fields['display'] == 'past' ) {
				$args['meta_query'] = array(
					array(
						'key'     => 'event_date',
						'value'   => date( 'Ymd' ),
						'type'    => 'DATE',
						'compare' => '<',
					),
				);
			}

			// Only filter by tags if the ignore setting isn't selected
			if ( $fields['ignore_tags'] != 'true' ) {
				$args['tag__in'] = $fields['tags'];
			}

			// If events are selected directly, limit to those events
			if ( is_array( $fields['select_posts'] ) ) {
				$args['post__in'] = $fields['select_posts'];
			}

			$result = new \WP_Query( $args );

			$events = array();

			foreach ( $result->posts as $event ) {
				// Get post thumbnail
				if ( has_post_thumbnail( $event->ID ) ) {
					$event->thumbnail_id = get_post_thumbnail_id( $event->ID );
				}

				// Get tags
				$event->tags = wp_get_post_tags( $event->ID );

				// Class list for color schemes
				$classes = '';
				foreach ($event->tags as $tag) {
					$classes .= 'tag-' . $tag->slug . " ";
				}
				$event->classes = $classes;

				// Permalink
				$event->link = get_post_permalink( $event );

				// Event date , time and place (from ACF field)
				$event->date       = get_field( 'event_date', $event->ID );
				$event->start_time = get_field( 'start_time', $event->ID );
				$event->place      = get_field( 'place', $event->ID );

				$events[] = $event;
			}

			// Prepare parameters for template
			$params = array(
				'events'         => $events,
				'title'          => $fields['title'],
				'no_events_text' => $fields['no_events_text'],
			);

			// Output template
			\Timber::render( $this->template_file, $params );

			// Restore original Post Data
			wp_reset_postdata();
		}
	}
}
