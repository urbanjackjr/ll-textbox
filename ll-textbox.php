<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              netkeeper.pl
 * @since             1.1.0
 * @package           Ll_Textbox
 *
 * @wordpress-plugin
 * Plugin Name:       Learn Language Textbox
 * Plugin URI:        netkeeper.pl/projekty/LearnPolish
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Jacek Urban
 * Author URI:        netkeeper.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ll-textbox
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
define( 'LL_TEXTBOX_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ll-textbox-activator.php
 */
function activate_ll_textbox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ll-textbox-activator.php';
	Ll_Textbox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ll-textbox-deactivator.php
 */
function deactivate_ll_textbox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ll-textbox-deactivator.php';
	Ll_Textbox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ll_textbox' );
register_deactivation_hook( __FILE__, 'deactivate_ll_textbox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ll-textbox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ll_textbox() {

	$plugin = new Ll_Textbox();
	$plugin->run();

}
run_ll_textbox();

