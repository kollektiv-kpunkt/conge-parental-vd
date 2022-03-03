<?php

namespace CongeParentalVD;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kollektiv-kpunkt/conge-parental-vd
 * @since             1.0.0
 * @package           Coge Parental VD
 *
 * @wordpress-plugin
 * Plugin Name:       conge-parental-vd
 * Plugin URI:        https://github.com/kollektiv-kpunkt/conge-parental-vd
 * Description:       demovox is a tool to collect signatures for Swiss popular initiatives by offering the visitor a personalized signature sheet.
 * Version:           1.0.0
 * Author:            Timothy@K.
 * Author URI:        https://kpunkt.ch/
 * GitHub Plugin URI: https://github.com/kollektiv-kpunkt/conge-parental-vd
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       conge-parental-vd
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die('No direct access');
}