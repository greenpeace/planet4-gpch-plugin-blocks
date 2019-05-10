<?php

namespace Greenpeace\Planet4GPCHBlocks;

use Greenpeace\Planet4GPCHBlocks\Blocks;

if ( ! class_exists( 'Planet4_GPCH_Plugin_Blocks' ) ) {
	class Planet4_GPCH_Plugin_Blocks {

		/**
		 * Singleton instance
		 *
		 * @var Planet4_Gpch_Plugin_Blocks
		 */
		private static $instance;

		/**
		 * Block instances
		 *
		 * @var $blocks
		 */
		private $blocks;


		/**
		 * Returns the instance
		 *
		 * @return Planet4_Gpch_Plugin_Blocks
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}


		/**
		 * Constructor.
		 */
		private function __construct() {
			// Check dependencies
			add_action( 'plugins_loaded', array( $this, 'check_plugin_dependencies' ) );

			// Scripts & Styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// Register a block category
			add_filter( 'block_categories', array( $this, 'register_block_category' ), 10, 2 );

			// Load Blocks
			add_action( 'acf/init', array( $this, 'load_blocks' ) );
		}


		/**
		 * Load our custom blocks
		 */
		public function load_blocks() {
			$this->blocks = [
				new Blocks\Planet4_GPCH_Block_Form_Progress_Bar(),
			];
		}


		/**
		 * Check for dependencies and output an error message if needed
		 */
		public function check_plugin_dependencies() {
			// Output an error message in case ACF isn't installed.
			if ( ! class_exists( 'ACF' ) ) {
				add_action( 'admin_notices', array( $this, 'error_message_no_acf' ) );
			}
			// Output an error message in case Timber isn't installed.
			if ( ! class_exists( 'Timber' ) ) {
				add_action( 'admin_notices', array( $this, 'error_message_no_timber' ) );
			}
		}


		/**
		 * Registers a new categories for our blocks
		 *
		 * @param $categories
		 * @param $post
		 *
		 * @return array
		 */
		public function register_block_category( $categories, $post ) {
			return array_merge(
				$categories,
				array(
					array(
						'slug'  => 'gpch',
						'title' => __( 'GPCH', 'planet4-gpch-blocks' ),
					),
				)
			);
		}


		/**
		 * Outputs an error message in Wordpress admin about ACF not being installed
		 */
		public function error_message_no_acf() {
			?>
            <div class="error notice">
                <p><?php _e( 'Planet 4 GPCH Blocks: Advanced Custom Fields must be installed and activated for this plugin to work.', 'planet4-gpch-blocks' ); ?></p>
            </div>
			<?php
		}


		/**
		 * Outputs an error message in Wordpress admin about Timber not being installed
		 */
		public function error_message_no_timber() {
			?>
            <div class="error notice">
                <p><?php _e( 'Planet 4 GPCH Blocks: Timber must be installed and activated for this plugin to work.', 'planet4-gpch-blocks' ); ?></p>
            </div>
			<?php
		}


		/**
		 * Enqueue our scripts
		 */
		public function enqueue_scripts() {
			$file = '/assets/css/style.css';

			wp_enqueue_style( 'planet4-gpch-blocks-style',
				P4_GPCH_PLUGIN_BLOCKS_BASE_URL . $file,
				null,
				filemtime( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . $file )
			);
		}
	}
}