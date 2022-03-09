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

    register_activation_hook(__FILE__, 'cpv_send_orders_activation');
    function cpv_send_orders_activation() {
        if (! wp_next_scheduled ( 'cpv_send_orders_event' )) {
            wp_schedule_event(time(), 'hourly', 'cpv_send_orders_event');
        }
    }

    add_action('cpv_send_orders_event', 'cpv_send_orders');

    function cpv_send_orders() {
        include(__DIR__ . "/../../../../wp-load.php");
        $orders = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}cpv_boegen` WHERE `is_sent` = 0;");
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
        $filename = "orders_" . date("Ymd");

        $file = fopen(__DIR__ . "/CSVs/{$filename}.csv", "w");
        fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        fputcsv($file, array("Order Date","Name","Address","Email", "Sheet"), ";");

        foreach ($orders as $order) {
            fputcsv($file, array($order->date, "{$order->first_name} {$order->last_name}", "{$order->first_name} {$order->last_name}\n{$order->street}\n{$order->zip} {$order->city}", $order->mail, "{$current_url}/merci/?sign={$order->guid}"), ";");
            $wpdb->query("UPDATE `{$wpdb->prefix}cpv_boegen` SET `is_sent` = 1 WHERE `guid` = '{$order->guid}';");
        }

        fclose($file);

        $to = get_option('admin_email');
        $subject = "Sheet orders for the week of " . date("d.m.Y");
        $message = <<<EOD
        <p style="font-family: sans-serif">
            Hello there!<br><br>
            Attached, you can find the sheet orders for this week. These people said they don't have a printer and therefore asked you to send them a copy of the signature sheet by mail.<br><br>
            <b>Thanks for everything you do!</b><br><br>
            Keep up the good work,<br>
            Timothy
        </p>
        EOD;
        $headers = array("Content-type: text/html");
        $attachments = array( WP_CONTENT_DIR . "/plugins/conge-parental-vd/utils/CSVs/{$filename}.csv" );

        wp_mail( $to, $subject, $message, $headers, $attachments );
    }
}


function cpv_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cpv_boegen';

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    delete_option( 'conge-parental-vd_db_version');
}


register_activation_hook( __FILE__, 'cpv_install' );
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