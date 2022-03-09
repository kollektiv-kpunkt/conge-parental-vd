<?php
function send_orders_function() {
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

?>