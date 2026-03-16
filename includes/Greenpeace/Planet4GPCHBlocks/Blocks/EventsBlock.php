<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

use Timber\Timber;

class EventsBlock extends BaseBlock {
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
						'label'             => __( 'Title', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Number of events', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'event_count',
						'type'              => 'number',
						'instructions'      => __( 'The maximum number of events to display', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Display', 'planet4-gpch-plugin-blocks' ),
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
							'upcoming' => __( 'Upcoming Events', 'planet4-gpch-plugin-blocks' ),
							'past'     => __( 'Past Events', 'planet4-gpch-plugin-blocks' ),
							'all'      => __( 'All Events', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Order', 'planet4-gpch-plugin-blocks' ),
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
							'asc'  => __( 'Date Ascending', 'planet4-gpch-plugin-blocks' ),
							'desc' => __( 'Date Descending', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Tags', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Ignore Tags', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'ignore_tags',
						'type'              => 'select',
						'instructions'      => __( 'Ignore tags and show events of all tags', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'Select posts', 'planet4-gpch-plugin-blocks' ),
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
						'label'             => __( 'No Events Text', 'planet4-gpch-plugin-blocks' ),
						'name'              => 'no_events_text',
						'type'              => 'wysiwyg',
						'instructions'      => __( 'This text will be shown when no events are available', 'planet4-gpch-plugin-blocks' ),
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
				'title'           => __( 'GPCH Events', 'planet4-gpch-plugin-blocks' ),
				'description'     => __( 'GPCH Events', 'planet4-gpch-plugin-blocks' ),
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
		$event_count = isset( $fields['event_count'] ) ? (int) $fields['event_count'] : 4;
		$display = isset( $fields['display'] ) ? $fields['display'] : 'upcoming';
		$order = isset( $fields['order'] ) ? strtoupper( $fields['order'] ) : 'ASC';

		// Events filter
		$args = array(
			'post_type'      => array( 'gpch_event' ),
			'post_status'    => array( 'publish' ),
			'order'          => in_array( $order, array( 'ASC', 'DESC' ), true ) ? $order : 'ASC',
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'event_date',
			'no_found_rows'  => true,
		);

		// Keep SQL light and handle end-date fallback logic in PHP.
		$today = date( 'Ymd' );

		if ( 'upcoming' === $display ) {
			// Events are at most 3 months long, so this window still includes ongoing events.
			$window_start = date( 'Ymd', strtotime( '-3 months' ) );

			$args['meta_query'] = array(
				array(
					'key'     => 'event_date',
					'value'   => $window_start,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				),
			);
		} else if ( 'past' === $display ) {
			$args['meta_query'] = array(
				array(
					'key'     => 'event_date',
					'value'   => $today,
					'type'    => 'NUMERIC',
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

		$events = array();
		$requires_php_date_filter = in_array( $display, array( 'upcoming', 'past' ), true );

		if ( $requires_php_date_filter ) {
			$today_numeric = (int) $today;
			$page = 1;
			$batch_size = max( $event_count * 4, 20 );

			while ( count( $events ) < $event_count ) {
				$page_args = $args;
				$page_args['posts_per_page'] = $batch_size;
				$page_args['paged'] = $page;

				$result = new \WP_Query( $page_args );
				if ( empty( $result->posts ) ) {
					break;
				}

				foreach ( $result->posts as $event ) {
					$event_date = (int) get_post_meta( $event->ID, 'event_date', true );
					$end_date = get_post_meta( $event->ID, 'event_end_date', true );
					
					// If end date is set, use it for filtering, otherwise fall back to event date.
					$effective_end_date = '' !== $end_date ? (int) $end_date : $event_date;

					if ( $display === 'upcoming' && $effective_end_date < $today_numeric ) {
						continue;
					}

					if ( $display === 'past' && $effective_end_date >= $today_numeric ) {
						continue;
					}

					$events[] = $this->prepare_event( $event );
					
					if ( count( $events ) >= $event_count ) {
						break;
					}
				}

				if ( count( $result->posts ) < $batch_size ) {
					break;
				}

				$page++;
			}
		} else { // if "All Events" is selected, we can directly limit in SQL
			$args['posts_per_page'] = $event_count;
			$result = new \WP_Query( $args );

			foreach ( $result->posts as $event ) {
				$events[] = $this->prepare_event( $event );
			}
		}

		// Prepare parameters for template
		$params = array(
			'events'         => $events,
			'title'          => $fields['title'],
			'no_events_text' => $fields['no_events_text'],
			'archive_link'   => get_post_type_archive_link( 'gpch_event' ),
		);

		// Output template
		Timber::render( $this->template_file, $params );

		// Restore original Post Data
		wp_reset_postdata();
	}

	/**
	 * Prepare event data for template output.
	 *
	 * @param object $event Event post object.
	 *
	 * @return object
	 */
	private function prepare_event( $event ) {
		// Get post thumbnail.
		if ( has_post_thumbnail( $event->ID ) ) {
			$event->thumbnail_id = get_post_thumbnail_id( $event->ID );
		}

		// Get tags.
		$event->tags = wp_get_post_tags( $event->ID );

		// Class list for color schemes.
		$classes = '';
		foreach ( $event->tags as $tag ) {
			$classes .= 'tag-' . $tag->slug . ' ';
		}
		$event->classes = $classes;

		// Permalink.
		$event->link = get_post_permalink( $event );

		// Event date, time and place (from ACF fields).
		$event->date       = get_field( 'event_date', $event->ID );
		$event->end_date   = get_field( 'event_end_date', $event->ID );
		$event->start_time = get_field( 'start_time', $event->ID );
		$event->place      = get_field( 'place', $event->ID );

		return $event;
	}
}
