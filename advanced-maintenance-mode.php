<?php
/**
 * Plugin Name: Advanced Maintenance Mode
 * Plugin URI: https://example.com/advanced-maintenance-mode
 * Description: A fully featured maintenance mode, coming soon, and under construction page plugin.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: advanced-maintenance-mode
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('AMM_VERSION', '1.0.0');
define('AMM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AMM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 */
function activate_advanced_maintenance_mode() {
    require_once AMM_PLUGIN_DIR . 'includes/class-amm-activator.php';
    AMM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_advanced_maintenance_mode() {
    require_once AMM_PLUGIN_DIR . 'includes/class-amm-deactivator.php';
    AMM_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_advanced_maintenance_mode');
register_deactivation_hook(__FILE__, 'deactivate_advanced_maintenance_mode');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require AMM_PLUGIN_DIR . 'includes/class-amm-core.php';

/**
 * Begins execution of the plugin.
 */
function run_advanced_maintenance_mode() {
    $plugin = new AMM_Core();
    $plugin->run();
}
run_advanced_maintenance_mode();