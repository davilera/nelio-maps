<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://neliosoftware.com
 * @since             1.0.0
 * @package           NELIO_MAPS
 *
 * @wordpress-plugin
 * Plugin Name: Nelio Maps
 * Plugin URI:  https://neliosoftware.com/
 * Description: Simple and beautiful Google Maps block for WordPress.
 * Version:     1.0.0
 * Author:      Nelio Software
 * Author URI:  https://neliosoftware.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: nelio-maps
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}//end if

/**
 * NELIO_MAPS
 */
class NELIO_MAPS {

	private static $instance = null;

	public $plugin_path;
	public $plugin_url;
	public $plugin_name;
	public $plugin_version;

	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init_options();
			self::$instance->init_hooks();
		}//end if

		return self::$instance;

	}//end instance()

	public function init_options() {

		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->plugin_url  = plugin_dir_url( __FILE__ );

		// load textdomain.
		load_plugin_textdomain( 'nelio-maps', false, basename( dirname( __FILE__ ) ) . '/languages' );

	}//end init_options()

	public function init_hooks() {

		add_action( 'admin_init', [ $this, 'admin_init' ] );

		// Works only if Gutenberg is available.
		if ( function_exists( 'register_block_type' ) ) {

			// Add Demo category.
			add_filter( 'block_categories', [ $this, 'block_categories' ], 9 );

			// Enqueue scripts and styles.
			add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 9 );

		}//end if

	}//end init_hooks()

	public function block_categories( $categories ) {

		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'demo',
					'title' => __( 'Demo', 'nelio-maps' ),
				),
			)
		);

	}//end block_categories()

	public function enqueue_block_editor_assets() {

		wp_enqueue_script(
			'nelio-maps-blocks',
			untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/dist/js/blocks.js',
			[ 'wp-editor', 'wp-i18n', 'wp-element', 'wp-data', 'wp-edit-post' ],
			$this->plugin_version,
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'nelio-maps-blocks', 'nelio-maps' );
		}//end if

		wp_enqueue_style(
			'nelio-maps-blocks',
			untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/dist/css/blocks.css',
			[],
			$this->plugin_version
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'nelio-maps-plugin', 'nelio-maps' );
		}//end if

	}//end enqueue_block_editor_assets()

	public function admin_init() {

		// Get current plugin data.
		$data                        = get_plugin_data( __FILE__ );
		$this->plugin_name           = $data['Name'];
		$this->plugin_version        = $data['Version'];
		$this->plugin_slug           = plugin_basename( __FILE__, '.php' );
		$this->plugin_name_sanitized = basename( __FILE__, '.php' );

	}//end admin_init()

	public function admin_menu() {

	}//end admin_menu()

}

function nelio_maps() {
	return NELIO_MAPS::instance();
}//end nelio_maps()
add_action( 'plugins_loaded', 'nelio_maps' );
