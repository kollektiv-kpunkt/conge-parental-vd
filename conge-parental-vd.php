<?php

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
 * Plugin Name:       Cogé Parental VD
 * Plugin URI:        https://github.com/kollektiv-kpunkt/conge-parental-vd
 * Description:       Plugin for cantonal initiative in the état de vaud for collecting signatures with Demovox (https://github.com/spschweiz/demovox).
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

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CONGEPARENTALVD_VERSION', '1.0.0');


function cpv_install() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'cpv_boegen';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        guid char(36) NOT NULL,
        first_name varchar(678) NOT NULL,
        last_name varchar(678) NOT NULL,
        mail varchar(424) NOT NULL,
        street varchar(422) NULL,
        zip varchar(200) NULL,
        city varchar(296) NULL,
        is_optin tinyint(4) NULL,
        is_sent tinyint(4) DEFAULT 0,
        PRIMARY KEY (ID),
        UNIQUE KEY guid_index (guid)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'conge-parental-vd_db_version', CONGEPARENTALVD_VERSION );

    if (! wp_next_scheduled ( 'cpv_send_orders_hook' )) {
        wp_schedule_event(time(), 'weekly', 'cpv_send_orders_hook');
    }
}

add_action('cpv_send_orders_hook', 'cpv_send_orders');

function cpv_send_orders() {
    include(__DIR__ . "/utils/send-orders.php");
    send_orders_function();
}

function cpv_deactivate() {
    wp_clear_scheduled_hook( 'cpv_send_orders_hook' );
}

function cpv_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cpv_boegen';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    delete_option( 'conge-parental-vd_db_version');
}


register_activation_hook( __FILE__, 'cpv_install' );
register_deactivation_hook( __FILE__, 'cpv_deactivate' );
register_uninstall_hook( __FILE__, 'cpv_uninstall');

function cpv_lander() {
    wp_enqueue_style( 'cpv-main', plugin_dir_url( __FILE__ ) . "public/style/style.css" );
    wp_enqueue_style( 'cpv-fa', plugin_dir_url( __FILE__ ) . "lib/font-awesome/css/font-awesome.min.css" );
    wp_enqueue_script( "cpv-app", plugin_dir_url( __FILE__) . "public/js/app.js" , array("jquery"), CONGEPARENTALVD_VERSION, true );
    //Turn on output buffering
    ob_start();
    include(__DIR__ . "/views/lander.php");
    return ob_get_clean();
}

// register shortcode
add_shortcode('cpv-lander', 'cpv_lander');

function cpv_thx() {
    wp_enqueue_style( 'cpv-main', plugin_dir_url( __FILE__ ) . "public/style/style.css" );
    wp_enqueue_style( 'cpv-thx', plugin_dir_url( __FILE__ ) . "public/style/thx.css" );
    wp_enqueue_style( 'cpv-fa', plugin_dir_url( __FILE__ ) . "lib/font-awesome/css/font-awesome.min.css" );
    wp_enqueue_script( "cpv-app", plugin_dir_url( __FILE__) . "public/js/app.js" , array("jquery"), CONGEPARENTALVD_VERSION, true );

    //Turn on output buffering
    ob_start();
    include(__DIR__ . "/views/thx.php");
    return ob_get_clean();
}

// register shortcode
add_shortcode('cpv-thx', 'cpv_thx');