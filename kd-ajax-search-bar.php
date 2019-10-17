<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kingsdesign.com.au
 * @since             1.0.0
 * @package           Kd_Ajax_Search_Bar
 *
 * @wordpress-plugin
 * Plugin Name:       Ajax Search Bar
 * Plugin URI:        https://kingsdesign.com.au
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            KingsDesign
 * Author URI:        https://kingsdesign.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kd-ajax-search-bar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KD_AJAX_SEARCH_BAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kd-ajax-search-bar-activator.php
 */
function activate_kd_ajax_search_bar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kd-ajax-search-bar-activator.php';
	Kd_Ajax_Search_Bar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kd-ajax-search-bar-deactivator.php
 */
function deactivate_kd_ajax_search_bar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kd-ajax-search-bar-deactivator.php';
	Kd_Ajax_Search_Bar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kd_ajax_search_bar' );
register_deactivation_hook( __FILE__, 'deactivate_kd_ajax_search_bar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kd-ajax-search-bar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kd_ajax_search_bar() {

	$plugin = new Kd_Ajax_Search_Bar();
	$plugin->run();

}
run_kd_ajax_search_bar();
