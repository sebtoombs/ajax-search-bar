<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://kingsdesign.com.au
 * @since      1.0.0
 *
 * @package    Kd_Ajax_Search_Bar
 * @subpackage Kd_Ajax_Search_Bar/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Kd_Ajax_Search_Bar
 * @subpackage Kd_Ajax_Search_Bar/includes
 * @author     KingsDesign <seb@kingsdesign.com.au>
 */
class Kd_Ajax_Search_Bar_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'kd-ajax-search-bar',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
