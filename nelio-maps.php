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
 * Version:     1.0.1
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
 * Nelio_Maps
 */
class Nelio_Maps {

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

		$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		$this->plugin_url  = untrailingslashit( plugin_dir_url( __FILE__ ) );

		// load textdomain.
		load_plugin_textdomain( 'nelio-maps', false, basename( dirname( __FILE__ ) ) . '/languages' );

	}//end init_options()

	public function init_hooks() {

		add_action( 'admin_init', [ $this, 'admin_init' ] );

		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}//end if

		add_action( 'init', [ $this, 'register_google_maps_api_key_option' ] );
		add_filter( 'block_categories', [ $this, 'add_extra_category' ], 9 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 9 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_block_assets' ] );

	}//end init_hooks()

	public function add_extra_category( $categories ) {

		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'extra',
					'title' => _x( 'Extra', 'text (block category)', 'nelio-maps' ),
				),
			)
		);

	}//end add_extra_category()

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

		wp_localize_script(
			'nelio-maps-blocks',
			'NelioMaps',
			array(
				'googleMapsApiKey' => get_option( 'nelio_maps_api_key_option', '' ),
				'optionsPageUrl'   => admin_url( 'options.php#nelio_maps_api_key_option' ),
			)
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'nelio-maps-plugin', 'nelio-maps' );
		}//end if

	}//end enqueue_block_editor_assets()

	public function enqueue_block_assets() {

		wp_register_script(
			'google-maps',
			add_query_arg(
				array(
					'key'       => get_option( 'nelio_maps_api_key_option', '' ),
					'libraries' => 'geometry,drawing,places',
				),
				'https://maps.googleapis.com/maps/api/js'
			),
			[],
			$this->plugin_version,
			true
		);

		wp_enqueue_style(
			'nelio-maps-gutenberg',
			$this->plugin_url . '/assets/dist/css/blocks.css',
			[],
			$this->plugin_version
		);

		wp_enqueue_script(
			'nelio-maps',
			$this->plugin_url . '/assets/dist/js/public.js',
			[ 'google-maps' ],
			$this->plugin_version,
			true
		);

	}//end enqueue_block_assets()

	public function admin_init() {

		// Get current plugin data.
		$data                        = get_plugin_data( __FILE__ );
		$this->plugin_name           = $data['Name'];
		$this->plugin_version        = $data['Version'];
		$this->plugin_slug           = plugin_basename( __FILE__, '.php' );
		$this->plugin_name_sanitized = basename( __FILE__, '.php' );

	}//end admin_init()

	public function register_google_maps_api_key_option() {

		$api_key = get_option( 'nelio_maps_api_key_option', '' );
		update_option( 'nelio_maps_api_key_option', $api_key );

	}//end register_google_maps_api_key_option()

}//end class

function nelio_maps() {
	return Nelio_Maps::instance();
}//end nelio_maps()
add_action( 'plugins_loaded', 'nelio_maps' );
