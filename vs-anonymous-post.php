<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.templatesplugin.com/
 * @since             1.0.0
 * @package           Vs_Anonymous_Post
 *
 * @wordpress-plugin
 * Plugin Name:       Virtual Solution Anonymous Post
 * Plugin URI:        https://wordpress.org/plugins/vs-anonymous-post
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            templatesplugin
 * Author URI:        http://www.templatesplugin.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vs-anonymous-post
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vs-anonymous-post-activator.php
 */
function activate_vs_anonymous_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vs-anonymous-post-activator.php';
	Vs_Anonymous_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vs-anonymous-post-deactivator.php
 */
function deactivate_vs_anonymous_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vs-anonymous-post-deactivator.php';
	Vs_Anonymous_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vs_anonymous_post' );
register_deactivation_hook( __FILE__, 'deactivate_vs_anonymous_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vs-anonymous-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vs_anonymous_post() {

	$plugin = new Vs_Anonymous_Post();
	$plugin->run();

}
run_vs_anonymous_post();


