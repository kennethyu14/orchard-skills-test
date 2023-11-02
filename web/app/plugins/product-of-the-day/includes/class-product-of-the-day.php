<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://example
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 * @author     Kenneth Yu <kennethyu14@gmail.com>
 */
class Product_Of_The_Day {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Product_Of_The_Day_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRODUCT_OF_THE_DAY_VERSION' ) ) {
			$this->version = PRODUCT_OF_THE_DAY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'product-of-the-day';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->create_blocks();
		$this->create_post_types();
		$this->post_type_columns();
		$this->wp_ajax();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Product_Of_The_Day_Loader. Orchestrates the hooks of the plugin.
	 * - Product_Of_The_Day_i18n. Defines internationalization functionality.
	 * - Product_Of_The_Day_Admin. Defines all hooks for the admin area.
	 * - Product_Of_The_Day_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-product-of-the-day-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-product-of-the-day-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-product-of-the-day-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-product-of-the-day-public.php';

		$this->loader = new Product_Of_The_Day_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Product_Of_The_Day_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Product_Of_The_Day_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Product_Of_The_Day_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Product_Of_The_Day_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Product_Of_The_Day_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function create_blocks() {
		$plugin_admin = new Product_Of_The_Day_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'acf/init', $plugin_admin, 'register_acf_blocks' );
	}

	public function create_post_types() {
		$plugin_admin = new Product_Of_The_Day_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'create_posttype' );
	}
	
	public function post_type_columns() {
		$plugin_admin = new Product_Of_The_Day_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'manage_products_posts_columns' , $plugin_admin, 'custom_products_columns' );
		$this->loader->add_action( 'manage_products_posts_custom_column' , $plugin_admin, 'custom_products_column_content', 10, 2 );
	}
	
	public function wp_ajax() {
		$plugin_admin = new Product_Of_The_Day_Admin( $this->get_plugin_name(), $this->get_version() );
	
		$this->loader->add_action( 'wp_ajax_toggle_featured', $plugin_admin, 'toggle_featured_status' );
		$this->loader->add_action( 'wp_ajax_nopriv_toggle_featured', $plugin_admin, 'toggle_featured_status' );

		$this->loader->add_action( 'wp_ajax_record_cta_click', $plugin_admin, 'record_cta_click' );
		$this->loader->add_action( 'wp_ajax_nopriv_record_cta_click', $plugin_admin, 'record_cta_click' );
	}

}
