<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://example
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/includes
 * @author     Kenneth Yu <kennethyu14@gmail.com>
 */
class Product_Of_The_Day_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'product-of-the-day',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
