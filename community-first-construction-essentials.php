<?php
/**
 * Plugin Name:       Community First Construction Essentials
 * Plugin URI:        https://communityfirstconstruction.com/plugins/community-first-construction-essentials
 * Description:       Custom Gutenberg blocks and essential functions for Community First Construction website.
 * Version:           1.0.5.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Community First Construction
 * Author URI:        https://communityfirstconstruction.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        
 * Text Domain:       community-first-construction-essentials
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin constants
define( 'CFCE_VERSION', '1.0.5.0' );
define( 'CFCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CFCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_community_first_construction_essentials() {
	require_once CFCE_PLUGIN_DIR . 'includes/class-community-first-construction-essentials-activator.php';
	Community_First_Construction_Essentials_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_community_first_construction_essentials() {
	require_once CFCE_PLUGIN_DIR . 'includes/class-community-first-construction-essentials-deactivator.php';
	Community_First_Construction_Essentials_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_community_first_construction_essentials' );
register_deactivation_hook( __FILE__, 'deactivate_community_first_construction_essentials' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require CFCE_PLUGIN_DIR . 'includes/class-community-first-construction-essentials.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_community_first_construction_essentials() {
	$plugin = new Community_First_Construction_Essentials();
	$plugin->run();
}
run_community_first_construction_essentials();

/**
 * Plugin Update Checker (PUC) integration
 * Allows auto-updates directly from a Git repository without Appsero.
 *
 * To use with GitHub:
 *  - Place the PUC library at: CFCE_PLUGIN_DIR . 'plugin-update-checker/plugin-update-checker.php'
 *  - Set $cfce_repo_url to your repository URL, e.g. 'https://github.com/your-org/community-first-construction-essentials/'
 *  - Ensure you create a release or tag matching the Version header (e.g., v1.0.1) and bump Version here.
 */
add_action( 'plugins_loaded', function() {
	$maybe_library = CFCE_PLUGIN_DIR . 'plugin-update-checker/plugin-update-checker.php';
	if ( file_exists( $maybe_library ) ) {
		require_once $maybe_library;

		$cfce_repo_url = 'https://github.com/johncrislasta/community-first-construction-essentials'; 
		$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
			$cfce_repo_url,
			__FILE__,
			'community-first-construction-essentials'
		);

		// If using a branch other than default, set it here.
		$update_checker->setBranch( 'main' );

		// For private repos, uncomment and set a Personal Access Token (classic) with repo scope.
		// $update_checker->setAuthentication( 'YOUR_GITHUB_TOKEN' );
	} else {
		// Admin notice to help install the library.
		add_action( 'admin_notices', function() {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<div class="notice notice-warning"><p><strong>Community First Construction Essentials:</strong> Plugin Update Checker library not found. Place it in <code>plugin-update-checker/</code> inside the plugin folder to enable automatic updates from your Git repository.</p></div>';
			}
		} );
	}
} );
