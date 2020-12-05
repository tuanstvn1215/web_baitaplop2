<?php
session_start();

$host = 'B1704786';
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "web";
define('host', '/B1704786');
$conn;
try {
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    $conn->set_charset("utf8");
} catch (Throwable $th) {
    echo $th->getMessage();
}
