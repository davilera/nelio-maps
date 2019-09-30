<?php
/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       Nelio Maps
 * Plugin URI:        https://neliosoftware.com
 * Description:       Simple and beautiful Google Maps block for WordPress.
 * Version:           1.0.2
 *
 * Author:            Nelio Software
 * Author URI:        http://neliosoftware.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Text Domain:       nelio-maps
 *
 * @package Nelio_Maps
 * @author  David Aguilera <david.aguilera@neliosoftware.com>
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}//end if

define( 'NELIO_MAPS', true );

function nelio_maps() {
	return Nelio_Maps::instance();
}//end nelio_maps()

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
		load_plugin_textdomain( 'nelio-maps' );

	}//end init_options()

	public function init_hooks() {

		add_action( 'admin_init', [ $this, 'admin_init' ] );

		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}//end if

		add_action( 'init', [ $this, 'register_google_maps_api_key_option' ] );
		add_filter( 'block_categories', [ $this, 'add_extra_category' ], 99 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 9 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_block_assets' ] );

		if ( is_admin() ) {
			require_once $this->plugin_path . '/options.php';
		}//end if

	}//end init_hooks()

	public function add_extra_category( $categories ) {

		if ( count( array_filter( $categories, function( $category ) { return 'extra' === $category['slug']; } ) ) ) {
			return $categories;
		}//end if

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

		$script_meta = require $this->plugin_path . '/assets/dist/blocks.asset.php';
		wp_enqueue_script(
			'nelio-maps-blocks',
			untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/dist/blocks.js',
			$script_meta['dependencies'],
			$script_meta['version'],
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'nelio-maps-blocks', 'nelio-maps' );
		}//end if

		wp_enqueue_style(
			'nelio-maps-blocks',
			untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/assets/dist/blocks.css',
			[],
			$this->plugin_version
		);

		wp_localize_script(
			'nelio-maps-blocks',
			'NelioMaps',
			array(
				'googleMapsApiKey' => get_option( 'nelio_maps_api_key_option', '' ),
				'optionsPageUrl'   => admin_url( 'options-general.php?page=nelio-maps' ),
			)
		);

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
			$this->plugin_url . '/assets/dist/blocks.css',
			[],
			$this->plugin_version
		);

		$script_meta = require $this->plugin_path . '/assets/dist/public.asset.php';
		wp_enqueue_script(
			'nelio-maps',
			$this->plugin_url . '/assets/dist/public.js',
			array_merge( $script_meta['dependencies'], [ 'google-maps' ] ),
			$script_meta['version'],
			true
		);

	}//end enqueue_block_assets()

	public function admin_init() {

		$data = get_file_data( __FILE__, [ 'Plugin Name', 'Version' ], 'plugin' );

		$this->plugin_name           = $data[0];
		$this->plugin_version        = $data[1];
		$this->plugin_slug           = plugin_basename( __FILE__, '.php' );
		$this->plugin_name_sanitized = basename( __FILE__, '.php' );

	}//end admin_init()

	public function register_google_maps_api_key_option() {

		$api_key = get_option( 'nelio_maps_api_key_option', '' );
		update_option( 'nelio_maps_api_key_option', $api_key );

	}//end register_google_maps_api_key_option()

}//end class

// Start plugin.
nelio_maps();
