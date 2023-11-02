<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/admin
 * @author     Kenneth Yu <kennethyu14@gmail.com>
 */
class Product_Of_The_Day_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Of_The_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Of_The_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-of-the-day-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Of_The_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Of_The_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-of-the-day-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'custom_products_params', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'custom-products-nonce' ),
        ) );

	}

	public function register_acf_blocks() {
		acf_register_block( array(
			'name'				=> 'product-of-the-day',
			'title'				=> get_field( 'block_title', 'option' ) ?: __( 'Product of the Day' ),
			'description'		=> __( 'A custom block for product of the day.' ),
			'render_template'	=> plugin_dir_path( __DIR__ ) . 'public/blocks/product-of-the-day/product-of-the-day.php',
			'enqueue_style'		=> plugin_dir_url( __DIR__ ) . 'public/blocks/product-of-the-day/style.css',
			'category'			=> 'layout',
			'icon'				=> 'products',
			'keywords'			=> array( 'product' )
		) );

		acf_add_options_page(array(
			'page_title'    => 'Product of the Day Options',
			'menu_title'    => 'Product of the Day Options',
			'menu_slug'     => 'product-of-the-day-options',
			'capability'    => 'manage_options',
			'redirect'      => false,
			'icon_url'      => 'dashicons-admin-generic',
			'position'      => 30
		));
	}

	public function create_posttype() {

		$labels = array(
			'name'                => __( 'Products' ),
			'singular_name'       => __( 'Product' ),
			'menu_name'           => __( 'Products' ),
			'all_items'           => __( 'All Products' ),
			'view_item'           => __( 'View Product' ),
			'add_new_item'        => __( 'Add New Product' ),
			'add_new'             => __( 'Add New' ),
			'edit_item'           => __( 'Edit Product' ),
			'update_item'         => __( 'Update Product' ),
			'search_items'        => __( 'Search Product' ),
			'not_found'           => __( 'Not Found' ),
			'not_found_in_trash'  => __( 'Not found in Trash' )
		);
		  		  
		$args = array(
			'label'               => __( 'products' ),
			'description'         => __( 'Products' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'       	  => 'dashicons-products',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
		);
		  
		register_post_type( 'products', $args );
	}

	public function custom_products_columns( $columns ) {
		$columns['featured'] = 'Featured';
    	return $columns;
	}

	public function custom_products_column_content( $column, $post_id ) {
		if ( $column == 'featured' ) {
			$is_featured = (bool) get_post_meta( $post_id, '_featured', true );
	
			echo '<a href="#" class="toggle-featured" data-post-id="' . $post_id . '" data-featured="' . esc_attr( $is_featured ) . '">';
			echo ( $is_featured ) ? '<span class="dashicons dashicons-star-filled"></span>' : '<span class="dashicons dashicons-star-empty"></span>';
			echo '</a>';
		}
	}

	public function toggle_featured_status() {
		check_ajax_referer( 'custom-products-nonce', 'nonce' );
	
		$post_id = $_POST['post_id'];
		$is_featured = $_POST['is_featured'] === 'true';
	
		update_post_meta( $post_id, '_featured', ! $is_featured );
	
		wp_send_json_success( array( 'is_featured' => ! $is_featured ) );
	}

	public function record_cta_click() {
		check_ajax_referer( 'custom-products-nonce', 'nonce' );
		
		global $wpdb;

		$table_name = $wpdb->prefix . 'cta_clicks';

		$cta_id = isset( $_POST['cta_id'] ) ? intval( $_POST['cta_id'] ) : 0;

		if ( $cta_id > 0 ) {
			$wpdb->insert(
				$table_name,
				array(
					'cta_id' => $cta_id,
					'click_date' => current_time( 'mysql' ),
				),
				array('%d', '%s')
			);

			echo 'Click recorded successfully';
		} else {
			echo 'Invalid CTA ID';
		}

		wp_die();
	}

}
