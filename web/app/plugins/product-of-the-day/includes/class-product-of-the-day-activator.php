<?php

/**
 * Fired during plugin activation
 *
 * @link       https://example
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 * @author     Kenneth Yu <kennethyu14@gmail.com>
 */
class Product_Of_The_Day_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Product_Of_The_Day_Activator::create_cta_table();
	}

	public static function create_cta_table() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'cta_clicks';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id INT(11) NOT NULL AUTO_INCREMENT,
			cta_id INT(11) NOT NULL,
			click_date DATETIME NOT NULL,
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			
		dbDelta( $sql );
	}

}
