<?php

use Greenpeace\Planet4GPCHBlocks\Blocks;

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

		// Register Scripts
		add_action( 'init', array( $this, 'register_scripts' ) );

		// Load Blocks
		$this->blocks = [
			new Blocks\BSBingoBlock(),
			new Blocks\P2PShareBlock(),
			new Blocks\FormEntriesBlock(),
            new Blocks\DreampeaceCoverBlock(),
            new Blocks\DreampeaceSlideBlock(),
			new Blocks\FormProgressBarBlock(),
			new Blocks\FormCounterTextBlock(),
			new Blocks\ActionDividerBlock(),
			new Blocks\AccordionBlock(),
			new Blocks\TaskforceBlock(),
			new Blocks\EventsBlock(),
			new Blocks\NewsletterBlock(),
			new Blocks\SpacerBlock(),
			new Blocks\MagazineArticlesBlock(),
			new Blocks\WordCloudBlock(),
			new Blocks\BannerToolBlock(),
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
					'title' => __( 'GPCH', 'planet4-gpch-plugin-blocks' ),
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
            <p><?php _e( 'Planet 4 GPCH Blocks: Advanced Custom Fields must be installed and activated for this plugin to work.', 'planet4-gpch-plugin-blocks' ); ?></p>
        </div>
		<?php
	}


	/**
	 * Outputs an error message in Wordpress admin about Timber not being installed
	 */
	public function error_message_no_timber() {
		?>
        <div class="error notice">
            <p><?php _e( 'Planet 4 GPCH Blocks: Timber must be installed and activated for this plugin to work.', 'planet4-gpch-plugin-blocks' ); ?></p>
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

		$js = 'assets/js/blocks.js';

		wp_enqueue_script( 'planet4-gpch-blocks-js',
			P4_GPCH_PLUGIN_BLOCKS_BASE_URL . $js,
			array( 'jquery' ),
			filemtime( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . $js ),
			true );

		wp_localize_script( 'planet4-gpch-blocks-js', 'gpchBlocks', array(
			'restURL'   => rest_url(),
			'restNonce' => wp_create_nonce( 'wp_rest' ),
			'postID'    => get_the_ID(),
			'pluginUrl' => P4_GPCH_PLUGIN_BLOCKS_BASE_URL,
		) );

		// Make the assets URL available in JS
		$script = 'var gpchBlocksAssetsURL = "' . P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'assets/"';

		wp_add_inline_script( 'planet4-gpch-blocks-js', $script, 'before' );
	}

	/**
	 * Register Gutenberg JS
	 */
	function register_scripts() {
		// automatically load dependencies and version
		$asset_file = include( P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'build/js/admin/index.asset.php' );

		// Register Gutenberg blocks script
		wp_register_script(
			'planet4-gpch-plugin-blocks',
			P4_GPCH_PLUGIN_BLOCKS_BASE_URL . 'build/js/admin/index.js',
			$asset_file['dependencies'],
			$asset_file['version']
		);

		wp_set_script_translations( 'planet4-gpch-plugin-blocks', 'planet4-gpch-plugin-blocks', P4_GPCH_PLUGIN_BLOCKS_BASE_PATH . 'languages' );
	}
}
