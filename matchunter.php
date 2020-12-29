<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://matchunter.com/
 * @since             1.0.0
 * @package           Matchunter
 *
 * @wordpress-plugin
 * Plugin Name:       Matchunter
 * Plugin URI:        https://matchunter.com/
 * Description:       Fight your way through endless tournaments. Unlock achievements, win prizes and climb the ranks in the hall of fame!
 * Version:           1.0.0
 * Author:            Matchunter
 * Author URI:        https://matchunter.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       matchunter
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

define( 'MATCHUNTER_VERSION',			'1.0.0' );
define( 'MATCHUNTER_NAME',				'matchunter' );
define( 'MATCHUNTER_SHORTCODE',		'matchunter' );
define( 'MATCHUNTER_DOMAIN',			'matchunter');
define( 'MATCHUNTER_NONCE', 			'matchunter_nonce');
define( 'MATCHUNTER_PATH',				plugin_dir_path(__FILE__) );
define( 'MATCHUNTER_URL',					plugin_dir_url( __FILE__ ) );
define( 'MATCHUNTER_PANEL_URL', 	'admin.php?page=matchunter_settings' );
define( 'MATCHUNTER_OPTIONS', 		'matchunter_options' );

define( 'MATCHUNTER_ADMIN_URL',					MATCHUNTER_URL . 'admin/');
define( 'MATCHUNTER_ADMIN_ASSETS_URL',	MATCHUNTER_URL . 'assets/admin/');
define( 'MATCHUNTER_PUBLIC_URL',				MATCHUNTER_URL . 'public/');
define( 'MATCHUNTER_PUBLIC_ASSETS_URL',	MATCHUNTER_URL . 'assets/public/');

define( 'MATCHUNTER_ASSET_VERSION', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : MATCHUNTER_VERSION );


define( 'MATCHUNTER_API', [
	'root' => 'http://78.46.160.168:5000/api/views',
	'names' => [
		'round_list' => [
			'endpoint' => '/round/list',
			'methods' => ['GET']
		],
		'tournament_ranking' => [
			'endpoint' => '/tournament/ranking',
			'methods' => ['GET']
		],
		'round_ranking' => [
			'endpoint' => '/round/ranking',
			'methods' => ['GET']
		],
		'round_matches' => [
			'endpoint' => '/round/matches',
			'methods' => ['GET']
		],
		'insights' => [
			'endpoint' => '/:match_id/insight',
			'methods' => ['GET']
		],
		'lineup' => [
			'endpoint' => '/:match_id/lineup',
			'methods' => ['GET']
		]
	]
]);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-matchunter-activator.php
 */
function activate_matchunter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-matchunter-activator.php';
	Matchunter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-matchunter-deactivator.php
 */
function deactivate_matchunter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-matchunter-deactivator.php';
	Matchunter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_matchunter' );
register_deactivation_hook( __FILE__, 'deactivate_matchunter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-matchunter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_matchunter() {

	$plugin = new Matchunter();
	$plugin->run();

}
run_matchunter();
