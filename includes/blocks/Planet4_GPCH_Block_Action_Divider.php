<?php

namespace Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Action_Divider' ) ) {
	class Planet4_GPCH_Action_Divider extends Planet4_GPCH_Base_Block {
		/**
		 * @var string Template file path
		 */
		protected $template_file = P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'templates/blocks/action_divider.twig';

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
					'key'                   => 'group_p4_gpch_blocks_action_divider',
					'title'                 => 'Donation Devider',
					'fields'                => array(
						array(
							'key'               => 'field_p4_gpch_blocks_action_divider_text',
							'label'             => __( 'Text', 'planet4-gpch-blocks' ),
							'name'              => 'text',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => 'Unsere Arbeit wird durch Spenden ermöglicht.',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => 255,
						),
						array(
							'key'               => 'field_p4_gpch_blocks_action_divider_button_link',
							'label'             => __( 'Action Link', 'planet4-gpch-blocks' ),
							'name'              => 'action_link',
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
							'key' => 'field_p4_gpch_blocks_action_divider_icon',
							'label' => __( 'Icon', 'planet4-gpch-blocks' ),
							'name' => 'icon',
							'type' => 'select',
							'instructions' => __( 'For a preview please visit https://developer.wordpress.org/resource/dashicons/', 'planet4-gpch-blocks' ),
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'no-icon' => __( '-- no icon --', 'planet4-gpch-blocks' ),
								'dashicons-menu' => 'menu',
								'dashicons-menu-alt' => 'menu-alt',
								'dashicons-menu-alt2' => 'menu-alt2',
								'dashicons-menu-alt3' => 'menu-alt3',
								'dashicons-admin-site' => 'admin-site',
								'dashicons-admin-site-alt' => 'admin-site-alt',
								'dashicons-admin-site-alt2' => 'admin-site-alt2',
								'dashicons-admin-site-alt3' => 'admin-site-alt3',
								'dashicons-dashboard' => 'dashboard',
								'dashicons-admin-post' => 'admin-post',
								'dashicons-admin-media' => 'admin-media',
								'dashicons-admin-links' => 'admin-links',
								'dashicons-admin-page' => 'admin-page',
								'dashicons-admin-comments' => 'admin-comments',
								'dashicons-admin-appearance' => 'admin-appearance',
								'dashicons-admin-plugins' => 'admin-plugins',
								'dashicons-plugins-checked' => 'plugins-checked',
								'dashicons-admin-users' => 'admin-users',
								'dashicons-admin-tools' => 'admin-tools',
								'dashicons-admin-settings' => 'admin-settings',
								'dashicons-admin-network' => 'admin-network',
								'dashicons-admin-home' => 'admin-home',
								'dashicons-admin-generic' => 'admin-generic',
								'dashicons-admin-collapse' => 'admin-collapse',
								'dashicons-filter' => 'filter',
								'dashicons-admin-customizer' => 'admin-customizer',
								'dashicons-admin-multisite' => 'admin-multisite',
								'dashicons-welcome-write-blog' => 'welcome-write-blog',
								'dashicons-welcome-add-page' => 'welcome-add-page',
								'dashicons-welcome-view-site' => 'welcome-view-site',
								'dashicons-welcome-widgets-menus' => 'welcome-widgets-menus',
								'dashicons-welcome-comments' => 'welcome-comments',
								'dashicons-welcome-learn-more' => 'welcome-learn-more',
								'dashicons-format-aside' => 'format-aside',
								'dashicons-format-image' => 'format-image',
								'dashicons-format-gallery' => 'format-gallery',
								'dashicons-format-video' => 'format-video',
								'dashicons-format-status' => 'format-status',
								'dashicons-format-quote' => 'format-quote',
								'dashicons-format-chat' => 'format-chat',
								'dashicons-format-audio' => 'format-audio',
								'dashicons-camera' => 'camera',
								'dashicons-camera-alt' => 'camera-alt',
								'dashicons-images-alt' => 'images-alt',
								'dashicons-images-alt2' => 'images-alt2',
								'dashicons-video-alt' => 'video-alt',
								'dashicons-video-alt2' => 'video-alt2',
								'dashicons-video-alt3' => 'video-alt3',
								'dashicons-media-archive' => 'media-archive',
								'dashicons-media-audio' => 'media-audio',
								'dashicons-media-code' => 'media-code',
								'dashicons-media-default' => 'media-default',
								'dashicons-media-document' => 'media-document',
								'dashicons-media-interactive' => 'media-interactive',
								'dashicons-media-spreadsheet' => 'media-spreadsheet',
								'dashicons-media-text' => 'media-text',
								'dashicons-media-video' => 'media-video',
								'dashicons-playlist-audio' => 'playlist-audio',
								'dashicons-playlist-video' => 'playlist-video',
								'dashicons-controls-play' => 'controls-play',
								'dashicons-controls-pause' => 'controls-pause',
								'dashicons-controls-forward' => 'controls-forward',
								'dashicons-controls-skipforward' => 'controls-skipforward',
								'dashicons-controls-back' => 'controls-back',
								'dashicons-controls-skipback' => 'controls-skipback',
								'dashicons-controls-repeat' => 'controls-repeat',
								'dashicons-controls-volumeon' => 'controls-volumeon',
								'dashicons-controls-volumeoff' => 'controls-volumeoff',
								'dashicons-image-crop' => 'image-crop',
								'dashicons-image-rotate' => 'image-rotate',
								'dashicons-image-rotate-left' => 'image-rotate-left',
								'dashicons-image-rotate-right' => 'image-rotate-right',
								'dashicons-image-flip-vertical' => 'image-flip-vertical',
								'dashicons-image-flip-horizontal' => 'image-flip-horizontal',
								'dashicons-image-filter' => 'image-filter',
								'dashicons-undo' => 'undo',
								'dashicons-redo' => 'redo',
								'dashicons-editor-bold' => 'editor-bold',
								'dashicons-editor-italic' => 'editor-italic',
								'dashicons-editor-ul' => 'editor-ul',
								'dashicons-editor-ol' => 'editor-ol',
								'dashicons-editor-ol-rtl' => 'editor-ol-rtl',
								'dashicons-editor-quote' => 'editor-quote',
								'dashicons-editor-alignleft' => 'editor-alignleft',
								'dashicons-editor-aligncenter' => 'editor-aligncenter',
								'dashicons-editor-alignright' => 'editor-alignright',
								'dashicons-editor-insertmore' => 'editor-insertmore',
								'dashicons-editor-spellcheck' => 'editor-spellcheck',
								'dashicons-editor-expand' => 'editor-expand',
								'dashicons-editor-contract' => 'editor-contract',
								'dashicons-editor-kitchensink' => 'editor-kitchensink',
								'dashicons-editor-underline' => 'editor-underline',
								'dashicons-editor-justify' => 'editor-justify',
								'dashicons-editor-textcolor' => 'editor-textcolor',
								'dashicons-editor-paste-word' => 'editor-paste-word',
								'dashicons-editor-paste-text' => 'editor-paste-text',
								'dashicons-editor-removeformatting' => 'editor-removeformatting',
								'dashicons-editor-video' => 'editor-video',
								'dashicons-editor-customchar' => 'editor-customchar',
								'dashicons-editor-outdent' => 'editor-outdent',
								'dashicons-editor-indent' => 'editor-indent',
								'dashicons-editor-help' => 'editor-help',
								'dashicons-editor-strikethrough' => 'editor-strikethrough',
								'dashicons-editor-unlink' => 'editor-unlink',
								'dashicons-editor-rtl' => 'editor-rtl',
								'dashicons-editor-ltr' => 'editor-ltr',
								'dashicons-editor-break' => 'editor-break',
								'dashicons-editor-code' => 'editor-code',
								'dashicons-editor-paragraph' => 'editor-paragraph',
								'dashicons-editor-table' => 'editor-table',
								'dashicons-align-left' => 'align-left',
								'dashicons-align-right' => 'align-right',
								'dashicons-align-center' => 'align-center',
								'dashicons-align-none' => 'align-none',
								'dashicons-lock' => 'lock',
								'dashicons-unlock' => 'unlock',
								'dashicons-calendar' => 'calendar',
								'dashicons-calendar-alt' => 'calendar-alt',
								'dashicons-visibility' => 'visibility',
								'dashicons-hidden' => 'hidden',
								'dashicons-post-status' => 'post-status',
								'dashicons-edit' => 'edit',
								'dashicons-trash' => 'trash',
								'dashicons-sticky' => 'sticky',
								'dashicons-external' => 'external',
								'dashicons-arrow-up' => 'arrow-up',
								'dashicons-arrow-down' => 'arrow-down',
								'dashicons-arrow-right' => 'arrow-right',
								'dashicons-arrow-left' => 'arrow-left',
								'dashicons-arrow-up-alt' => 'arrow-up-alt',
								'dashicons-arrow-down-alt' => 'arrow-down-alt',
								'dashicons-arrow-right-alt' => 'arrow-right-alt',
								'dashicons-arrow-left-alt' => 'arrow-left-alt',
								'dashicons-arrow-up-alt2' => 'arrow-up-alt2',
								'dashicons-arrow-down-alt2' => 'arrow-down-alt2',
								'dashicons-arrow-right-alt2' => 'arrow-right-alt2',
								'dashicons-arrow-left-alt2' => 'arrow-left-alt2',
								'dashicons-sort' => 'sort',
								'dashicons-leftright' => 'leftright',
								'dashicons-randomize' => 'randomize',
								'dashicons-list-view' => 'list-view',
								'dashicons-excerpt-view' => 'excerpt-view',
								'dashicons-grid-view' => 'grid-view',
								'dashicons-move' => 'move',
								'dashicons-share' => 'share',
								'dashicons-share-alt' => 'share-alt',
								'dashicons-share-alt2' => 'share-alt2',
								'dashicons-twitter' => 'twitter',
								'dashicons-rss' => 'rss',
								'dashicons-email' => 'email',
								'dashicons-email-alt' => 'email-alt',
								'dashicons-email-alt2' => 'email-alt2',
								'dashicons-facebook' => 'facebook',
								'dashicons-facebook-alt' => 'facebook-alt',
								'dashicons-googleplus' => 'googleplus',
								'dashicons-networking' => 'networking',
								'dashicons-instagram' => 'instagram',
								'dashicons-hammer' => 'hammer',
								'dashicons-art' => 'art',
								'dashicons-migrate' => 'migrate',
								'dashicons-performance' => 'performance',
								'dashicons-universal-access' => 'universal-access',
								'dashicons-universal-access-alt' => 'universal-access-alt',
								'dashicons-tickets' => 'tickets',
								'dashicons-nametag' => 'nametag',
								'dashicons-clipboard' => 'clipboard',
								'dashicons-heart' => 'heart',
								'dashicons-megaphone' => 'megaphone',
								'dashicons-schedule' => 'schedule',
								'dashicons-tide' => 'tide',
								'dashicons-rest-api' => 'rest-api',
								'dashicons-code-standards' => 'code-standards',
								'dashicons-buddicons-activity' => 'buddicons-activity',
								'dashicons-buddicons-bbpress-logo' => 'buddicons-bbpress-logo',
								'dashicons-buddicons-buddypress-logo' => 'buddicons-buddypress-logo',
								'dashicons-buddicons-community' => 'buddicons-community',
								'dashicons-buddicons-forums' => 'buddicons-forums',
								'dashicons-buddicons-friends' => 'buddicons-friends',
								'dashicons-buddicons-groups' => 'buddicons-groups',
								'dashicons-buddicons-pm' => 'buddicons-pm',
								'dashicons-buddicons-replies' => 'buddicons-replies',
								'dashicons-buddicons-topics' => 'buddicons-topics',
								'dashicons-buddicons-tracking' => 'buddicons-tracking',
								'dashicons-wordpress' => 'wordpress',
								'dashicons-wordpress-alt' => 'wordpress-alt',
								'dashicons-pressthis' => 'pressthis',
								'dashicons-update' => 'update',
								'dashicons-update-alt' => 'update-alt',
								'dashicons-screenoptions' => 'screenoptions',
								'dashicons-info' => 'info',
								'dashicons-cart' => 'cart',
								'dashicons-feedback' => 'feedback',
								'dashicons-cloud' => 'cloud',
								'dashicons-translation' => 'translation',
								'dashicons-tag' => 'tag',
								'dashicons-category' => 'category',
								'dashicons-archive' => 'archive',
								'dashicons-tagcloud' => 'tagcloud',
								'dashicons-text' => 'text',
								'dashicons-yes' => 'yes',
								'dashicons-yes-alt' => 'yes-alt',
								'dashicons-no' => 'no',
								'dashicons-no-alt' => 'no-alt',
								'dashicons-plus' => 'plus',
								'dashicons-plus-alt' => 'plus-alt',
								'dashicons-minus' => 'minus',
								'dashicons-dismiss' => 'dismiss',
								'dashicons-marker' => 'marker',
								'dashicons-star-filled' => 'star-filled',
								'dashicons-star-half' => 'star-half',
								'dashicons-star-empty' => 'star-empty',
								'dashicons-flag' => 'flag',
								'dashicons-warning' => 'warning',
								'dashicons-location' => 'location',
								'dashicons-location-alt' => 'location-alt',
								'dashicons-vault' => 'vault',
								'dashicons-shield' => 'shield',
								'dashicons-shield-alt' => 'shield-alt',
								'dashicons-sos' => 'sos',
								'dashicons-search' => 'search',
								'dashicons-slides' => 'slides',
								'dashicons-text-page' => 'text-page',
								'dashicons-analytics' => 'analytics',
								'dashicons-chart-pie' => 'chart-pie',
								'dashicons-chart-bar' => 'chart-bar',
								'dashicons-chart-line' => 'chart-line',
								'dashicons-chart-area' => 'chart-area',
								'dashicons-groups' => 'groups',
								'dashicons-businessman' => 'businessman',
								'dashicons-businesswoman' => 'businesswoman',
								'dashicons-businessperson' => 'businessperson',
								'dashicons-id' => 'id',
								'dashicons-id-alt' => 'id-alt',
								'dashicons-products' => 'products',
								'dashicons-awards' => 'awards',
								'dashicons-forms' => 'forms',
								'dashicons-testimonial' => 'testimonial',
								'dashicons-portfolio' => 'portfolio',
								'dashicons-book' => 'book',
								'dashicons-book-alt' => 'book-alt',
								'dashicons-download' => 'download',
								'dashicons-upload' => 'upload',
								'dashicons-backup' => 'backup',
								'dashicons-clock' => 'clock',
								'dashicons-lightbulb' => 'lightbulb',
								'dashicons-microphone' => 'microphone',
								'dashicons-desktop' => 'desktop',
								'dashicons-laptop' => 'laptop',
								'dashicons-tablet' => 'tablet',
								'dashicons-smartphone' => 'smartphone',
								'dashicons-phone' => 'phone',
								'dashicons-index-card' => 'index-card',
								'dashicons-carrot' => 'carrot',
								'dashicons-building' => 'building',
								'dashicons-store' => 'store',
								'dashicons-album' => 'album',
								'dashicons-palmtree' => 'palmtree',
								'dashicons-tickets-alt' => 'tickets-alt',
								'dashicons-money' => 'money',
								'dashicons-smiley' => 'smiley',
								'dashicons-thumbs-up' => 'thumbs-up',
								'dashicons-thumbs-down' => 'thumbs-down',
								'dashicons-layout' => 'layout',
								'dashicons-paperclip' => 'paperclip',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/p4-gpch-block-action-divider',
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
					'name'            => 'p4-gpch-block-action-divider',
					'title'           => __( 'Action Divider', 'planet4-gpch-blocks' ),
					'description'     => __( 'Divider Block with Donation Button', 'planet4-gpch-blocks' ),
					'render_callback' => array( $this, 'render_block' ),
					'category'        => 'gpch',
					'icon'            => 'minus',
					'keywords'        => array( 'action', 'divider' ),
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

			// prepare parameters for template

			// error_log( print_r( '[grownnotmade]' ) );
			// error_log( print_r( '[Planet4_GPCH_Base_Block] -> [render_block($block)] -> [$fields]' ) );
			// error_log( print_r( $fields ) );

			$text  = $fields['text'];
			$title = $fields['action_link']['title'];
			$url   = $fields['action_link']['url'];
			$icon  = $fields['icon'];

			if ( $fields['action_link']['target'] != '' ) {
				$target = $fields['action_link']['target'];
			} else {
				$target = '_self';
			}

			$params = array(
				'text'   => $text,
				'title'  => $title,
				'url'    => $url,
				'target' => $target,
				'icon' => $icon,
			);

			// output template
			\Timber::render( $this->template_file, $params );
		}
	}
}
