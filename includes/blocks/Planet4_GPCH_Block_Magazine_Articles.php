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
					'title'                 => 'Magazine Articles',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_magazine_articles_tags',
							'label'             => 'Tags',
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
							'key'               => 'field_p4_gpch_blocks_magazine_article_count',
							'label'             => 'Article Count',
							'name'              => 'article_count',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 3,
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => '01',
							'max'               => 99,
							'step'              => 1,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_magazine_articles_ignore_tags',
							'label'             => 'Ignore Tags',
							'name'              => 'ignore_tags',
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
					'icon'            => 'book',
					'keywords'        => array( 'magazine', 'articles' ),
				) );
			}
		}

		/**
		 * Populate selected posts for frontend template.
		 *
		 * @param array $posts Selected posts.
		 *
		 * @return array
		 */
		private function populate_post_items( $posts ) {
			$recent_posts = [];

			if ( $posts ) {
				foreach ( $posts as $recent ) {
					$recent['alt_text'] = '';
					// TODO - Update this method to use P4_Post functionality to get P4_User.
					$author_override           = get_post_meta( $recent['ID'], 'p4_author_override', true );
					$recent['author_name']     = '' === $author_override ? get_the_author_meta( 'display_name', $recent['post_author'] ) : $author_override;
					$recent['author_url']      = '' === $author_override ? get_author_posts_url( $recent['post_author'] ) : '#';
					$recent['author_override'] = $author_override;

					if ( has_post_thumbnail( $recent['ID'] ) ) {
						$img_id                    = get_post_thumbnail_id( $recent['ID'] );
						$dimensions                = wp_get_attachment_metadata( $img_id );
						$recent['thumbnail_ratio'] = ( isset( $dimensions['height'] ) && $dimensions['height'] > 0 ) ? $dimensions['width'] / $dimensions['height'] : 1;
						$recent['alt_text']        = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					}

					// TODO - Update this method to use P4_Post functionality to get Tags/Terms.
					$wp_tags = wp_get_post_tags( $recent['ID'] );

					$tags = [];

					if ( $wp_tags ) {
						foreach ( $wp_tags as $wp_tag ) {
							$tags_data['name'] = $wp_tag->name;
							$tags_data['slug'] = $wp_tag->slug;
							$tags_data['link'] = get_tag_link( $wp_tag );
							$tags[]            = $tags_data;
						}
					}

					$recent['tags'] = $tags;
					$page_type_data = get_the_terms( $recent['ID'], 'p4-page-type' );
					$page_type      = '';
					$page_type_id   = '';

					if ( $page_type_data && ! is_wp_error( $page_type_data ) ) {
						$page_type    = $page_type_data[0]->name;
						$page_type_id = $page_type_data[0]->term_id;
					}

					$recent['page_type']    = $page_type;
					$recent['page_type_id'] = $page_type_id;
					$recent['link']         = get_permalink( $recent['ID'] );

					$recent_posts[] = $recent;
				}
			}

			return $recent_posts;
		}

		/**
		 * Callback function to render the content block
		 *
		 * @param $block
		 */
		public function render_block( $block ) {

			$post_type = 'gpch_magredirect';
			$orderby   = 'date';
			$order     = 'DESC';

			$fields = get_fields();

			$posts_per_page = $fields['article_count'];
			$tags           = $fields['tags'];
			$ignore_tags    = $fields['ignore_tags'];

			if ( $ignore_tags == 'true' ) {
				$tags = false;
			}

			// Prepare the arguments for the query

			$args = array(
				'post_type'      => $post_type,
				'orderby'        => $orderby,
				'order'          => $order,
				'posts_per_page' => $posts_per_page,
				'tags'           => $tags
			);

			$posts = wp_get_recent_posts( $args );

			// print_r('[$posts]');
			// print_r($posts);

			$recent_posts = $this->populate_post_items($posts);

			// print_r('[$recent_posts]');
			// print_r($recent_posts);

			// Prepare the parameters for the template
			$params = array(
				'recent_posts' => $recent_posts,
			);

			// Output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
