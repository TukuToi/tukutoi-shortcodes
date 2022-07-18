<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress or ClassicPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.tukutoi.com/
 * @since             1.0.0
 * @package    Plugins\ShortCodes
 * @author     Beda Schmid <beda@tukutoi.com>
 *
 * @wordpress-plugin
 * Plugin Name:       TukuToi ShortCodes
 * Plugin URI:        https://www.tukutoi.com/
 * Description:       A library of indispensable ShortCodes for ClassicPress (and WordPress without Blocks) Websites.
 * Version:           1.26.2
 * Author:            TukuToi
 * Author URI:        https://www.tukutoi.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tkt-shortcodes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 *
 * Start at version 1.0.0 and use SemVer
 * Rename this for your plugin and update it as you release new versions.
 *
 * @link https://semver.org
 * @var string $TKT_SHORTCODES_VERSION The Version of this plugin.
 */
define( 'TKT_SHORTCODES_VERSION', '1.26.2' );

/**
 * The code that runs during plugin activation.
 *
 * @see Tkt_Shortcodes_Activator::activate()
 */
function tkt_shortcodes_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tkt-shortcodes-activator.php';
	Tkt_Shortcodes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * @see Tkt_Shortcodes_Deactivator::deactivate()
 */
function tkt_shortcodes_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tkt-shortcodes-deactivator.php';
	Tkt_Shortcodes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'tkt_shortcodes_activate' );
register_deactivation_hook( __FILE__, 'tkt_shortcodes_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tkt-shortcodes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Generally you will want to hook this function, instead of callign it globally.
 * However since the purpose of your plugin is not known until you write it, we include the function globally.
 *
 * @since    1.0.0
 */
function tkt_shortcodes_run() {

	$plugin = new Tkt_Shortcodes();
	$plugin->run();

}
/**
 * TukuToi ShortCode runs a bit late because other plugins need to register ShortCodes with it.
 * If we run at default 10, which most init hooks do, then it'll follow alphabetical order of plugin name.
 * That means, whatever comes after `t` in the alphabet wouldn't be able to hook in.
 * Thus temptatively run at 20.
 */
add_action( 'init', 'tkt_shortcodes_run', 20 );
