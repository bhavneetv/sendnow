<?php


$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "file_transfer";

// Create connection
$db = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

date_default_timezone_set('Asia/Kolkata');
$db->set_charset("utf8mb4");
?>
