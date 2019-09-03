<?php
/**
 * Widgets loader for Header Footer Elementor.
 *
 * @package     HFE
 * @author      HFE
 * @copyright   Copyright (c) 2018, HFE
 * @link        http://brainstormforce.com/
 * @since       HFE x.x.x
 */

defined( 'ABSPATH' ) or exit;

/**
 * Set up Widgets Loader class
 */
class HFE_Widgets_Loader {

	/**
	 * Instance of HFE_Widgets_Loader.
	 *
	 * @since  1.0.9
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Get instance of HFE_Widgets_Loader
	 *
	 * @since  1.0.9
	 * @return HFE_Widgets_Loader
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Setup actions and filters.
	 *
	 * @since  1.0.9
	 */
	private function __construct() {
		// Register widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

		// Add svg support.
		add_filter( 'upload_mimes', array( $this, 'hfe_svg_mime_types' ) );
	}

	
	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since x.x.x
	 * @access public
	 */
	public function include_widgets_files() {
		require_once HFE_DIR . 'widgets/class-retina.php';
	}

	/**
	 * Provide the SVG support for Retina Logo widget.
	 *
	 * @param array $mimes which return mime type.
	 *
	 * @since  x.x.x
	 * @return $mimes.
	 */
	public function hfe_svg_mime_types( $mimes ) {

		// New allowed mime types.
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since x.x.x
	 * @access public
	 */
	public function register_widgets() {

		// Its is now safe to include Widgets files.
		$this->include_widgets_files();
		// Register Widgets.
		Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Retina() );
	}

}

/**
 * Initiate the class.
 */
HFE_Widgets_Loader::instance();
