<?php
include("../../../../wp-load.php");
$guid = $_POST["guid"];
$signature = $wpdb->get_row("SELECT * from `{$wpdb->prefix}demovox_signatures` WHERE `guid` = '{$guid}';");

## ID	guid	first_name	last_name	mail	street	zip	city	is_optin	is_sent

$insert = array(
    "guid" => $signature->guid,
    "first_name" => $signature->first_name,
    "last_name" => $signature->last_name,
    "mail" => $signature->mail,
    "street" => $signature->street . " " . $signature->street_no,
    "zip" => $signature->zip,
    "city" => $signature->city,
    "is_optin" => $signature->is_optin
);

$wpdb->insert("{$wpdb->prefix}cpv_boegen", $insert);
echo("uwu")

?>